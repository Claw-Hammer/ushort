<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;

class RedirectionController extends Controller
{
    /**
     * Redirects from the shortened URL to the real URL
     * and saves that visit into the Database
     * @param string $url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(string $url)
    {
        $link = Url::where('short_url', 'like', '%' . $url . '%')
            ->first();

        $link->number_of_visits += 1;
        $link->save();

        return redirect($link->real_url);
    }
}
