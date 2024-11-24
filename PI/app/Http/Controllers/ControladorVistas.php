<?php

namespace App\Http\Controllers;

use App\Http\Requests\validarLogin;
use Illuminate\Http\Request;
use App\Http\Requests\TestRequest;
use App\Http\Requests\ValidarRegistro;
use App\Http\Requests\ValidarLoginUsr;
use App\Http\Requests\ValidarReportarUsr;
use App\Http\Requests\ValidarRegDepa;
use App\Http\Requests\ValidarRegActividad;
use App\Http\Requests\ValidarRegAvisos;
use App\Http\Requests\ValidarRecuperacion;
use App\Http\Requests\ValidarEditDepa;
use App\Http\Requests\ValidarEditUsr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;




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
        return view('gestion', compact('departamentos'));
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
        return view('AdminUsers');
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

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verificar si el usuario existe en la base de datos
        $user = DB::table('usuarios')->where('email', $credentials['email'])->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Iniciar la sesión manualmente
            session(['user_id' => $user->id_usuario]);

            // Redirigir al perfil o página principal
            return redirect()->route('RutaPerfil');
        }

        // Si las credenciales no son válidas
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con algun registro.',
        ]);
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
