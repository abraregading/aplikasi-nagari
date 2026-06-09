<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posyandu;
use App\Models\PosyanduKader;
use App\Models\ProfilNagari;

class PosyanduController extends Controller
{
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $posyandu = Posyandu::withCount('kaders')->get();
        return view('admin.posyandu.index', compact('posyandu', 'profil'));
    }

    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.posyandu.create', compact('profil'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_posyandu' => 'required|string|max:50|unique:posyandu,kode_posyandu',
            'nama_posyandu' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'jorong' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'kaders' => 'nullable|array|max:5',
            'kaders.*.nama_kader' => 'nullable|string|max:255',
            'kaders.*.jabatan' => 'nullable|string|max:100',
            'kaders.*.no_hp' => 'nullable|string|max:20',
        ]);

        $posyandu = Posyandu::create([
            'kode_posyandu' => $request->kode_posyandu,
            'nama_posyandu' => $request->nama_posyandu,
            'alamat' => $request->alamat,
            'jorong' => $request->jorong,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        if ($request->has('kaders')) {
            foreach ($request->kaders as $kader) {
                if (!empty($kader['nama_kader'])) {
                    $posyandu->kaders()->create([
                        'nama_kader' => $kader['nama_kader'],
                        'jabatan' => $kader['jabatan'] ?? null,
                        'no_hp' => $kader['no_hp'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('posyandu.index')->with('success', 'Pos Yandu berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $posyandu = Posyandu::with('kaders')->findOrFail($id);
        return view('admin.posyandu.show', compact('posyandu', 'profil'));
    }

    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $posyandu = Posyandu::with('kaders')->findOrFail($id);
        return view('admin.posyandu.edit', compact('posyandu', 'profil'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_posyandu' => 'required|string|max:50|unique:posyandu,kode_posyandu,' . $id,
            'nama_posyandu' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'jorong' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'kaders' => 'nullable|array|max:5',
            'kaders.*.nama_kader' => 'nullable|string|max:255',
            'kaders.*.jabatan' => 'nullable|string|max:100',
            'kaders.*.no_hp' => 'nullable|string|max:20',
        ]);

        $posyandu = Posyandu::findOrFail($id);
        $posyandu->update([
            'kode_posyandu' => $request->kode_posyandu,
            'nama_posyandu' => $request->nama_posyandu,
            'alamat' => $request->alamat,
            'jorong' => $request->jorong,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        $posyandu->kaders()->delete();

        if ($request->has('kaders')) {
            foreach ($request->kaders as $kader) {
                if (!empty($kader['nama_kader'])) {
                    $posyandu->kaders()->create([
                        'nama_kader' => $kader['nama_kader'],
                        'jabatan' => $kader['jabatan'] ?? null,
                        'no_hp' => $kader['no_hp'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('posyandu.index')->with('success', 'Pos Yandu berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $posyandu = Posyandu::findOrFail($id);
        $posyandu->delete();

        return redirect()->route('posyandu.index')->with('success', 'Pos Yandu berhasil dihapus.');
    }
}
