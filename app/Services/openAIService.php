<?php

namespace App\Services;

use GuzzleHttp\Client;
use OpenAI\Laravel\Facades\OpenAI;

class openAIService
{
    public function transcribe($filePath, $language)
    {
        $response = OpenAI::audio()->transcribe([
            'model' => 'whisper-1',
            'file' => fopen(storage_path('app/' . $filePath), 'r'),
            'language' => $language,
            'response_format' => 'verbose_json',
        ]);

        return $response;
    }

    public function ask($chatBoxModel, $chatBoxMaxTokens, $chatBoxTemperature, $transactions)
    {
        $response = OpenAI::chat()->create([
            'model' => $chatBoxModel,
            'messages' => $transactions,
            'max_tokens' => (int) $chatBoxMaxTokens,
            'temperature' => (float) $chatBoxTemperature,
        ]);

        return $response;
    }

    public function availableGPTModels()
    {
        return [
            'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
            'gpt-3.5-turbo-16k' => 'GPT-3.5 Turbo 16k',
            'gpt-4' => 'GPT-4',
            'gpt-4-32k' => 'GPT-4 32k',
            'gpt-4o' => 'GPT-4o',
        ];
    }

    public function availableGPTRoles()
    {
        $client = new Client();
        $response = $client->get('https://raw.githubusercontent.com/f/awesome-chatgpt-prompts/main/prompts.csv');
        $records = [];
        $headers = null;
        $csvString = $response->getBody();
        // Remove the first line and last line
        $csvString = substr($csvString, strpos($csvString, "\n") + 1);
        $csvString = substr($csvString, 0, strrpos($csvString, "\n"));
        $prompts = [];

        foreach (explode("\n", $csvString) as $line) {
            $values = str_getcsv($line);

            $promptName = trim($values[0], '"');
            $promptDescription = trim($values[1], '"');

            $prompts[$promptName] = $promptDescription;
        }

        return $prompts;
    }
}
