<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Mua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LayananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = auth::user();
            if (!$user) {
                abort(401);
            }

            $role = strtolower(trim($user->role ?? ''));
            if (!in_array($role, ['mua', 'admin'], true)) {
                abort(403, 'Akses khusus MUA');
            }
            return $next($request);
        });
    }

    public function index(): View
    {
        $mua = Auth::user()->mua;
        abort_unless((bool) $mua, 404);

        $items = Layanan::where('mua_id', $mua->id)
            ->latest()
            ->paginate(12);

        return view('panelmua.layanan.index', compact('items', 'mua'));
    }

    public function create(): View
    {
        abort_unless((bool) Auth::user()->mua, 404);
        return view('panelmua.layanan.create');
    }

    public function store(Request $r): RedirectResponse
    {
        $mua = Auth::user()->mua;
        abort_unless((bool) $mua, 404);

        $data = $r->validate([
            'nama'      => ['required', 'string', 'max:120'],
            'harga'     => ['required', 'integer', 'min:0'],
            'kategori'  => ['nullable', 'string', 'max:40'],
            'deskripsi' => ['nullable', 'string'],
            'foto'      => ['nullable', 'image', 'max:2048'],
        ]);

        if ($r->hasFile('foto')) {
            $data['foto'] = $r->file('foto')->store('layanan', 'public');
        }
        $data['mua_id'] = $mua->id;

        Layanan::create($data);

        return redirect()->route('panelmua.layanan.index')->with('success', 'Layanan ditambahkan.');
    }

    public function edit(string $id): View
    {
        $mua = Auth::user()->mua;
        $item = Layanan::where('id', $id)->where('mua_id', $mua->id)->firstOrFail();
        return view('panelmua.layanan.edit', compact('item'));
    }

    public function update(Request $r, string $id): RedirectResponse
    {
        $mua = Auth::user()->mua;
        $item = Layanan::where('id', $id)->where('mua_id', $mua->id)->firstOrFail();

        $data = $r->validate([
            'nama'      => ['required', 'string', 'max:120'],
            'harga'     => ['required', 'integer', 'min:0'],
            'kategori'  => ['nullable', 'string', 'max:40'],
            'deskripsi' => ['nullable', 'string'],
            'foto'      => ['nullable', 'image', 'max:2048'],
        ]);

        if ($r->hasFile('foto')) {
            if ($item->foto) Storage::disk('public')->delete($item->foto);
            $data['foto'] = $r->file('foto')->store('layanan', 'public');
        }

        $item->update($data);

        return redirect()->route('panelmua.layanan.index')->with('success', 'Layanan diupdate.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $mua = Auth::user()->mua;
        $item = Layanan::where('id', $id)->where('mua_id', $mua->id)->firstOrFail();

        if ($item->foto) Storage::disk('public')->delete($item->foto);

        $item->delete();

        return back()->with('success', 'Layanan dihapus.');
    }
}
