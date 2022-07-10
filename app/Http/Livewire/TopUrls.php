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
        $response = Http::get('http://ushort.test/api/v1/url/top');
        $myJsonResponse = json_decode($response->body());

        return view('livewire.top-urls')->with('urlData', $myJsonResponse->data);
    }

    public function save()
    {
        $this->validate();

        $response = Http::get('http://ushort.test/api/v1/url/shortener', [
            'url' => $this->real_url
        ]);

        if ($response->status() !== 200) {
            $this->short_url = 'Error, please try again';

        } else {
            $myJsonResponse = json_decode($response->body());
            $this->short_url = $myJsonResponse->short_url;
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
}
