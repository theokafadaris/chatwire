<?php

namespace App\Livewire;

use App\Services\openAIService;
use Livewire\Component;
use Livewire\WithFileUploads;

class TranscribeBox extends Component
{
    use WithFileUploads;

    public $file;

    public $language;

    public $availableLanguages = [
        'English' => 'en',
        'German' => 'de',
        'Greek' => 'el',
        'Spanish' => 'es',
        'French' => 'fr',
        'Italian' => 'it',
        'Portuguese' => 'pt',
    ];

    protected $openAIService;

    public $message = [];

    public function boot(openAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function transcribe()
    {
        $this->validate([
            'file' => 'required|mimes:mp3,mp4,wav,mpeg,mpga,m4a,webm|max:25000',
            'language' => 'required',
        ]);
        $filePath = $this->file->storeAs($this->file->getClientOriginalName());
        $response = $this->openAIService->transcribe($filePath, $this->availableLanguages[$this->language]);
        $this->message = [
            'duration' => $response->duration,
            'text' => $response->text,
        ];
    }

    public function render()
    {
        return view('livewire.transcribe-box.transcribe-box');
    }
}
