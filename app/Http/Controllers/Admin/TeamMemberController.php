<?php

namespace App\Http\Controllers\Admin;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeamMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Pastikan hanya role "admin" (case-insensitive) yang boleh masuk
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            if (! $user || strtolower($user->role ?? '') !== 'admin') {
                abort(403, 'Hanya admin yang boleh mengakses.');
            }

            return $next($request);
        });
    }

    /**
     * Tampilkan daftar anggota tim + info max urutan.
     */
    public function index()
    {
        // Bisa atur jumlah per halaman: 4 / 6 / 9 sesuai selera
        $teamMembers = TeamMember::orderBy('urutan')->paginate(4);
        $maxOrder    = TeamMember::max('urutan') ?? 0;

        return view('admin.team_members.index', compact('teamMembers', 'maxOrder'));
    }

    /**
     * (Opsional) halaman create terpisah.
     */
    public function create()
    {
        return view('admin.team_members.create');
    }

    /**
     * Simpan anggota tim baru.
     * - Nama/role/division di sini hanya formalitas (dikunci di home.blade.php)
     * - Fokus utama: foto, urutan, status aktif.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'nullable|string|max:255',
            'role'         => 'nullable|string|max:255',
            'division'     => 'nullable|string|max:255',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'urutan'       => 'nullable|integer|min:1',
            'is_highlight' => 'nullable|boolean',
            'is_active'    => 'nullable|boolean',
        ]);

        // Default aman kalau form kirim hidden / kosong
        $data['name']     = $data['name']     ?? 'Anggota Tim';
        $data['role']     = $data['role']     ?? 'Peran Tim';
        $data['division'] = $data['division'] ?? 'Divisi';

        // ===== SIMPAN FOTO KE public/uploads/team =====
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            $uploadPath = public_path('uploads/team');
            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);

            // YANG DISIMPAN DI DB: "uploads/team/namafile.jpg"
            $data['photo'] = 'uploads/team/' . $filename;
        }

        // Kalau urutan kosong → otomatis max+1
        if (empty($data['urutan'])) {
            $data['urutan'] = (TeamMember::max('urutan') ?? 0) + 1;
        }

        $data['is_highlight'] = $request->boolean('is_highlight');
        $data['is_active']    = $request->boolean('is_active');

        TeamMember::create($data);

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    /**
     * (Opsional) kalau mau pakai halaman edit terpisah.
     */
    public function edit(TeamMember $team_member)
    {
        return view('admin.team_members.edit', ['member' => $team_member]);
    }

    /**
     * Update anggota tim.
     * - Tidak menyentuh name/role/division (dikunci di tampilan beranda).
     * - Bisa ganti foto, urutan, dan status tampil.
     */
    public function update(Request $request, TeamMember $team_member)
    {
        $data = $request->validate([
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'urutan'       => 'nullable|integer|min:1',
            'is_highlight' => 'nullable|boolean',
            'is_active'    => 'nullable|boolean',
        ]);

        // ===== GANTI FOTO DI public/uploads/team =====
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            $uploadPath = public_path('uploads/team');
            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Hapus foto lama kalau ada
            if ($team_member->photo) {
                $oldPath = public_path($team_member->photo); // DB sudah "uploads/team/xxx.jpg"
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);

            // Simpan path baru
            $data['photo'] = 'uploads/team/' . $filename;
        }

        // Kalau urutan kosong, pertahankan urutan lama
        if (empty($data['urutan'])) {
            $data['urutan'] = $team_member->urutan;
        }

        $data['is_highlight'] = $request->boolean('is_highlight');
        $data['is_active']    = $request->boolean('is_active');

        $team_member->update($data);

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Anggota tim berhasil diupdate.');
    }

    /**
     * Hapus anggota tim + file fotonya.
     */
    public function destroy(TeamMember $team_member)
    {
        if ($team_member->photo) {
            $oldPath = public_path($team_member->photo); // "uploads/team/xxx.jpg"
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        $team_member->delete();

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Anggota tim berhasil dihapus.');
    }
}
