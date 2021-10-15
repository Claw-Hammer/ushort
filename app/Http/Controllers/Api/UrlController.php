<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Returns the shortened URL.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'url' => 'required|string|url'
        ]);

        if ($short = $this->transform($request->url)) {

            return response([
                'short_url' => env('APP_URL') . "/s/" . $short
            ], 200);
        }

        return response('Error: something unexpected happened, please try again', 503);
    }


    /**
     * Generates the shortened URL
     * @param string  $url
     * @param int $lenght
     * @return string $shortURL
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

        return $shortURL;
    }


    /**
     * Checks if the shortened URL already exists into the Database
     * @param  string  $url
     * @return int
     */
    private function checkURL($url)
    {
        return Url::where('short_url', $url)->count();
    }
}
