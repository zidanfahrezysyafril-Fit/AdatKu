<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    // TAMPILKAN FORM SETEL ULANG PASSWORD
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');

        return view('auth.reset_password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    // PROSES SIMPAN PASSWORD BARU
    public function reset(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'token'    => ['required'],
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        // cek token ada & belum kadaluarsa (misal 60 menit)
        if (!$reset || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors([
                'email' => 'Token reset password tidak valid atau sudah kadaluarsa.',
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Pengguna tidak ditemukan.',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // hapus token setelah dipakai
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil direset, silakan login.');
        // kalau nama route login kamu beda, ganti 'login' jadi nama route-mu
    }
}
