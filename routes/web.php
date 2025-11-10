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

=======
>>>>>>> d357a4052ae19e65fe0b0e967bdaff9c5465de25
    })->name('dashboard.auth');
});

