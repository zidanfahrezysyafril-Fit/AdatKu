<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\MuaRequest;   // <-- tambahkan ini
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // user yang sedang login
        $userLogin = Auth::user();

        // semua user MUA (lebih aman untuk case lowercase/uppercase)
        $muas = User::whereRaw('LOWER(role) = ?', ['mua'])->orderBy('name')->get();

        // total untuk card
        $totalUser = User::count();
        $totalMua  = $muas->count();

        /** ------------------------------------------------------------------
         *  PENGAJUAN MUA (UNTUK NOTIFIKASI)
         * ------------------------------------------------------------------*/
        $pendingRequestsCount = MuaRequest::where('status', 'pending')->count();

        // ambil 3 pengajuan terbaru untuk ditampilkan
        $latestPendingRequests = MuaRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard_a', compact(
            'userLogin',
            'muas',
            'totalUser',
            'totalMua',
            'pendingRequestsCount',
            'latestPendingRequests'
        ));
    }
}
