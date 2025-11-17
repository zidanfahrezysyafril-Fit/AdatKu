<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PublicMuaController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', fn() => view('home'))->name('landing');
Route::get('/home', fn() => view('home'))->name('home');
Route::get('/dashboard', [\App\Http\Controllers\MuaController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware('auth');

Route::get('hubungikami', fn() => view('menudpn.hubungikami'))->name('hubungikami');

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});

Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':mua'])->group(function () {
    Route::get('/muapanel', [MuaController::class, 'index'])->name('mua.panel');

    Route::get('/profilemua/create', [MuaController::class, 'create'])->name('profilemua.create');
    Route::post('/profilemua',        [MuaController::class, 'store'])->name('profilemua.store');
    Route::get('/profilemua/edit',    [MuaController::class, 'edit'])->name('profilemua.edit');
    Route::put('/profilemua',         [MuaController::class, 'update'])->name('profilemua.update');
});

Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':pengguna'])->group(function () {
    Route::get('/pengguna/home', [PenggunaController::class, 'index'])->name('pengguna.home');
});

Route::get('/mua', [MuaController::class, 'index'])->name('mua.list');

Route::middleware(['auth', CheckRole::class . ':mua'])->group(function () {

    Route::prefix('panelmua')->name('panelmua.')->group(function () {

        Route::get('/layanan', [LayananController::class, 'index'])
            ->name('layanan.index');

        Route::get('/layanan/create', [LayananController::class, 'create'])
            ->name('layanan.create');

        Route::post('/layanan', [LayananController::class, 'store'])
            ->name('layanan.store');

        Route::get('/layanan/{layanan}/edit', [LayananController::class, 'edit'])
            ->name('layanan.edit');

        Route::put('/layanan/{layanan}', [LayananController::class, 'update'])
            ->name('layanan.update');

        Route::delete('/layanan/{layanan}', [LayananController::class, 'destroy'])
            ->name('layanan.destroy');
    });
});

// Halaman daftar MUA (user depan)
Route::get('/daftarmua', [PublicMuaController::class, 'index'])
    ->name('public.mua.index');

// Halaman detail satu MUA + layanan
Route::get('/daftarmua/{mua}', [PublicMuaController::class, 'show'])
    ->name('public.mua.show');
Route::get('/dashboard_a', [DashboardController::class, 'index'])->name('admin.dashboard');
