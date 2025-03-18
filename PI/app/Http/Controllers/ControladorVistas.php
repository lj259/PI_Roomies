<?php

namespace App\Http\Controllers;

use App\Http\Requests\validarLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth;

use App\Http\Requests\TestRequest;
use App\Http\Requests\ValidarLoginUsr;
use App\Http\Requests\ValidarReportarUsr;
use App\Http\Requests\ValidarRegDepa;
use App\Http\Requests\ValidarRegActividad;
use App\Http\Requests\ValidarRegAvisos;
use App\Http\Requests\ValidarRecuperacion;
use App\Http\Requests\ValidarEditDepa;
use App\Http\Requests\ValidarEditUsr;
use App\Http\Requests\ValidarRegistro;
use Illuminate\Support\Facades\Hash;




class ControladorVistas extends Controller
{
    // Usuarios
    public function Inicio(){
        return view('Inicio');
    }
    public function Test(){
        return view('Test');
    }

    public function Registro(){
        return view('RegistroUsuario');
    }
    public function mostrarDepartamentos()
    {
        $departamentos = DB::table('departamentos')->get();
        
        // Pasar los departamentos a la vista
        return view('gestion', data: compact('departamentos'));
    }
    

    public function Recuperacion(){
    return view('Contraseñas.RecuperacionContraseña');
    }
    public function Nueva(){
    return view('Contraseñas.ContraseñaNueva');
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
        return view('Administradores.Paneladmin');
    }
    public function AdminUsers(){
        $consulta = DB::select('select * from usuarios');
        return view('Administradores.index.AdminUser',compact('consulta'));
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
/*     public function ValidasUsuario(ValidarRegistro $request)
    {
        $Usuario = $request->input('nombre');
        session()->flash('Exito', 'Usuario registrado exitosamente: '.$Usuario);
        return to_route('RutaTest');
    } */

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
        session()->flash('succes', 'Contraseña Restablecida');
        return to_route('login');
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
