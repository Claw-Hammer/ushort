<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{url}', [RedirectionController::class, 'show'])->name('url');
