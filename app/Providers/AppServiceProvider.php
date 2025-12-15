<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Khusus layout MUA panel kamu: layouts.app
        view()->composer('layouts.app', function ($view) {
            $pendingPesanan = 0;

            if (Auth::check() && strtolower(Auth::user()->role ?? '') === 'mua') {
                $mua = Auth::user()->mua;

                if ($mua) {
                    // Hitung pesanan yang masuk ke MUA ini (via layanan.mua_id)
                    // Pending = Belum_Lunas (dan support data lama: pending)
                    $pendingPesanan = Pesanan::whereHas('layanan', function ($q) use ($mua) {
                            $q->where('mua_id', $mua->id);
                        })
                        ->where(function ($q) {
                            $q->where('status_pembayaran', 'Belum_Lunas')
                              ->orWhereRaw("LOWER(REPLACE(status_pembayaran,' ','_')) = 'pending'");
                        })
                        ->count();
                }
            }

            $view->with('pendingPesanan', $pendingPesanan);
        });
    }
}
