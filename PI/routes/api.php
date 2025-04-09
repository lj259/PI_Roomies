<?php
// routes/api.php

use App\Http\Controllers\Api\ChatApiController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas por el middleware 'auth'
Route::middleware('auth:api')->group(function () {
    // Obtener la lista de usuarios con los que ha chateado el usuario autenticado
    Route::get('/usuarios', [ChatApiController::class, 'obtenerUsuarios']);
    
    // Obtener los mensajes con un usuario específico
    Route::get('/chat/mensajes/{usuarioId}', [ChatApiController::class, 'obtenerMensajes']);
    
    // Enviar un mensaje
    Route::post('/chat/mensajes/{usuarioId}', [ChatApiController::class, 'enviarMensaje']);
});
