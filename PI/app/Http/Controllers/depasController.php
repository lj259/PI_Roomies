<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartamento;
use App\Http\Requests\ValidarRegDepa;
use Illuminate\Container\Attributes\Auth;

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

    public function Resultados()
    {
        $departamentos=DB::table('departamentos')->get();
        return view('resultados', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Administradores.create.RegDeparta');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidarRegDepa $request)
    {
        if ($request ->hasFile('foto')) {
            $imgPath = $request->file('foto')->store('houses', 'public');
        }

        $precio = floatval($request->input('precio'));

        $habitaciones = intval($request->input('habitaciones'));
        $banos = intval($request->input('banos'));

        DB::table('departamentos')->insert([
            'img_path' => '',
            'id_usuario'=>1,
            'id_categoria'=>1,
            'precio'=> $precio,
            'ubicacion'=> $request->input('ubicacion'),
            'habitaciones'=> $habitaciones,
            'baños'=> $banos,
            'servicios'=> $request->input('servicios'),
            'restricciones'=> $request->input('restricciones'),
            'cercanias'=> $request->input('cercanias'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);

        session()->flash('registrado', 'Se guardo el registro del departamento');
        return to_route('Ruta_gestion_depas');
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
        $depa=DB::table('departamentos')->where('id', $id)->first();
        return view('Editar_depa', compact('depa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidarRegDepa $request, string $id)
    {
        if ($request ->hasFile('foto')) {
            $imgPath = $request->file('foto')->store('houses', 'public');
        }
        
        $precio = floatval($request->input('precio'));

        $habitaciones = intval($request->input('habitaciones'));
        $banos = intval($request->input('banos'));

        DB::table('departamentos')->where('id', $id)->update([
            'img_path' => '',
            'id_usuario'=>1,
            'id_categoria'=>1,
            'precio'=> $precio,
            'ubicacion'=> $request->input('ubicacion'),
            'habitaciones'=> $request->input('habitaciones'),
            'baños'=> $banos,
            'servicios'=> $habitaciones,
            'restricciones'=> $request->input('restricciones'),
            'cercanias'=> $request->input('cercanias'),
            'updated_at'=>Carbon::now()
        ]);

        session()->flash('actualizado', 'Se actualizo con exito la vivienda');
        return to_route('Ruta_gestion_depas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('departamentos')->where('id', $id)->delete();

        session()->flash('eliminado','Se elimino la vivienda');
        return to_route('Ruta_gestion_depas');
    }
}
