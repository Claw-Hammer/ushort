<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\UrlController;

Route::group(['prefix' => 'v1/url'], function () {
    Route::get('/shortener', [UrlController::class, 'index'])->name('api.v1.url.shortener');
    Route::get('/top', [UrlController::class, 'showTop'])->name('api.v1.url.top');
});
