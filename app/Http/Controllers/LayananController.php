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

        $kategori = request('k');

        $query = Layanan::where('mua_id', $mua->id);

        if (!empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        $items = $query->latest()->paginate(12);

        return view('layanan.index', [
            'items'    => $items,
            'mua'      => $mua,
            'kategori' => $kategori,
        ]);
    }

    public function create(): View
    {
        abort_unless((bool) Auth::user()->mua, 404);

        $item = null;
        return view('layanan.create', compact('item'));
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

        // ====== UPLOAD FOTO KE public/uploads/layanan/{mua_id}/ ======
        if ($r->hasFile('foto')) {
            $folderPath = public_path('uploads/layanan/' . $mua->id);

            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $file = $r->file('foto');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($folderPath, $filename);

            // path yang disimpan di DB
            $data['foto'] = 'uploads/layanan/' . $mua->id . '/' . $filename;
        }

        $data['mua_id'] = $mua->id;

        Layanan::create($data);

        return redirect()
            ->route('panelmua.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(string $id): View
    {
        $mua = Auth::user()->mua;
        abort_unless((bool) $mua, 404);

        $item = Layanan::where('id', $id)
            ->where('mua_id', $mua->id)
            ->firstOrFail();

        return view('layanan.edit', compact('item'));
    }

    public function update(Request $r, string $id): RedirectResponse
    {
        $mua = Auth::user()->mua;
        abort_unless((bool) $mua, 404);

        $item = Layanan::where('id', $id)
            ->where('mua_id', $mua->id)
            ->firstOrFail();

        $data = $r->validate([
            'nama'      => ['required', 'string', 'max:120'],
            'harga'     => ['required', 'integer', 'min:0'],
            'kategori'  => ['nullable', 'string', 'max:40'],
            'deskripsi' => ['nullable', 'string'],
            'foto'      => ['nullable', 'image', 'max:2048'],
        ]);

        // ====== JIKA GANTI FOTO ======
        if ($r->hasFile('foto')) {
            // hapus foto lama kalau ada
            if (!empty($item->foto)) {
                $oldPath = public_path($item->foto);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $folderPath = public_path('uploads/layanan/' . $mua->id);

            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $file = $r->file('foto');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($folderPath, $filename);

            $data['foto'] = 'uploads/layanan/' . $mua->id . '/' . $filename;
        }

        $item->update($data);

        return redirect()
            ->route('panelmua.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $mua = Auth::user()->mua;
        abort_unless((bool) $mua, 404);

        $item = Layanan::where('id', $id)
            ->where('mua_id', $mua->id)
            ->firstOrFail();

        // hapus foto dari folder upload
        if (!empty($item->foto)) {
            $path = public_path($item->foto);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $item->delete();

        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}
