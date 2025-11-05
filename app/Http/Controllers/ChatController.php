<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $messages = ChatMessage::with('user')
            ->latest()
            ->take(50)
            ->get()
            ->reverse()
            ->values();

        return view('chat.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = ChatMessage::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        $message->load('user');

        return response()->json([
            'success' => true,
            'message' => $message,
            'html' => view('chat.partials.message', compact('message'))->render()
        ]);
    }

    public function getMessages(Request $request)
    {
        $lastId = $request->get('last_id', 0);

        $messages = ChatMessage::with('user')
            ->where('id', '>', $lastId)
            ->latest()
            ->take(10)
            ->get()
            ->reverse()
            ->values();

        $html = '';
        foreach ($messages as $message) {
            $html .= view('chat.partials.message', compact('message'))->render();
        }

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'html' => $html,
            'last_id' => $messages->isNotEmpty() ? $messages->last()->id : $lastId
        ]);
    }
}