<?php

namespace App\Http\Livewire;

use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;


class ChatBox extends Component
{
    public $message;

    public $transactions = [];

    public $messages = [];

    public function ask()
    {
        $this->transactions[] = ['role' => 'system', 'content' => 'You are Laravel ChatGPT clone. Answer as concisely as possible.'];
        // If the user has typed something, then asking the ChatGPT API
        if (!empty($this->message)) {
            $this->transactions[] = ['role' => 'user', 'content' => $this->message];
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $this->transactions,
                'max_tokens' => 100,
                'temperature' => 0.9,

            ]);
            $this->transactions[] = ['role' => 'assistant', 'content' => $response->choices[0]->message->content];
            $this->messages = collect($this->transactions)->reject(fn ($message) => $message['role'] === 'system');
            $this->message = '';
        }
    }

    public function actAs($role)
    {
        switch ($role) {
            case 'laravel_tinker':
                $this->message = "I want you to act as a laravel tinker console. I will type commands and you will reply with what the laravel tinker console should show. I want you to only reply with the terminal output inside one unique code block, and nothing else. do not write explanations. do not type commands unless I instruct you to do so. when i need to tell you something in english, i will do so by putting text inside curly brackets {like this}. my first command is User::first()";
                break;
            case 'js_console':
                $this->message = "I want you to act as a javascript console. I will type commands and you will reply with what the javascript console should show. I want you to only reply with the terminal output inside one unique code block, and nothing else. do not write explanations. do not type commands unless I instruct you to do so. when i need to tell you something in english, i will do so by putting text inside curly brackets {like this}. my first command is console.log(\"Hello World\");";
                break;
        }
    }

    public function render()
    {
        return view('livewire.chat-box');
    }
}
