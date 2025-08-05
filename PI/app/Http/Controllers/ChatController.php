<?php

namespace App\Http\Controllers;

use App\Models\Amigo;
use App\Models\Mensaje;
use App\Models\Propietario;
use App\Models\MensajeProp;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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

        $mensajes = Mensaje::where(function ($query) use ($usuario, $amigoId) {
            $query->where('emisor_id', $usuario->id)
                ->where('receptor_id', $amigoId);
        })->orWhere(function ($query) use ($usuario, $amigoId) {
            $query->where('emisor_id', $amigoId)
                ->where('receptor_id', $usuario->id);
        })->with(['emisor', 'receptor'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Agregar flag para identificar mensajes propios
        $mensajes = $mensajes->map(function ($mensaje) use ($usuario) {
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

        // Get all landlords that have apartments
        $propietarios = Propietario::whereHas('apartamentos')->distinct()->get();

        return view('chat.simple_props', compact('propietarios'));
    }

    public function chatConPropietario($propietarioId)
    {
        $usuario = Auth::user();
        $propietario = Propietario::findOrFail($propietarioId);

        return response()->json([
            'success' => true,
            'propietario' => $propietario
        ]);
    }

    public function enviarMensajePropietario(Request $request)
    {
        $request->validate([
            'receptor_id' => 'required|exists:propietarios,id',
            'mensaje' => 'required|string|max:1000'
        ]);

        $usuario = Auth::user();

        try {
            $mensaje = MensajeProp::create([
                'emisor_id' => $usuario->id,
                'receptor_id' => $request->receptor_id,
                'contenido' => $request->mensaje
            ]);

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

    public function obtenerMensajesPropietario($propietarioId)
    {
        $usuario = Auth::user();

        $mensajes = MensajeProp::where(function ($query) use ($usuario, $propietarioId) {
            $query->where('emisor_id', $usuario->id)
                ->where('receptor_id', $propietarioId);
        })->orWhere(function ($query) use ($usuario, $propietarioId) {
            $query->where('emisor_id', $propietarioId)
                ->where('receptor_id', $usuario->id);
        })->orderBy('created_at', 'asc')
            ->get();

        // Add flag for own messages
        $mensajes = $mensajes->map(function ($mensaje) use ($usuario) {
            $mensaje->es_mio = $mensaje->emisor_id == $usuario->id;
            return $mensaje;
        });

        return response()->json([
            'success' => true,
            'mensajes' => $mensajes
        ]);
    }

    public function chatConUsuarioPropietario($usuarioId)
    {
        $propietario = Session::get('propietario');
        $usuario = Usuario::findOrFail($usuarioId);

        return response()->json([
            'success' => true,
            'usuario' => $usuario
        ]);
    }

    public function enviarMensajeComoPropietario(Request $request)
    {
        $request->validate([
            'receptor_id' => 'required|exists:usuarios,id',
            'mensaje' => 'required|string|max:1000'
        ]);

        $propietario = Session::get('propietario');

        try {
            $mensaje = MensajeProp::create([
                'emisor_id' => $propietario->id,
                'receptor_id' => $request->receptor_id,
                'contenido' => $request->mensaje,
                'es_propietario' => true // This field needs to be added to your mensajes_props table
            ]);

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

    public function obtenerMensajesPropietarioUsuario($usuarioId)
    {
        $propietario = Session::get('propietario');

        $mensajes = MensajeProp::where(function ($query) use ($propietario, $usuarioId) {
            $query->where('emisor_id', $propietario->id)
                ->where('receptor_id', $usuarioId);
        })->orWhere(function ($query) use ($propietario, $usuarioId) {
            $query->where('emisor_id', $usuarioId)
                ->where('receptor_id', $propietario->id);
        })->orderBy('created_at', 'asc')
            ->get();

        // Add flag for own messages
        $mensajes = $mensajes->map(function ($mensaje) use ($propietario) {
            $mensaje->es_mio = $mensaje->emisor_id == $propietario->id;
            return $mensaje;
        });

        return response()->json([
            'success' => true,
            'mensajes' => $mensajes
        ]);
    }
}
