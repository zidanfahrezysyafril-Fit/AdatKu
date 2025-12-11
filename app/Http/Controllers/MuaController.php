<?php

namespace App\Http\Controllers;

use App\Models\Mua;
use App\Models\Pesanan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MuaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (! $user) {
                abort(401);
            }

            $role = strtolower(trim($user->role ?? ''));
            if (! in_array($role, ['mua', 'admin'], true)) {
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
                Rule::unique('muas', 'kontak_wa')->ignore($existing?->id),
            ],
            'alamat'     => ['nullable', 'string'],
            'deskripsi'  => ['nullable', 'string'],
            'instagram'  => ['nullable', 'string', 'max:100'],
            'tiktok'     => ['nullable', 'string', 'max:100'],
            'foto'       => ['nullable', 'image', 'max:2048'],
        ]);

        // ====== HANDLE FOTO PROFIL MUA (UPLOADS) ======
        if ($request->hasFile('foto')) {
            $userId    = Auth::id();
            $uploadDir = public_path('uploads/muas/' . $userId);

            // buat folder jika belum ada
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // kalau sudah ada MUA dan punya foto lama → hapus dulu
            if ($existing && $existing->foto && file_exists(public_path($existing->foto))) {
                @unlink(public_path($existing->foto));
            }

            $file     = $request->file('foto');
            $filename = 'mua-' . $userId . '-' . time() . '.' . $file->getClientOriginalExtension();

            // pindahkan ke public/uploads/muas/{user_id}
            $file->move($uploadDir, $filename);

            // simpan path relatif (dari public)
            $data['foto'] = 'uploads/muas/' . $userId . '/' . $filename;
        }

        $data['user_id'] = Auth::id();

        Mua::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        return redirect()
            ->route('mua.panel')
            ->with('success', 'Profil MUA tersimpan.');
    }

    public function edit()
    {
        $mua = Mua::where('user_id', Auth::id())->first();

        if (! $mua) {
            abort(404, 'Data MUA tidak ditemukan.');
        }

        return view('profilemua.edit', compact('mua'));
    }

    public function update(Request $request): RedirectResponse
    {
        $mua = Mua::where('user_id', Auth::id())->firstOrFail();

        $data = $request->validate([
            'nama_usaha' => ['required', 'string', 'max:100'],
            'kontak_wa'  => [
                'required',
                'string',
                'max:20',
                Rule::unique('muas', 'kontak_wa')->ignore($mua->id),
            ],
            'alamat'     => ['nullable', 'string'],
            'deskripsi'  => ['nullable', 'string'],
            'instagram'  => ['nullable', 'string', 'max:100'],
            'tiktok'     => ['nullable', 'string', 'max:100'],
            'foto'       => ['nullable', 'image', 'max:2048'],
        ]);

        // ====== HANDLE FOTO PROFIL MUA (UPLOADS) ======
        if ($request->hasFile('foto')) {
            $userId    = Auth::id();
            $uploadDir = public_path('uploads/muas/' . $userId);

            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // hapus foto lama kalau ada
            if ($mua->foto && file_exists(public_path($mua->foto))) {
                @unlink(public_path($mua->foto));
            }

            $file     = $request->file('foto');
            $filename = 'mua-' . $userId . '-' . time() . '.' . $file->getClientOriginalExtension();

            $file->move($uploadDir, $filename);

            $data['foto'] = 'uploads/muas/' . $userId . '/' . $filename;
        }

        $mua->update($data);

        return redirect()
            ->route('mua.panel')
            ->with('success', 'Profil MUA berhasil diperbarui.');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $mua  = Mua::where('user_id', $user->id)->first();

        $totalPesanan       = 0;
        $totalPending       = 0;
        $totalProses        = 0; // status "proses" memang tidak dipakai
        $totallunas         = 0;
        $pendapatanBulanIni = 0;
        $pesananTerbaru     = collect();

        if ($mua) {
            $layananIds = Layanan::where('mua_id', $mua->id)->pluck('id');

            if ($layananIds->isNotEmpty()) {
                $allPesanan = Pesanan::whereIn('id_layanan', $layananIds)
                    ->orderByDesc('tanggal_booking')
                    ->get();

                $orders = $allPesanan->groupBy('kode_checkout');

                // total pesanan = jumlah booking
                $totalPesanan = $orders->count();

                // pending & lunas berdasar status_pembayaran
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

                $totalProses = 0; // tidak dipakai

                // pendapatan = total_harga semua booking yang lunas
                $pendapatanBulanIni = $orders->filter(function ($group) {
                    $first  = $group->first();
                    $status = strtolower(str_replace(' ', '_', $first->status_pembayaran ?? ''));
                    return $status === 'lunas';
                })->sum(function ($group) {
                    return $group->sum('total_harga');
                });

                // pesanan terbaru untuk list di dashboard
                $pesananTerbaru = $orders
                    ->sortByDesc(function ($group) {
                        return $group->first()->tanggal_booking;
                    })
                    ->take(6)
                    ->map(function ($group) {
                        $first = $group->first();

                        $first->total_dashboard = $group->sum('total_harga');

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
