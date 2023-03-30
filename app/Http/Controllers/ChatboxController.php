<?php

namespace App\Http\Controllers;

use App\Models\ChatBox;

class ChatboxController extends Controller
{
    public function index(ChatBox $chatbox)
    {
        return view('chatbox.index', [
            'chatbox' => $chatbox
        ]);
    }
}
