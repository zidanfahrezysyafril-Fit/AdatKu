<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// HALAMAN PUBLIK
Route::get('/', function () {
    return view('home');
})->name('landing');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('auth', function () {
    return view('auth.login');
})->name('auth');

Route::get('mua', function () {
    return view('menu.mua');
})->name('mua');

// AUTH ROUTES
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// HANYA UNTUK USER LOGIN
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
<<<<<<< HEAD
    })->name('dashboard');
});
=======
    })->name('dashboard.auth');
});
>>>>>>> 81bdab28264c82ea398382c567f119fe33284aa4
