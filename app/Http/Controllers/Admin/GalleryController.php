<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // optional: cek role admin
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user || $user->role !== 'Admin') {
                abort(403, 'Hanya admin yang boleh mengakses.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $galleries = Gallery::orderBy('kategori')
            ->orderBy('urutan')
            ->paginate(4);

        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori'   => 'required|in:baju_adat,makeup,pelaminan',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'image'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'urutan'     => 'nullable|integer|min:1',
            'is_active'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('galeri', 'public');
        }

        $data['urutan']    = $data['urutan'] ?? 1;
        $data['is_active'] = $request->boolean('is_active');

        Gallery::create($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'kategori'   => 'required|in:baju_adat,makeup,pelaminan',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'urutan'     => 'nullable|integer|min:1',
            'is_active'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('galeri', 'public');
        }

        $data['urutan']    = $data['urutan'] ?? $gallery->urutan;
        $data['is_active'] = $request->boolean('is_active');

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto galeri berhasil diupdate.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto galeri berhasil dihapus.');
    }
}