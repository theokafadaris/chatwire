<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TranslateController extends Controller
{
    public function index()
    {
        return view('translate.index');
    }

    public function detect(Request $request)
    {
        $text = $request->input('text');

        // Call the API to detect the language
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'google-translator9.p.rapidapi.com',
            'x-rapidapi-key' => '7ebf5e11cfmsh7ead57ebfc7b047p158009jsn7e2400c0c8dc'
        ])->post('https://google-translator9.p.rapidapi.com/v2/detect', [
            'q' => $text
        ]);

        $data = $response->json();
        $languageCode = $data['data']['detections'][0][0]['language'];
        $languages = $this->getLanguageMapping();
        $detectedLanguage = $languages[$languageCode] ?? 'Unknown';

        // Store values in the session for later use
        session([
            'detectedLanguage' => $detectedLanguage,
            'detectedLanguageCode' => $languageCode,
            'originalText' => $text
        ]);

        return redirect()->back()->with('detectedLanguage', $detectedLanguage);
    }

    public function translate(Request $request)
    {
        if ($request->input('translate') === 'no') {
            return redirect()->back();
        }

        // Retrieve stored values from the session
        $originalText = $request->input('original-text');
        $sourceLanguage = $request->input('detected-language');
        $targetLanguage = $request->input('target-language');

        // Call the API to translate the text
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'google-translator9.p.rapidapi.com',
            'x-rapidapi-key' => '7ebf5e11cfmsh7ead57ebfc7b047p158009jsn7e2400c0c8dc'
        ])->post('https://google-translator9.p.rapidapi.com/v2', [
            'q' => $originalText,
            'source' => $sourceLanguage,
            'target' => $targetLanguage,
            'format' => 'text'
        ]);

        $data = $response->json();
        $translatedText = $data['data']['translations'][0]['translatedText'];

        // Store the translated text in the session and display it
        return redirect()->back()->with('translatedText', $translatedText);
    }

    private function getLanguageMapping()
    {
        return [
            'language_codes' => [
                'en' => 'English',
                'fr' => 'French',
                'es' => 'Spanish',
                'sw' => 'Swahili',
                'de' => 'German',
                'it' => 'Italian',
                'pt' => 'Portuguese',
                'ru' => 'Russian',
                'zh' => 'Chinese',
                'ja' => 'Japanese',
                'ko' => 'Korean',
                'ar' => 'Arabic',
                'hi' => 'Hindi',
                'bn' => 'Bengali',
                'nl' => 'Dutch',
                'tr' => 'Turkish',
                'vi' => 'Vietnamese',
                'ms' => 'Malay',
                'id' => 'Indonesian',
                'pl' => 'Polish',
                'th' => 'Thai',
                'ro' => 'Romanian',
                'el' => 'Greek',
                'he' => 'Hebrew',
                'sv' => 'Swedish',
                'no' => 'Norwegian',
                'da' => 'Danish',
                'fi' => 'Finnish',
                'cs' => 'Czech',
                'hu' => 'Hungarian',
                'uk' => 'Ukrainian',
                'fa' => 'Persian',
                'ur' => 'Urdu',
                'ta' => 'Tamil',
                'te' => 'Telugu',
                'ml' => 'Malayalam',
                'kn' => 'Kannada',
                'mr' => 'Marathi',
                'pa' => 'Punjabi',
                'bg' => 'Bulgarian',
                'sr' => 'Serbian',
                'sk' => 'Slovak',
                'sl' => 'Slovenian',
                'lt' => 'Lithuanian',
                'lv' => 'Latvian',
                'et' => 'Estonian',
                'hr' => 'Croatian',
                'is' => 'Icelandic',
                'ga' => 'Irish',
                'ca' => 'Catalan',
                'eu' => 'Basque',
                'gl' => 'Galician',
                'fil' => 'Filipino',
                'kk' => 'Kazakh',
                'mn' => 'Mongolian',
                'ne' => 'Nepali',
                'si' => 'Sinhala',
                'hy' => 'Armenian',
                'az' => 'Azerbaijani',
            ]            
        ];
    }
}
