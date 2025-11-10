<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::view('/dashboard', 'dashboard')->name('dashboard');
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('auth', function () {
    return view('auth.login');
})->name('auth');

Route::get('mua', function () {
    return view('menudpn.mua');
})->name('mua');

Route::get('/', function () {
    return view('home');
})->name('landing');

// AUTH ROUTES
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::resource('panelmua', \App\Http\Controllers\MuaController::class);
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
