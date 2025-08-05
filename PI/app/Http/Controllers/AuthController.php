<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ValidarLoginUsr;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(ValidarLoginUsr $request)
    {

        $user = DB::table('usuarios')->where('correo', $request->input('correo'))->first();

        if ($user && Hash::check($request->input('contraseña'), $user->contraseña)) { //Esta cosa comprueba que exista el usuario y las contraseñas sean iguales con encriptado
            // Almacena info del usuario en la sesion
            Session::put('usuario', $user);
            $registro = DB::select('select * from usuarios where correo = \'' . $request->input('correousr') . '\'');
            $Usuario = $registro[0]->nombre;
            // $id = $registro[0]->id;

            if ($user->rol == 'usuario') {
                session()->flash('Exito', 'Bienvenido: ' . $Usuario);
                return redirect()->route('RutaPerfil');
            } elseif ($user->rol == 'administrador') {
                session()->flash('Exito', 'Bienvenido Administrador: ' . $Usuario);
                // ,['id'=>$id]
                return to_route('RutaPanelAdmin');
            }
        }

        return back()->withErrors([
            'correousr' => 'El correo o contraseña no son correctos',
        ])->onlyInput('correousr');
    }

    public function Perfil()
    {
        $usuario = Session::get('usuario');
        return view('Perfil', compact('usuario'));
    }
}
