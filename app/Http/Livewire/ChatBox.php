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

    public function render()
    {
        return view('livewire.chat-box');
    }
}
