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
        // ambil list + max urutan untuk default di modal create
        $teamMembers = TeamMember::orderBy('urutan')->paginate(4); // boleh diganti 4 / 6 sesuai selera
        $maxOrder    = TeamMember::max('urutan') ?? 0;

        return view('admin.team_members.index', compact('teamMembers', 'maxOrder'));
    }

    public function create()
    {
        // kalau nanti mau pakai halaman create terpisah
        return view('admin.team_members.create');
    }

    public function store(Request $request)
    {
        // di create masih boleh isi name/role/division (atau dikosongkan, nanti diisi default)
        $data = $request->validate([
            'name'        => 'nullable|string|max:255',
            'role'        => 'nullable|string|max:255',
            'division'    => 'nullable|string|max:255',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'urutan'      => 'nullable|integer|min:1',
            'is_highlight'=> 'nullable|boolean',
            'is_active'   => 'nullable|boolean',
        ]);

        // default kalau tidak diisi (aman walau form pakai input hidden ataupun tidak)
        $data['name']     = $data['name']     ?? 'Anggota Tim';
        $data['role']     = $data['role']     ?? 'Peran Tim';
        $data['division'] = $data['division'] ?? 'Divisi';

        // ===== SIMPAN FOTO KE public/uploads/team =====
        if ($request->hasFile('photo')) {
            $uploadPath = public_path('uploads/team');

            if (! file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $file = $request->file('photo');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            // pindahkan file
            $file->move($uploadPath, $filename);

            // yang disimpan di DB HANYA "team/namafile.jpg"
            $data['photo'] = 'team/' . $filename;
        }

        // kalau urutan kosong → otomatis max+1
        if (empty($data['urutan'])) {
            $data['urutan'] = (TeamMember::max('urutan') ?? 0) + 1;
        }

        $data['is_highlight'] = $request->boolean('is_highlight');
        $data['is_active']    = $request->boolean('is_active');

        TeamMember::create($data);

        return redirect()->route('admin.team-members.index')
            ->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(TeamMember $team_member)
    {
        return view('admin.team_members.edit', ['member' => $team_member]);
    }

    public function update(Request $request, TeamMember $team_member)
    {
        // DI SINI kita TIDAK menyentuh name/role/division → keterangan tetap
        $data = $request->validate([
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'urutan'      => 'nullable|integer|min:1',
            'is_highlight'=> 'nullable|boolean',
            'is_active'   => 'nullable|boolean',
        ]);

        // ===== GANTI FOTO DI public/uploads/team =====
        if ($request->hasFile('photo')) {
            $uploadPath = public_path('uploads/team');

            if (! file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // hapus foto lama kalau ada
            if ($team_member->photo) {
                $oldPath = public_path('uploads/' . $team_member->photo);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file = $request->file('photo');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);

            $data['photo'] = 'team/' . $filename;
        }

        // kalau input urutan kosong, pakai yang lama
        if (empty($data['urutan'])) {
            $data['urutan'] = $team_member->urutan;
        }

        $data['is_highlight'] = $request->boolean('is_highlight');
        $data['is_active']    = $request->boolean('is_active');

        $team_member->update($data);

        return redirect()->route('admin.team-members.index')
            ->with('success', 'Anggota tim berhasil diupdate.');
    }

    public function destroy(TeamMember $team_member)
    {
        // hapus file fisik juga
        if ($team_member->photo) {
            $oldPath = public_path('uploads/' . $team_member->photo);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        $team_member->delete();

        return redirect()->route('admin.team-members.index')
            ->with('success', 'Anggota tim berhasil dihapus.');
    }
}
