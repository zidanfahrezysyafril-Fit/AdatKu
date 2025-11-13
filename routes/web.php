<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\LayananController;

// --- Public & auth basic ---
Route::get('/', fn() => view('home'))->name('landing');
Route::get('/home', fn() => view('home'))->name('home');
Route::get('/dashboard', [\App\Http\Controllers\MuaController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware('auth');

Route::get('mua', fn() => view('menudpn.mua'))->name('mua');
Route::get('hubungikami', fn() => view('menudpn.hubungikami'))->name('hubungikami');
Route::get('daftarmua', fn() => view('menudpn.mua'))->name('mua');

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

    Route::prefix('panelmua')->name('panelmua.')->group(function () {
        Route::resource('layanan', LayananController::class)->except('show');
    });
});

Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':pengguna'])->group(function () {
    Route::get('/pengguna/home', [PenggunaController::class, 'index'])->name('pengguna.home');
});

Route::get('/pilih-mua', function () {
    $muas = \App\Models\Mua::latest()->paginate(12);
    return view('public.pilih-mua', compact('muas'));
})->name('pilih.mua');

Route::get('/mua/{id}', function (string $id) {
    $mua = \App\Models\Mua::with('layanan')->findOrFail($id);
    return view('public.mua-show', compact('mua'));
})->name('public.mua.show');

Route::get('/mua', [MuaController::class, 'index'])->name('mua.list');