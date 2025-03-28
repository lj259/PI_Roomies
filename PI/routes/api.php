<?php

use App\Http\Controllers\Api\ChatApiController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [ChatApiController::class, 'getUsers']);
Route::get('/chat/messages/{userId}', [ChatApiController::class, 'getMessages']);
Route::post('/chat/messages/{userId}', [ChatApiController::class, 'sendMessage']);
});

