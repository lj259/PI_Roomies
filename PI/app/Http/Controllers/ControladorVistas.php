<?php

namespace App\Http\Controllers;

use App\Http\Requests\validarLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Http\Requests\TestRequest;
use App\Http\Requests\ValidarLoginUsr;
use App\Http\Requests\ValidarReportarUsr;
use App\Http\Requests\ValidarRegDepa;
use App\Http\Requests\ValidarRegActividad;
use App\Http\Requests\ValidarRegAvisos;
use App\Http\Requests\ValidarRecuperacion;
use App\Http\Requests\ValidarEditDepa;
use App\Http\Requests\ValidarEditUsr;


class ControladorVistas extends Controller
{
    // Usuarios
    public function Inicio(){
        return view('Inicio');
    }
    public function Test(){
        return view('Test');
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

    public function Resultados(){
        return view('resultados');
    }

    public function LoginUser(){
        return view('loginUser');
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
        $registros = DB::select('select * from usuarios');
        return view('AdminUsers',compact('registros'));
    }
    public function RegisUsuario(){
        return view('RegisUsuario');
    }
    //Validaciones
    public function ValidarTest(TestRequest $request)
    {
        session()->flash('Exito', 'Se Envio Exitosamente el Test');

        return to_route('RutaPerfil');
    }


    public function ValidarAdmin(validarLogin $request){
        return to_route('RutaPanelAdmin');
    }

    public function ValidarLoginUsr(ValidarLoginUsr $request){

        return to_route('RutaBusqueda');
    }

    public function ValidarReportes(ValidarReportarUsr $request){
        return to_route('RutaReportes');
    }

    public function ValidarDepa(ValidarRegDepa $request){
        session()->flash('registrado', 'El departamento se ha registrado correctamente');
        return to_route('RutaRegDeparta');
    }

    public function ValidarRegActividad(ValidarRegActividad $request){
        if ($request->input('accion')==='eliminar') {
            session()->flash('eliminar', 'Se elimino la actividad');
        }
        
        elseif ($request->input('accion')==='guardar') {
            session()->flash('guardado', 'Se guardo el cambio la actividad');
        }

        return to_route('RutaRegistroActividad');
    }

    public function ValidarRegAvisos(ValidarRegAvisos $request){
        if ($request->input('accion')==='eliminar') {
            session()->flash('eliminar', 'Se elimino el aviso');
        }
        
        elseif ($request->input('accion')==='guardar') {
            session()->flash('enviado', 'Se envió el aviso a los usuarios');
        }

        return to_route('RutaRegistroAvisos');
    }

    public function ValidarRecuperacion(ValidarRecuperacion $request){
        session()->flash('enviado', 'Se envió un codigo de recuperación');
        return to_route('RutaRecuperacion');
    }

    public function ValidarEditDepa(ValidarEditDepa $request){
        if ($request->boolean('borrado_logico')) {
            session()->flash('borrado', 'Se realizó el borrado lógico');
        } else {
            session()->flash('editado', 'Se edito el departamento');
        }
        return to_route('RutaEditDep');
    }

    public function ValidarEditUsr(ValidarEditUsr $request){
        $usuario=$request->input('nombreEdit');
        session()->flash('exito', 'Se guardo el usuario: ' .$usuario);
        return to_route('RutaEditUser');
    }
}
