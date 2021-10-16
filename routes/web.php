<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{url}', [RedirectionController::class, 'show'])->name('url');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
