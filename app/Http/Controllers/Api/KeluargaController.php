<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    public function index()
    {
        $keluarga = Keluarga::all();
        return response()->json($keluarga);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|unique:keluarga|digits:16',
            'kepala_keluarga_nik' => 'required|digits:16',
            'alamat' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'desa_kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten_kota' => 'required',
            'provinsi' => 'required',
            'kode_pos' => 'nullable',
            'jumlah_anggota' => 'nullable|integer',
            'status' => 'nullable|in:aktif,tidak_aktif',
        ]);

        $keluarga = Keluarga::create($validated);

        return response()->json([
            'message' => 'Keluarga created successfully',
            'data' => $keluarga
        ], 201);
    }

    public function show(string $id)
    {
        $keluarga = Keluarga::findOrFail($id);
        return response()->json($keluarga);
    }

    public function update(Request $request, string $id)
    {
        $keluarga = Keluarga::findOrFail($id);

        $validated = $request->validate([
            'no_kk' => 'sometimes|unique:keluarga,no_kk,' . $id . '|digits:16',
            'kepala_keluarga_nik' => 'sometimes|digits:16',
            'alamat' => 'sometimes',
            'rt' => 'sometimes',
            'rw' => 'sometimes',
            'desa_kelurahan' => 'sometimes',
            'kecamatan' => 'sometimes',
            'kabupaten_kota' => 'sometimes',
            'provinsi' => 'sometimes',
            'kode_pos' => 'nullable',
            'jumlah_anggota' => 'nullable|integer',
            'status' => 'sometimes|in:aktif,tidak_aktif',
        ]);

        $keluarga->update($validated);

        return response()->json([
            'message' => 'Keluarga updated successfully',
            'data' => $keluarga
        ]);
    }

    public function destroy(string $id)
    {
        $keluarga = Keluarga::findOrFail($id);
        $keluarga->delete();

        return response()->json([
            'message' => 'Keluarga deleted successfully'
        ]);
    }
}