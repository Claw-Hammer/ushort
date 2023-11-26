<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    private $host;

    public function __construct()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
        ? "https://"
        : "http://";

        $this->host = $protocol . $_SERVER['HTTP_HOST'];
    }


    /**
     * Returns the shortened URL.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $request->validate([
            'url' => 'required|string|url'
        ]);

        if ($short = $this->transform($request->url)) {

            if ($short !== 'Error') {

                return response([
                    'data' => [
                        'short_url' => "$this->host/$short"
                    ]
                ], 201);
            }
        }

        return response('Error: something unexpected happened, please try again', 503);
    }


    /**
     * It returns the top 100 visited URLs
     * @return Response
     */
    public function showTop(): Response
    {
        $top = Url::orderByDesc('number_of_visits')
            ->limit(100)
            ->get();

        return response([
            'data' => $top
        ], 200);
    }


    /**
     * Shows the real URL
     * @param Request $request
     * @return Response
     */
    public function showReal(Request $request): Response
    {
        $request->validate([
            'url' => 'required|string|url'
        ]);

        $short = $request->url;

        $real = Url::select('real_url')
            ->where('short_url', $short)
            ->first();

        if ($real) {
            return response([
                'data' => $real
            ], 200);
        }

        return response('Error: Url not found', 404);
    }


    /**
     * Generates the shortened URL
     * @param string  $url
     * @param int $lenght
     * @return string
     */
    private function transform(string $url, int $lenght = 5): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shortURL = '';

        for ($i = 0; $i < $lenght; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $shortURL .= $characters[$index];
        }

        if ($this->checkIfExists($shortURL) !== 0) {
            $lenght += 1;
            $this->transform($url, $lenght);
        }

        if (!$this->store($url, $shortURL)) {

            return 'Error';
        }

        return $shortURL;
    }


    /**
     * Checks if the shortened URL already exists into the Database
     * @param  string  $url
     * @return int
     */
    private function checkIfExists(string $url): int
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
    private function store(string $url, string $shortURL): bool
    {
        if (Url::create([
            'real_url' => $url,
            'short_url' => "$this->host/$shortURL",
            'number_of_visits' => 0,
            'nsfw' => 0
        ])) {

            return true;
        }

        return false;
    }
}
