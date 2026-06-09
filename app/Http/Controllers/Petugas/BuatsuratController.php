<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\Penduduk;
use App\Models\RiwayatSurat;
use App\Models\ProfilNagari;
use App\Models\Penandatangan;
use Carbon\Carbon;

class BuatsuratController extends Controller
{
    /**
     * Display a listing of jenis surat (pilih jenis surat).
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $fields = config('profilnagari');
        $jenisSurat = JenisSurat::withCount(['riwayatSurat'])->get();

        return view('operator.buatsurat.index', compact('profil', 'fields', 'jenisSurat'));
    }

    /**
     * Show the form for creating a new surat.
     */
    public function create(Request $request)
    {
        $jenisId = $request->query('jenis');
        $jenisSurat = JenisSurat::findOrFail($jenisId);
        $allJenis = JenisSurat::all();
        $penandatanganList = Penandatangan::active()->orderBy('nama')->get();
        $defaultPenandatangan = Penandatangan::getDefault();

        return view('operator.buatsurat.create', compact('jenisSurat', 'allJenis', 'penandatanganList', 'defaultPenandatangan'));
    }

    /**
     * Store a newly created surat in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik_pemohon' => 'required|string|max:20',
            'jenis_surat' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'pernyataan' => 'nullable|string|max:255',
            'penandatangan_id' => 'nullable|exists:penandatangan,id',
            'jorong' => 'nullable|string|max:100',
            'nama_jalan' => 'nullable|string|max:255',
            'nomor_surat' => 'nullable|string|max:50',
            'tanggal_pengantar' => 'nullable|date',
        ]);

        RiwayatSurat::create([
            'user_id' => null,
            'nik_pemohon' => $request->nik_pemohon,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'pernyataan' => $request->pernyataan,
            'penandatangan_id' => $request->penandatangan_id,
            'jorong' => $request->jorong,
            'nama_jalan' => $request->nama_jalan,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_pengantar' => $request->tanggal_pengantar,
            'status' => 'diajukan',
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('buatsurat.proses')->with('success', 'Surat berhasil dibuat dan diajukan.');
    }

    /**
     * Display the specified surat (redirect to cetak).
     */
    public function show(string $id)
    {
        return redirect()->route('buatsurat.cetak', $id);
    }

    /**
     * Show the form for editing the specified surat.
     */
    public function edit(string $id)
    {
        $surat = RiwayatSurat::with('penduduk')->findOrFail($id);
        $allJenis = JenisSurat::all();
        $penandatanganList = Penandatangan::active()->orderBy('nama')->get();

        return view('operator.buatsurat.edit', compact('surat', 'allJenis', 'penandatanganList'));
    }

    /**
     * Update the specified surat in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nik_pemohon' => 'required|string|max:20',
            'jenis_surat' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'pernyataan' => 'nullable|string|max:255',
            'penandatangan_id' => 'nullable|exists:penandatangan,id',
            'jorong' => 'nullable|string|max:100',
            'nama_jalan' => 'nullable|string|max:255',
            'nomor_surat' => 'nullable|string|max:50',
            'tanggal_pengantar' => 'nullable|date',
        ]);

        $surat = RiwayatSurat::findOrFail($id);
        $surat->update([
            'nik_pemohon' => $request->nik_pemohon,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'pernyataan' => $request->pernyataan,
            'penandatangan_id' => $request->penandatangan_id,
            'jorong' => $request->jorong,
            'nama_jalan' => $request->nama_jalan,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_pengantar' => $request->tanggal_pengantar,
        ]);

        return redirect()->route('buatsurat.proses')->with('success', 'Data surat berhasil diperbarui.');
    }

    /**
     * Remove the specified surat from storage.
     */
    public function destroy(string $id)
    {
        $surat = RiwayatSurat::findOrFail($id);
        $surat->delete();

        return redirect()->route('buatsurat.proses')->with('success', 'Surat berhasil dihapus.');
    }

    /**
     * Halaman proses permohonan surat — daftar semua surat + filter status.
     */
    public function proses(Request $request)
    {
        $status = $request->query('status');

        $query = RiwayatSurat::with('penduduk')->orderBy('tanggal_pengajuan', 'desc');

        if ($status && in_array($status, ['diajukan', 'diproses', 'selesai', 'ditolak'])) {
            $query->where('status', $status);
        }

        $suratList = $query->get();
        $counts = [
            'semua' => RiwayatSurat::count(),
            'diajukan' => RiwayatSurat::where('status', 'diajukan')->count(),
            'diproses' => RiwayatSurat::where('status', 'diproses')->count(),
            'selesai' => RiwayatSurat::where('status', 'selesai')->count(),
            'ditolak' => RiwayatSurat::where('status', 'ditolak')->count(),
        ];

        return view('operator.buatsurat.proses', compact('suratList', 'status', 'counts'));
    }

    /**
     * Update status surat (diajukan → diproses → selesai / ditolak).
     */
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:diajukan,diproses,selesai,ditolak',
        ]);

        $surat = RiwayatSurat::findOrFail($id);
        $surat->status = $request->status;

        if ($request->status === 'selesai') {
            $surat->tanggal_selesai = now();
        }

        $surat->save();

        return redirect()->route('buatsurat.proses')->with('success', 'Status surat berhasil diperbarui.');
    }

    /**
     * Halaman cetak surat (standalone, tanpa sidebar).
     */
    public function cetak(string $id)
    {
        $surat = RiwayatSurat::with(['penduduk', 'penandatangan'])->findOrFail($id);
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $penduduk = $surat->penduduk;
        $penandatangan = $surat->penandatangan;

        return view('operator.buatsurat.cetak', compact('surat', 'profil', 'penduduk', 'penandatangan'));
    }

    /**
     * Halaman riwayat permohonan surat (selesai & ditolak).
     */
    public function riwayat(Request $request)
    {
        $search = $request->query('search');

        $query = RiwayatSurat::with('penduduk')
            ->whereIn('status', ['selesai', 'ditolak'])
            ->orderBy('tanggal_selesai', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nik_pemohon', 'like', "%{$search}%")
                  ->orWhere('jenis_surat', 'like', "%{$search}%")
                  ->orWhere('nomor_surat', 'like', "%{$search}%")
                  ->orWhereHas('penduduk', function ($pq) use ($search) {
                      $pq->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        $suratList = $query->get();

        return view('operator.buatsurat.riwayat', compact('suratList', 'search'));
    }

    /**
     * API endpoint — cari penduduk berdasarkan NIK (AJAX).
     */
    public function cariPenduduk(Request $request)
    {
        $nik = $request->query('nik');

        if (!$nik || strlen($nik) < 3) {
            return response()->json([]);
        }

        $results = Penduduk::where('nik', 'like', "%{$nik}%")
            ->limit(10)
            ->get(['id', 'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'status_perkawinan', 'pekerjaan', 'alamat']);

        return response()->json($results);
    }
}
