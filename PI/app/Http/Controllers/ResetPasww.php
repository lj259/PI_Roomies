<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\ValidarRecuperacion;

class ResetPasww extends Controller
{
    //
    public function FormNuevaContraseña(){
        return view('#');
    }
    public function NuevaContraseña(ValidarRecuperacion $request){
        $usuario = User::where('email',$request->password)->first();
        if($usuario){
            $usuario->password = Hash::make($request->password);
            $usuario->save();
            return redirect('/login')->with('succes','Contraseña restablecida (modo local temporal)');
        } else {
            return back()->with('error','Usuario no encontrado');
        }
    }
}
