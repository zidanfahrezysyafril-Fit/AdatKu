<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\MuaRequest;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $requestMua = null;
        if ($user) {
            // ambil pengajuan MUA milik user ini (kalau ada)
            $requestMua = MuaRequest::where('user_id', $user->id)->first();
        }

        // Kalau kamu punya variabel $team di home, tinggal tambahin di sini
        // misal: $team = Team::all();

        return view('home', [
            'user'       => $user,
            'requestMua' => $requestMua,
            // 'team'    => $team,
        ]);
    }
}
