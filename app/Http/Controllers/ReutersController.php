<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ReutersController extends Controller
{
    public function index()
    {
        $date = Carbon::now()->format('Y-m-d'); 
        $cacheKey = 'reuters_articles_' . $date;
        $cacheTime = Carbon::now()->endOfDay()->diffInSeconds(Carbon::now()) + 1; 

        $articles = Cache::remember($cacheKey, $cacheTime, function () use ($date) {
            $client = new Client();
            $allArticles = [];
            $page = 0;
            $pageSize = 20;

            do {
                try {
                    $response = $client->get("https://reuters-business-and-financial-news.p.rapidapi.com/articles-by-trends/{$date}/{$page}/{$pageSize}", [
                        'headers' => [
                            'x-rapidapi-host' => 'reuters-business-and-financial-news.p.rapidapi.com',
                            'x-rapidapi-key' => '7ebf5e11cfmsh7ead57ebfc7b047p158009jsn7e2400c0c8dc', 
                        ],
                    ]);

                    $responseData = json_decode($response->getBody(), true);

                    if (empty($responseData['articles'])) {
                        break; // Break if no more articles are available
                    }

                    // Process article descriptions if available
                    foreach ($responseData['articles'] as &$article) {
                        if (isset($article['articlesDescription'])) {
                            $article['articlesDescription'] = json_decode($article['articlesDescription'], true);
                        }
                    }

                    $allArticles = array_merge($allArticles, $responseData['articles']);
                    $page++;

                } catch (\Exception $e) {
                    // Log error and exit loop if there is a problem
                    \Log::error('Error fetching Reuters articles: ' . $e->getMessage());
                    break;
                }

            } while (count($responseData['articles']) === $pageSize);

            return $allArticles;
        });

        if (empty($articles)) {
            return view('reuters.index', ['articles' => [], 'error' => 'Oops! No articles found for today.']);
        }

        return view('reuters.index', ['articles' => $articles]);
    }
}
