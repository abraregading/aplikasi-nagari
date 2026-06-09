<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilNagari;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\PendataanPenduduk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DatapendudukopController extends Controller
{
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $penduduks = Penduduk::all();
        $jmlpenduduk = Penduduk::count();
        $jmllakilaki = Penduduk::where('jenis_kelamin', 'L')->count();
        $jmlperempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $jmlkeluarga = Keluarga::count();

        return view('operator.datapenduduk.index', compact('profil', 'penduduks', 'jmlpenduduk', 'jmllakilaki', 'jmlperempuan', 'jmlkeluarga'));
    }

    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $keluargas = Keluarga::all();
        return view('operator.datapenduduk.create', compact('profil', 'keluargas'));
    }

    public function store(Request $request)
    {
        $isFromExisting = $request->input('pilih_dari_keluarga_ada') === '1';
        
        if ($isFromExisting && $request->has('anggota_keluarga')) {
            $anggotaKeluarga = $request->input('anggota_keluarga', []);
            $petugasId = Auth::id();
            
            foreach ($anggotaKeluarga as $anggota) {
                $nik = $anggota['nik'];
                $dataPenduduk = [
                    'nik' => $nik,
                    'no_kk' => $anggota['no_kk'],
                    'nama_lengkap' => $anggota['nama_lengkap'],
                    'tempat_lahir' => $anggota['tempat_lahir'],
                    'tanggal_lahir' => $anggota['tanggal_lahir'],
                    'jenis_kelamin' => $anggota['jenis_kelamin'],
                    'agama' => $anggota['agama'] ?? null,
                    'status_perkawinan' => $anggota['status_perkawinan'] ?? null,
                    'hubungan_keluarga' => $anggota['hubungan_keluarga'] ?? null,
                    'pekerjaan' => $anggota['pekerjaan'] ?? null,
                    'pendidikan_terakhir' => $anggota['pendidikan_terakhir'] ?? null,
                    'alamat' => $anggota['alamat'] ?? null,
                    'status_hidup' => $anggota['status_hidup'] ?? 'hidup',
                ];

                Penduduk::updateOrCreate(
                    ['nik' => $nik],
                    $dataPenduduk
                );

                PendataanPenduduk::create([
                    'petugas_id' => $petugasId,
                    'nik' => $nik,
                    'no_kk' => $anggota['no_kk'],
                    'nama_lengkap' => $anggota['nama_lengkap'],
                    'tempat_lahir' => $anggota['tempat_lahir'],
                    'tanggal_lahir' => $anggota['tanggal_lahir'],
                    'jenis_kelamin' => $anggota['jenis_kelamin'],
                    'agama' => $anggota['agama'] ?? null,
                    'status_perkawinan' => $anggota['status_perkawinan'] ?? null,
                    'hubungan_keluarga' => $anggota['hubungan_keluarga'] ?? null,
                    'pekerjaan' => $anggota['pekerjaan'] ?? null,
                    'pendidikan_terakhir' => $anggota['pendidikan_terakhir'] ?? null,
                    'alamat' => $anggota['alamat'] ?? null,
                    'status_hidup' => $anggota['status_hidup'] ?? 'hidup',
                    'status_verifikasi' => 'pending',
                    'tanggal_pendataan' => now(),
                ]);
            }

            return redirect()->route('data-penduduk-operator.index')->with('success', 'Data keluarga berhasil disimpan ke pendataan dan diperbarui di数据库.');
        }

        $request->validate([
            'nik' => 'required|string|max:20|unique:penduduk,nik',
            'no_kk' => 'required|string|max:20',
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|string|max:20',
            'status_perkawinan' => 'nullable|string|max:20',
            'hubungan_keluarga' => 'nullable|string|max:30',
            'pekerjaan' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
            'status_hidup' => 'required|in:hidup,meninggal,pindah',
        ]);

        $pendudukData = $request->only([
            'nik', 'no_kk', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'agama', 'status_perkawinan', 'hubungan_keluarga',
            'pekerjaan', 'pendidikan_terakhir', 'alamat', 'status_hidup',
        ]);

        $penduduk = Penduduk::create($pendudukData);

        PendataanPenduduk::create([
            'petugas_id' => Auth::id(),
            'nik' => $penduduk->nik,
            'no_kk' => $penduduk->no_kk,
            'nama_lengkap' => $penduduk->nama_lengkap,
            'tempat_lahir' => $penduduk->tempat_lahir,
            'tanggal_lahir' => $penduduk->tanggal_lahir,
            'jenis_kelamin' => $penduduk->jenis_kelamin,
            'agama' => $penduduk->agama,
            'status_perkawinan' => $penduduk->status_perkawinan,
            'hubungan_keluarga' => $penduduk->hubungan_keluarga,
            'pekerjaan' => $penduduk->pekerjaan,
            'pendidikan_terakhir' => $penduduk->pendidikan_terakhir,
            'alamat' => $penduduk->alamat,
            'status_hidup' => $penduduk->status_hidup,
            'status_verifikasi' => 'pending',
            'tanggal_pendataan' => now(),
        ]);

        return redirect()->route('data-penduduk-operator.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function cariKeluarga(Request $request)
    {
        $no_kk = $request->no_kk;
        
        $keluarga = Keluarga::where('no_kk', $no_kk)->first();
        
        if (!$keluarga) {
            return response()->json(['found' => false, 'message' => 'Keluarga tidak ditemukan']);
        }

        $anggotaKeluarga = Penduduk::where('no_kk', $no_kk)->get();

        return response()->json([
            'found' => true,
            'keluarga' => $keluarga,
            'anggota' => $anggotaKeluarga
        ]);
    }

    public function cariKk()
    {
        $search = request('q', '');
        $keluargas = Keluarga::where('no_kk', 'like', "%{$search}%")
            ->orWhere('alamat', 'like', "%{$search}%")
            ->limit(20)
            ->get()
            ->map(function ($k) {
                $kepala = Penduduk::where('nik', $k->kepala_keluarga_nik)->first();
                return [
                    'id' => $k->id,
                    'no_kk' => $k->no_kk,
                    'kepala_keluarga' => $kepala ? $kepala->nama_lengkap : $k->kepala_keluarga_nik,
                    'alamat' => $k->alamat,
                    'rt' => $k->rt,
                    'rw' => $k->rw,
                ];
            });
        
        return response()->json($keluargas);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $penduduk = Penduduk::findOrFail($id);
        return view('operator.datapenduduk.show', compact('profil', 'penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $penduduk = Penduduk::findOrFail($id);
        $keluargas = Keluarga::all();
        return view('operator.datapenduduk.edit', compact('profil', 'penduduk', 'keluargas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $request->validate([
            'nik' => 'required|string|max:20|unique:penduduk,nik,' . $penduduk->id,
            'no_kk' => 'required|string|max:20',
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|string|max:20',
            'status_perkawinan' => 'nullable|string|max:20',
            'hubungan_keluarga' => 'nullable|string|max:30',
            'pekerjaan' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
            'status_hidup' => 'required|in:hidup,meninggal,pindah',
        ]);

        $penduduk->update($request->only([
            'nik', 'no_kk', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'agama', 'status_perkawinan', 'hubungan_keluarga',
            'pekerjaan', 'pendidikan_terakhir', 'alamat', 'status_hidup',
        ]));

        return redirect()->route('data-penduduk-operator.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();

        return redirect()->route('data-penduduk-operator.index')->with('success', 'Data penduduk berhasil dihapus.');
    }
}
