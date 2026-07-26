<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolController;
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

/*
|--------------------------------------------------------------------------
| routes with authentication
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/school/settings', [SchoolController::class, 'edit'])->name('school.edit');
    Route::put('/school/settings', [SchoolController::class, 'update'])->name('school.update');
});
