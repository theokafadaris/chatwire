<?php

namespace App\Livewire;

use App\Models\Wordpress as WordpressModel;
use App\Services\openAIService;
use Livewire\Component;

class WordpressSeo extends Component
{
    public $url;

    public $firstPost;

    public $transactions = [];

    public $chatBoxModel = 'gpt-3.5-turbo';

    public $chatBoxMaxTokens = 600;

    public $chatBoxTemperature = 0.6;

    public $totalTokens;

    public $message;

    public $messages = [];

    public $chatBoxSystemInstruction = 'I want you to act as a SEO expert. 
                I will type blog post title and body and you will reply with SEO focus_keywords, 
                meta_title and meta_description in a json format. I want you to only reply with this words, 
                and nothing else. Do not write explanations. 
                My first blog post title and body is the following.';

    protected $openAIService;

    public function boot(openAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function load()
    {
        $this->validate([
            'url' => 'required|url',
        ]);
        $response = WordpressModel::getPostsPerPage($this->url, 1, 1)[0];

        $this->firstPost = 'title: ' . $response->title->rendered . PHP_EOL . 'body: ' . $response->content->rendered;
    }

    public function ask()
    {
        $this->transactions[] = ['role' => 'system', 'content' => $this->chatBoxSystemInstruction];
        // If the user has typed something, then asking the ChatGPT API
        if (!empty($this->firstPost)) {
            $this->transactions[] = ['role' => 'user', 'content' => $this->firstPost];
            $response = $this->openAIService->ask(
                $this->chatBoxModel,
                $this->chatBoxMaxTokens,
                $this->chatBoxTemperature,
                $this->transactions
            );
            $this->totalTokens = $response->usage->totalTokens;
            $this->transactions[] = ['role' => 'assistant', 'content' => $response->choices[0]->message->content];
            $this->messages = collect($this->transactions)->reject(fn ($message) => $message['role'] === 'system');
            // dd($this->messages);
        }
    }

    public function resetUrl()
    {
        return redirect()->route('wordpress');
    }

    public function render()
    {
        return view('livewire.wordpress.seo');
    }
}
