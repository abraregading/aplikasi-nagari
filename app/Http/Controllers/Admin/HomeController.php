<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilNagari;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\RiwayatSurat;
use App\Models\User;
use App\Models\Berita;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
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

        // Statistik Pengguna & Berita
        $totalUser = User::count();
        $totalBerita = Berita::count();

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

        // Data layanan per jenis surat (untuk pie chart)
        $jenisLayanan = RiwayatSurat::select('jenis_surat', DB::raw('count(*) as total'))
            ->groupBy('jenis_surat')
            ->orderByDesc('total')
            ->limit(6)
            ->get();
        $jenisLabels = $jenisLayanan->pluck('jenis_surat')->toArray();
        $jenisData = $jenisLayanan->pluck('total')->toArray();

        // Riwayat surat terbaru (5 terakhir)
        $suratTerbaru = RiwayatSurat::with('penduduk')
            ->orderByDesc('tanggal_pengajuan')
            ->limit(5)
            ->get();

        return view('admin.home.index', compact(
            'profil', 'jmlpenduduk', 'jmllakilaki', 'jmlperempuan', 'jmlkeluarga',
            'totalSurat', 'suratDiajukan', 'suratDiproses', 'suratSelesai', 'suratDitolak',
            'totalUser', 'totalBerita',
            'hariLabels', 'hariData',
            'mingguLabels', 'mingguData',
            'bulanLabels', 'bulanData',
            'jenisLabels', 'jenisData',
            'suratTerbaru'
        ));
    }
}
