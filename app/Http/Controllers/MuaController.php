<?php

namespace App\Http\Controllers;

use App\Models\Mua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\Layanan;
use Carbon\Carbon;

class MuaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if (!$user) abort(401);

            $role = strtolower(trim($user->role ?? ''));
            if (!in_array($role, ['mua', 'admin'], true)) {
                abort(403, 'Akses khusus MUA');
            }
            return $next($request);
        });
    }

    public function index(): View
    {
        $mua = Mua::where('user_id', Auth::id())->first();
        return view('profilemua.index', compact('mua'));
    }

    public function create(): View|RedirectResponse
    {
        if (Auth::user()->mua) {
            return redirect()->route('profilemua.edit');
        }
        return view('profilemua.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $existing = Auth::user()->mua;

        $data = $request->validate([
            'nama_usaha' => ['required', 'string', 'max:100'],
            'kontak_wa'  => [
                'required',
                'string',
                'max:20',
                Rule::unique('muas', 'kontak_wa')
                    ->ignore($existing?->id)
            ],
            'alamat'     => ['nullable', 'string'],
            'deskripsi'  => ['nullable', 'string'],
            'instagram'  => ['nullable', 'string', 'max:100'],
            'tiktok'     => ['nullable', 'string', 'max:100'],
            'foto'       => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('muas', 'public');
        }
        $data['user_id'] = Auth::id();

        Mua::updateOrCreate(['user_id' => Auth::id()], $data);

        return redirect()->route('mua.panel')->with('success', 'Profil MUA tersimpan.');
    }

    public function edit()
    {
        $mua = Mua::where('user_id', Auth::id())->first();

        if (!$mua) {
            abort(404, 'Data MUA tidak ditemukan.');
        }

        return view('profilemua.edit', compact('mua'));
    }

    public function update(Request $request): RedirectResponse
    {
        $mua = Mua::where('user_id', Auth::id())->firstOrFail();

        $data = $request->validate([
            'nama_usaha' => ['required', 'string', 'max:100'],
            'kontak_wa'  => ['required', 'string', 'max:20', Rule::unique('muas', 'kontak_wa')->ignore($mua->id)],
            'alamat'     => ['nullable', 'string'],
            'deskripsi'  => ['nullable', 'string'],
            'instagram'  => ['nullable', 'string', 'max:100'],
            'tiktok'     => ['nullable', 'string', 'max:100'],
            'foto'       => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($mua->foto && Storage::disk('public')->exists($mua->foto)) {
                Storage::disk('public')->delete($mua->foto);
            }
            $data['foto'] = $request->file('foto')->store('muas', 'public');
        }

        $mua->update($data);

        return redirect()->route('mua.panel')->with('success', 'Profil MUA berhasil diperbarui.');
    }
    public function dashboard()
    {
        $user = Auth::user();

        // Profil MUA milik user ini
        $mua = Mua::where('user_id', $user->id)->first();

        // Nilai default kalau belum ada data
        $totalPesanan       = 0;
        $totalPending       = 0;
        $totalProses        = 0; // kamu tidak pakai status "proses"
        $totallunas         = 0;
        $pendapatanBulanIni = 0;
        $pesananTerbaru     = collect();

        if ($mua) {
            // semua layanan milik MUA ini
            $layananIds = Layanan::where('mua_id', $mua->id)->pluck('id');

            if ($layananIds->isNotEmpty()) {

                // ambil SEMUA baris pesanan untuk layanan-layanan ini
                $allPesanan = Pesanan::whereIn('id_layanan', $layananIds)
                    ->orderByDesc('tanggal_booking')
                    ->get();

                // group per kode_checkout (1 booking = 1 group)
                $orders = $allPesanan->groupBy('kode_checkout');

                // ----- COUNTER ATAS -----

                // total pesanan = jumlah booking (bukan jumlah baris)
                $totalPesanan = $orders->count();

                // hitung pending & lunas dari status_pembayaran tiap booking
                $totalPending = $orders->filter(function ($group) {
                    $first  = $group->first();
                    $status = strtolower(str_replace(' ', '_', $first->status_pembayaran ?? ''));
                    return in_array($status, ['pending', 'belum_lunas'], true);
                })->count();

                $totallunas = $orders->filter(function ($group) {
                    $first  = $group->first();
                    $status = strtolower(str_replace(' ', '_', $first->status_pembayaran ?? ''));
                    return $status === 'lunas';
                })->count();

                // totalProses tetap 0 karena kamu tidak punya status itu
                $totalProses = 0;

                // ----- PENDAPATAN (SEMUA WAKTU) -----

                $pendapatanBulanIni = $orders->filter(function ($group) {
                    $first  = $group->first();
                    $status = strtolower(str_replace(' ', '_', $first->status_pembayaran ?? ''));

                    return $status === 'lunas';
                })->sum(function ($group) {
                    // total 1 booking = jumlah total_harga semua layanan di dalamnya
                    return $group->sum('total_harga');
                });
                // ----- PESANAN TERBARU (LIST BAWAH) -----

                $pesananTerbaru = $orders
                    ->sortByDesc(function ($group) {
                        return $group->first()->tanggal_booking;
                    })
                    ->take(6)
                    ->map(function ($group) {
                        $first = $group->first();

                        // buat properti khusus untuk dashboard
                        $first->total_dashboard = $group->sum('total_harga');

                        // kalau layanannya banyak, tulis "3 layanan", dll
                        if ($group->count() > 1) {
                            $first->layanan_dashboard = $group->count() . ' layanan';
                        } else {
                            $first->layanan_dashboard = optional($first->layanan)->nama;
                        }

                        return $first;
                    })
                    ->values();
            }
        }

        return view('dashboard', [
            'mua'                => $mua,
            'totalPesanan'       => $totalPesanan,
            'totalPending'       => $totalPending,
            'totalProses'        => $totalProses,
            'totallunas'         => $totallunas,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'pesananTerbaru'     => $pesananTerbaru,
        ]);
    }
}
