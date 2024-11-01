<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorVistas extends Controller
{
    public function Inicio(){
        return view('Inicio');
    }
    public function Test(){
        return view('Test');
    }
    public function RegistroUsuario(){
        return view('RegUsuario');
    }
    public function Perfil(){
        return view('Perfil');
    }
    public function Recuperacion(){
        return view('RecuperacionContraseña');
    }
    public function Reportes(){
        return view('Reportes');
    }
    public function Busqueda(){
        return view('Busqueda');
    }
}
