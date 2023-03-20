<?php

namespace App\Http\Livewire;

use App\Models\ChatBox as ModelsChatBox;
use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;

class ChatBox extends Component
{
    public $message;

    public $chatBoxMaxTokens = 600;

    public $chatBoxTemperature = 0.2;

    public $transactions = [];

    public $messages = [];

    public $chatBoxRole;

    public $chatBoxModel = 'gpt-3.5-turbo';

    public function ask()
    {
        $this->transactions[] = ['role' => 'system', 'content' => 'You are Laravel ChatGPT clone. Answer as concisely as possible.'];
        // If the user has typed something, then asking the ChatGPT API
        if (!empty($this->message)) {
            $this->transactions[] = ['role' => 'user', 'content' => $this->message];
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $this->transactions,
                'max_tokens' => $this->chatBoxMaxTokens,
                'temperature' => $this->chatBoxTemperature,

            ]);
            $this->transactions[] = ['role' => 'assistant', 'content' => $response->choices[0]->message->content];
            $this->messages = collect($this->transactions)->reject(fn ($message) => $message['role'] === 'system');
            $this->message = '';
        }
    }

    public function updatedChatBoxRole($value)
    {
        switch ($value) {
            case '':
                $this->message = '';
                break;
            case 'laravel_tinker':
                $this->message = ModelsChatBox::availableRoles()['laravel_tinker'];
                break;
            case 'js_console':
                $this->message = ModelsChatBox::availableRoles()['js_console'];
                break;
            case 'sql_terminal':
                $this->message = ModelsChatBox::availableRoles()['sql_terminal'];
                break;
        }
    }

    public function resetChatBox()
    {
        $this->transactions = [];
        $this->messages = [];
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chat-box.chat-box', [
            'availableModels' => ModelsChatBox::availableModels(),
            'availableRoles' => ModelsChatBox::availableRoles(),
        ]);
    }
}
