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
                    ->whereNull('deleted_at'),
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
        $userId = auth::id();
        $mua = \App\Models\Mua::where('user_id', $userId)->first();
        $tblLayanan = null;
        if (Schema::hasTable('layanans')) $tblLayanan = 'layanans';
        elseif (Schema::hasTable('layanan')) $tblLayanan = 'layanan';
        elseif (Schema::hasTable('layanan_items')) $tblLayanan = 'layanan_items';

        $totalBaju = $totalMakeup = $totalPelamin = 0;

        if ($tblLayanan && $mua) {
            $totalBaju    = DB::table($tblLayanan)->where('mua_id', $mua->id)->where('kategori', 'baju')->count();
            $totalMakeup  = DB::table($tblLayanan)->where('mua_id', $mua->id)->where('kategori', 'makeup')->count();
            $totalPelamin = DB::table($tblLayanan)->where('mua_id', $mua->id)->where('kategori', 'pelamin')->count();
        }
        $tblPesanan = Schema::hasTable('pesanan') ? 'pesanan' : (Schema::hasTable('orders') ? 'orders' : null);

        $totalPesanan = $pending = $proses = $selesai = 0;
        $revenueBulanIni = 0;
        $labels = [];
        $series = [];

        if ($tblPesanan && $mua) {
            $totalPesanan = DB::table($tblPesanan)->where('mua_id', $mua->id)->count();
            $pending      = DB::table($tblPesanan)->where('mua_id', $mua->id)->where('status', 'pending')->count();
            $proses       = DB::table($tblPesanan)->where('mua_id', $mua->id)->where('status', 'proses')->count();
            $selesai      = DB::table($tblPesanan)->where('mua_id', $mua->id)->where('status', 'selesai')->count();

            $revenueBulanIni = DB::table($tblPesanan)
                ->where('mua_id', $mua->id)
                ->where('status', 'selesai')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_harga');

            for ($i = 6; $i >= 0; $i--) {
                $tgl = now()->subDays($i)->toDateString();
                $labels[] = \Carbon\Carbon::parse($tgl)->format('d M');
                $series[] = DB::table($tblPesanan)
                    ->where('mua_id', $mua->id)
                    ->whereDate('created_at', $tgl)
                    ->count();
            }

            $pesananTerbaru = DB::table($tblPesanan)
                ->where('mua_id', $mua->id)
                ->latest()
                ->take(6)
                ->get();
        } else {
            for ($i = 6; $i >= 0; $i--) {
                $labels[] = now()->subDays($i)->format('d M');
                $series[] = 0;
            }
            $pesananTerbaru = collect();
        }

        return view('dashboard', compact(
            'mua',
            'totalBaju',
            'totalMakeup',
            'totalPelamin',
            'totalPesanan',
            'pending',
            'proses',
            'selesai',
            'revenueBulanIni',
            'labels',
            'series',
            'pesananTerbaru'
        ));
    }
}
