<?php

namespace App\Http\Controllers;

use App\Models\Propietario;
use Illuminate\Http\Request;

class PropietarioController extends Controller {
    public function index() {
        $propietarios = Propietario::all();
        return view('Administradores.propietarios.index', compact('propietarios'));
    }

    public function create() {
        return view('Administradores.propietarios.Registro_Propietarios');
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:propietarios,correo',
            'telefono' => 'nullable|string|max:20',
        ]);

        Propietario::create($request->all());
        return redirect()->route('propietarios.index')->with('Exito', 'Propietario registrado correctamente');
    }

    public function edit(Propietario $propietario) {
        return view('propietarios.edit', compact('propietario'));
    }

    public function update(Request $request, Propietario $propietario) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:propietarios,correo,' . $propietario->id,
            'telefono' => 'nullable|string|max:20',
        ]);

        $propietario->update($request->all());
        return redirect()->route('propietarios.index')->with('Exito', 'Propietario actualizado correctamente');
    }

    public function destroy(Propietario $propietario) {
        $propietario->delete();
        return redirect()->route('propietarios.index')->with('Exito', 'Propietario eliminado correctamente');
    }
}
