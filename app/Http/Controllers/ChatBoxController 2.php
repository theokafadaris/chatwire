<?php

namespace App\Http\Controllers;

use App\Models\ChatBox;

class ChatBoxController extends Controller
{
    public function index(ChatBox $chatbox)
    {
        return view('chatbox.index', [
            'chatbox' => $chatbox,
        ]);
    }

    public function destroy(ChatBox $chatbox)
    {
        $chatbox->delete();

        return redirect()->route('dashboard');
    }
}
