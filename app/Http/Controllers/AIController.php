<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class AIController extends Controller
{
    public function index()
    {
        return view('ai.index');
    }
    public function sendGemini(Request $request)
    {
        $message = $request->input('message');
        $apiKey = "AIzaSyCqln_uoGn6mYcuhEsQQu9LPxWiTBTfMkY";
        // $apiKey = env('GOOGLE_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'API key missing'], 500);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=$apiKey";

        //payload
        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $message]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 1.9,
                "maxOutputTokens" => 3000
            ]
        ];
        $client = new Client();
        try {
            $response = $client->post($url, [
                'json' => $payload,
                'headers' => ['Content-Type' => 'application/json']
            ]);

            $body = json_decode($response->getBody(), true);
            $text = $body['candidates'][0]['content']['parts'][0]['text'] ?? 'No response';
            return response()->json(['result' => $text]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get a response from Gemini'], 500);
        }
    }
    public function send(Request $request)
    {
        $message = $request->input('message');
        $response = $this->callAiApi($message);
        return response()->json([
            'result' => $response['content'] ?? 'No response from AI',
            'status' => $response['status'] ?? false
        ]);
    }

    private function callAiApi($message)
    {
        $apiUrl = "https://cheapest-gpt-4-turbo-gpt-4-vision-chatgpt-openai-ai-api.p.rapidapi.com/v1/chat/completions";
        $apiKey = "89752ff3d5msh0010508de6eca5cp1d1ae6jsn2d45ec083d0b";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ],
                'model' => 'gpt-4o',
                'max_tokens' => 3000,
                'temperature' => 0.9
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "x-rapidapi-host: cheapest-gpt-4-turbo-gpt-4-vision-chatgpt-openai-ai-api.p.rapidapi.com",
                "x-rapidapi-key: $apiKey"
            ],
        ]);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['content' => 'cURL Error: ' . $err, 'status' => false];
        } else {
            $decodedResponse = json_decode($response, true);
            return [
                'content' => $decodedResponse['choices'][0]['message']['content'] ?? 'No content received',
                'status' => true
            ];
        }
    }
}
