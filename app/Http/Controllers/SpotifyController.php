<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use League\Flysystem\ZipArchive\ZipArchiveProvider;
use ZipArchive;

class SpotifyController extends Controller
{
    public function index()
    {
        $albums = [];
        $tracks = [];
        $query = null;

        try {
            $accessToken = $this->getSpotifyAccessToken();
            $albums = $this->getTrendingAlbums($accessToken, 30, 5); 
        } catch (\Exception $e) {
            \Log::error('Trending albums error: ' . $e->getMessage());
        }

        return view('spotify.index', [
            'albums' => $albums,
            'query' => $query,
            'tracks' => $tracks,
        ]);
    }

    public function showAlbum($id)
    {
        $album = [];
        $artists = [];
        $artistImages = [];

        try {
            $accessToken = $this->getSpotifyAccessToken();
            $album = $this->getAlbumDetails($id, $accessToken);
            $artistIds = collect($album['artists'])->pluck('id')->toArray();
            $artists = collect($artistIds)->mapWithKeys(function ($artistId) use ($accessToken) {
                $artistDetails = $this->getArtistDetails($artistId, $accessToken);
                return [$artistId => $artistDetails];
            });
            $artistImages = $artists->mapWithKeys(function ($artist, $id) {
                return [$id => $artist['images'][0]['url'] ?? '']; 
            });

        } catch (\Exception $e) {
            \Log::error('Album details error: '.$e->getMessage());
        }

        return view('spotify.album', [
            'album' => $album,
            'artists' => $artists->values(),
            'artistImages' => $artistImages,
        ]);
    }
    
    public function downloadAlbum($albumId)
{
    $apiKey = 'b1cd77318fmsh22bd1f715d40dc6p1c952cjsn0c4f79854c46';
    $apiUrl = "https://spotify-downloader9.p.rapidapi.com/downloadAlbum?albumId=https%3A%2F%2Fopen.spotify.com%2Falbum%2F{$albumId}";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: spotify-downloader9.p.rapidapi.com",
            "x-rapidapi-key: {$apiKey}",
        ],
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return response()->json(['success' => false, 'message' => 'cURL error: ' . $error]);
    }

    $data = json_decode($response, true);

    if (!is_array($data) || !isset($data['success']) || !$data['success']) {
        return response()->json(['success' => false, 'message' => 'Unable to complete download at this time.']);
    }

    $downloadLinks = [];
    foreach ($data['data']['songs'] as $song) {
        $downloadLinks[] = $song['downloadLink'];
    }

    return response()->json([
        'success' => true,
        'message' => 'Download links fetched successfully.',
        'downloadLinks' => $downloadLinks
    ]);
}

    public function search(Request $request)
    {
        $query = $request->input('query');
        $tracks = [];
        $albums = []; 

        if ($query) {
            try {
                $accessToken = $this->getSpotifyAccessToken();
                $tracks = $this->searchSpotify($query, $accessToken);
            } catch (\Exception $e) {
                \Log::error('Search error: ' . $e->getMessage());
            }
        }

        return view('spotify.index', [
            'albums' => $albums,
            'tracks' => $tracks,
            'query' => $query,
        ]);
    }

    private function getAlbumDetails($id, $accessToken)
    {
        $response = Http::withToken($accessToken)->get("https://api.spotify.com/v1/albums/{$id}");

        if ($response->failed()) {
            \Log::error('Failed to fetch album details', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
            throw new \Exception('Failed to fetch album details');
        }

        return $response->json();
    }

    private function getArtistDetails($id, $accessToken)
    {
        $response = Http::withToken($accessToken)->get("https://api.spotify.com/v1/artists/{$id}");

        if ($response->failed()) {
            \Log::error('Failed to fetch artist details', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
            throw new \Exception('Failed to fetch artist details');
        }

        return $response->json();
    }

    private function getSpotifyAccessToken()
    {
        $clientId = config('services.spotify.client_id');
        $clientSecret = config('services.spotify.client_secret');

        $authToken = base64_encode("{$clientId}:{$clientSecret}");
        $response = Http::asForm()->withHeaders([
            'Authorization' => "Basic {$authToken}"
        ])->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
        ]);

        \Log::info('Spotify Token Response:', ['response' => $response->body()]);

        if ($response->failed()) {
            \Log::error('Failed to get Spotify access token', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
            throw new \Exception('Failed to get Spotify access token');
        }

        $data = $response->json();

        if (!isset($data['access_token'])) {
            \Log::error('Spotify access token not found in response', [
                'response' => $data,
            ]);
            throw new \Exception('Access token not found in the response');
        }

        return $data['access_token'];
    }

    private function getTrendingAlbums($accessToken, $limit = 20, $offset = 0)
    {
        $response = Http::withToken($accessToken)->get('https://api.spotify.com/v1/browse/new-releases', [
            'limit' => $limit,
            'offset' => $offset,
        ]);

        if ($response->failed()) {
            \Log::error('Failed to fetch trending albums', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
            throw new \Exception('Failed to fetch trending albums');
        }

        return collect($response->json()['albums']['items'])->map(function ($album) {
            return [
                'id' => $album['id'],
                'name' => $album['name'],
                'artist' => collect($album['artists'])->pluck('name')->join(', '),
                'release_date' => $album['release_date'],
                'thumbnail' => $album['images'][0]['url'] ?? 'default-image-url',
                'url' => $album['external_urls']['spotify'],
                'uri' => $album['uri'],
            ];
        })->toArray();
    }

    private function searchSpotify($query, $accessToken)
    {
        $response = Http::withToken($accessToken)->get('https://api.spotify.com/v1/search', [
            'q' => $query,
            'type' => 'track',
            'limit' => 30,
        ]);

        if ($response->failed()) {
            \Log::error('Failed to search Spotify', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
            throw new \Exception('Failed to search Spotify');
        }

        $tracksData = $response->json('tracks.items', []);

        return collect($tracksData)->map(function ($track) {
            return [
                'name' => $track['name'],
                'artist' => collect($track['artists'])->pluck('name')->join(', '),
                'album' => $track['album']['name'],
                'release_date' => $track['album']['release_date'],
                'thumbnail' => $track['album']['images'][0]['url'] ?? 'default-image-url', 
                'url' => $track['external_urls']['spotify'],
                'explicit' => $track['explicit'] ? 'Explicit' : 'Not Explicit',
                'album_id' => $track['album']['id'], 
            ];
        })->toArray();
    }
}
