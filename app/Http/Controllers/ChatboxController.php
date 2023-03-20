<?php

namespace App\Http\Controllers;

class ChatboxController extends Controller
{
    public function index()
    {
        return view('chatbox.index');
    }
}
