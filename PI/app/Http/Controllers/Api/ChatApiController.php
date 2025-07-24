<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatApiController extends Controller
{
    /**
     * Obtener la lista de usuarios con los que ha chateado el usuario autenticado
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerUsuarios()
    {
        // Obtener los usuarios que no sean el usuario autenticado
        $usuarios = User::where('id', '!=', Auth::id())->get();

        // Retornar la lista de usuarios como respuesta JSON
        return response()->json($usuarios);
    }

    /**
     * Obtener los mensajes con un usuario específico
     * 
     * @param  int  $usuarioId
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerMensajes($usuarioId)
    {
        // Obtener los mensajes entre el usuario autenticado y el usuario seleccionado
        $mensajes = Mensaje::where(function ($query) use ($usuarioId) {
            $query->where('emisor_id', Auth::id())  // Los mensajes enviados por el usuario autenticado
                  ->where('receptor_id', $usuarioId); // A un receptor específico
        })
        ->orWhere(function ($query) use ($usuarioId) {
            $query->where('emisor_id', $usuarioId)  // Los mensajes enviados por el usuario seleccionado
                  ->where('receptor_id', Auth::id()); // A un receptor autenticado
        })
        ->orderBy('created_at', 'asc')  // Ordenar los mensajes por fecha ascendente
        ->get();

        // Retornar los mensajes encontrados como respuesta JSON
        return response()->json(['success' => true, 'mensajes' => $mensajes]);
    }

    /**
     * Enviar un mensaje
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $usuarioId
     * @return \Illuminate\Http\JsonResponse
     */
    public function enviarMensaje(Request $request, $usuarioId)
    {
        // Validar que el contenido del mensaje esté presente y sea de tipo string
        $request->validate([
            'contenido' => 'required|string'
        ]);

        // Crear un nuevo mensaje en la base de datos
        $mensaje = Mensaje::create([
            'emisor_id' => Auth::id(),  // ID del usuario autenticado (emisor)
            'receptor_id' => $usuarioId,  // ID del usuario receptor
            'contenido' => $request->contenido,  // Contenido del mensaje
        ]);

        // Retornar una respuesta JSON con el mensaje enviado
        return response()->json(['success' => true, 'mensaje' => $mensaje]);
    }
}
