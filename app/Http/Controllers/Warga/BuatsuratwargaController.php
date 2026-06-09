<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\Penduduk;
use App\Models\RiwayatSurat;
use App\Models\ProfilNagari;
use App\Models\Penandatangan;
use App\Helpers\SuratHelper;
use Carbon\Carbon;

class BuatsuratwargaController extends Controller
{
    /**
     * Display a listing of jenis surat (pilih jenis surat).
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $fields = config('profilnagari');
        $jenisSurat = JenisSurat::withCount(['riwayatSurat'])->get();

        return view('warga.buatsurat.index', compact('profil', 'fields', 'jenisSurat'));
    }

    /**
     * Show the form for creating a new surat.
     */
    public function create(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jenisId = $request->query('jenis');
        $jenisSurat = JenisSurat::with('templateSurat')->findOrFail($jenisId);
        $allJenis = JenisSurat::all();
        $penandatanganList = Penandatangan::active()->orderBy('nama')->get();
        $defaultPenandatangan = Penandatangan::getDefault();

        $user = auth()->user();
        $penduduk = $user->penduduk;
        if (!$penduduk && $user->nik) {
            $penduduk = Penduduk::where('nik', $user->nik)->first();
        }
        $userNik = $penduduk ? $penduduk->nik : ($user->nik ?? '');

        $formFields = $jenisSurat->form_fields ?? [];
        $formTemplate = $jenisSurat->form_template;
        if ($jenisSurat->templateSurat && $jenisSurat->templateSurat->form_template) {
            $formTemplate = $jenisSurat->templateSurat->form_template;
        }

        return view('warga.buatsurat.create', compact(
            'jenisSurat', 'allJenis', 'penandatanganList', 'defaultPenandatangan', 'profil', 'penduduk', 'userNik', 'formFields'
        ));
    }

    /**
     * Store a newly created surat in storage.
     */
    protected function buildDynamicValidation(JenisSurat $jenisSurat): array
    {
        $rules = [];
        $fields = $jenisSurat->form_fields ?? [];
        foreach ($fields as $field) {
            $fieldName = $field['name'] ?? null;
            if (!$fieldName) continue;
            $fieldRules = [];
            if (!empty($field['required'])) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }
            $type = $field['type'] ?? 'text';
            if ($type === 'number') {
                $fieldRules[] = 'numeric';
            } elseif ($type === 'email') {
                $fieldRules[] = 'email';
            } elseif ($type === 'date') {
                $fieldRules[] = 'date';
            } else {
                $fieldRules[] = 'string';
            }
            $fieldRules[] = 'max:65535';
            $rules['dynamic.' . $fieldName] = $fieldRules;
        }
        return $rules;
    }

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

        $jenisSurat = JenisSurat::where('nama_layanan', $request->jenis_surat)->first();
        if ($jenisSurat && $jenisSurat->form_fields) {
            $dynamicRules = $this->buildDynamicValidation($jenisSurat);
            $request->validate($dynamicRules);
        }

        $dataSurat = $request->input('dynamic', []);

        RiwayatSurat::create([
            'user_id' => auth()->id(),
            'nik_pemohon' => $request->nik_pemohon,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'pernyataan' => $request->pernyataan,
            'data_surat' => $dataSurat,
            'penandatangan_id' => $request->penandatangan_id,
            'jorong' => $request->jorong,
            'nama_jalan' => $request->nama_jalan,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_pengantar' => $request->tanggal_pengantar,
            'status' => 'diajukan',
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('buatsuratwarga.proses')->with('success', 'Surat berhasil dibuat dan diajukan.');
    }

    /**
     * Display the specified surat (redirect to cetak).
     */
    public function show(string $id)
    {
        return redirect()->route('buatsuratwarga.cetak', $id);
    }

    /**
     * Show the form for editing the specified surat.
     */
    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $surat = RiwayatSurat::with('penduduk')->where('user_id', auth()->id())->findOrFail($id);
        $allJenis = JenisSurat::all();
        $penandatanganList = Penandatangan::active()->orderBy('nama')->get();

        $jenisSurat = JenisSurat::where('nama_layanan', $surat->jenis_surat)->with('templateSurat')->first();
        $formFields = $jenisSurat ? ($jenisSurat->form_fields ?? []) : [];

        return view('warga.buatsurat.edit', compact('surat', 'allJenis', 'penandatanganList', 'profil', 'formFields', 'jenisSurat'));
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
        $jenisSurat = JenisSurat::where('nama_layanan', $request->jenis_surat)->first();
        if ($jenisSurat && $jenisSurat->form_fields) {
            $dynamicRules = $this->buildDynamicValidation($jenisSurat);
            $request->validate($dynamicRules);
        }

        $dataSurat = $request->input('dynamic', $surat->data_surat ?? []);

        $surat->update([
            'nik_pemohon' => $request->nik_pemohon,
            'jenis_surat' => $request->jenis_surat,
            'keterangan' => $request->keterangan,
            'pernyataan' => $request->pernyataan,
            'data_surat' => $dataSurat,
            'penandatangan_id' => $request->penandatangan_id,
            'jorong' => $request->jorong,
            'nama_jalan' => $request->nama_jalan,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_pengantar' => $request->tanggal_pengantar,
        ]);

        return redirect()->route('buatsuratwarga.proses')->with('success', 'Data surat berhasil diperbarui.');
    }

    /**
     * Remove the specified surat from storage.
     */
    public function destroy(string $id)
    {
        $surat = RiwayatSurat::where('user_id', auth()->id())->findOrFail($id);
        $surat->delete();

        return redirect()->route('buatsuratwarga.proses')->with('success', 'Surat berhasil dihapus.');
    }

    /**
     * Halaman proses permohonan surat — daftar semua surat + filter status.
     */
    public function proses(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $status = $request->query('status');

        $query = RiwayatSurat::with('penduduk')->where('user_id', auth()->id())->orderBy('tanggal_pengajuan', 'desc');

        if ($status && in_array($status, ['diajukan', 'diproses', 'selesai', 'ditolak'])) {
            $query->where('status', $status);
        }

        $suratList = $query->get();
        $counts = [
            'semua' => RiwayatSurat::where('user_id', auth()->id())->count(),
            'diajukan' => RiwayatSurat::where('user_id', auth()->id())->where('status', 'diajukan')->count(),
            'diproses' => RiwayatSurat::where('user_id', auth()->id())->where('status', 'diproses')->count(),
            'selesai' => RiwayatSurat::where('user_id', auth()->id())->where('status', 'selesai')->count(),
            'ditolak' => RiwayatSurat::where('user_id', auth()->id())->where('status', 'ditolak')->count(),
        ];

        return view('warga.buatsurat.proses', compact('suratList', 'status', 'counts', 'profil'));
    }

    /**
     * Update status surat (diajukan → diproses → selesai / ditolak).
     */
    public function updateStatus(Request $request, string $id)
    {
        
        $request->validate([
            'status' => 'required|in:diajukan,diproses,selesai,ditolak',
        ]);

        $surat = RiwayatSurat::where('user_id', auth()->id())->findOrFail($id);
        $surat->status = $request->status;

        if ($request->status === 'selesai') {
            $surat->tanggal_selesai = now();
            if (!$surat->nomor_surat) {
                $surat->nomor_surat = SuratHelper::generateNomorSurat($surat);
            }
        }

        $surat->save();

        return redirect()->route('buatsuratwarga.proses')->with('success', 'Status surat berhasil diperbarui.');
    }

    /**
     * Halaman cetak surat (standalone, tanpa sidebar).
     */
    public function cetak(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $surat = RiwayatSurat::with(['penduduk', 'penandatangan'])->findOrFail($id);
        $penduduk = $surat->penduduk;
        $penandatangan = $surat->penandatangan;

        $jenisSurat = JenisSurat::where('nama_layanan', $surat->jenis_surat)->first();
        $templateFile = $jenisSurat ? ($jenisSurat->template_file ?? null) : null;

        if ($templateFile && view()->exists($templateFile)) {
            return view($templateFile, compact('surat', 'profil', 'penduduk', 'penandatangan'));
        }

        return view('warga.buatsurat.cetak', compact('surat', 'profil', 'penduduk', 'penandatangan'));
    }

    /**
     * Halaman riwayat permohonan surat (selesai & ditolak).
     */
    public function riwayat(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $search = $request->query('search');

        $query = RiwayatSurat::with('penduduk')
            ->where('user_id', auth()->id())
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

        return view('warga.buatsurat.riwayat', compact('suratList', 'search', 'profil'));
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
