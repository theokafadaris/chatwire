<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function fetchVideo($album, $artist)
    {
        $query = urlencode($artist . ' ' . $album);

        $videoId = $this->fetchVideoId($query);
        if (!$videoId) {
            return response()->json(['error' => 'Video not found'], 404);
        }

        $videoUrl = $this->fetchVideoUrl($videoId);
        if (!$videoUrl) {
            return response()->json(['error' => 'Video not found'], 404);
        }

        return response()->json([
            'videoUrl' => $videoUrl,
            'thumbnailUrl' => $this->fetchThumbnailUrl($videoId),
        ]);
    }

    public function streamVideo(Request $request)
    {
        $videoUrl = $request->query('videoUrl');
        if (!$videoUrl) {
            abort(404, 'Video URL not provided');
        }

        $headers = get_headers($videoUrl, 1);
        $contentType = $headers['Content-Type'] ?? 'application/octet-stream';

        $response = file_get_contents($videoUrl);
        return response($response)
            ->header('Content-Type', $contentType);
    }

    private function fetchVideoId($query)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://yt-api.p.rapidapi.com/search?query={$query}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: yt-api.p.rapidapi.com",
                "x-rapidapi-key: 89752ff3d5msh0010508de6eca5cp1d1ae6jsn2d45ec083d0b" 
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return null;
        }

        $data = json_decode($response, true);
        foreach ($data['data'] as $item) {
            if ($item['type'] === 'video') {
                return $item['videoId'];
            }
        }

        return null;
    }

    private function fetchVideoUrl($videoId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://yt-api.p.rapidapi.com/dl?id={$videoId}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: yt-api.p.rapidapi.com",
                "x-rapidapi-key: 89752ff3d5msh0010508de6eca5cp1d1ae6jsn2d45ec083d0b" 
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return null;
        }

        $data = json_decode($response, true);
        return $data['formats'][0]['url'] ?? null;
    }

    private function fetchThumbnailUrl($videoId)
    {
        return "https://i.ytimg.com/vi/{$videoId}/hqdefault.jpg";
    }
}
