<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class usuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('usuarios')->insert([
            "id_rol" => 1,
            "nombre" => $request->input('nombre'),
            "apellido_paterno" => $request->input('ap_reg'),
            "apellido_materno" => $request->input('am_reg'),
            "genero" => $request->input('radio_gen'),
            "telefono" => $request->input('telefono'),
            "email" => $request->input('email'),
            "password" => $request->input('password'),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        
        $Usuario = $request->input('nombre');
        session()->flash('Exito', 'Usuario registrado exitosamente: '.$Usuario);
        return redirect()->route('LoginUser');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $usuarios = DB::table('usuarios')->get();
        return view('verUsuarios',compact('usuarios'));}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::table('usuarios')->whereId($id)->update([
            "nombre" => $request->input('nombre'),
            "apellido_paterno" => $request->input('ap_reg'),
            "apellido_materno" => $request->input('am_reg'),
            "genero" => $request->input('radio_gen'),
            "telefono" => $request->input('telefono'),
            "email" => $request->input('correo'),
            "password" => $request->input('password'),
        ]);
        $usuario = $request->input('nombre');
        session()->flash('Exito','Se edito el usuario: '.$usuario);
        return to_route('RutaTest');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
