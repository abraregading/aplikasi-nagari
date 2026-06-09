<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilNagari;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\RiwayatPendataanKeluarga;
use App\Models\BisnisKos;
use Carbon\Carbon;

class HomepetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $userId = Auth::id();

        // Statistik Penduduk Keseluruhan (bukan berdasarkan petugas)
        $jmlpenduduk = Penduduk::count();
        $jmllakilaki = Penduduk::where('jenis_kelamin', 'L')->count();
        $jmlperempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $jmlkeluarga = Keluarga::count();

        // Statistik Pendataan Keluarga (berdasarkan petugas login)
        $pendataanKeluarga = RiwayatPendataanKeluarga::where('petugas_id', $userId);
        $totalPendataanKeluarga = $pendataanKeluarga->count();
        $pendataanKeluargaBaru = $pendataanKeluarga->where('aksi', 'create')->count();
        $pendataanKeluargaEdit = $pendataanKeluarga->where('aksi', 'update')->count();

        // Statistik Bisnis Kos/Kontrakan (berdasarkan petugas login)
        $bisnisQuery = BisnisKos::where('petugas_id', $userId);
        $totalBisnis = $bisnisQuery->count();
        $bisnisKos = $bisnisQuery->where('jenis_usaha', 'kos')->count();
        $bisnisKontrakan = $bisnisQuery->where('jenis_usaha', 'kontrakan')->count();
        $bisnisRumahPetak = $bisnisQuery->where('jenis_usaha', 'rumah_petak')->count();
        $bisnisAktif = $bisnisQuery->where('status', 'aktif')->count();

        // Grafik pendataan keluarga per hari (7 hari terakhir)
        $hariLabels = [];
        $hariData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $hariLabels[] = $date->translatedFormat('D, d M');
            $hariData[] = RiwayatPendataanKeluarga::where('petugas_id', $userId)
                ->whereDate('tanggal_update', $date->toDateString())
                ->count();
        }

        // Grafik pendataan keluarga per minggu (4 minggu terakhir)
        $mingguLabels = [];
        $mingguData = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            $mingguLabels[] = $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M');
            $mingguData[] = RiwayatPendataanKeluarga::where('petugas_id', $userId)
                ->whereBetween('tanggal_update', [$startOfWeek, $endOfWeek])
                ->count();
        }

        // Grafik pendataan keluarga per bulan (6 bulan terakhir)
        $bulanLabels = [];
        $bulanData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $bulanLabels[] = $date->translatedFormat('M Y');
            $bulanData[] = RiwayatPendataanKeluarga::where('petugas_id', $userId)
                ->whereYear('tanggal_update', $date->year)
                ->whereMonth('tanggal_update', $date->month)
                ->count();
        }

        // Grafik bisnis per jenis
        $jenisLabels = ['Kos', 'Kontrakan', 'Rumah Petak'];
        $jenisData = [$bisnisKos, $bisnisKontrakan, $bisnisRumahPetak];

        // Riwayat pendataan terbaru (5 terbaru)
        $riwayatKeluargaTerbaru = RiwayatPendataanKeluarga::with('keluarga')
            ->where('petugas_id', $userId)
            ->orderByDesc('tanggal_update')
            ->limit(5)
            ->get();

        // Riwayat bisnis terbaru
        $riwayatBisnisTerbaru = BisnisKos::where('petugas_id', $userId)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('petugas.home.index', compact(
            'profil',
            'jmlpenduduk', 'jmllakilaki', 'jmlperempuan', 'jmlkeluarga',
            'totalPendataanKeluarga', 'pendataanKeluargaBaru', 'pendataanKeluargaEdit',
            'totalBisnis', 'bisnisKos', 'bisnisKontrakan', 'bisnisRumahPetak', 'bisnisAktif',
            'hariLabels', 'hariData',
            'mingguLabels', 'mingguData',
            'bulanLabels', 'bulanData',
            'jenisLabels', 'jenisData',
            'riwayatKeluargaTerbaru',
            'riwayatBisnisTerbaru'
        ));
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
