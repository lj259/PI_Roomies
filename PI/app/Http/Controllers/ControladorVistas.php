<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorVistas extends Controller
{
// Usuarios
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
    //Admin
    public function loginAdmin(){
        return view('loginAdmin');
    }
    public function Roles(){
        return view('Roles');
    }
    public function RegistroActividad(){
        return view('RegActividad');
    }
    public function RegistroAvisos(){
        return view('RegAvisos');
    }
    public function Prueba(){
        return view('RegDeparta');
    }
    public function RegDeparta(){
        return view('RegDeparta');
    }
    public function EditDep(){
        return view('EditDep');
    }
    public function EditUser(){
        return view('EditUser');
    }
    public function PanelAdmin(){
        return view('Paneladmin');
    }
    public function AdminUsers(){
        return view('AdminUsers');
    }
    public function RegisUsuario(){
        return view('RegisUsuario');
    }
}
