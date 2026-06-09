<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;
use App\Models\User;
use App\Models\ProfilNagari;

class PengumumanController extends Controller
{
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $pengumuman = Pengumuman::with('creator', 'targetUser')
            ->latest()
            ->get();

        return view('admin.pengumuman.index', compact('pengumuman', 'profil'));
    }

    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $warga = User::where('role', 'warga')->orderBy('name')->get();

        return view('admin.pengumuman.create', compact('profil', 'warga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'isi' => 'required|string',
            'tipe' => 'required|in:umum,khusus',
            'target_user_id' => 'required_if:tipe,khusus|exists:users,id|nullable',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        Pengumuman::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tipe' => $request->tipe,
            'target_user_id' => $request->tipe === 'khusus' ? $request->target_user_id : null,
            'created_by' => auth()->id(),
            'is_active' => $request->boolean('is_active', true),
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $pengumuman = Pengumuman::findOrFail($id);
        $warga = User::where('role', 'warga')->orderBy('name')->get();

        return view('admin.pengumuman.edit', compact('pengumuman', 'profil', 'warga'));
    }

    public function update(Request $request, string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:200',
            'isi' => 'required|string',
            'tipe' => 'required|in:umum,khusus',
            'target_user_id' => 'required_if:tipe,khusus|exists:users,id|nullable',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $pengumuman->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tipe' => $request->tipe,
            'target_user_id' => $request->tipe === 'khusus' ? $request->target_user_id : null,
            'is_active' => $request->boolean('is_active', true),
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function cariWarga(Request $request)
    {
        $term = $request->q;
        $warga = User::where('role', 'warga')
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('nik', 'like', "%{$term}%");
            })
            ->limit(20)
            ->get(['id', 'name', 'nik']);

        return response()->json($warga);
    }
}
