<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Apartamento;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Requests\ValidarRegDepa;
use App\Http\Requests\ValidarEditDepa;
use App\Models\Propietario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class depasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departamentos = Apartamento::all();
        return view('Administradores.Departamentos.Gestion_depas', compact('departamentos'));
    }

    public function Resultados(Request $request)
    {
        try {
            $query = Apartamento::query();

            // Filtrar por género disponible
            if ($request->has('publico') && in_array($request->input('publico'), ['masculino', 'femenino', 'otro'])) {
                $query->where('disponible_para', $request->input('publico'));
            }

            // Filtrar por rango de precio
            if ($request->has('precio_min') && $request->input('precio_min') != '') {
                $query->where('precio', '>=', $request->input('precio_min'));
            }
            if ($request->has('precio_max') && $request->input('precio_max') != '') {
                $query->where('precio', '<=', $request->input('precio_max'));
            }

            // Filtrar por número de habitaciones
            if ($request->has('habitaciones') && $request->input('habitaciones') != '') {
                $query->where('habitaciones_disponibles', '>=', $request->input('habitaciones'));
            }

            // Filtrar por servicios (búsqueda en JSON)
            if ($request->has('servicios') && is_array($request->input('servicios')) && !empty($request->input('servicios'))) {
                $servicios = array_filter($request->input('servicios')); // Remove empty values
                if (!empty($servicios)) {
                    $query->where(function($q) use ($servicios) {
                        foreach ($servicios as $servicio) {
                            $q->orWhere(function($subQuery) use ($servicio) {
                                $subQuery->whereJsonContains('servicios', $servicio)
                                         ->orWhere('servicios', 'like', '%"' . str_replace('"', '\"', $servicio) . '"%');
                            });
                        }
                    });
                }
            }

            // Filtrar por ubicación (búsqueda parcial en dirección)
            if ($request->has('ubicacion') && $request->input('ubicacion') != '') {
                $query->where('direccion', 'like', '%' . $request->input('ubicacion') . '%');
            }

            // Ordenar resultados
            $ordenar = $request->input('ordenar', 'precio_asc');
            switch ($ordenar) {
                case 'precio_desc':
                    $query->orderBy('precio', 'desc');
                    break;
                case 'habitaciones_asc':
                    $query->orderBy('habitaciones_disponibles', 'asc');
                    break;
                case 'habitaciones_desc':
                    $query->orderBy('habitaciones_disponibles', 'desc');
                    break;
                case 'precio_asc':
                default:
                    $query->orderBy('precio', 'asc');
                    break;
            }

            // Obtener los apartamentos filtrados
            $apartamentos = $query->get();

            // Obtener los IDs de los propietarios de estos apartamentos
            $propietariosIds = $apartamentos->pluck('propietario_id');

            // Hacer otra consulta para traer información de los propietarios
            $propietarios = Propietario::whereIn('id', $propietariosIds)->get();

            // Obtener datos para filtros (servicios únicos disponibles)
            $serviciosDisponibles = collect();
            try {
                $serviciosDisponibles = Apartamento::select('servicios')
                    ->whereNotNull('servicios')
                    ->where('servicios', '!=', '[]')
                    ->where('servicios', '!=', '')
                    ->get()
                    ->map(function ($apartamento) {
                        // Verificar si servicios ya es un array o es un string JSON
                        $servicios = $apartamento->servicios;
                        if (is_string($servicios)) {
                            $decoded = json_decode($servicios, true);
                            return $decoded ?: [];
                        } else if (is_array($servicios)) {
                            return $servicios;
                        }
                        return [];
                    })
                    ->flatten()
                    ->filter(function($item) {
                        return !empty($item) && is_string($item);
                    })
                    ->unique()
                    ->values()
                    ->sort();
            } catch (Exception $e) {
                Log::error('Error processing servicios: ' . $e->getMessage());
                $serviciosDisponibles = collect();
            }

            // Retornar los resultados a la vista
            return view('usuarios.resultados', compact('apartamentos', 'propietarios', 'serviciosDisponibles'));
            
        } catch (Exception $e) {
            Log::error('Error in Resultados method: ' . $e->getMessage());
            // Return with empty results in case of error
            $apartamentos = collect();
            $propietarios = collect();
            $serviciosDisponibles = collect();
            
            return view('usuarios.resultados', compact('apartamentos', 'propietarios', 'serviciosDisponibles'))
                ->with('error', 'Ocurrió un error al procesar los filtros. Por favor, intenta nuevamente.');
        }
    }

    public function Detalles($id, $propietario_id)
    {
        // Use Eloquent to get proper model casting
        $apartamento = Apartamento::find($id);
        $propietario = Propietario::find($propietario_id);

        // Verifica si existen
        if (!$apartamento || !$propietario) {
            return redirect()->route('RutaBusqueda')->with('error', 'El apartamento o el propietario no existen.');
        }
    
    
        // Pasa el apartamento a la vista
        return view('Administradores.Propietarios.Detalles',compact('apartamento', 'propietario'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { //Llamar a registro
        $propietarios = Propietario::all();
        // Log::Info('Propietarios: '.$propietarios);
        return view('Administradores.Departamentos.RegDeparta', compact('propietarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidarRegDepa $request)
    { //Guardar registro
        Log::info('Entra a guardado');

        try{
            Log::info('Datos: '.$request);
            $imagenes = [];
            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $imagen) {
                    $ruta = $imagen->store('departamentos', 'public');
                    $imagenes[] = $ruta;
                }
            }
            
            Apartamento::create([
                'propietario_id' => $request->propietario_id,
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'direccion' => $request->direccion,
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
                'precio' => $request->precio,
                'habitaciones_disponibles' => $request->habitaciones_disponibles,
                'disponible_para' => $request->disponible_para,
                'servicios' => $request->servicios ? json_encode($request->servicios) : json_encode([]),
                'imagenes' => json_encode($imagenes),
            ]);
            
            Log::info("Registro correcto");
            session()->flash('Exito', 'Departamento registrado correctamente');
            return back();

        }catch(Exception $e){
            Log::info("Error en: ".$e);
            return back();
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $depa=Apartamento::findOrFail($id);
        return view('Administradores.Departamentos.Editar_depa', compact('depa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidarEditDepa $request, string $id)
    {
        if ($request ->hasFile('foto')) {
            $imgPath = $request->file('foto')->store('houses', 'public');
        }

        $apartamento=Apartamento::find($id);
        $apartamento->update($request->validated());
        

        // Metodo Actualizacion
        session()->flash('actualizado', 'Se actualizo con exito la vivienda');
        return to_route('Ruta_gestion_depas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $apartamento=Apartamento::find($id);
        $apartamento->delete();
        session()->flash('eliminado','Se elimino la vivienda');
        return to_route('Ruta_gestion_depas');
    }
}
