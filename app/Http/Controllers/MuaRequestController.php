<?php

namespace App\Http\Controllers;

use App\Models\MuaRequest;
use Illuminate\Http\Request;
use App\Mail\MuaRequestSubmitted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MuaRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // hanya user login
    }

    /**
     * Halaman: Ajukan / Lihat status pengajuan MUA (untuk USER).
     */
    public function index()
    {
        $user = Auth::user();
        $requestMua = $user->muaRequest; // bisa null

        // PENTING: pakai view user, bukan admin
        return view('mua.request_index', compact('user', 'requestMua'));
    }

    /**
     * Simpan / update pengajuan MUA.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // kalau sudah MUA, tidak boleh ajukan lagi
        if ($user->isMua()) {
            return redirect()->back()->with('error', 'Kamu sudah terdaftar sebagai MUA.');
        }

        $data = $request->validate([
            'nama_usaha' => ['required', 'string', 'max:100'],
            'kontak_wa'  => ['required', 'string', 'max:20'],
            'alamat'     => ['nullable', 'string'],
            'deskripsi'  => ['nullable', 'string'],
            'instagram'  => ['nullable', 'string', 'max:100'],
            'tiktok'     => ['nullable', 'string', 'max:100'],
        ]);

        $data['user_id'] = $user->id;
        $data['status']  = 'pending';
        $data['catatan_admin'] = null;

        $muaRequest = MuaRequest::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        // kirim email ke admin
        try {
            $adminEmail = config('mail.admin_address', config('mail.from.address'));
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new MuaRequestSubmitted($muaRequest));
            }
        } catch (\Throwable $e) {
        }

        return redirect()
            ->route('mua.request.index')
            ->with('success', 'Pengajuan MUA berhasil dikirim. Mohon tunggu persetujuan admin.');
    }
}
