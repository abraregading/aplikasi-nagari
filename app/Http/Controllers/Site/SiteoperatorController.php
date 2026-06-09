<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProfilNagari;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\Tentang;
use App\Models\Berita;

class SiteoperatorController extends Controller
{
    public function index()
    {
        $profilnagari = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jmlpenduduk = Penduduk::count();
        $jmllakilaki = Penduduk::where('jenis_kelamin', 'L')->count();
        $jmlperempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $jmlkeluarga = Keluarga::count();
        $tentang = Tentang::get()->first();
        $galeri = Berita::orderBy('created_at', 'desc')->paginate(3);
        
        // dd($profilnagari);
        return view('site.home.index', compact('profilnagari', 'jmlpenduduk', 'jmllakilaki', 'jmlperempuan', 'jmlkeluarga', 'tentang', 'galeri'));
    }

    public function profil()
    {
        $profilnagari = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $tentang = Tentang::get()->first();

        return view('site.home.profil', compact('profilnagari', 'tentang'));
    }

    public function layanan()
    {
        $profilnagari = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        
        return view('site.home.layanan', compact('profilnagari'));
    }

    public function galeri()
    {
        $profilnagari = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $galeri = Berita::orderBy('created_at', 'desc')->paginate(6);

        return view('site.home.galeri', compact('profilnagari', 'galeri'));
    }

    public function kontak()
    {
        $profilnagari = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        
        return view('site.home.kontak', compact('profilnagari'));
    }

    public function umkm()
    {
        $profilnagari = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        
        return view('site.home.umkm', compact('profilnagari'));
    }

    public function kesehatan()
    {
        $profilnagari = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        
        return view('site.home.kesehatan', compact('profilnagari'));
    }

    public function statistik()
    {
        $profilnagari = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();

        $jmlkeluarga = Keluarga::count();
        $jmlpenduduk = Penduduk::where('status_hidup', 'hidup')->count();

        $agama = Penduduk::select('agama', DB::raw('count(*) as total'))
            ->where('status_hidup', 'hidup')
            ->whereNotNull('agama')
            ->groupBy('agama')
            ->orderBy('total', 'desc')
            ->get();

        $pekerjaan = Penduduk::select('pekerjaan', DB::raw('count(*) as total'))
            ->where('status_hidup', 'hidup')
            ->whereNotNull('pekerjaan')
            ->groupBy('pekerjaan')
            ->orderBy('total', 'desc')
            ->get();

        $kelompokUmur = Penduduk::select(DB::raw("
            CASE
                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 5 THEN '0-5 (Balita)'
                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 6 AND 12 THEN '6-12 (Anak-anak)'
                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 13 AND 17 THEN '13-17 (Remaja)'
                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 40 THEN '18-40 (Dewasa)'
                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 41 AND 59 THEN '41-59 (Pertengahan)'
                ELSE '60+ (Lansia)'
            END as kategori,
            COUNT(*) as total
        "))
            ->where('status_hidup', 'hidup')
            ->whereNotNull('tanggal_lahir')
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->get();

        return view('site.home.statistik', compact(
            'profilnagari', 'jmlkeluarga', 'jmlpenduduk',
            'agama', 'pekerjaan', 'kelompokUmur'
        ));
    }
}
