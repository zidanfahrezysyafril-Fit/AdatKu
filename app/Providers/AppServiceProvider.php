<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('layouts.app', function ($view) {
            $pendingPesanan = 0;

            if (Auth::check()) {
                $role = strtolower(Auth::user()->role ?? '');

                // khusus MUA aja
                if ($role === 'mua') {
                    // sesuaikan field ini dengan tabel pesanan kamu: mua_id / id_mua / mua_user_id
                    $pendingPesanan = Pesanan::where('mua_id', Auth::id())
                        ->where('status', 'pending')
                        ->count();
                }
            }

            $view->with('pendingPesanan', $pendingPesanan);
        });
    }
}
