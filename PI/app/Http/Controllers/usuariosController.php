<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidarLoginUsr;
use App\Http\Requests\ValidarRegistro;

use App\Http\Requests\RegistroUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Log;

class usuariosController extends Controller
{
    //Registro de usuario
    public function registrar(RegistroUsuarioRequest $request) {
        try{
            if ($request->hasFile('foto_perfil')) {
                // Depuración para ver el nombre del archivo
                Log::info($request->file('foto_perfil')->getClientOriginalName());
                
                $rutaImagen = $request->file('foto_perfil')->store('perfil', 'public');
            } else {
                $rutaImagen = 'perfil/default.jpg';
            }
            
    
            $usuario = Usuario::create([
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'correo' => $request->correo,
                'contraseña' => Hash::make($request->contraseña),
                'telefono' => $request->telefono,
                'foto_perfil' => $rutaImagen,
                'genero' => $request->genero,
            ]);
            
            Auth::login($usuario);
            session()->flash('Exito','Registro Exitoso');
            return redirect()->route('RutaPerfil'); 
        }catch (\Illuminate\Database\QueryException $e) {
            // Manejar errores de duplicidad de correo
            session()->flash('Fallo', 'El correo ya está registrado.');
            return redirect()->back();
        }
        
    }
    //Fin registro de usuario
    public function LoginUser(){
        if(Auth::check()){
            $usuario = Auth::user();
            if($usuario->rol == "admin"){
                session()->flash('Exito', 'Bienvenido administrador a Polie Roomies');
                return redirect()->route('RutaPanelAdmin');
            }else{
                session()->flash('Exito', 'Bienvenido a Polie Roomies');
                return redirect()->route('RutaPerfil'); 
            }
        }else{
            return view('loginUser');
        }
    }
    public function login(ValidarLoginUsr $request) {
        $usuario = Usuario::whereRaw('LOWER(correo) = ?', [strtolower(trim($request->correo))])->first();
    
        if (!$usuario) {
            session()->flash('Fallo', 'Usuario y/o contraseña no coinciden');
            return back();
        }
        
        if (!Hash::check($request->contraseña, $usuario->contraseña)) {
            session()->flash('Fallo', 'Usuario y/o contraseña no coinciden');
            return back();
        }
        
        Auth::login($usuario);
        if($usuario->rol == "admin"){
            session()->flash('Exito', 'Bienvenido administrador a Polie Roomies');
            return redirect()->route('RutaPanelAdmin');
        }else{
            session()->flash('Exito', 'Bienvenido a Polie Roomies');
            return redirect()->route('RutaPerfil');
        }
    
    }

    public function logout(){
    Auth::logout(); // Cierra la sesión del usuario
    return redirect()->route('login')->with('Exito', 'Sesión cerrada correctamente');
    }
    
    public function Perfil(){
        $usuario = Auth::User();
        return view('usuarios.Perfil', compact('usuario'));
    }
    
    public function index()
    {
        $consulta=DB::table('usuarios')->get();
        return view('AdminUsers', compact('consulta'));
    }
    
    public function create()
    {
        return view('usuarios.Registro.RegistroUsuario');
    }
    
    public function store(ValidarRegistro $request)
    {
        try {
            $password = $request->input('password');
            $hashedPassword = bcrypt($password);
            error_log("Contraseña cifrada: " . $hashedPassword);

            // Insertar el nuevo usuario
            DB::table('usuarios')->insert([
                "id_rol" => 3, // Rol por defecto
                "nombre" => $request->input('nombre'),
                "apellido_paterno" => $request->input('ap_reg'),
                "apellido_materno" => $request->input('am_reg'),
                "genero" => $request->input('radio_gen'),
                "telefono" => $request->input('telefono'),
                "correo" => $request->input('email'),
                "contraseña" => bcrypt($request->input('password')), // Contraseña cifrada
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
            $user = DB::table('usuarios')->where('email', $request->input('email'))->first();

            if ($user && Hash::check($request->input('password'), $user->password)) { //Esta cosa comprueba que exista el usuario y las contraseñas sean iguales con encriptado
                // Almacena info del usuario en la sesion
                Session::put('usuario', $user);
                $registro = DB::select('select * from usuarios where email = \'' . $request->input('email') . '\'');
                $Usuario = $registro[0]->nombre;
                // $id = $registro[0]->id;

                if ($user->id_rol == 1) {
                    session()->flash('Exito', 'Bienvenido: ' . $Usuario);
                    return redirect()->route('RutaInicio');
                } elseif ($user->id_rol == 2) {
                    session()->flash('Exito', 'Bienvenido Administrador: ' . $Usuario);
                    // ,['id'=>$id]
                    return to_route('RutaInicio');
                }
            }
    
            // Redirigir al login por defecto
            return to_route('login');
    
        } catch (\Illuminate\Database\QueryException $e) {
            // Manejar errores de duplicidad de correo
            session()->flash('Fallo', 'El correo ya está registrado.');
            return redirect()->back();
        }
    }
       

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $usuarios = DB::table('usuarios')->get();
        return view('verUsuarios',compact('usuarios'));}

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
            "id_rol" => $request->input('id_rol'),
            "nombre" => $request->input('nombre'),
            "apellido_paterno" => $request->input('ap_reg'),
            "apellido_materno" => $request->input('am_reg'),
            "genero" => $request->input('radio_gen'),
            "telefono" => $request->input('telefono'),
            "email" => $request->input('email'),
            "password" => bcrypt($request->input('password')),
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
        return to_route('RutaAdminUsers');
    }
}
