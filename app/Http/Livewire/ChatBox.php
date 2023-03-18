<?php

namespace App\Http\Livewire;

use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;


class ChatBox extends Component
{
    public $message;

    public $messages = [];

    public function ask()
    {
        // If the user has typed something, then asking the ChatGPT API
        if (!empty($this->message)) {
            $this->messages[] = ['role' => 'user', 'content' => $this->message];
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $this->messages,
                'max_tokens' => 100,
                'temperature' => 0.9,

            ]);

            $this->messages[] = ['role' => 'assistant', 'content' => $response->choices[0]->message->content];
            $this->message = '';
        }
    }

    public function render()
    {
        return view('livewire.chat-box');
    }
}
