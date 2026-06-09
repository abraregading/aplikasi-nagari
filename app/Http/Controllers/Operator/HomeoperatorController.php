<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilNagari;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\RiwayatSurat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeoperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();

        // Statistik Penduduk
        $jmlpenduduk = Penduduk::count();
        $jmllakilaki = Penduduk::where('jenis_kelamin', 'L')->count();
        $jmlperempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $jmlkeluarga = Keluarga::count();

        // Statistik Surat/Layanan
        $totalSurat = RiwayatSurat::count();
        $suratDiajukan = RiwayatSurat::where('status', 'diajukan')->count();
        $suratDiproses = RiwayatSurat::where('status', 'diproses')->count();
        $suratSelesai = RiwayatSurat::where('status', 'selesai')->count();
        $suratDitolak = RiwayatSurat::where('status', 'ditolak')->count();

        // Data grafik harian (7 hari terakhir)
        $hariLabels = [];
        $hariData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $hariLabels[] = $date->translatedFormat('D, d M');
            $hariData[] = RiwayatSurat::whereDate('tanggal_pengajuan', $date->toDateString())->count();
        }

        // Data grafik mingguan (4 minggu terakhir)
        $mingguLabels = [];
        $mingguData = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            $mingguLabels[] = $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M');
            $mingguData[] = RiwayatSurat::whereBetween('tanggal_pengajuan', [$startOfWeek, $endOfWeek])->count();
        }

        // Data grafik bulanan (6 bulan terakhir)
        $bulanLabels = [];
        $bulanData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $bulanLabels[] = $date->translatedFormat('M Y');
            $bulanData[] = RiwayatSurat::whereYear('tanggal_pengajuan', $date->year)
                ->whereMonth('tanggal_pengajuan', $date->month)
                ->count();
        }

        // Data layanan per jenis surat
        $jenisLayanan = RiwayatSurat::select('jenis_surat', DB::raw('count(*) as total'))
            ->groupBy('jenis_surat')
            ->orderByDesc('total')
            ->limit(6)
            ->get();
        $jenisLabels = $jenisLayanan->pluck('jenis_surat')->toArray();
        $jenisData = $jenisLayanan->pluck('total')->toArray();

        // Riwayat surat terbaru
        $suratTerbaru = RiwayatSurat::with('penduduk')
            ->orderByDesc('tanggal_pengajuan')
            ->limit(5)
            ->get();

        return view('operator.home.index', compact(
            'profil',
            'jmlpenduduk', 'jmllakilaki', 'jmlperempuan', 'jmlkeluarga',
            'totalSurat', 'suratDiajukan', 'suratDiproses', 'suratSelesai', 'suratDitolak',
            'hariLabels', 'hariData',
            'mingguLabels', 'mingguData',
            'bulanLabels', 'bulanData',
            'jenisLabels', 'jenisData',
            'suratTerbaru'
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
