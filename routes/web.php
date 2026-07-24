<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('the-author', function () {
    return view('the-author');
})->name('the-author');
/*
|--------------------------------------------------------------------
| routes for authentication
|--------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
