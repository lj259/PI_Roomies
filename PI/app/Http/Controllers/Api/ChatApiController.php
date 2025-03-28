<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatApiController extends Controller
{
    public function getMessages($userId)
    {
        $messages = Message::where(function($query) use ($userId) {
            $query->where('user_id', Auth::id())->where('receiver_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('user_id', $userId)->where('receiver_id', Auth::id());
        })->with('user')->latest()->take(50)->get()->reverse()->values();

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request, $userId)
    {
        $message = Message::create([
            'user_id' => Auth::id(),
            'receiver_id' => $userId, // Agrega el ID del receptor
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function getUsers() {
        $users = User::where('id', '!=', Auth::id())->get();

        return response()->json($users);
    }
}