<?php

namespace App\Http\Livewire;

use App\Models\ChatBox as ModelsChatBox;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;

class ChatBox extends Component
{
    use LivewireAlert;

    public $message;

    public $chatBoxMaxTokens = 600;

    public $chatBoxTemperature = 0.6;

    public $transactions = [];

    public $messages = [];

    public $chatBoxRole;

    public $chatBoxModel = 'gpt-3.5-turbo';

    public function ask()
    {
        $this->transactions[] = ['role' => 'system', 'content' => 'You are Laravel ChatGPT clone. Answer as concisely as possible.'];
        // If the user has typed something, then asking the ChatGPT API
        if (! empty($this->message)) {
            $this->transactions[] = ['role' => 'user', 'content' => $this->message];
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $this->transactions,
                'max_tokens' => $this->chatBoxMaxTokens,
                'temperature' => (float) $this->chatBoxTemperature,

            ]);
            $this->transactions[] = ['role' => 'assistant', 'content' => $response->choices[0]->message->content];
            $this->messages = collect($this->transactions)->reject(fn ($message) => $message['role'] === 'system');
            $this->message = '';
        }
    }

    public function sendChatToEmail()
    {
        if ($this->messages === []) {
            $this->alert('error', 'You have not started a conversation yet!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            $details = [
                'email' => auth()->user()->email,
                'messages' => $this->messages,
            ];
            dispatch(new \App\Jobs\SendEmailJob($details));
            $this->alert('success', 'Your email was sent successfully!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
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
