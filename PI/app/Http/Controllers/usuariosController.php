<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidarRegistro;

class usuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consulta=DB::table('usuarios')->get();
        return view('AdminUsers', compact('consulta'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('RegistroUsuario');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidarRegistro $request)
    {
        DB::table('usuarios')->insert([
            "nombre" => $request->input('nombre'),
            "apellido_paterno" => $request->input('ap_reg'),
            "apellido_materno" => $request->input('am_reg'),
            "genero" => $request->input('radio_gen'),
            "telefono" => $request->input('telefono'),
            "email" => $request->input('correo'),
            "password" => $request->input('password'),
            "rol"=>1,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        $Usuario = $request->input('nombre');
        session()->flash('Exito', 'Usuario registrado exitosamente: '.$Usuario);
        return to_route('RutaTest');
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
        $registro = DB::select('select * from usuarios where id ='.$id.'');
        return view('EditUser',compact('registro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidarRegistro $request, string $id)
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
        return to_route('RutaAdminUsers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registro = DB::select('select nombre from usuarios where id ='.$id.'');
        $nombre = $registro[0]->nombre;
        DB::table('usuarios')->delete($id);
        session()->flash('Exito','Se elimino al usuario: '.$nombre);
        return redirect()->route('RutaAdminUsers');
    }
}
