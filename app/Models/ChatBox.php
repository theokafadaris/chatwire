<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class ChatBox extends Model
{
    protected $table = 'chatboxes';

    protected $fillable = [
        'user_id',
        'total_tokens',
        'messages',
    ];

    public static function availableModels()
    {
        return [
            'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
            'gpt-4' => 'GPT-4',
        ];
    }

    public static function availableRoles()
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
