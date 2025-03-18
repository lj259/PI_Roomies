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

class usuariosController extends Controller
{
    //Registro de usuario
    public function registrar(RegistroUsuarioRequest $request) {
        if ($request->hasFile('foto_perfil')) {
            $rutaImagen = $request->file('foto_perfil')->store('perfil', 'public');
        } else {
            $rutaImagen = 'default.png';
        }

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contraseña' => Hash::make($request->contraseña),
            'telefono' => $request->telefono,
            'foto_perfil' => $rutaImagen,
        ]);
        
        Auth::login($usuario);

        return redirect()->route('dashboard')->with('mensaje', 'Registro exitoso');
    }
    //Fin registro de usuario
    public function login(ValidarLoginUsr $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return to_route('RutaPerfil');
        }
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consulta=DB::table('usuarios')->get();
        return view('AdminUsers', compact('consulta'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('RegistroUsuario');
    }

    /**
     * Store a newly created resource in storage.
     */
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
    
            // Recuperar el usuario recién creado
            $user = DB::table('usuarios')->where('correo', $request->input('email'))->first();
    
            // Almacenar información del usuario en la sesión
            Session::put('usuario', $user);
    
            // Mensaje de éxito
            session()->flash('Exito', 'Usuario registrado exitosamente: ' . $user->nombre);
    
            // Redirigir según el rol
            if ($user->id_rol == 3) {
                return redirect()->route('RutaPerfil');
            } elseif ($user->id_rol == 2) {
                return to_route('RutaPanelAdmin');
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
