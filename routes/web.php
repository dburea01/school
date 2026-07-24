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
Route::post('login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| routes for the reset-password
|--------------------------------------------------------------------------
*/
Route::get('password-lost', function () {
    return view('auth.password-lost');
})->name('password-lost');
Route::post('password-lost', [AuthController::class, 'passwordResetRequest'])->name('password-lost');
Route::get('password-reset/{token}', [AuthController::class, 'formPasswordReset'])->where('token', '[A-Za-z0-9]{40}')->name('password-reset');
Route::post('password-reset', [AuthController::class, 'passwordReset']);
