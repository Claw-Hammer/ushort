<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectionController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/top-urls', 'top-url')->name('top-urls');
});

Route::get('/{url}', [RedirectionController::class, 'show'])->name('url');
