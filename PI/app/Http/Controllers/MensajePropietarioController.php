<?php

namespace App\Http\Controllers;

use App\Models\MensajePropietario;
use App\Models\Propietario;
use App\Models\Apartamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MensajePropietarioController extends Controller
{
    /**
     * Enviar un mensaje a un propietario
     */
    public function enviarMensaje(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión para enviar mensajes'
            ], 401);
        }

        $request->validate([
            'propietario_id' => 'required|exists:propietarios,id',
            'apartamento_id' => 'required|exists:apartamentos,id',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string|max:1000'
        ]);

        try {
            $mensaje = MensajePropietario::create([
                'usuario_id' => Auth::id(),
                'propietario_id' => $request->propietario_id,
                'apartamento_id' => $request->apartamento_id,
                'asunto' => $request->asunto,
                'contenido' => $request->mensaje,
                'emisor_tipo' => 'usuario'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente',
                'mensaje' => $mensaje
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener mensajes entre un usuario y un propietario
     */
    public function obtenerMensajes($propietarioId, $apartamentoId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 401);
        }

        try {
            $mensajes = MensajePropietario::obtenerConversacion(
                Auth::id(), 
                $propietarioId, 
                $apartamentoId
            );

            // Agregar flag para identificar mensajes propios
            $mensajes = $mensajes->map(function($mensaje) {
                $mensaje->es_mio = $mensaje->emisor_tipo === 'usuario' && $mensaje->usuario_id === Auth::id();
                return $mensaje;
            });

            return response()->json([
                'success' => true,
                'mensajes' => $mensajes
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener mensajes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Responder un mensaje (para propietarios)
     */
    public function responderMensaje(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'apartamento_id' => 'required|exists:apartamentos,id',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string|max:1000'
        ]);

        try {
            // Verificar que el propietario autenticado es dueño del apartamento
            $propietario = session('propietario');
            
            // Debug: log the session content
            Log::info('Propietario session:', ['propietario' => $propietario]);
            
            if (!$propietario) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autorizado - sesión de propietario no encontrada'
                ], 401);
            }

            // Handle both object and array cases for propietario session
            $propietarioId = is_object($propietario) ? $propietario->id : (is_array($propietario) ? $propietario['id'] : $propietario);

            $apartamento = Apartamento::where('id', $request->apartamento_id)
                                     ->where('propietario_id', $propietarioId)
                                     ->first();

            if (!$apartamento) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para responder mensajes de este apartamento'
                ], 403);
            }

            $mensaje = MensajePropietario::create([
                'usuario_id' => $request->usuario_id,
                'propietario_id' => $propietarioId,
                'apartamento_id' => $request->apartamento_id,
                'asunto' => $request->asunto, // Use the asunto as provided (already has "Re: " from frontend)
                'contenido' => $request->mensaje,
                'emisor_tipo' => 'propietario'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Respuesta enviada correctamente',
                'mensaje' => $mensaje
            ]);

        } catch (\Exception $e) {
            Log::error('Error al enviar respuesta propietario:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar la respuesta: ' . $e->getMessage()
            ], 500);
        }
    }
}
