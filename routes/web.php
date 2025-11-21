<?php

use App\Models\Pesanan;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PublicMuaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\GoogleController;

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

// Google OAuth Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

// Protected Routes (contoh)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard_a');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});

Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':mua'])->group(function () {
    Route::get('/muapanel', [MuaController::class, 'index'])->name('mua.panel');

    Route::get('/profilemua/create', [MuaController::class, 'create'])->name('profilemua.create');
    Route::post('/profilemua', [MuaController::class, 'store'])->name('profilemua.store');
    Route::get('/profilemua/edit', [MuaController::class, 'edit'])->name('profilemua.edit');
    Route::put('/profilemua', [MuaController::class, 'update'])->name('profilemua.update');
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

        Route::get('/pesanan', [PesananController::class, 'indexMua'])
            ->name('pesanan.index');
    });
});

Route::get('/daftarmua', [PublicMuaController::class, 'index'])
    ->name('public.mua.index');

Route::get('/daftarmua/{mua}', [PublicMuaController::class, 'show'])
    ->name('public.mua.show');

Route::get('/dashboard_a', [DashboardController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware(['auth', CheckRole::class . ':admin']);

Route::get('/users', [PenggunaController::class, 'index'])->name('users.index');

Route::get('/users/create', [PenggunaController::class, 'create'])->name('users.create');
Route::post('/users', [PenggunaController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [PenggunaController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [PenggunaController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [PenggunaController::class, 'destroy'])->name('users.destroy');

Route::middleware(['auth', CheckRole::class . ':pengguna'])->group(function () {
    Route::get('/pesanan', [PesananController::class, 'indexUser'])
        ->name('pengguna.pesanan.index');

    Route::get('/pesanan/create/{layanan}', [PesananController::class, 'createUser'])
        ->name('pengguna.pesanan.create');

    Route::post('/pengguna/pesanan/store', [PesananController::class, 'storeuser'])
        ->name('pengguna.store');

    Route::get('/pesanan/{pesanan}', [PesananController::class, 'showUser'])
        ->name('pengguna.show');

    Route::delete('/pesanan/{pesanan}', [PesananController::class, 'destroyUser'])
        ->name('pengguna.destroy');
});

Route::middleware(['auth', CheckRole::class . ':mua'])->group(function () {

    Route::prefix('panelmua')->name('panelmua.')->group(function () {

        Route::get('/pesanan', [PesananController::class, 'indexMua'])
            ->name('pesanan.index');

        Route::patch('/pesanan/{pesanan}/status', [PesananController::class, 'updateStatusMua'])
            ->name('pesanan.updateStatus');

        Route::delete('/pesanan/{pesanan}', [PesananController::class, 'destroyMua'])
            ->name('pesanan.destroy');

        Route::get('/pesanan/{pesanan}/pembayaran/create', [PembayaranController::class, 'create'])
            ->name('pembayaran.create');

        Route::post('/pesanan/{pesanan}/pembayaran', [PembayaranController::class, 'store'])
            ->name('pembayaran.store');

        Route::get('/pembayaran/{pembayaran}', [PembayaranController::class, 'show'])
            ->name('pembayaran.show');

        Route::get('/pembayaran/{pembayaran}/edit', [PembayaranController::class, 'edit'])
            ->name('pembayaran.edit');

        Route::put('/pembayaran/{pembayaran}', [PembayaranController::class, 'update'])
            ->name('pembayaran.update');

        Route::get('/pembayaran', [PembayaranController::class, 'index'])
            ->name('pembayaran.index');
    });
});

    // Route untuk kirim pesan (public)
    Route::post('/api/hubungi-kami', [ContactController::class, 'send']);

    // Route untuk admin (harus login sebagai admin)
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/contact-messages', [ContactController::class, 'index'])->name('admin.contact.index');
        Route::post('/contact-messages/{id}/read', [ContactController::class, 'markAsRead'])->name('admin.contact.read');
        Route::delete('/contact-messages/{id}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');
        Route::get('/contact-messages/unread-count', [ContactController::class, 'unreadCount']);
    });
    
