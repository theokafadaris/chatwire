<?php

// App\Http\Controllers\BibleController.php

// App\Http\Controllers\BibleController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PDF; 


class BibleController extends Controller
{
    public function index()
    {
        return view('bible.index');
    }

    public function show($book)
    {
        // Fetch the book data from the API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-rapidapi-host' => 'good-news-bible.p.rapidapi.com',
            'x-rapidapi-key' => '7ebf5e11cfmsh7ead57ebfc7b047p158009jsn7e2400c0c8dc', 
        ])->post('https://good-news-bible.p.rapidapi.com/api//bible/book', [
            'book' => $book,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Structure data by chapter
            $chapters = [];
            foreach ($data as $entry) {
                $chapters[$entry['chapter']][] = $entry;
            }

            return view('bible.book-content', [
                'book' => $book,
                'chapters' => $chapters
            ]);
        }

        return abort(500, 'Unable to fetch Bible data');
    }
    public function download($book)
    {
        // Fetch the book data from the API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-rapidapi-host' => 'good-news-bible.p.rapidapi.com',
            'x-rapidapi-key' => '7ebf5e11cfmsh7ead57ebfc7b047p158009jsn7e2400c0c8dc', 
        ])->post('https://good-news-bible.p.rapidapi.com/api//bible/book', [
            'book' => $book,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Structure data by chapter
            $chapters = [];
            foreach ($data as $entry) {
                $chapters[$entry['chapter']][] = $entry;
            }

            // Generate the PDF using the 'pdf' view
            $pdf = PDF::loadView('bible.pdf', [
                'book' => $book,
                'chapters' => $chapters,
            ])->setPaper('a4', 'portrait'); // Optional: set paper size and orientation

            // Return the PDF download response
            return $pdf->download($book . '.pdf');
        }

        return abort(500, 'Unable to fetch Bible data');
    }
}
