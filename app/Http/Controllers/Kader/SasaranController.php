<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PosyanduSasaran;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\ProfilNagari;

class SasaranController extends Controller
{
    protected function getPosyanduId()
    {
        return Auth::user()->posyandu_id;
    }

    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $posyanduId = $this->getPosyanduId();
        $sasaran = PosyanduSasaran::where('posyandu_id', $posyanduId)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('kader.sasaran.index', compact('sasaran', 'profil'));
    }

    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('kader.sasaran.create', compact('profil'));
    }

    public function store(Request $request)
    {
        $posyanduId = $this->getPosyanduId();

        $request->validate([
            'keluarga_id' => 'nullable|exists:keluarga,id',
            'no_kk' => 'required|string|max:20',
            'anggota' => 'nullable|array',
            'anggota.*.penduduk_id' => 'nullable|exists:penduduk,id',
            'anggota.*.nama_lengkap' => 'required|string|max:255',
            'anggota.*.nik' => 'nullable|string|max:20',
            'anggota.*.tempat_lahir' => 'nullable|string|max:50',
            'anggota.*.tanggal_lahir' => 'nullable|date',
            'anggota.*.jenis_kelamin' => 'nullable|in:L,P',
            'anggota.*.nama_ibu' => 'nullable|string|max:100',
            'anggota.*.nama_ayah' => 'nullable|string|max:100',
            'anggota.*.hubungan_keluarga' => 'nullable|string|max:30',
            'anggota.*.alamat' => 'nullable|string',
        ], [
            'no_kk.required' => 'No. KK harus diisi.',
            'anggota.*.nama_lengkap.required' => 'Nama lengkap harus diisi.',
        ]);

        $keluarga = null;
        if ($request->keluarga_id) {
            $keluarga = Keluarga::find($request->keluarga_id);
        }

        $alamat = $keluarga ? $keluarga->alamat : ($request->anggota[0]['alamat'] ?? null);

        if ($request->has('anggota')) {
            foreach ($request->anggota as $item) {
                if (empty($item['nama_lengkap'])) continue;

                PosyanduSasaran::create([
                    'posyandu_id' => $posyanduId,
                    'keluarga_id' => $request->keluarga_id,
                    'penduduk_id' => $item['penduduk_id'] ?? null,
                    'no_kk' => $request->no_kk,
                    'nik' => $item['nik'] ?? null,
                    'nama_lengkap' => $item['nama_lengkap'],
                    'tempat_lahir' => $item['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $item['tanggal_lahir'] ?? null,
                    'jenis_kelamin' => $item['jenis_kelamin'] ?? null,
                    'nama_ibu' => $item['nama_ibu'] ?? null,
                    'nama_ayah' => $item['nama_ayah'] ?? null,
                    'hubungan_keluarga' => $item['hubungan_keluarga'] ?? null,
                    'alamat' => $alamat,
                    'status' => 'aktif',
                    'created_by' => Auth::id(),
                ]);
            }
        }

        return redirect()->route('kader.sasaran.index')
            ->with('success', 'Data sasaran berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $posyanduId = $this->getPosyanduId();
        $sasaran = PosyanduSasaran::where('posyandu_id', $posyanduId)
            ->findOrFail($id);
        return view('kader.sasaran.edit', compact('sasaran', 'profil'));
    }

    public function update(Request $request, string $id)
    {
        $posyanduId = $this->getPosyanduId();
        $sasaran = PosyanduSasaran::where('posyandu_id', $posyanduId)->findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'nama_ibu' => 'nullable|string|max:100',
            'nama_ayah' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,nonaktif,pindah',
            'keterangan' => 'nullable|string',
        ]);

        $sasaran->update($request->only([
            'nama_lengkap', 'nik', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'nama_ibu', 'nama_ayah', 'status', 'keterangan',
        ]));

        return redirect()->route('kader.sasaran.index')
            ->with('success', 'Data sasaran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $posyanduId = $this->getPosyanduId();
        $sasaran = PosyanduSasaran::where('posyandu_id', $posyanduId)->findOrFail($id);
        $sasaran->delete();

        return redirect()->route('kader.sasaran.index')
            ->with('success', 'Data sasaran berhasil dihapus.');
    }

    public function cariKk(Request $request)
    {
        $request->validate(['q' => 'required|string']);

        $input = trim($request->q);

        // Cari berdasarkan No. KK (numeric, minimal 6 digit)
        if (is_numeric($input) && strlen($input) >= 6) {
            $keluarga = Keluarga::where('no_kk', $input)->first();

            if (!$keluarga) {
                return response()->json(['found' => false, 'message' => 'KK tidak ditemukan.']);
            }

            $kepalaKeluarga = null;
            if ($keluarga->kepala_keluarga_nik_hash) {
                $p = Penduduk::where('nik_hash', $keluarga->kepala_keluarga_nik_hash)->first();
                $kepalaKeluarga = $p ? $p->nama_lengkap : null;
            }

            return response()->json([
                'found' => true,
                'multiple' => false,
                'keluarga_id' => $keluarga->id,
                'data' => [
                    'id' => $keluarga->id,
                    'no_kk' => $keluarga->no_kk,
                    'kepala_keluarga' => $kepalaKeluarga,
                    'alamat' => $keluarga->alamat,
                    'rt' => $keluarga->rt,
                    'rw' => $keluarga->rw,
                    'desa_kelurahan' => $keluarga->desa_kelurahan,
                    'kecamatan' => $keluarga->kecamatan,
                    'jumlah_anggota' => $keluarga->jumlah_anggota,
                ]
            ]);
        }

        // Cari berdasarkan nama (ibu/ayah/anggota keluarga)
        $pendudukList = Penduduk::where('nama_lengkap', 'like', '%' . $input . '%')
            ->where('status_hidup', 'hidup')
            ->where(function ($q) {
                $q->where(function ($q2) {
                    $q2->where('jenis_kelamin', 'P')
                       ->whereIn('hubungan_keluarga', ['Istri', 'Ibu', 'Kepala Keluarga']);
                })->orWhere(function ($q2) {
                    $q2->where('jenis_kelamin', 'L')
                       ->whereIn('hubungan_keluarga', ['Kepala Keluarga', 'Suami', 'Ayah']);
                });
            })
            ->get();

        if ($pendudukList->isEmpty()) {
            return response()->json(['found' => false, 'message' => 'Nama tidak ditemukan. Pastikan nama ibu/ayah sesuai data penduduk.']);
        }

        $noKkList = $pendudukList->pluck('no_kk')->unique();
        $keluargaList = Keluarga::whereIn('no_kk', $noKkList)->where('status', 'aktif')->get();

        if ($keluargaList->isEmpty()) {
            return response()->json(['found' => false, 'message' => 'Data keluarga tidak ditemukan.']);
        }

        $results = $keluargaList->map(function ($k) {
            $kepalaKeluarga = null;
            if ($k->kepala_keluarga_nik_hash) {
                $p = Penduduk::where('nik_hash', $k->kepala_keluarga_nik_hash)->first();
                $kepalaKeluarga = $p ? $p->nama_lengkap : null;
            }

            // Cari nama ibu di keluarga ini
            $ibu = Penduduk::where('no_kk', $k->no_kk)
                ->where('jenis_kelamin', 'P')
                ->where(function ($q) {
                    $q->where('hubungan_keluarga', 'like', '%istri%')
                      ->orWhere('hubungan_keluarga', 'like', '%Ibu%');
                })->first();

            return [
                'id' => $k->id,
                'no_kk' => $k->no_kk,
                'kepala_keluarga' => $kepalaKeluarga,
                'nama_ibu' => $ibu ? $ibu->nama_lengkap : null,
                'alamat' => $k->alamat,
                'jumlah_anggota' => $k->jumlah_anggota,
            ];
        });

        return response()->json([
            'found' => true,
            'multiple' => true,
            'results' => $results,
        ]);
    }

    public function anggotaByKk(Request $request)
    {
        $request->validate(['no_kk' => 'required|string']);

        $keluarga = Keluarga::where('no_kk', $request->no_kk)->first();

        if (!$keluarga) {
            return response()->json(['found' => false, 'message' => 'KK tidak ditemukan.']);
        }

        $pendudukList = Penduduk::where('no_kk', $request->no_kk)
            ->where('status_hidup', 'hidup')
            ->orderBy('hubungan_keluarga')
            ->get()
            ->map(function ($p) {
                $namaIbu = null;
                if ($p->no_kk) {
                    $ibu = Penduduk::where('no_kk', $p->no_kk)
                        ->where('jenis_kelamin', 'P')
                        ->where(function ($q) {
                            $q->where('hubungan_keluarga', 'like', '%istri%')
                              ->orWhere('hubungan_keluarga', 'like', '%Ibu%');
                        })
                        ->first();
                    if ($ibu) {
                        $namaIbu = $ibu->nama_lengkap;
                    }
                }
                return [
                    'id' => $p->id,
                    'nik' => $p->nik,
                    'nama_lengkap' => $p->nama_lengkap,
                    'tempat_lahir' => $p->tempat_lahir,
                    'tanggal_lahir' => $p->tanggal_lahir,
                    'jenis_kelamin' => $p->jenis_kelamin,
                    'hubungan_keluarga' => $p->hubungan_keluarga,
                    'nama_ibu' => $namaIbu,
                ];
            });

        return response()->json([
            'found' => true,
            'keluarga_id' => $keluarga->id,
            'anggota' => $pendudukList,
        ]);
    }
}
