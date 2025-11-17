<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // user yang sedang login
        $userLogin = auth()->user();

        // semua user yang jadi MUA (diasumsikan pakai kolom 'role' = 'mua')
        $muas = User::where('role', 'mua')->orderBy('name')->get();

        // total untuk card
        $totalUser   = User::count();
        $totalMua    = $muas->count();

        return view('dashboard_a', compact(
            'userLogin',
            'muas',
            'totalUser',
            'totalMua'
        ));
    }
}
