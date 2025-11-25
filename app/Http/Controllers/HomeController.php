<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\MuaRequest;
use App\Models\Gallery;
use App\Models\TeamMember;
use App\Models\Mua;
use App\Models\Layanan;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // =========================
        //  STATUS PENGAJUAN MUA USER (KALAU LOGIN)
        // =========================
        $requestMua = null;
        if ($user) {
            $requestMua = MuaRequest::where('user_id', $user->id)->first();
        }

        // =========================
        //  GALERI (4 item per kategori)
        // =========================
        $galleryBaju = Gallery::where('kategori', 'baju_adat')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->take(4)
            ->get();

        $galleryMakeup = Gallery::where('kategori', 'makeup')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->take(4)
            ->get();

        $galleryPelaminan = Gallery::where('kategori', 'pelaminan')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->take(4)
            ->get();

        // =========================
        //  TIM PENGEMBANG
        // =========================
        $team = TeamMember::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        // =========================
        //  HITUNG TOTAL DATA (MUA & LAYANAN)
        // =========================

        // Semua MUA yang sudah punya profil di tabel muas
        $totalMua = Mua::count();

        // Semua layanan yang tersedia di website
        $totalBusana    = Layanan::where('kategori', 'baju')->count();
        $totalMakeup    = Layanan::where('kategori', 'makeup')->count();
        $totalPelaminan = Layanan::where('kategori', 'pelaminan')->count();

        // =========================
        //  KIRIM KE BLADE
        // =========================
        return view('home', [
            'user'             => $user,
            'requestMua'       => $requestMua,

            'galleryBaju'      => $galleryBaju,
            'galleryMakeup'    => $galleryMakeup,
            'galleryPelaminan' => $galleryPelaminan,

            'team'             => $team,

            'totalMua'         => $totalMua,
            'totalBusana'      => $totalBusana,
            'totalMakeup'      => $totalMakeup,
            'totalPelaminan'   => $totalPelaminan,
        ]);
    }
}
