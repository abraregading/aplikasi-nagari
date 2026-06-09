<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penandatangan;
use App\Models\ProfilNagari;

class PenandatanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $penandatangan = Penandatangan::orderBy('is_default', 'desc')
            ->orderBy('is_active', 'desc')
            ->orderBy('nama')
            ->get();

        return view('admin.penandatangan.index', compact('penandatangan', 'profil'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.penandatangan.create', compact('profil'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'nullable|string|max:30',
            'jabatan' => 'required|string|max:100',
            'pangkat_golongan' => 'nullable|string|max:50',
        ]);

        // Jika set sebagai default, reset default lainnya
        if ($request->has('is_default')) {
            Penandatangan::where('is_default', true)->update(['is_default' => false]);
        }

        Penandatangan::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'pangkat_golongan' => $request->pangkat_golongan,
            'is_active' => $request->has('is_active') ? true : false,
            'is_default' => $request->has('is_default') ? true : false,
        ]);

        return redirect()->route('penandatangan.index')->with('success', 'Penandatangan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penandatangan = Penandatangan::findOrFail($id);
        return view('admin.penandatangan.show', compact('penandatangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
         $penandatangan = Penandatangan::findOrFail($id);
         return view('admin.penandatangan.edit', compact('penandatangan', 'profil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'nullable|string|max:30',
            'jabatan' => 'required|string|max:100',
            'pangkat_golongan' => 'nullable|string|max:50',
        ]);

        $penandatangan = Penandatangan::findOrFail($id);

        // Jika set sebagai default, reset default lainnya
        if ($request->has('is_default') && !$penandatangan->is_default) {
            Penandatangan::where('is_default', true)->update(['is_default' => false]);
        }

        $penandatangan->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'pangkat_golongan' => $request->pangkat_golongan,
            'is_active' => $request->has('is_active') ? true : false,
            'is_default' => $request->has('is_default') ? true : false,
        ]);

        return redirect()->route('penandatangan.index')->with('success', 'Penandatangan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penandatangan = Penandatangan::findOrFail($id);

        // Cek apakah masih digunakan di riwayat surat
        if ($penandatangan->riwayatSurat()->count() > 0) {
            return redirect()->route('penandatangan.index')
                ->with('error', 'Penandatangan tidak dapat dihapus karena masih digunakan pada ' . $penandatangan->riwayatSurat()->count() . ' surat.');
        }

        $penandatangan->delete();
        return redirect()->route('penandatangan.index')->with('success', 'Penandatangan berhasil dihapus.');
    }
}
