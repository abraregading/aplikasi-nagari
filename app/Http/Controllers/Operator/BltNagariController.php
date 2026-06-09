<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BltNagari;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\Perangkat;
use App\Models\ProfilNagari;

class BltNagariController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', now()->format('Y'));

        $data = BltNagari::with('creator')
            ->where('tahun', $tahun)
            ->orderBy('created_at')
            ->get();

        return view('operator.blt-nagari.index', compact('data', 'tahun'));
    }

    public function create(Request $request)
    {
        $tahun = $request->input('tahun', now()->format('Y'));
        return view('operator.blt-nagari.create', compact('tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penduduk_id' => 'nullable|exists:penduduk,id',
            'nik' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'no_kk' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'alamat_jalan' => 'nullable|string',
            'alamat_jorong' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:50',
            'jumlah_anggota_keluarga' => 'required|integer|min:0',
            'tahun' => 'required|integer|min:2020|max:2099',
        ]);

        BltNagari::create([
            'penduduk_id' => $request->penduduk_id,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'no_kk' => $request->no_kk,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat_jalan' => $request->alamat_jalan,
            'alamat_jorong' => $request->alamat_jorong,
            'pekerjaan' => $request->pekerjaan,
            'jumlah_anggota_keluarga' => $request->jumlah_anggota_keluarga,
            'tahun' => $request->tahun,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('operator.blt-nagari.index', ['tahun' => $request->tahun])
            ->with('success', 'Data penerima BLT Nagari berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $data = BltNagari::findOrFail($id);
        return view('operator.blt-nagari.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        $data = BltNagari::findOrFail($id);

        $request->validate([
            'nik' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'no_kk' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'alamat_jalan' => 'nullable|string',
            'alamat_jorong' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:50',
            'jumlah_anggota_keluarga' => 'required|integer|min:0',
        ]);

        $data->update([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'no_kk' => $request->no_kk,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat_jalan' => $request->alamat_jalan,
            'alamat_jorong' => $request->alamat_jorong,
            'pekerjaan' => $request->pekerjaan,
            'jumlah_anggota_keluarga' => $request->jumlah_anggota_keluarga,
        ]);

        return redirect()->route('operator.blt-nagari.index', ['tahun' => $data->tahun])
            ->with('success', 'Data penerima BLT Nagari berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $data = BltNagari::findOrFail($id);
        $tahun = $data->tahun;
        $data->delete();

        return redirect()->route('operator.blt-nagari.index', ['tahun' => $tahun])
            ->with('success', 'Data penerima BLT Nagari berhasil dihapus.');
    }

    public function cetak(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();

        $tahun = $request->input('tahun', now()->format('Y'));

        $data = BltNagari::where('tahun', $tahun)
            ->orderBy('alamat_jorong')
            ->orderBy('nama')
            ->get();

        $walinagari = Perangkat::where('jabatan_id', 1)->with('penduduk', 'jabatan')->first();

        return view('operator.blt-nagari.cetak', compact('profil', 'data', 'tahun', 'walinagari'));
    }

    public function getPenduduk(Request $request)
    {
        if ($request->filled('id')) {
            $penduduk = Penduduk::with('keluarga')->find($request->id);
            if (!$penduduk) {
                return response()->json(['error' => 'Penduduk tidak ditemukan'], 404);
            }
            $jorong = $penduduk->keluarga?->jorong ?? '';
            $jumlahAnggota = $penduduk->no_kk ? Penduduk::where('no_kk', $penduduk->no_kk)->count() : 0;

            return response()->json([
                'id' => $penduduk->id,
                'nik' => $penduduk->nik,
                'nama_lengkap' => $penduduk->nama_lengkap,
                'no_kk' => $penduduk->no_kk,
                'tempat_lahir' => $penduduk->tempat_lahir,
                'tanggal_lahir' => $penduduk->tanggal_lahir?->format('Y-m-d'),
                'alamat' => $penduduk->alamat,
                'jorong' => $jorong,
                'pekerjaan' => $penduduk->pekerjaan,
                'jumlah_anggota_keluarga' => $jumlahAnggota,
            ]);
        }

        $q = $request->input('q', '');
        if (empty($q)) {
            return response()->json([]);
        }

        $penduduk = Penduduk::where(function ($query) use ($q) {
            $query->where('nik', 'like', "%{$q}%")
                ->orWhere('nama_lengkap', 'like', "%{$q}%");
        })
            ->limit(20)
            ->get(['id', 'nik', 'nama_lengkap', 'no_kk']);

        return response()->json($penduduk);
    }
}
