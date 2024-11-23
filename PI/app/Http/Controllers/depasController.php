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
        return view('RegDeparta');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidarRegDepa $request)
    {
        if ($request ->hasFile('foto')) {
            $imgPath = $request->file('foto')->store('houses', 'public');
        }
        DB::table('departamentos')->insert([
            'img_path' => $imgPath,
            'id_propietario'=>1,
            'precio'=> $request->input('precio'),
            'ubicacion'=> $request->input('ubicacion'),
            'habitaciones'=> $request->input('habitaciones'),
            'baños'=> $request->input('banos'),
            'servicios'=> $request->input('servicios'),
            'restricciones'=> $request->input('restricciones'),
            'cercanias'=> $request->input('cercanias'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);

        session()->flash('Exito', 'Departamento registrado con éxito: ');
        return to_route('RutaRegDeparta');
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
