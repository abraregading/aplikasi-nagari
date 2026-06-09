<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index()
    {
        $penduduk = Penduduk::all();
        return response()->json($penduduk);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:penduduk|digits:16',
            'no_kk' => 'required|digits:16',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required',
            'status_perkawinan' => 'required',
            'hubungan_keluarga' => 'required',
            'pekerjaan' => 'required',
            'pendidikan_terakhir' => 'required',
            'alamat' => 'required',
            'status_hidup' => 'required|in:hidup,meninggal',
        ]);

        $penduduk = Penduduk::create($validated);

        return response()->json([
            'message' => 'Penduduk created successfully',
            'data' => $penduduk
        ], 201);
    }

    public function show(string $id)
    {
        $penduduk = Penduduk::findOrFail($id);
        return response()->json($penduduk);
    }

    public function update(Request $request, string $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $validated = $request->validate([
            'nik' => 'sometimes|unique:penduduk,nik,' . $id . '|digits:16',
            'no_kk' => 'sometimes|digits:16',
            'nama_lengkap' => 'sometimes',
            'tempat_lahir' => 'sometimes',
            'tanggal_lahir' => 'sometimes|date',
            'jenis_kelamin' => 'sometimes|in:L,P',
            'agama' => 'sometimes',
            'status_perkawinan' => 'sometimes',
            'hubungan_keluarga' => 'sometimes',
            'pekerjaan' => 'sometimes',
            'pendidikan_terakhir' => 'sometimes',
            'alamat' => 'sometimes',
            'status_hidup' => 'sometimes|in:hidup,meninggal',
        ]);

        $penduduk->update($validated);

        return response()->json([
            'message' => 'Penduduk updated successfully',
            'data' => $penduduk
        ]);
    }

    public function destroy(string $id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();

        return response()->json([
            'message' => 'Penduduk deleted successfully'
        ]);
    }
}