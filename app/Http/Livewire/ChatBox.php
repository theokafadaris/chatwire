<?php

namespace App\Http\Livewire;

use App\Services\openAIService;
use App\Models\ChatBox as ChatBoxModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ChatBox extends Component
{
    use LivewireAlert;

    public $chatbox;

    public $message;

    public $chatBoxMaxTokens = 600;

    public $chatBoxTemperature = 0.6;

    public $transactions = [];

    public $messages = [];

    public $chatBoxRole;

    public $chatBoxModel = 'gpt-3.5-turbo';

    public $totalTokens;

    public $showSystemInstruction = false;

    public $chatBoxSystemInstruction = 'You are Chatwire. Answer as concisely as possible.';

    protected $openAIService;

    public function boot(openAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function mount(ChatBoxModel $chatbox)
    {
        if ($chatbox->exists) {
            $this->messages = json_decode($chatbox->messages, true);
            // Preparing saved messages to be loaded in transactions array
            $saved_messages = array_values(json_decode($chatbox->messages, true));
            foreach ($saved_messages as $saved_message) {
                $this->transactions[] = ['role' => $saved_message['role'], 'content' => $saved_message['content']];
            }
        }
    }

    public function ask()
    {
        $this->transactions[] = ['role' => 'system', 'content' => $this->chatBoxSystemInstruction];
        // If the user has typed something, then asking the ChatGPT API
        if (!empty($this->message)) {
            $this->transactions[] = ['role' => 'user', 'content' => $this->message];
            $response = $this->openAIService->ask(
                $this->chatBoxModel,
                $this->chatBoxMaxTokens,
                $this->chatBoxTemperature,
                $this->transactions
            );
            $this->totalTokens = $response->usage->totalTokens;
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
        $this->message = $value;
    }

    public function resetChatBox()
    {
        return redirect()->route('chatbox');
    }

    public function saveChat()
    {
        if ($this->messages === []) {
            $this->alert('error', 'You have not started a conversation yet!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            if ($this->chatbox->exists) {
                $this->chatbox->update([
                    'messages' => $this->messages,
                    'total_tokens' => $this->totalTokens,
                ]);
                $this->message = '';
                $this->alert('success', 'Your chat was updated successfully!', [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                ]);
            } else {
                $chatBox = new ChatBoxModel();
                $chatBox->user_id = auth()->user()->id;
                $chatBox->messages = $this->messages;
                $chatBox->total_tokens = $this->totalTokens;
                $chatBox->save();
                $this->message = '';
                $this->alert('success', 'Your chat was saved successfully!', [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.chat-box.chat-box', [
            'availableGPTModels' => $this->openAIService->availableGPTModels(),
            'availableGPTRoles' => $this->openAIService->availableGPTRoles(),
        ]);
    }
}
