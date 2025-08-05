<?php

namespace App\Http\Controllers;

use App\Models\Amigo;
use App\Models\Mensaje;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        
        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder al chat.');
        }
        
        $amigos = Amigo::getAmigosAceptados($usuario->id);
        
        return view('chat.simple', compact('amigos'));
    }

    public function chatConAmigo($amigoId)
    {
        $usuario = Auth::user();
        
        // Verificar que son amigos
        if (!Amigo::sonAmigos($usuario->id, $amigoId)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para chatear con este usuario.'
            ]);
        }

        $amigo = Usuario::findOrFail($amigoId);
        
        return response()->json([
            'success' => true,
            'amigo' => $amigo
        ]);
    }

    public function enviarMensaje(Request $request)
    {
        $request->validate([
            'receptor_id' => 'required|exists:usuarios,id',
            'mensaje' => 'required|string|max:1000'
        ]);

        $usuario = Auth::user();
        
        // Verificar que son amigos
        if (!Amigo::sonAmigos($usuario->id, $request->receptor_id)) {
            return response()->json([
                'success' => false,
                'error' => 'No puedes enviar mensajes a este usuario.'
            ], 403);
        }

        try {
            $mensaje = Mensaje::create([
                'emisor_id' => $usuario->id,
                'receptor_id' => $request->receptor_id,
                'contenido' => $request->mensaje
            ]);

            $mensaje->load(['emisor', 'receptor']);

            return response()->json([
                'success' => true,
                'mensaje' => $mensaje
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al crear mensaje:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => 'Error al guardar el mensaje'
            ], 500);
        }
    }

    public function obtenerMensajes($amigoId)
    {
        $usuario = Auth::user();
        
        // Verificar que son amigos
        if (!Amigo::sonAmigos($usuario->id, $amigoId)) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        $mensajes = Mensaje::where(function($query) use ($usuario, $amigoId) {
            $query->where('emisor_id', $usuario->id)
                  ->where('receptor_id', $amigoId);
        })->orWhere(function($query) use ($usuario, $amigoId) {
            $query->where('emisor_id', $amigoId)
                  ->where('receptor_id', $usuario->id);
        })->with(['emisor', 'receptor'])
          ->orderBy('created_at', 'asc')
          ->get();

        // Agregar flag para identificar mensajes propios
        $mensajes = $mensajes->map(function($mensaje) use ($usuario) {
            $mensaje->es_mio = $mensaje->emisor_id == $usuario->id;
            return $mensaje;
        });

        return response()->json([
            'success' => true,
            'mensajes' => $mensajes
        ]);
    }

    public function index_props()
    {
        $usuario = Auth::user();
        
        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder al chat.');
        }
        
        $amigos = Amigo::getAmigosAceptados($usuario->id);
        
        return view('chat.simple', compact('amigos'));
    }
}
