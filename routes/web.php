<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/home');
});
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('toko', function () {
    return redirect('/toko');
});
Route::get('/toko', function () {
    return view('toko');
})->name('toko');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/auth', function () {
        return view('auth');
    })->name('auth');
});
