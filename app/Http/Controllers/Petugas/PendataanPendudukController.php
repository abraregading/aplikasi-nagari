<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\PendataanPenduduk;
use App\Models\Penduduk;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PendataanPendudukController extends Controller
{
    public function index()
    {
        $dataPendataan = PendataanPenduduk::with('petugas')
            ->orderByDesc('tanggal_pendataan')
            ->paginate(10);

        return view('petugas.pendataan.index', compact('dataPendataan'));
    }

    public function create()
    {
        return view('petugas.pendataan.create');
    }

    /**
     * Store pendataan data - supports both single manual entry and batch KK-based entry
     */
    public function store(Request $request)
    {
        // Check if this is a batch submission (from KK search)
        if ($request->has('anggota') && is_array($request->anggota)) {
            return $this->storeBatch($request);
        }

        // Single manual entry
        return $this->storeSingle($request);
    }

    /**
     * Store single manual entry
     */
    private function storeSingle(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:pendataan_penduduk,nik',
            'no_kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|string|max:20',
            'status_perkawinan' => 'nullable|string|max:20',
            'hubungan_keluarga' => 'nullable|string|max:30',
            'pekerjaan' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
            'status_hidup' => 'nullable|in:hidup,meninggal,pindah',
            'catatan' => 'nullable|string',
        ], [
            'nik.required' => 'NIK harus diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar dalam pendataan.',
            'no_kk.required' => 'No. KK harus diisi.',
            'no_kk.size' => 'No. KK harus 16 digit.',
            'nama_lengkap.required' => 'Nama lengkap harus diisi.',
            'tempat_lahir.required' => 'Tempat lahir harus diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
        ]);

        $validated['petugas_id'] = Auth::id();
        $validated['tanggal_pendataan'] = now();
        $validated['status_hidup'] = $validated['status_hidup'] ?? 'hidup';
        $validated['status_verifikasi'] = 'pending';

        DB::beginTransaction();
        try {
            // Save to pendataan_penduduk
            PendataanPenduduk::create($validated);

            // Also update or create in penduduk table
            Penduduk::updateOrCreate(
                ['nik' => $validated['nik']],
                [
                    'no_kk' => $validated['no_kk'],
                    'nama_lengkap' => $validated['nama_lengkap'],
                    'tempat_lahir' => $validated['tempat_lahir'],
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'agama' => $validated['agama'] ?? null,
                    'status_perkawinan' => $validated['status_perkawinan'] ?? null,
                    'hubungan_keluarga' => $validated['hubungan_keluarga'] ?? null,
                    'pekerjaan' => $validated['pekerjaan'] ?? null,
                    'pendidikan_terakhir' => $validated['pendidikan_terakhir'] ?? null,
                    'alamat' => $validated['alamat'] ?? null,
                    'status_hidup' => $validated['status_hidup'],
                ]
            );

            DB::commit();
            return redirect()->route('petugas.pendataan.index')
                ->with('success', 'Data penduduk berhasil disimpan dan tabel penduduk diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Store batch entry from KK-based search
     */
    private function storeBatch(Request $request)
    {
        $anggotaList = $request->anggota;
        $noKk = $request->no_kk_batch;
        $catatan = $request->catatan_batch;

        if (empty($anggotaList)) {
            return redirect()->back()->with('error', 'Tidak ada data anggota keluarga untuk disimpan.');
        }

        DB::beginTransaction();
        try {
            $savedCount = 0;
            $skippedCount = 0;

            foreach ($anggotaList as $anggota) {
                // Validate each member has required fields
                if (empty($anggota['nik']) || empty($anggota['nama_lengkap']) || empty($anggota['jenis_kelamin'])) {
                    continue;
                }

                // Check if already in pendataan
                $existing = PendataanPenduduk::where('nik', $anggota['nik'])->first();
                if ($existing) {
                    // Update existing pendataan record
                    $existing->update([
                        'no_kk' => $noKk ?? $anggota['no_kk'] ?? $existing->no_kk,
                        'nama_lengkap' => $anggota['nama_lengkap'],
                        'tempat_lahir' => $anggota['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $anggota['tanggal_lahir'] ?? null,
                        'jenis_kelamin' => $anggota['jenis_kelamin'],
                        'agama' => $anggota['agama'] ?? null,
                        'status_perkawinan' => $anggota['status_perkawinan'] ?? null,
                        'hubungan_keluarga' => $anggota['hubungan_keluarga'] ?? null,
                        'pekerjaan' => $anggota['pekerjaan'] ?? null,
                        'pendidikan_terakhir' => $anggota['pendidikan_terakhir'] ?? null,
                        'alamat' => $anggota['alamat'] ?? null,
                        'status_hidup' => $anggota['status_hidup'] ?? 'hidup',
                        'catatan' => $catatan ?? null,
                        'tanggal_pendataan' => now(),
                    ]);
                    $savedCount++;
                } else {
                    // Create new pendataan record
                    PendataanPenduduk::create([
                        'petugas_id' => Auth::id(),
                        'nik' => $anggota['nik'],
                        'no_kk' => $noKk ?? $anggota['no_kk'] ?? '',
                        'nama_lengkap' => $anggota['nama_lengkap'],
                        'tempat_lahir' => $anggota['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $anggota['tanggal_lahir'] ?? null,
                        'jenis_kelamin' => $anggota['jenis_kelamin'],
                        'agama' => $anggota['agama'] ?? null,
                        'status_perkawinan' => $anggota['status_perkawinan'] ?? null,
                        'hubungan_keluarga' => $anggota['hubungan_keluarga'] ?? null,
                        'pekerjaan' => $anggota['pekerjaan'] ?? null,
                        'pendidikan_terakhir' => $anggota['pendidikan_terakhir'] ?? null,
                        'alamat' => $anggota['alamat'] ?? null,
                        'status_hidup' => $anggota['status_hidup'] ?? 'hidup',
                        'status_verifikasi' => 'pending',
                        'catatan' => $catatan ?? null,
                        'tanggal_pendataan' => now(),
                    ]);
                    $savedCount++;
                }

                // Update penduduk table
                Penduduk::updateOrCreate(
                    ['nik' => $anggota['nik']],
                    [
                        'no_kk' => $noKk ?? $anggota['no_kk'] ?? '',
                        'nama_lengkap' => $anggota['nama_lengkap'],
                        'tempat_lahir' => $anggota['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $anggota['tanggal_lahir'] ?? null,
                        'jenis_kelamin' => $anggota['jenis_kelamin'],
                        'agama' => $anggota['agama'] ?? null,
                        'status_perkawinan' => $anggota['status_perkawinan'] ?? null,
                        'hubungan_keluarga' => $anggota['hubungan_keluarga'] ?? null,
                        'pekerjaan' => $anggota['pekerjaan'] ?? null,
                        'pendidikan_terakhir' => $anggota['pendidikan_terakhir'] ?? null,
                        'alamat' => $anggota['alamat'] ?? null,
                        'status_hidup' => $anggota['status_hidup'] ?? 'hidup',
                    ]
                );
            }

            DB::commit();
            return redirect()->route('petugas.pendataan.index')
                ->with('success', "Pendataan berhasil! {$savedCount} data anggota keluarga disimpan dan tabel penduduk diperbarui.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan data batch: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $pendataan = PendataanPenduduk::with('petugas')->findOrFail($id);
        return view('petugas.pendataan.show', compact('pendataan'));
    }

    public function edit(string $id)
    {
        $pendataan = PendataanPenduduk::findOrFail($id);
        return view('petugas.pendataan.edit', compact('pendataan'));
    }

    public function update(Request $request, string $id)
    {
        $pendataan = PendataanPenduduk::findOrFail($id);

        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', Rule::unique('pendataan_penduduk')->ignore($pendataan->id)],
            'no_kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|string|max:20',
            'status_perkawinan' => 'nullable|string|max:20',
            'hubungan_keluarga' => 'nullable|string|max:30',
            'pekerjaan' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
            'status_hidup' => 'nullable|in:hidup,meninggal,pindah',
        ]);

        $validated['status_hidup'] = $validated['status_hidup'] ?? 'hidup';

        $pendataan->update($validated);

        return redirect()->route('petugas.pendataan.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pendataan = PendataanPenduduk::findOrFail($id);
        $pendataan->delete();

        return redirect()->route('petugas.pendataan.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }

    public function cekNik(Request $request)
    {
        $nik = $request->nik;

        $pendataan = PendataanPenduduk::where('nik', $nik)->first();
        if ($pendataan) {
            return response()->json([
                'found' => true,
                'source' => 'pendataan',
                'data' => $pendataan
            ]);
        }

        $penduduk = Penduduk::where('nik', $nik)->first();
        if ($penduduk) {
            return response()->json([
                'found' => true,
                'source' => 'penduduk',
                'data' => [
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
                ]
            ]);
        }

        return response()->json(['found' => false]);
    }

    /**
     * Search KK and return all family members from penduduk table
     */
    public function cekKk(Request $request)
    {
        $no_kk = $request->no_kk;

        // Search in keluarga table
        $keluarga = Keluarga::where('no_kk', $no_kk)->first();
        
        // Search all family members in penduduk table
        $anggota = Penduduk::where('no_kk', $no_kk)->get();

        if ($keluarga || $anggota->count() > 0) {
            $kepalaKeluarga = null;
            $keluargaData = null;

            if ($keluarga) {
                if ($keluarga->kepala_keluarga_nik) {
                    $penduduk = Penduduk::where('nik', $keluarga->kepala_keluarga_nik)->first();
                    $kepalaKeluarga = $penduduk ? $penduduk->nama_lengkap : $keluarga->kepala_keluarga_nik;
                }
                $keluargaData = [
                    'no_kk' => $keluarga->no_kk,
                    'kepala_keluarga' => $kepalaKeluarga,
                    'alamat' => $keluarga->alamat,
                    'rt' => $keluarga->rt,
                    'rw' => $keluarga->rw,
                    'desa_kelurahan' => $keluarga->desa_kelurahan,
                    'kecamatan' => $keluarga->kecamatan,
                    'kabupaten_kota' => $keluarga->kabupaten_kota,
                    'provinsi' => $keluarga->provinsi,
                    'jumlah_anggota' => $keluarga->jumlah_anggota,
                    'status' => $keluarga->status,
                ];
            }

            // Format each family member
            $anggotaData = $anggota->map(function ($p) {
                // Check if this person already exists in pendataan
                $sudahDiData = PendataanPenduduk::where('nik', $p->nik)->exists();
                
                return [
                    'nik' => $p->nik,
                    'no_kk' => $p->no_kk,
                    'nama_lengkap' => $p->nama_lengkap,
                    'tempat_lahir' => $p->tempat_lahir,
                    'tanggal_lahir' => $p->tanggal_lahir ? $p->tanggal_lahir->format('Y-m-d') : ($p->getRawOriginal('tanggal_lahir') ?? null),
                    'jenis_kelamin' => $p->jenis_kelamin,
                    'agama' => $p->agama,
                    'status_perkawinan' => $p->status_perkawinan,
                    'hubungan_keluarga' => $p->hubungan_keluarga,
                    'pekerjaan' => $p->pekerjaan,
                    'pendidikan_terakhir' => $p->pendidikan_terakhir,
                    'alamat' => $p->alamat,
                    'status_hidup' => $p->status_hidup,
                    'sudah_didata' => $sudahDiData,
                ];
            });

            return response()->json([
                'found' => true,
                'keluarga' => $keluargaData,
                'anggota' => $anggotaData,
                'jumlah_anggota' => $anggota->count(),
            ]);
        }

        return response()->json(['found' => false]);
    }
}