<?php

namespace App\Http\Controllers\Kajor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilNagari;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\RiwayatSurat;
use App\Models\User;
use App\Models\BisnisKos;
use App\Models\PenghuniKos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KajorController extends Controller
{
    private function getJorongName()
    {
        $user = Auth::user();
        return $user->jorong;
    }

    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();
        
        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong. Hubungi admin.');
        }

        // Statistik Penduduk (berdasarkan jorong dari keluarga)
        $jmlkeluarga = Keluarga::where('jorong', $jorongName)->count();
        
        // Ambil NIK dari keluarga di jorong ini
        $noKkList = Keluarga::where('jorong', $jorongName)->pluck('no_kk');
        $jmlpenduduk = Penduduk::whereIn('no_kk', $noKkList)->count();
        $jmllakilaki = Penduduk::whereIn('no_kk', $noKkList)->where('jenis_kelamin', 'L')->count();
        $jmlperempuan = Penduduk::whereIn('no_kk', $noKkList)->where('jenis_kelamin', 'P')->count();

        // Statistik Bisnis Kos
        $totalKos = BisnisKos::where('jorong', $jorongName)->count();
        $totalKamar = BisnisKos::where('jorong', $jorongName)->sum('jumlah_kamar');

        // Grafik pendataan keluarga per hari (7 hari terakhir)
        $hariLabels = [];
        $hariData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $hariLabels[] = $date->translatedFormat('D, d M');
            $noKkDalamJorong = Keluarga::where('jorong', $jorongName)->pluck('no_kk');
            $hariData[] = Penduduk::whereIn('no_kk', $noKkDalamJorong)
                ->whereDate('created_at', $date->toDateString())
                ->count();
        }

        // Grafik pendataan keluarga per minggu (4 minggu terakhir)
        $mingguLabels = [];
        $mingguData = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            $mingguLabels[] = $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M');
            $noKkDalamJorong = Keluarga::where('jorong', $jorongName)->pluck('no_kk');
            $mingguData[] = Penduduk::whereIn('no_kk', $noKkDalamJorong)
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->count();
        }

        // Grafik pendataan keluarga per bulan (6 bulan terakhir)
        $bulanLabels = [];
        $bulanData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $bulanLabels[] = $date->translatedFormat('M Y');
            $noKkDalamJorong = Keluarga::where('jorong', $jorongName)->pluck('no_kk');
            $bulanData[] = Penduduk::whereIn('no_kk', $noKkDalamJorong)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Grafik bisnis per jenis
        $jenisLabels = ['Kos', 'Kontrakan', 'Rumah Petak'];
        $jenisData = [
            BisnisKos::where('jorong', $jorongName)->where('jenis_usaha', 'kos')->count(),
            BisnisKos::where('jorong', $jorongName)->where('jenis_usaha', 'kontrakan')->count(),
            BisnisKos::where('jorong', $jorongName)->where('jenis_usaha', 'rumah_petak')->count(),
        ];

        // Surat terbaru
        $suratTerbaru = RiwayatSurat::with('user')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('kajor.home.index', compact(
            'profil', 'jmlpenduduk', 'jmllakilaki', 'jmlperempuan', 'jmlkeluarga', 'totalKos', 'totalKamar',
            'hariLabels', 'hariData',
            'mingguLabels', 'mingguData',
            'bulanLabels', 'bulanData',
            'jenisLabels', 'jenisData',
            'suratTerbaru',
            'jorongName'
        ));
    }

    public function keluarga(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        $query = Keluarga::where('jorong', $jorongName);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $keluargas = $query->with('kepalaKeluarga')->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('kajor.keluarga.index', compact('profil', 'keluargas', 'jorongName'));
    }

    public function keluargaShow(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();
        $keluarga = Keluarga::with('penduduks')->findOrFail($id);

        if (strcasecmp(trim($keluarga->jorong ?? ''), trim($jorongName ?? '')) !== 0) {
            return redirect()->route('kajor.keluarga.index')->with('error', 'Data tidak ditemukan di jorong Anda.');
        }

        return view('kajor.keluarga.show', compact('profil', 'keluarga', 'jorongName'));
    }

    public function syncJumlahAnggota()
    {
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        $keluargas = Keluarga::where('jorong', $jorongName)->get();
        $updated = 0;

        foreach ($keluargas as $keluarga) {
            $count = Penduduk::where('no_kk', $keluarga->no_kk)->count();
            if ((int) $keluarga->jumlah_anggota !== $count) {
                $keluarga->update(['jumlah_anggota' => $count]);
                $updated++;
            }
        }

        return redirect()->route('kajor.keluarga.index')->with('success', "Sinkronisasi selesai. {$updated} data keluarga diperbarui dari total " . $keluargas->count() . " keluarga.");
    }

    public function penduduk(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        $noKkList = Keluarga::where('jorong', $jorongName)->pluck('no_kk');
        $query = Penduduk::whereIn('no_kk', $noKkList);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jk')) {
            $query->where('jenis_kelamin', $request->jk);
        }

        if ($request->filled('status')) {
            $query->where('status_hidup', $request->status);
        }

        $penduduks = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('kajor.penduduk.index', compact('profil', 'penduduks', 'jorongName'));
    }

    public function pendudukShow(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();
        
        $penduduk = Penduduk::with('keluarga')->findOrFail($id);

        if (!$penduduk->keluarga || strcasecmp(trim($penduduk->keluarga->jorong ?? ''), trim($jorongName ?? '')) !== 0) {
            return redirect()->route('kajor.penduduk.index')->with('error', 'Data tidak ditemukan di jorong Anda.');
        }

        return view('kajor.penduduk.show', compact('profil', 'penduduk', 'jorongName'));
    }

    // ============================================================
    // KELUARGA CRUD
    // ============================================================

    public function keluargaCreate()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        return view('kajor.keluarga.create', compact('profil', 'jorongName'));
    }

    public function keluargaStore(Request $request)
    {
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

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

        Keluarga::create([
            'no_kk' => $request->no_kk,
            'kepala_keluarga_nik' => $request->kepala_keluarga_nik,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'jorong' => $jorongName,
            'desa_kelurahan' => $request->desa_kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'jumlah_anggota' => $request->jumlah_anggota ?? 0,
            'status' => $request->status,
        ]);

        return redirect()->route('kajor.keluarga.index')->with('success', 'Keluarga berhasil ditambahkan.');
    }

    public function keluargaEdit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        $keluarga = Keluarga::where('id', $id)->where('jorong', $jorongName)->firstOrFail();

        return view('kajor.keluarga.edit', compact('profil', 'keluarga', 'jorongName'));
    }

    public function keluargaUpdate(Request $request, string $id)
    {
        $jorongName = $this->getJorongName();
        $keluarga = Keluarga::where('id', $id)->where('jorong', $jorongName)->firstOrFail();

        $request->validate([
            'no_kk' => 'required|string|max:20|unique:keluarga,no_kk,' . $id,
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

        $keluarga->update([
            'no_kk' => $request->no_kk,
            'kepala_keluarga_nik' => $request->kepala_keluarga_nik,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'desa_kelurahan' => $request->desa_kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'jumlah_anggota' => Penduduk::where('no_kk', $keluarga->no_kk)->count(),
            'status' => $request->status,
        ]);

        return redirect()->route('kajor.keluarga.show', $id)->with('success', 'Keluarga berhasil diperbarui.');
    }

    // ============================================================
    // PENDUDUK (ANGOTA KELUARGA) CRUD
    // ============================================================

    public function pendudukCreate(string $no_kk)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        $keluarga = Keluarga::where('no_kk', $no_kk)->where('jorong', $jorongName)->firstOrFail();

        return view('kajor.penduduk.create', compact('profil', 'keluarga', 'jorongName'));
    }

    public function pendudukStore(Request $request)
    {
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
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
        ]);

        // Verify keluarga belongs to jorong
        $keluarga = Keluarga::where('no_kk', $request->no_kk)->where('jorong', $jorongName)->first();

        if (!$keluarga) {
            return redirect()->back()->with('error', 'Nomor KK tidak ditemukan di jorong Anda.');
        }

        Penduduk::create([
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'status_perkawinan' => $request->status_perkawinan,
            'hubungan_keluarga' => $request->hubungan_keluarga,
            'pekerjaan' => $request->pekerjaan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'alamat' => $request->alamat,
            'status_hidup' => 'hidup',
        ]);

        // Update jumlah anggota (hitung aktual dari database)
        $keluarga->update(['jumlah_anggota' => Penduduk::where('no_kk', $keluarga->no_kk)->count()]);

        return redirect()->route('kajor.keluarga.show', $keluarga->id)->with('success', 'Anggota keluarga berhasil ditambahkan.');
    }

    public function pendudukEdit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        $penduduk = Penduduk::with('keluarga')->findOrFail($id);

        if (!$penduduk->keluarga || strcasecmp(trim($penduduk->keluarga->jorong ?? ''), trim($jorongName ?? '')) !== 0) {
            return redirect()->route('kajor.penduduk.index')->with('error', 'Data tidak ditemukan di jorong Anda.');
        }

        $noKkList = Keluarga::where('jorong', $jorongName)->pluck('no_kk');
        $keluargas = Keluarga::where('jorong', $jorongName)->get();

        return view('kajor.penduduk.edit', compact('profil', 'penduduk', 'keluargas', 'jorongName', 'noKkList'));
    }

    public function pendudukUpdate(Request $request, string $id)
    {
        $jorongName = $this->getJorongName();

        $penduduk = Penduduk::with('keluarga')->findOrFail($id);

        if (!$penduduk->keluarga || strcasecmp(trim($penduduk->keluarga->jorong ?? ''), trim($jorongName ?? '')) !== 0) {
            return redirect()->route('kajor.penduduk.index')->with('error', 'Data tidak ditemukan di jorong Anda.');
        }

        $request->validate([
            'nik' => 'required|string|max:20|unique:penduduk,nik,' . $id,
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

        $oldNoKk = $penduduk->no_kk;
        $penduduk->update($request->only([
            'nik', 'no_kk', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'agama', 'status_perkawinan', 'hubungan_keluarga',
            'pekerjaan', 'pendidikan_terakhir', 'alamat', 'status_hidup',
        ]));

        // Update jumlah_anggota berdasarkan hitungan aktual
        if ($oldNoKk !== $penduduk->no_kk) {
            Keluarga::where('no_kk', $oldNoKk)->update(['jumlah_anggota' => Penduduk::where('no_kk', $oldNoKk)->count()]);
            Keluarga::where('no_kk', $penduduk->no_kk)->update(['jumlah_anggota' => Penduduk::where('no_kk', $penduduk->no_kk)->count()]);
        } else {
            Keluarga::where('no_kk', $penduduk->no_kk)->update(['jumlah_anggota' => Penduduk::where('no_kk', $penduduk->no_kk)->count()]);
        }

        return redirect()->route('kajor.penduduk.show', $id)->with('success', 'Data anggota berhasil diperbarui.');
    }

    // ============================================================
    // AJAX
    // ============================================================

    public function cariKk(Request $request)
    {
        $jorongName = $this->getJorongName();
        $query = $request->input('q');

        $keluargas = Keluarga::where('jorong', $jorongName)
            ->where(function ($q) use ($query) {
                $q->where('no_kk', 'like', "%{$query}%")
                  ->orWhere('kepala_keluarga_nik', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get();

        return response()->json($keluargas);
    }

    public function bisnisKos(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        $query = BisnisKos::where('jorong', $jorongName);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('pemilik_nama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis_usaha')) {
            $query->where('jenis_usaha', $request->jenis_usaha);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bisnis = $query->withCount(['penghunis' => function ($q) {
            $q->where('status', 'aktif');
        }])->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('kajor.bisniskos.index', compact('profil', 'bisnis', 'jorongName'));
    }

    public function bisnisKosShow(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();
        
        $bisnis = BisnisKos::with(['penghunis' => function ($q) {
            $q->orderByDesc('tanggal_masuk');
        }])->findOrFail($id);

        if (strcasecmp(trim($bisnis->jorong ?? ''), trim($jorongName ?? '')) !== 0) {
            return redirect()->route('kajor.bisniskos.index')->with('error', 'Data tidak ditemukan di jorong Anda.');
        }

        $penghuniAktif = $bisnis->penghunis()->where('status', 'aktif')->get();
        $penghuniNonaktif = $bisnis->penghunis()->where('status', '!=', 'aktif')->get();

        return view('kajor.bisniskos.show', compact('profil', 'bisnis', 'penghuniAktif', 'penghuniNonaktif', 'jorongName'));
    }

    public function bisnisKosPrint(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();
        
        $bisnis = BisnisKos::with(['penghunis' => function ($q) {
            $q->orderBy('status')->orderByDesc('tanggal_masuk');
        }])->findOrFail($id);

        if (strcasecmp(trim($bisnis->jorong ?? ''), trim($jorongName ?? '')) !== 0) {
            return redirect()->route('kajor.bisniskos.index')->with('error', 'Data tidak ditemukan di jorong Anda.');
        }

        return view('kajor.bisniskos.print', compact('profil', 'bisnis', 'jorongName'));
    }

    public function scanner()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->route('kajor.home')->with('error', 'Anda belum memiliki assigning jorong.');
        }

        return view('kajor.scanner.index', compact('profil', 'jorongName'));
    }

    public function verifyQr(Request $request)
    {
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum memiliki assigning jorong.'
            ]);
        }

        $request->validate([
            'keluarga_id' => 'required|integer',
            'token' => 'required|string'
        ]);

        // Verify QR token from riwayat pendataan
        $riwayat = \App\Models\RiwayatPendataanKeluarga::where('keluarga_id', $request->keluarga_id)
            ->where('qr_token', $request->token)
            ->first();

        if (!$riwayat) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau tidak ditemukan.'
            ]);
        }

        // Check if keluarga belongs to kajor's jorong
        $keluarga = Keluarga::find($request->keluarga_id);

        if (!$keluarga) {
            return response()->json([
                'success' => false,
                'message' => 'Data keluarga tidak ditemukan.'
            ]);
        }

        if (strcasecmp(trim($keluarga->jorong ?? ''), trim($jorongName ?? '')) !== 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data keluarga ini bukan milik jorong Anda (' . $jorongName . ').'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'QR Code valid! Data keluarga ditemukan.',
            'redirect_url' => route('kajor.keluarga.show', $keluarga->id)
        ]);
    }

    public function ceknik(Request $request)
    {
        $request->validate(['nik' => 'required|digits:16'], ['nik.digits' => 'NIK harus 16 digit']);

        $nikHash = hash('sha256', $request->nik);
        $penduduk = Penduduk::where('nik_hash', $nikHash)->first();

        return response()->json([
            'found' => !is_null($penduduk),
            'data' => $penduduk ? [
                'nama' => $penduduk->nama_lengkap,
                'no_kk' => $penduduk->no_kk,
                'alamat' => $penduduk->alamat,
                'jenis_kelamin' => $penduduk->jenis_kelamin,
                'tempat_lahir' => $penduduk->tempat_lahir,
                'tanggal_lahir' => $penduduk->tanggal_lahir,
            ] : null
        ]);
    }

    public function cekkk(Request $request)
    {
        $request->validate(['no_kk' => 'required|digits:16'], ['no_kk.digits' => 'No. KK harus 16 digit']);

        $keluarga = Keluarga::where('no_kk', $request->no_kk)->first();

        $kepalaKeluarga = null;
        if ($keluarga && $keluarga->kepala_keluarga_nik_hash) {
            $penduduk = Penduduk::where('nik_hash', $keluarga->kepala_keluarga_nik_hash)->first();
            $kepalaKeluarga = $penduduk ? $penduduk->nama_lengkap : $keluarga->kepala_keluarga_nik;
        }

        return response()->json([
            'found' => !is_null($keluarga),
            'data' => $keluarga ? [
                'kepala_keluarga' => $kepalaKeluarga,
                'alamat' => $keluarga->alamat,
                'rt' => $keluarga->rt,
                'rw' => $keluarga->rw,
                'desa_kelurahan' => $keluarga->desa_kelurahan,
                'jumlah_anggota' => $keluarga->jumlah_anggota,
            ] : null
        ]);
    }
}