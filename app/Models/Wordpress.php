<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;


class Wordpress extends Model
{
    use HasFactory;

    public static function getPostsCount($url)
    {
        //Create a new guzzle client
        $client = new Client();

        //Get the wordpress posts using the wordpress api
        $response = $client->request('GET', $url . '/wp-json/wp/v2/posts');

        //Get the number of posts
        $totalPosts = $response->getHeader('X-WP-Total')[0];

        //Return the total number of posts and posts
        return $totalPosts;
    }

    public static function getPostsPerPage($url, $page = 1, $perPage = 10)
    {
        //Create a new guzzle client
        $client = new Client();

        //Get the wordpress posts using the wordpress api
        $response = $client->request('GET', $url . '/wp-json/wp/v2/posts', [
            'query' => [
                'page' => $page,
                'per_page' => $perPage
            ]
        ]);

        //Get the response body
        $posts = $response->getBody();

        //Decode the response body
        $posts = json_decode($posts);

        //Return the posts
        // dd($posts);
        return $posts;
    }
}