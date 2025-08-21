<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(SocialiteController::class)->group(function () {
// Google Login
    Route::get('/auth/google', 'googleLogin')->name('auth.google');
    Route::get('/auth/callback', 'googleAuthentication')->name('auth.callback');

    // Github Login
    Route::get('auth/github', 'githubLogin')->name('github.login');
    Route::get('auth/github/callback', 'githubAuthentication');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
