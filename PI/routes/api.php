<?php
// routes/api.php

use App\Http\Controllers\Api\ChatApiController;
use App\Http\Controllers\Api\UnifiedChatController;
use Illuminate\Support\Facades\Route;

// Legacy API routes (keeping for backward compatibility)
Route::middleware('auth:api')->group(function () {
    // Obtener la lista de usuarios con los que ha chateado el usuario autenticado
    Route::get('/usuarios', [ChatApiController::class, 'obtenerUsuarios']);
    
    // Obtener los mensajes con un usuario específico
    Route::get('/chat/mensajes/{usuarioId}', [ChatApiController::class, 'obtenerMensajes']);
    
    // Enviar un mensaje
    Route::post('/chat/mensajes/{usuarioId}', [ChatApiController::class, 'enviarMensaje']);
});

// New Unified Chat API (v2) - for synchronization across all platforms
Route::prefix('v2')->middleware('auth:api')->group(function () {
    // Get all active chats for user
    Route::get('/chats', [UnifiedChatController::class, 'getActiveChats']);
    
    // Get conversation with specific user
    Route::get('/chats/{userId}/messages', [UnifiedChatController::class, 'getConversation']);
    
    // Send message to specific user
    Route::post('/chats/{userId}/messages', [UnifiedChatController::class, 'sendMessage']);
    
    // Send message (with receptor_id in body)
    Route::post('/messages', [UnifiedChatController::class, 'sendMessage']);
    
    // Get messages since timestamp (for polling)
    Route::get('/chats/{userId}/messages/since', [UnifiedChatController::class, 'getMessagesSince']);
    
    // Mark messages as read
    Route::patch('/chats/{userId}/read', [UnifiedChatController::class, 'markAsRead']);
    
    // Get user info for chat
    Route::get('/users/{userId}', [UnifiedChatController::class, 'getUserInfo']);
});

// Web compatibility routes (for existing web app)
Route::middleware('auth:web')->group(function () {
    // Same endpoints but for web authentication
    Route::prefix('web/v2')->group(function () {
        Route::get('/chats', [UnifiedChatController::class, 'getActiveChats']);
        Route::get('/chats/{userId}/messages', [UnifiedChatController::class, 'getConversation']);
        Route::post('/chats/{userId}/messages', [UnifiedChatController::class, 'sendMessage']);
        Route::post('/messages', [UnifiedChatController::class, 'sendMessage']);
        Route::get('/chats/{userId}/messages/since', [UnifiedChatController::class, 'getMessagesSince']);
        Route::patch('/chats/{userId}/read', [UnifiedChatController::class, 'markAsRead']);
        Route::get('/users/{userId}', [UnifiedChatController::class, 'getUserInfo']);
    });
});
