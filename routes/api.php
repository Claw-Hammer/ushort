<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\UrlController;

Route::group(['prefix' => 'v1/url'], function () {
    Route::post('/shortener', [UrlController::class, 'index'])->name('api.v1.url.shortener');
    Route::get('/top', [UrlController::class, 'showTop'])->name('api.v1.url.top');
    Route::get('/real', [UrlController::class, 'showReal'])->name('api.v1.url.real');
});
