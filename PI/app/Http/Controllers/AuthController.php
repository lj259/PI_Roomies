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
    public function login(ValidarLoginUsr $request){
        
        $user = DB::table('usuarios')->where('correo', $request->input('correousr'))->first();

        if ($user && Hash::check($request->input('pwdusr'), $user->password)) { //Esta cosa comprueba que exista el usuario y las contraseñas sesan iguales con encriptado
            // Almacena info del usuario en la sesion
            Session::put('usuario', $user);

            if ($user->id_rol==1) {
                return redirect()->route('RutaPerfil');
            } elseif ($user->id_rol==2) {
                return redirect()->route('RutaPanelAdmin');
            }
        }

        return back()->withErrors([
            'correousr' => 'El correo o contraseña no son correctos',
        ])->onlyInput('correousr');
    }
}
