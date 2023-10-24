<?php

namespace App\Livewire;

use App\Models\Wordpress;
use App\Services\openAIService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class WordpressCreatePost extends Component
{
    use LivewireAlert;

    public $topic;

    public $transactions = [];

    public $chatBoxModel = 'gpt-3.5-turbo';

    public $chatBoxMaxTokens = 600;

    public $chatBoxTemperature = 0.6;

    public $totalTokens;

    public $message;

    public $messages = [];

    public $chatBoxSystemInstruction = 'I want you to act as a Wordpress Content Creator. 
                I will type my topic proposal and you will reply with post title and body in a json format. 
                I want you to only reply with this words, and nothing else. Do not write explanations. 
                My first topic proposal for a wordpress post is the following.';

    public $url;

    public $title;

    public $body;

    public $status;

    public $username;

    public $password;

    protected $openAIService;

    public function boot(openAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function ask()
    {
        $this->transactions[] = ['role' => 'system', 'content' => $this->chatBoxSystemInstruction];
        // If the user has typed something, then asking the ChatGPT API
        if (!empty($this->topic)) {
            $this->transactions[] = ['role' => 'user', 'content' => $this->topic];
            $response = $this->openAIService->ask(
                $this->chatBoxModel,
                $this->chatBoxMaxTokens,
                $this->chatBoxTemperature,
                $this->transactions
            );
            $this->totalTokens = $response->usage->totalTokens;
            $this->transactions[] = ['role' => 'assistant', 'content' => $response->choices[0]->message->content];
            $this->messages = collect($this->transactions)->reject(function ($message) {
                return $message['role'] === 'system' || $message['role'] === 'user';
            })->map(function ($message) {
                return $message['content'];
            })->toArray();
            $this->messages = json_decode(array_shift($this->messages), true);
            $this->title = $this->messages['title'];
            $this->body = $this->messages['body'];
        }
    }

    public function createPost()
    {
        $this->validate([
            'url' => 'required|url',
            'title' => 'required',
            'body' => 'required',
            // 'status' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        $response = Wordpress::createPost(
            $this->url,
            $this->title,
            $this->body,
            $this->status,
            $this->username,
            $this->password
        );
        if ($response) {
            $this->alert('success', 'Your post was created successfully!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            $this->reset(['url', 'title', 'body', 'status', 'username', 'password']);
        } else {
            $this->alert('error', 'Your post was not created!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.wordpress.create-post');
    }
}
