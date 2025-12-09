<?php

use App\Models\Pesanan;
use App\Models\Keranjang;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PublicMuaController;
use App\Http\Controllers\MuaRequestController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\MuaPortfolioController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\MuaApprovalController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| HOME & DASHBOARD
|--------------------------------------------------------------------------
*/

// Halaman utama (public) - SELALU pakai HomeController@index (galeri & tim dari DB)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard MUA (butuh login + verified + role mua)
Route::get('/dashboard', [MuaController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware(['auth', 'verified', CheckRole::class . ':mua']);

// /home hanya redirect ke home utama (tanpa nama route lagi, biar gak bentrok)
Route::middleware('auth')->get('/home', function () {
    return redirect()->route('home');
});

/*
|--------------------------------------------------------------------------
| MENU DEPAN / AUTH
|--------------------------------------------------------------------------
*/

Route::get('hubungikami', fn () => view('menudpn.hubungikami'))->name('hubungikami');

// LOGIN
Route::get('login', [AuthController::class, 'showLogin'])->name('login');

// 🔒 Proteksi brute force login: max 5 percobaan per 1 menit per IP
Route::post('login', [AuthController::class, 'login'])
    ->name('login.post')
    ->middleware('throttle:5,1');

// REGISTER
Route::get('register', [AuthController::class, 'showRegister'])->name('register');

// 🔒 Boleh juga batasi spam register (misal 10x per menit)
Route::post('register', [AuthController::class, 'register'])
    ->name('register.post')
    ->middleware('throttle:10,1');

// LOGOUT
Route::post('logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Google OAuth Routes (pakai AuthController)
Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

/*
|--------------------------------------------------------------------------
| PROFILE USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});

/*
|--------------------------------------------------------------------------
| PENGGUNA (ROLE: pengguna)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', CheckRole::class . ':pengguna'])->group(function () {
    Route::get('/pengguna/home', [PenggunaController::class, 'index'])->name('pengguna.home');
});

/*
|--------------------------------------------------------------------------
| MUA PROFILE & PANEL
|--------------------------------------------------------------------------
*/

// list MUA (khusus MUA sendiri / internal)
Route::get('/mua', [MuaController::class, 'index'])->name('mua.list');

// PANEL MUA (profile + layanan + pesanan + pembayaran, dll)
Route::middleware(['auth', 'verified', CheckRole::class . ':mua'])->group(function () {

    // halaman panel utama
    Route::get('/muapanel', [MuaController::class, 'index'])->name('mua.panel');

    // profile MUA
    Route::get('/profilemua/create', [MuaController::class, 'create'])->name('profilemua.create');
    Route::post('/profilemua', [MuaController::class, 'store'])->name('profilemua.store');
    Route::get('/profilemua/edit', [MuaController::class, 'edit'])->name('profilemua.edit');
    Route::put('/profilemua', [MuaController::class, 'update'])->name('profilemua.update');

    // prefix panelmua
    Route::prefix('panelmua')->name('panelmua.')->group(function () {

        // Layanan
        Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
        Route::get('/layanan/create', [LayananController::class, 'create'])->name('layanan.create');
        Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
        Route::get('/layanan/{layanan}/edit', [LayananController::class, 'edit'])->name('layanan.edit');
        Route::put('/layanan/{layanan}', [LayananController::class, 'update'])->name('layanan.update');
        Route::delete('/layanan/{layanan}', [LayananController::class, 'destroy'])->name('layanan.destroy');

        // Pesanan untuk MUA
        Route::get('/pesanan', [PesananController::class, 'indexMua'])->name('pesanan.index');

        // Status pesanan MUA
        Route::patch('/pesanan/{pesanan}/status', [PesananController::class, 'updateStatusMua'])->name('pesanan.updateStatus');
        Route::delete('/pesanan/{pesanan}', [PesananController::class, 'destroyMua'])->name('pesanan.destroy');

        // Pembayaran
        Route::get('/pesanan/{pesanan}/pembayaran/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/pesanan/{pesanan}/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
        Route::get('/pembayaran/{pembayaran}', [PembayaranController::class, 'show'])->name('pembayaran.show');
        Route::get('/pembayaran/{pembayaran}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
        Route::put('/pembayaran/{pembayaran}', [PembayaranController::class, 'update'])->name('pembayaran.update');
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');

        // 🔹 ROUTE BARU UNTUK LIHAT BUKTI
        Route::get('/pembayaran/{pembayaran}/bukti', [PembayaranController::class, 'viewBukti'])
            ->name('pembayaran.bukti');
    });
});

/*
|--------------------------------------------------------------------------
| PESANAN USER (ROLE: pengguna)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', CheckRole::class . ':pengguna'])->group(function () {

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

/*
|--------------------------------------------------------------------------
| PUBLIC MUA (daftar & detail) – TETAP PUBLIC (boleh diakses tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/daftarmua', [PublicMuaController::class, 'index'])
    ->name('public.mua.index');

Route::get('/daftarmua/{mua}', [PublicMuaController::class, 'show'])
    ->name('public.mua.show');

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard_a', [DashboardController::class, 'index'])
    ->name('dashboard_a')
    ->middleware(['auth', 'verified', CheckRole::class . ':admin']);

/*
|--------------------------------------------------------------------------
| USERS (ADMIN)
|--------------------------------------------------------------------------
*/

// 🔒 Semua manajemen user dibatasi ke admin saja
Route::middleware(['auth', 'verified', 'admin'])->prefix('users')->name('users.')->group(function () {
    Route::get('/', [PenggunaController::class, 'index'])->name('index');
    Route::get('/create', [PenggunaController::class, 'create'])->name('create');
    Route::post('/', [PenggunaController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [PenggunaController::class, 'edit'])->name('edit');
    Route::put('/{user}', [PenggunaController::class, 'update'])->name('update');
    Route::delete('/{user}', [PenggunaController::class, 'destroy'])->name('destroy');
});

/*
|--------------------------------------------------------------------------
| HUBUNGI KAMI (PUBLIC + ADMIN)
|--------------------------------------------------------------------------
*/

// Kirim pesan (public)
Route::post('/hubungi-kami', [ContactController::class, 'send'])->name('contact.send');

// Admin kelola pesan
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/contact-messages', [ContactController::class, 'index'])->name('admin.contact.index');
    Route::post('/contact-messages/{id}/read', [ContactController::class, 'markAsRead'])->name('admin.contact.read');
    Route::delete('/contact-messages/{id}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');
    Route::get('/contact-messages/unread-count', [ContactController::class, 'unreadCount']);
});

/*
|--------------------------------------------------------------------------
| LUPA PASSWORD
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

// 🔒 Batasin kirim email reset password biar gak disalahgunakan
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email')
    ->middleware('throttle:5,1');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

// 🔒 Batasin percobaan reset juga
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update')
    ->middleware('throttle:5,1');

/*
|--------------------------------------------------------------------------
| ROUTES VERIFIKASI EMAIL LARAVEL (HYBRID + POPUP DI HOME)
|--------------------------------------------------------------------------
*/

// Halaman "verifikasi dulu ya" → TIDAK pakai view, langsung ke home + popup
Route::get('/email/verify', function (Request $request) {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('home');
    }

    return redirect()
        ->route('home')
        ->with('show_verify_modal', true);
})->middleware('auth')->name('verification.notice');

// Link verifikasi dari email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()
        ->route('home')
        ->with('success', 'Email kamu berhasil diverifikasi. Terima kasih! ✨');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Kirim ulang email verifikasi (dipakai di popup & alert)
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Email verifikasi telah dikirim ulang. Silakan cek inbox & folder spam ya ✉️');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| PENGAJUAN MUA (USER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mua/ajukan', [MuaRequestController::class, 'index'])
        ->name('mua.request.index');

    Route::post('/mua/ajukan', [MuaRequestController::class, 'store'])
        ->name('mua.request.store');
});

// CTA dari home: kalau belum login → ke login; kalau belum verified → popup di home
Route::get('/ajukan-mua', function () {

    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    if (strtolower($user->role ?? '') === 'mua') {
        return redirect()->route('mua.panel');
    }

    // Kalau email belum terverifikasi → balik ke home + popup + pesan error
    if (is_null($user->email_verified_at)) {
        return redirect()
            ->route('home')
            ->with('show_verify_modal', true)
            ->with('error', 'Sebelum ajukan sebagai MUA, silakan verifikasi email kamu dulu ya ✉️');
    }

    // Kalau sudah verified tapi belum MUA → buka home + modal pengajuan MUA
    return redirect()->route('home')->with('open_mua', true);
})->name('mua.entry');

/*
|--------------------------------------------------------------------------
| ADMIN - APPROVE / REJECT MUA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/mua-requests', [MuaApprovalController::class, 'index'])->name('mua-requests.index');
    Route::get('/mua-requests/{muaRequest}', [MuaApprovalController::class, 'show'])->name('mua-requests.show');
    Route::post('/mua-requests/{muaRequest}/approve', [MuaApprovalController::class, 'approve'])->name('mua-requests.approve');
    Route::post('/mua-requests/{muaRequest}/reject', [MuaApprovalController::class, 'reject'])->name('mua-requests.reject');
});

/*
|--------------------------------------------------------------------------
| KERANJANG
|--------------------------------------------------------------------------
*/

// Tambah ke keranjang: cukup login (boleh belum verified)
Route::middleware(['auth'])->post('/keranjang/add', [KeranjangController::class, 'add'])->name('cart.add');

// Checkout: FITUR PENTING → wajib verified
Route::middleware(['auth', 'verified'])->post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('cart.checkout');

/*
|--------------------------------------------------------------------------
| ADMIN: GALERI & TIM PENGEMBANG
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('galleries', GalleryController::class);
    Route::resource('team-members', TeamMemberController::class);
});

/*
|--------------------------------------------------------------------------
| MUA PORTFOLIO
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', CheckRole::class . ':mua'])->group(function () {
    Route::get('/mua/portfolio', [MuaPortfolioController::class, 'index'])
        ->name('mua.portfolio.index');

    Route::post('/mua/portfolio', [MuaPortfolioController::class, 'store'])
        ->name('mua.portfolio.store');

    Route::delete('/mua/portfolio/{portfolio}', [MuaPortfolioController::class, 'destroy'])
        ->name('mua.portfolio.destroy');
});
