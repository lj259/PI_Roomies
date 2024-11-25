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
        
        $user = DB::table('usuarios')->where('email', $request->input('correousr'))->first();

        if ($user && Hash::check($request->input('pwdusr'), $user->password)) { //Esta cosa comprueba que exista el usuario y las contraseñas sesan iguales con encriptado
            // Almacena info del usuario en la sesion
            Session::put('usuario', $user);
         $registro = DB::select('select * from usuarios where email = \''.$request->input('correousr').'\'');
            $Usuario = $registro[0]->nombre;
            // $id = $registro[0]->id;

            if ($user->id_rol==1) {
                session()->flash('Exito', 'Bienvenido: '.$Usuario);
                return redirect()->route('RutaPerfil');
            } elseif ($user->id_rol==2) {
                session()->flash('Exito', 'Bienvenido Administrador: '.$Usuario);
                // ,['id'=>$id]
                return to_route('RutaPanelAdmin');
            }   
        }

        return back()->withErrors([
            'correousr' => 'El correo o contraseña no son correctos',
        ])->onlyInput('correousr');
    }
}
