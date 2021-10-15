<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Url;
use http\Client\Response;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Returns the shortened URL.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'url' => 'required|string|url'
        ]);

        if ($short = $this->transform($request->url)) {

            if ($short != 'Error') {
                return response([
                    'short_url' => env('APP_URL') . "/s/" . $short
                ], 200);
            }
        }

        return response('Error: something unexpected happened, please try again', 503);
    }


    /**
     * Generates the shortened URL
     * @param string  $url
     * @param int $lenght
     * @return string
     */
    private function transform(string $url, int $lenght = 3): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shortURL = '';

        for ($i = 0; $i < $lenght; $i++) {

            $index = rand(0, strlen($characters) - 1);
            $shortURL .= $characters[$index];
        }

        if ($this->checkURL($shortURL) != 0) {

            $lenght += 1;
            $this->transform($url, $lenght);
        }

        if (!$this->storeURL($url, $shortURL)) {
            return 'Error';
        }

        return $shortURL;
    }


    /**
     * Checks if the shortened URL already exists into the Database
     * @param  string  $url
     * @return int
     */
    private function checkURL(string $url): int
    {
        return Url::where('short_url', $url)->count();
    }


    /**
     * Stores the shortened URL and the corresponding real URL
     * into the Database
     * @param  string  $url
     * @param  string  $shortURL
     * @return bool
     */
    private function storeURL(string $url, string $shortURL): bool
    {
        if (Url::create([
            'real_url' => $url,
            'short_url' => env('APP_URL') . "/s/" . $shortURL,
            'number_of_visits' => 0,
            'nsfw' => 0
        ])) {
            return true;
        }
        return false;
    }
}
