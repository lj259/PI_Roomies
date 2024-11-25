<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidarRegAvisos;
use Carbon\Carbon;

class AvisosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consulta = DB::table('registro_avisos')
        ->join('usuarios', 'registro_avisos.id_usuario', '=', 'usuarios.id')
        ->join('categoria', 'registro_avisos.id_categoria', '=', 'categoria.id')
        ->select('registro_avisos.*', 'usuarios.nombre as nombre_usr', 'categoria.nombre_categoria as categoria')
        ->get();
        return view('RegAvisos', compact('consulta'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('CrearAviso');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidarRegAvisos $request)
    {
        DB::table('registro_avisos')->insert([
            'id_categoria'=>3,
            'id_usuario'=>2,
            'titulo'=>$request->input('titulo'),
            'descripcion'=>$request->input('descripcion'),
            'activo'=>$request->input('estado'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);

        session()->flash('registrado', 'Se registro correctamento el aviso');
        return to_route('RutaVerAvisos');
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
        $aviso=DB::table('registro_avisos')->where('id', $id)->first();
        return view('editarAviso', compact('aviso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidarRegAvisos $request, string $id)
    {
        DB::table('registro_avisos')->where('id', $id)->update([
            'id_categoria'=>3,
            'id_usuario'=>2,
            'titulo'=>$request->input('titulo'),
            'descripcion'=>$request->input('descripcion'),
            'activo'=>$request->input('estado'),
            'updated_at'=>Carbon::now(),
        ]);

        session()->flash('actualizado', 'Se actualizo correctamente el aviso');
        return to_route('RutaVerAvisos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('registro_avisos')->where('id', $id)->delete();

        session()->flash('eliminado','Se elimino el aviso');
        return to_route('RutaVerAvisos');
    }
}
