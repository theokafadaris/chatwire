<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('query', null);
        $searchResults = [];

        if ($keyword) {
            // Perform search if a keyword is provided
            $searchResults = $this->fetchBooksFromSearchScript($keyword);
        }

        return view('books.index', [
            'searchResults' => $searchResults,
        ]);
    }

    private function fetchBooksFromSearchScript($keyword)
    {
        $command = escapeshellcmd("python3 " . base_path('resources/views/books/single_scraper.py') . " " . escapeshellarg($keyword));
        $output = shell_exec($command);

        if ($output === null) {
            Log::error("Python script execution failed.");
            return [];
        }

        $books = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error("JSON Decode Error: " . json_last_error_msg());
            return [];
        }

        return $books;
    }

    private function fetchBooksFromPythonScript($keyword)
    {
        $command = escapeshellcmd("python3 " . base_path('resources/views/books/combined_scraper.py') . " " . escapeshellarg($keyword));
        $output = shell_exec($command);

        if ($output === null) {
            Log::error("Python script execution failed.");
            return [];
        }

        $books = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error("JSON Decode Error: " . json_last_error_msg());
            return [];
        }

        return $books;
    }
}
