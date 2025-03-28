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
        return view('Gestion_depas', compact('departamentos'));
    }

    public function Resultados($publico)
    {
    //    Busqueda? tabla? recordar que era
        $apartamentos = Apartamento::all();
        $propietarios = Propietario::all();
        return view('usuarios.resultados', compact('apartamentos','propietarios'));
        
        /*     $apartamentos = DB::table('apartamentos')->get();
        } else {
            $apartamentos = DB::table('apartamentos')
                              ->where('disponible_para', $publico)
                              ->get(); // Mover ->get() aquí
        }
    
        return view('resultados', compact('apartamentos'));
    }
    
    
    public function Detalles($id, $propietario_id)
    {
        // Busca el apartamento por su ID
        $apartamento = DB::table('apartamentos')->where('id', $id)->first();
        $propietario = DB::table('propietarios')->where('id', $propietario_id)->first();

        // Verifica si existen
        if (!$apartamento || !$propietario) {
            return redirect()->route('RutaBusqueda')->with('error', 'El apartamento o el propietario no existen.');
        }
    
    
        // Pasa el apartamento a la vista
        return view('Detalles',compact('apartamento', 'propietario')); */
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
        // Log::info('Entra a guardado');
        try{
            // Log::info('Datos: '.$request);
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
                'servicios' => $request->servicios ? json_encode($request->servicios) : json_encode([]),
                'imagenes' => json_encode($imagenes),
            ]);
            
            // Log::info("Registro correcto");
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
        return view('Editar_depa', compact('depa'));
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
