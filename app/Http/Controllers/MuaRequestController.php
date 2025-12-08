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
     * GET /mua/ajukan
     * Sekarang kita TIDAK pakai halaman terpisah lagi.
     * Kalau ada yang akses URL ini, langsung balikin ke home
     * (form-nya sendiri muncul sebagai popup di home.blade.php).
     */
    public function index()
    {
        return redirect()->route('home');
    }

    /**
     * Simpan / update pengajuan MUA.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // kalau sudah MUA, tidak boleh ajukan lagi
        if ($user->isMua()) {
            return redirect()
                ->route('home')
                ->with('error', 'Kamu sudah terdaftar sebagai MUA.');
        }

        $data = $request->validate([
            'nama_usaha' => ['required', 'string', 'max:100'],
            'kontak_wa'  => ['required', 'string', 'max:20'],
            'alamat'     => ['nullable', 'string'],
            'deskripsi'  => ['nullable', 'string'],
            'instagram'  => ['nullable', 'string', 'max:100'],
            'tiktok'     => ['nullable', 'string', 'max:100'],
        ]);

        // --- NORMALISASI NOMOR WHATSAPP ---
        // ambil hanya angka
        $digits = preg_replace('/\D/', '', $data['kontak_wa'] ?? '');

        // default null kalau kosong
        $wa = null;

        if ($digits !== '') {
            if ($digits[0] === '0') {
                // kalau user (bandel) nulis 08... langsung saja
                $wa = $digits;
            } elseif (substr($digits, 0, 2) === '62') {
                // kalau dia tulis 62xxxx → jadikan 0xxxx
                $wa = '0' . substr($digits, 2);
            } else {
                // normal: dari form kita, user nulis 8123... → simpan 08123...
                $wa = '0' . $digits;
            }
        }

        $data['kontak_wa']     = $wa;
        $data['user_id']       = $user->id;
        $data['status']        = 'pending';
        $data['catatan_admin'] = null;


        $muaRequest = MuaRequest::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        // kirim email ke admin (punyamu tadi tetap aku pakai)
        try {
            $adminEmail = config('mail.admin_address', config('mail.from.address'));
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new MuaRequestSubmitted($muaRequest));
            }
        } catch (\Throwable $e) {
            // jangan bikin error ke user kalau email gagal
        }

        // PENTING: sekarang balik ke HOME, bukan ke view mua.request_index lagi
        return redirect()
            ->route('home')
            ->with('success', 'Pengajuan MUA berhasil dikirim. Pengajuan akan dikonfirmasi oleh admin, silakan tunggu.');
    }
}
