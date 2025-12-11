<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LayananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user) abort(401);

            $role = strtolower($user->role ?? '');
            if (!in_array($role, ['mua', 'admin'])) {
                abort(403, 'Akses khusus MUA');
            }

            return $next($request);
        });
    }

    public function index(): View
    {
        $mua = Auth::user()->mua;
        abort_unless($mua, 404);

        $kategori = request('k');

        $query = Layanan::where('mua_id', $mua->id);

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        return view('layanan.index', [
            'items'    => $query->latest()->paginate(12),
            'mua'      => $mua,
            'kategori' => $kategori,
        ]);
    }

    public function create(): View
    {
        abort_unless(Auth::user()->mua, 404);
        return view('layanan.create')->with('item', null);
    }

    public function store(Request $r): RedirectResponse
    {
        $mua = Auth::user()->mua;
        abort_unless($mua, 404);

        $data = $r->validate([
            'nama'      => 'required|string|max:120',
            'harga'     => 'required|integer|min:0',
            'kategori'  => 'nullable|string|max:40',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|max:2048',
        ]);

        // === UPLOAD FOTO ===
        if ($r->hasFile('foto')) {
            $folderPath = base_path('../public_html/adatku/uploads/layanan/' . $mua->id);

            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $file = $r->file('foto');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($folderPath, $filename);

            $data['foto'] = 'uploads/layanan/' . $mua->id . '/' . $filename;
        }

        $data['mua_id'] = $mua->id;

        Layanan::create($data);

        return to_route('panelmua.layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(string $id): View
    {
        $mua = Auth::user()->mua;
        abort_unless($mua, 404);

        $item = Layanan::where('id', $id)
            ->where('mua_id', $mua->id)
            ->firstOrFail();

        return view('layanan.edit', compact('item'));
    }

    public function update(Request $r, string $id): RedirectResponse
    {
        $mua = Auth::user()->mua;
        abort_unless($mua, 404);

        $item = Layanan::where('id', $id)
            ->where('mua_id', $mua->id)
            ->firstOrFail();

        $data = $r->validate([
            'nama'      => 'required|string|max:120',
            'harga'     => 'required|integer|min:0',
            'kategori'  => 'nullable|string|max:40',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|max:2048',
        ]);

        // === JIKA GANTI FOTO ===
        if ($r->hasFile('foto')) {
            // hapus foto lama
            if (!empty($item->foto)) {
                $oldPath = base_path('../public_html/adatku/' . $item->foto);
                if (file_exists($oldPath)) @unlink($oldPath);
            }

            $folderPath = base_path('../public_html/adatku/uploads/layanan/' . $mua->id);

            if (!is_dir($folderPath)) mkdir($folderPath, 0777, true);

            $file = $r->file('foto');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($folderPath, $filename);

            $data['foto'] = 'uploads/layanan/' . $mua->id . '/' . $filename;
        }

        $item->update($data);

        return to_route('panelmua.layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $mua = Auth::user()->mua;
        abort_unless($mua, 404);

        $item = Layanan::where('id', $id)
            ->where('mua_id', $mua->id)
            ->firstOrFail();

        if (!empty($item->foto)) {
            $fullPath = base_path('../public_html/adatku/' . $item->foto);
            if (file_exists($fullPath)) @unlink($fullPath);
        }

        $item->delete();

        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}
