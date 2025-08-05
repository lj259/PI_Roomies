<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mensaje;
use App\Models\Usuario;
use App\Models\Amigo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UnifiedChatController extends Controller
{
    /**
     * Get all active chats for authenticated user
     */
    public function getActiveChats()
    {
        try {
            $usuario = Auth::user();
            
            // Get all messages where user is either sender or receiver
            $mensajes = Mensaje::where(function($query) use ($usuario) {
                $query->where('emisor_id', $usuario->id)
                      ->orWhere('receptor_id', $usuario->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

            // Group by conversation partner
            $chats = [];
            $processed = [];

            foreach ($mensajes as $mensaje) {
                $partnerId = $mensaje->emisor_id == $usuario->id ? 
                           $mensaje->receptor_id : $mensaje->emisor_id;
                
                if (!in_array($partnerId, $processed)) {
                    $partner = Usuario::find($partnerId);
                    if ($partner) {
                        $chats[] = [
                            'id' => $partner->id,
                            'nombre' => $partner->nombre,
                            'apellido_paterno' => $partner->apellido_paterno,
                            'foto_perfil' => $partner->foto_perfil,
                            'ultimo_mensaje' => $mensaje->contenido,
                            'ultimo_mensaje_fecha' => $mensaje->created_at->toISOString(),
                            'ultimo_mensaje_timestamp' => $mensaje->created_at->timestamp,
                            'es_ultimo_mio' => $mensaje->emisor_id == $usuario->id
                        ];
                        $processed[] = $partnerId;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'chats' => $chats
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting active chats: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving chats'
            ], 500);
        }
    }

    /**
     * Get conversation messages between authenticated user and another user
     */
    public function getConversation($userId)
    {
        try {
            $authUser = Auth::user();
            
            // Verify friendship if needed
            if (!Amigo::sonAmigos($authUser->id, $userId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not friends with this user'
                ], 403);
            }

            $mensajes = Mensaje::where(function($query) use ($authUser, $userId) {
                $query->where('emisor_id', $authUser->id)
                      ->where('receptor_id', $userId);
            })->orWhere(function($query) use ($authUser, $userId) {
                $query->where('emisor_id', $userId)
                      ->where('receptor_id', $authUser->id);
            })
            ->with(['emisor', 'receptor'])
            ->orderBy('created_at', 'asc')
            ->get();

            $formattedMessages = $mensajes->map(function($mensaje) use ($authUser) {
                return [
                    'id' => $mensaje->id,
                    'emisor_id' => $mensaje->emisor_id,
                    'receptor_id' => $mensaje->receptor_id,
                    'contenido' => $mensaje->contenido,
                    'created_at' => $mensaje->created_at->toISOString(),
                    'timestamp' => $mensaje->created_at->timestamp,
                    'es_mio' => $mensaje->emisor_id == $authUser->id,
                    'emisor_nombre' => $mensaje->emisor->nombre,
                    'emisor_foto' => $mensaje->emisor->foto_perfil
                ];
            });

            return response()->json([
                'success' => true,
                'mensajes' => $formattedMessages
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting conversation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving messages'
            ], 500);
        }
    }

    /**
     * Send a new message
     */
    public function sendMessage(Request $request, $userId = null)
    {
        try {
            $request->validate([
                'receptor_id' => $userId ? 'nullable|exists:usuarios,id' : 'required|exists:usuarios,id',
                'contenido' => 'required|string|max:1000'
            ]);

            $authUser = Auth::user();
            $receptorId = $userId ?? $request->receptor_id;

            // Verify friendship
            if (!Amigo::sonAmigos($authUser->id, $receptorId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not friends with this user'
                ], 403);
            }

            $mensaje = Mensaje::create([
                'emisor_id' => $authUser->id,
                'receptor_id' => $receptorId,
                'contenido' => $request->contenido
            ]);

            $mensaje->load(['emisor', 'receptor']);

            // Broadcast to real-time channels
            $this->broadcastMessage($mensaje);

            return response()->json([
                'success' => true,
                'mensaje' => [
                    'id' => $mensaje->id,
                    'emisor_id' => $mensaje->emisor_id,
                    'receptor_id' => $mensaje->receptor_id,
                    'contenido' => $mensaje->contenido,
                    'created_at' => $mensaje->created_at->toISOString(),
                    'timestamp' => $mensaje->created_at->timestamp,
                    'es_mio' => true,
                    'emisor_nombre' => $mensaje->emisor->nombre,
                    'emisor_foto' => $mensaje->emisor->foto_perfil
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error sending message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending message'
            ], 500);
        }
    }

    /**
     * Get messages since specific timestamp for polling
     */
    public function getMessagesSince(Request $request, $userId)
    {
        try {
            $authUser = Auth::user();
            $since = $request->query('since', 0);

            $mensajes = Mensaje::where(function($query) use ($authUser, $userId) {
                $query->where('emisor_id', $authUser->id)
                      ->where('receptor_id', $userId);
            })->orWhere(function($query) use ($authUser, $userId) {
                $query->where('emisor_id', $userId)
                      ->where('receptor_id', $authUser->id);
            })
            ->where('created_at', '>', Carbon::createFromTimestamp($since))
            ->with(['emisor', 'receptor'])
            ->orderBy('created_at', 'asc')
            ->get();

            $formattedMessages = $mensajes->map(function($mensaje) use ($authUser) {
                return [
                    'id' => $mensaje->id,
                    'emisor_id' => $mensaje->emisor_id,
                    'receptor_id' => $mensaje->receptor_id,
                    'contenido' => $mensaje->contenido,
                    'created_at' => $mensaje->created_at->toISOString(),
                    'timestamp' => $mensaje->created_at->timestamp,
                    'es_mio' => $mensaje->emisor_id == $authUser->id,
                    'emisor_nombre' => $mensaje->emisor->nombre,
                    'emisor_foto' => $mensaje->emisor->foto_perfil
                ];
            });

            return response()->json([
                'success' => true,
                'mensajes' => $formattedMessages,
                'server_time' => now()->timestamp
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting messages since: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving new messages'
            ], 500);
        }
    }

    /**
     * Broadcast message to real-time channels
     */
    private function broadcastMessage($mensaje)
    {
        try {
            // Broadcast to both sender and receiver channels
            $channels = [
                "chat.{$mensaje->emisor_id}",
                "chat.{$mensaje->receptor_id}"
            ];

            foreach ($channels as $channel) {
                Broadcast::channel($channel, function ($user) {
                    return true; // Simple auth for now
                });
            }

            // You can implement WebSocket broadcasting here
            // broadcast(new MessageSent($mensaje))->toOthers();
            
        } catch (\Exception $e) {
            Log::error('Error broadcasting message: ' . $e->getMessage());
        }
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request, $userId)
    {
        try {
            $authUser = Auth::user();
            
            $request->validate([
                'message_ids' => 'array',
                'message_ids.*' => 'integer|exists:mensajes,id'
            ]);

            if ($request->has('message_ids')) {
                // Mark specific messages as read
                Mensaje::whereIn('id', $request->message_ids)
                       ->where('receptor_id', $authUser->id)
                       ->update(['read_at' => now()]);
            } else {
                // Mark all messages from this user as read
                Mensaje::where('emisor_id', $userId)
                       ->where('receptor_id', $authUser->id)
                       ->whereNull('read_at')
                       ->update(['read_at' => now()]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Messages marked as read'
            ]);

        } catch (\Exception $e) {
            Log::error('Error marking messages as read: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error marking messages as read'
            ], 500);
        }
    }

    /**
     * Get user info for chat
     */
    public function getUserInfo($userId)
    {
        try {
            $authUser = Auth::user();
            
            if (!Amigo::sonAmigos($authUser->id, $userId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not friends with this user'
                ], 403);
            }

            $user = Usuario::find($userId);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'nombre' => $user->nombre,
                    'apellido_paterno' => $user->apellido_paterno,
                    'correo' => $user->correo,
                    'foto_perfil' => $user->foto_perfil
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting user info: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving user info'
            ], 500);
        }
    }
}
