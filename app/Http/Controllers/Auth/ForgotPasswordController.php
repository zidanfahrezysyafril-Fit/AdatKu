<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // TAMPILKAN FORM "LUPA PASSWORD"
    public function showLinkRequestForm()
    {
        return view('auth.forgot_password');
    }

    // PROSES KIRIM EMAIL RESET
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        // Biar aman: JANGAN kasih tahu apakah email terdaftar atau tidak
        if (!$user) {
            return back()->with('status', 'Jika email terdaftar, link reset password telah dikirim.');
        }

        // Hapus token lama untuk email ini
        DB::table('password_resets')->where('email', $request->email)->delete();

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email'      => $request->email,
            'token'      => $token, // disimpan plain, tapi expired nanti dicek
            'created_at' => Carbon::now(),
        ]);

        $resetUrl = route('password.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);

        // kirim email
        Mail::send('emails.reset_password', ['resetUrl' => $resetUrl], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password Akun AdatKu');
        });

        return back()->with('status', 'Jika email terdaftar, link reset password telah dikirim.');
    }
}
