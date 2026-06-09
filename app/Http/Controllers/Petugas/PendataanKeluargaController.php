<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\Agama;
use App\Models\ProfilNagari;
use App\Models\RiwayatPendataanKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PendataanKeluargaController extends Controller
{
    /**
     * Display listing of keluarga data
     */
    public function index(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $query = Keluarga::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', "%{$search}%")
                  ->orWhere('kepala_keluarga_nik', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('desa_kelurahan', 'like', "%{$search}%");
            });
        }

        $keluargas = Keluarga::withCount('penduduks')->with('kepalaKeluarga')->orderByDesc('updated_at')->get();

        return view('petugas.pendataankeluarga.index', compact('keluargas', 'profil'));
    }

    /**
     * Show create form - search KK first then fill data
     */
    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('petugas.pendataankeluarga.create', compact('profil'));
    }

    /**
     * Store new keluarga
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|size:16|unique:keluarga,no_kk',
            'kepala_keluarga_nik' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'jorong' => 'nullable|string|max:50',
            'desa_kelurahan' => 'nullable|string|max:50',
            'kecamatan' => 'nullable|string|max:50',
            'kabupaten_kota' => 'nullable|string|max:50',
            'provinsi' => 'nullable|string|max:50',
            'kode_pos' => 'nullable|string|max:10',
            'jumlah_anggota' => 'nullable|integer|min:0',
            'status' => 'required|in:aktif,pindah,non-aktif',
        ], [
            'no_kk.required' => 'No. KK harus diisi.',
            'no_kk.size' => 'No. KK harus 16 digit.',
            'no_kk.unique' => 'No. KK sudah terdaftar.',
            'alamat.required' => 'Alamat harus diisi.',
        ]);

        $keluarga = Keluarga::create($validated);

        $this->syncAnggota($keluarga);

        $kepalaKeluarga = null;
        if ($validated['kepala_keluarga_nik']) {
            $nikHash = hash('sha256', $validated['kepala_keluarga_nik']);
            $penduduk = Penduduk::where('nik_hash', $nikHash)->first();
            $kepalaKeluarga = $penduduk ? $penduduk->nama_lengkap : $validated['kepala_keluarga_nik'];
        }

        RiwayatPendataanKeluarga::updateOrCreate(
            ['keluarga_id' => $keluarga->id],
            [
                'petugas_id' => Auth::id(),
                'no_kk' => $keluarga->no_kk,
                'kepala_keluarga_nama' => $kepalaKeluarga,
                'data_sebelum' => null,
                'data_sesudah' => $validated,
                'qr_token' => RiwayatPendataanKeluarga::generateQrToken(),
                'tanggal_update' => now(),
                'catatan' => 'Data keluarga baru dibuat',
                'aksi' => 'create',
            ]
        );

        return redirect()->route('petugas.pendataankeluarga.index')
            ->with('success', 'Data kartu keluarga berhasil ditambahkan.');
    }

    /**
     * Show detail keluarga with anggota
     */
    public function show(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $keluarga = Keluarga::findOrFail($id);
        $anggota = Penduduk::where('no_kk', $keluarga->no_kk)->get();
        $kepalaKeluarga = null;
        if ($keluarga->kepala_keluarga_nik_hash) {
            $kepalaKeluarga = Penduduk::where('nik_hash', $keluarga->kepala_keluarga_nik_hash)->first();
        }

        return view('petugas.pendataankeluarga.show', compact('keluarga', 'anggota', 'kepalaKeluarga', 'profil'));
    }

    /**
     * Show edit form - load existing data from database
     */
    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $keluarga = Keluarga::findOrFail($id);
        $agama = Agama::all();
        // dd($agama);
        $anggota = Penduduk::where('no_kk', $keluarga->no_kk)->get();

        return view('petugas.pendataankeluarga.edit', compact('keluarga', 'anggota', 'agama', 'profil'));
    }

    /**
     * Update keluarga data
     */
    public function update(Request $request, string $id)
    {
        $keluarga = Keluarga::findOrFail($id);

        $validated = $request->validate([
            'no_kk' => ['required', 'string', 'size:16', Rule::unique('keluarga')->ignore($keluarga->id)],
            'kepala_keluarga_nik' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'jorong' => 'nullable|string|max:50',
            'desa_kelurahan' => 'nullable|string|max:50',
            'kecamatan' => 'nullable|string|max:50',
            'kabupaten_kota' => 'nullable|string|max:50',
            'provinsi' => 'nullable|string|max:50',
            'kode_pos' => 'nullable|string|max:10',
            'jumlah_anggota' => 'nullable|integer|min:0',
            'status' => 'required|in:aktif,pindah,non-aktif',
        ]);

        DB::beginTransaction();
        try {
            $dataSebelum = $keluarga->toArray();
            $oldNoKk = $keluarga->no_kk;
            $keluarga->update($validated);

            if ($oldNoKk !== $validated['no_kk']) {
                Penduduk::where('no_kk', $oldNoKk)->update(['no_kk' => $validated['no_kk']]);
            }

            // Update/add anggota if provided
            if ($request->has('anggota') && is_array($request->anggota)) {
                foreach ($request->anggota as $data) {
                    if (empty($data['nama_lengkap'])) continue;

                    if (!empty($data['nik'])) {
                        $nikHash = hash('sha256', $data['nik']);
                        $existing = Penduduk::where('nik_hash', $nikHash)->first();
                        if (!$existing) {
                            $existing = Penduduk::where('nik', $data['nik'])->first();
                        }
                        if ($existing) {
                            $existing->update([
                                'nama_lengkap' => $data['nama_lengkap'],
                                'tempat_lahir' => $data['tempat_lahir'] ?? null,
                                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                                'jenis_kelamin' => $data['jenis_kelamin'] ?? 'L',
                                'agama' => $data['agama'] ?? null,
                                'status_perkawinan' => $data['status_perkawinan'] ?? null,
                                'hubungan_keluarga' => $data['hubungan_keluarga'] ?? null,
                                'pekerjaan' => $data['pekerjaan'] ?? null,
                                'pendidikan_terakhir' => $data['pendidikan_terakhir'] ?? null,
                                'alamat' => $validated['alamat'],
                                'status_hidup' => $data['status_hidup'] ?? 'hidup',
                            ]);
                        } else {
                            Penduduk::create([
                                'nik' => $data['nik'],
                                'no_kk' => $keluarga->no_kk,
                                'nama_lengkap' => $data['nama_lengkap'],
                                'tempat_lahir' => $data['tempat_lahir'] ?? null,
                                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                                'jenis_kelamin' => $data['jenis_kelamin'] ?? 'L',
                                'agama' => $data['agama'] ?? null,
                                'status_perkawinan' => $data['status_perkawinan'] ?? null,
                                'hubungan_keluarga' => $data['hubungan_keluarga'] ?? null,
                                'pekerjaan' => $data['pekerjaan'] ?? null,
                                'pendidikan_terakhir' => $data['pendidikan_terakhir'] ?? null,
                                'alamat' => $validated['alamat'],
                                'status_hidup' => $data['status_hidup'] ?? 'hidup',
                            ]);
                        }
                    } else {
                        $tempNik = 'TMP' . time() . rand(1000, 9999);
                        Penduduk::create([
                            'nik' => $tempNik,
                            'no_kk' => $keluarga->no_kk,
                            'nama_lengkap' => $data['nama_lengkap'],
                            'tempat_lahir' => $data['tempat_lahir'] ?? null,
                            'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                            'jenis_kelamin' => $data['jenis_kelamin'] ?? 'L',
                            'agama' => $data['agama'] ?? null,
                            'status_perkawinan' => $data['status_perkawinan'] ?? null,
                            'hubungan_keluarga' => $data['hubungan_keluarga'] ?? null,
                            'pekerjaan' => $data['pekerjaan'] ?? null,
                            'pendidikan_terakhir' => $data['pendidikan_terakhir'] ?? null,
                            'alamat' => $validated['alamat'],
                            'status_hidup' => $data['status_hidup'] ?? 'hidup',
                        ]);
                    }
                }
            }

            // Recount members
            $jumlah = Penduduk::where('no_kk', $keluarga->no_kk)->count();
            $keluarga->update(['jumlah_anggota' => $jumlah]);

            $kepalaKeluarga = null;
            if ($validated['kepala_keluarga_nik']) {
                $penduduk = Penduduk::where('nik', $validated['kepala_keluarga_nik'])->first();
                $kepalaKeluarga = $penduduk ? $penduduk->nama_lengkap : $validated['kepala_keluarga_nik'];
            }

            $keluarga->refresh();
            RiwayatPendataanKeluarga::updateOrCreate(
                ['keluarga_id' => $keluarga->id],
                [
                    'petugas_id' => Auth::id(),
                    'no_kk' => $keluarga->no_kk,
                    'kepala_keluarga_nama' => $kepalaKeluarga,
                    'data_sebelum' => $dataSebelum,
                    'data_sesudah' => $keluarga->toArray(),
                    'qr_token' => RiwayatPendataanKeluarga::generateQrToken(),
                    'tanggal_update' => now(),
                    'catatan' => 'Data keluarga diperbarui oleh petugas',
                    'aksi' => 'update',
                ]
            );

            DB::commit();
            return redirect()->route('petugas.pendataankeluarga.index')
                ->with('success', 'Data kartu keluarga dan anggota berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Delete keluarga
     */
    public function destroy(string $id)
    {
        $keluarga = Keluarga::findOrFail($id);
        $keluarga->delete();

        return redirect()->route('petugas.pendataankeluarga.index')
            ->with('success', 'Data kartu keluarga berhasil dihapus.');
    }

    /**
     * API: Search keluarga by no_kk
     */
    public function cariKk(Request $request)
    {
        $no_kk = $request->no_kk;
        $keluarga = Keluarga::where('no_kk', $no_kk)->first();

        if ($keluarga) {
            $anggota = Penduduk::where('no_kk', $no_kk)->get();
            $kepala = null;
            if ($keluarga->kepala_keluarga_nik) {
                $p = Penduduk::where('nik', $keluarga->kepala_keluarga_nik)->first();
                $kepala = $p ? $p->nama_lengkap : $keluarga->kepala_keluarga_nik;
            }

            return response()->json([
                'found' => true,
                'keluarga' => $keluarga,
                'kepala_keluarga_nama' => $kepala,
                'anggota' => $anggota->map(fn($p) => [
                    'nik' => $p->nik,
                    'nama_lengkap' => $p->nama_lengkap,
                    'hubungan_keluarga' => $p->hubungan_keluarga,
                    'jenis_kelamin' => $p->jenis_kelamin,
                    'status_hidup' => $p->status_hidup,
                ]),
            ]);
        }

        return response()->json(['found' => false]);
    }

    public function riwayat(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $query = RiwayatPendataanKeluarga::with(['petugas', 'keluarga'])
            ->orderByDesc('tanggal_update');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', "%{$search}%")
                  ->orWhere('kepala_keluarga_nama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('aksi')) {
            $query->where('aksi', $request->aksi);
        }

        $riwayats = $query->paginate(15)->withQueryString();

        return view('petugas.pendataankeluarga.riwayat', compact('riwayats', 'profil'));
    }

    public function riwayatDetail(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $riwayat = RiwayatPendataanKeluarga::with(['petugas', 'keluarga'])
            ->findOrFail($id);

        return view('petugas.pendataankeluarga.riwayatshow', compact('riwayat', 'profil'));
    }

    public function syncAll()
    {
        $keluargas = Keluarga::all();
        $count = 0;

        foreach ($keluargas as $keluarga) {
            $this->syncAnggota($keluarga);
            $count++;
        }

        return redirect()->route('petugas.pendataankeluarga.index')
            ->with('success', "Sinkronisasi selesai! {$count} data keluarga berhasil diperbarui.");
    }

    private function syncAnggota(Keluarga $keluarga)
    {
        if ($keluarga->kepala_keluarga_nik) {
            $nikHash = hash('sha256', $keluarga->kepala_keluarga_nik);
            Penduduk::where('nik_hash', $nikHash)
                ->where(function ($q) use ($keluarga) {
                    $q->where('no_kk', '!=', $keluarga->no_kk)
                      ->orWhereNull('no_kk');
                })
                ->update(['no_kk' => $keluarga->no_kk]);
        }

        $jumlah = Penduduk::where('no_kk', $keluarga->no_kk)->count();
        $keluarga->update(['jumlah_anggota' => $jumlah]);
    }

    public function riwayatSaya(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $query = RiwayatPendataanKeluarga::with(['keluarga'])
            ->where('petugas_id', Auth::id())
            ->orderByDesc('tanggal_update');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', "%{$search}%")
                  ->orWhere('kepala_keluarga_nama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('aksi')) {
            $query->where('aksi', $request->aksi);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_update', $request->tanggal);
        }

        $riwayats = $query->paginate(15)->withQueryString();

        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();

        return view('petugas.pendataankeluarga.riwayatsaya', compact('riwayats', 'profil'));
    }
}
