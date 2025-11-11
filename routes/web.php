<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuaController;
use App\Http\Controllers\AuthController;

// Halaman dasar
Route::get('/', function () {
    return view('home');
})->name('landing');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::view('/dashboard', 'dashboard')->name('dashboard');

Route::get('auth', function () {
    return view('auth.login');
})->name('auth');

Route::get('mua', function () {
    return view('menudpn.mua');
})->name('mua');

// AUTH ROUTES
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('panelmua', MuaController::class);

// Proteksi dashboard agar hanya bisa diakses user login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class,
'showProfile'])->name('profile.show');
 Route::put('/profile', [\App\Http\Controllers\ProfileController::class,
'updateProfile'])->name('profile.update');
});
Route::get('/files/{id}/{action}', function ($id, $action) {
 $file = \App\Models\File::findOrFail($id);
 return $file->handleAction($action);
})->name('files.action');
