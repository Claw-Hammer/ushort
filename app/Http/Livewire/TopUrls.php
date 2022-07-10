<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class TopUrls extends Component
{
    use WithPagination;

    public $showAddUrl = false;
    public $real_url;
    public $short_url;

    protected $rules = [
        'real_url' => 'required|string|url',
    ];

    public function render()
    {
        $host = $this->getHost();

        $response = Http::get("{$host}/api/v1/url/top");
        $myJsonResponse = json_decode($response->body());

        return view('livewire.top-urls')->with('urlData', $myJsonResponse->data);
    }

    public function save()
    {
        $host = $this->getHost();

        $this->validate();

        $response = Http::post("{$host}/api/v1/url/shortener", [
            'url' => $this->real_url
        ]);

        if ($response->status() !== 201) {
            $this->short_url = 'Error, please try again';
        } else {
            $myJsonResponse = json_decode($response->body());
            $this->short_url = $myJsonResponse->data->short_url;
        }
    }

    public function clear()
    {
        $this->reset([
            'showAddUrl',
            'real_url',
            'short_url'
        ]);
    }

    private function getHost(): string
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
        ? "https://"
        : "http://";

        return $protocol . $_SERVER['HTTP_HOST'];
    }
}
