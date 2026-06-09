<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilNagari;
use App\Models\Keluarga;

class DatakeluargaopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $keluargas = Keluarga::all();
        return view('operator.datakeluarga.index', compact('profil', 'keluargas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('operator.datakeluarga.create', compact('profil'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|string|max:20|unique:keluarga,no_kk',
            'kepala_keluarga_nik' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'desa_kelurahan' => 'nullable|string|max:50',
            'kecamatan' => 'nullable|string|max:50',
            'kabupaten_kota' => 'nullable|string|max:50',
            'provinsi' => 'nullable|string|max:50',
            'kode_pos' => 'nullable|string|max:10',
            'jumlah_anggota' => 'nullable|integer|min:0',
            'status' => 'required|in:aktif,pindah,non-aktif',
        ]);

        Keluarga::create($request->only([
            'no_kk', 'kepala_keluarga_nik', 'alamat', 'rt', 'rw',
            'desa_kelurahan', 'kecamatan', 'kabupaten_kota', 'provinsi',
            'kode_pos', 'jumlah_anggota', 'status',
        ]));

        return redirect()->route('data-keluarga-operator.index')->with('success', 'Data keluarga berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $keluarga = Keluarga::findOrFail($id);
        return view('operator.datakeluarga.show', compact('profil', 'keluarga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $keluarga = Keluarga::findOrFail($id);
        return view('operator.datakeluarga.edit', compact('profil', 'keluarga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $keluarga = Keluarga::findOrFail($id);

        $request->validate([
            'no_kk' => 'required|string|max:20|unique:keluarga,no_kk,' . $keluarga->id,
            'kepala_keluarga_nik' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'desa_kelurahan' => 'nullable|string|max:50',
            'kecamatan' => 'nullable|string|max:50',
            'kabupaten_kota' => 'nullable|string|max:50',
            'provinsi' => 'nullable|string|max:50',
            'kode_pos' => 'nullable|string|max:10',
            'jumlah_anggota' => 'nullable|integer|min:0',
            'status' => 'required|in:aktif,pindah,non-aktif',
        ]);

        $keluarga->update($request->only([
            'no_kk', 'kepala_keluarga_nik', 'alamat', 'rt', 'rw',
            'desa_kelurahan', 'kecamatan', 'kabupaten_kota', 'provinsi',
            'kode_pos', 'jumlah_anggota', 'status',
        ]));

        return redirect()->route('data-keluarga-operator.index')->with('success', 'Data keluarga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $keluarga = Keluarga::findOrFail($id);
        $keluarga->delete();

        return redirect()->route('data-keluarga-operator.index')->with('success', 'Data keluarga berhasil dihapus.');
    }
}
