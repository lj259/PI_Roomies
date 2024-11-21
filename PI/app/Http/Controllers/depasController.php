<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidarRegDepa;

class depasController extends Controller
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
    public function store(ValidarRegDepa $request)
    {
        DB::table('departamentos')->insert([

            'precio'=> $request->input('precio'),
            'ubicacion'=> $request->input('precio'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
