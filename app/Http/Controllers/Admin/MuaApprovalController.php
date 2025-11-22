<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\MuaRequestStatusUpdated;
use App\Models\Mua;
use App\Models\MuaRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MuaApprovalController extends Controller
{
    public function __construct()
    {
        // harus login
        $this->middleware('auth');

        // harus admin
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            if (!$user || $user->role !== 'Admin') {
                abort(403, 'Hanya admin yang boleh mengakses.');
            }

            return $next($request);
        });
    }

    /**
     * Halaman list semua pengajuan MUA (pending/approved/rejected)
     */
    public function index()
    {
        $pending  = MuaRequest::where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        $approved = MuaRequest::where('status', 'approved')
            ->with('user')
            ->latest()
            ->get();

        $rejected = MuaRequest::where('status', 'rejected')
            ->with('user')
            ->latest()
            ->get();

        // NOTE: SESUAIKAN DENGAN NAMA FILE:
        // resources/views/admin/mua_request_index.blade.php
        return view('admin.mua_request_index', [
            'pending'  => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
        ]);
    }

    /**
     * Detail satu pengajuan (kalau nanti kamu buat view-nya).
     */
    public function show(MuaRequest $muaRequest)
    {
        // nanti kalau sudah bikin: resources/views/admin/mua_request_show.blade.php
        return view('admin.mua_request_show', [
            'muaRequest' => $muaRequest,
        ]);
    }

    /**
     * Approve pengajuan MUA.
     */
    public function approve(Request $request, MuaRequest $muaRequest)
    {
        $request->validate([
            'catatan_admin' => ['nullable', 'string'],
        ]);

        $user = $muaRequest->user;

        // 1. Buat / update data di tabel muas
        $mua = Mua::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_usaha' => $muaRequest->nama_usaha,
                'kontak_wa'  => $muaRequest->kontak_wa,
                'alamat'     => $muaRequest->alamat,
                'deskripsi'  => $muaRequest->deskripsi,
                'instagram'  => $muaRequest->instagram,
                'tiktok'     => $muaRequest->tiktok,
                // 'foto'    => $muaRequest->foto, // kalau nanti pakai foto
            ]
        );

        // 2. Ubah role user → MUA
        $user->role = 'MUA';
        $user->save();

        // 3. Update status pengajuan
        $muaRequest->status        = 'approved';
        $muaRequest->catatan_admin = $request->input('catatan_admin');
        $muaRequest->save();

        // 4. Kirim email ke user
        try {
            Mail::to($user->email)->send(new MuaRequestStatusUpdated($muaRequest));
        } catch (\Throwable $e) {
            // kalau email gagal, jangan bikin error ke user
        }

        return redirect()
            ->route('admin.mua-requests.index')
            ->with('success', 'Pengajuan MUA disetujui dan role user diubah menjadi MUA.');
    }

    /**
     * Reject pengajuan MUA.
     */
    public function reject(Request $request, MuaRequest $muaRequest)
    {
        $data = $request->validate([
            'catatan_admin' => ['required', 'string', 'min:5'],
        ]);

        $muaRequest->status        = 'rejected';
        $muaRequest->catatan_admin = $data['catatan_admin'];
        $muaRequest->save();

        // kirim email ke user
        try {
            Mail::to($muaRequest->user->email)->send(new MuaRequestStatusUpdated($muaRequest));
        } catch (\Throwable $e) {
        }

        return redirect()
            ->route('admin.mua-requests.index')
            ->with('success', 'Pengajuan MUA ditolak.');
    }
}
