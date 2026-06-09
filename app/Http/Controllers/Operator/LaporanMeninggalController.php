<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataMeninggal;
use App\Models\Perangkat;
use App\Models\ProfilNagari;
use App\Models\User;

class LaporanMeninggalController extends Controller
{
    public function index(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();

        $bulan = $request->input('bulan', now()->format('m'));
        $tahun = $request->input('tahun', now()->format('Y'));
        $jorongFilter = $request->input('jorong', '');

        $query = DataMeninggal::with('creator')
            ->whereYear('tanggal_meninggal', $tahun)
            ->whereMonth('tanggal_meninggal', $bulan);

        if ($jorongFilter) {
            $query->whereHas('creator', function ($q) use ($jorongFilter) {
                $q->where('jorong', $jorongFilter);
            });
        }

        $dataMeninggal = $query->orderBy('tanggal_meninggal')->get();

        $dataPerJorong = $dataMeninggal->groupBy(function ($item) {
            return $item->creator ? $item->creator->jorong : 'Tanpa Jorong';
        });

        $totalMeninggal = $dataMeninggal->count();
        $totalLaki = $dataMeninggal->where('jenis_kelamin', 'L')->count();
        $totalPerempuan = $dataMeninggal->where('jenis_kelamin', 'P')->count();

        $daftarJorong = User::whereNotNull('jorong')->distinct()->orderBy('jorong')->pluck('jorong');

        $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $namaBulan = $bulanIndo[(int)$bulan - 1];

        return view('operator.laporan-meninggal.index', compact(
            'profil', 'dataMeninggal', 'dataPerJorong',
            'bulan', 'tahun', 'namaBulan', 'jorongFilter',
            'totalMeninggal', 'totalLaki', 'totalPerempuan',
            'daftarJorong'
        ));
    }

    public function cetak(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();

        $bulan = $request->input('bulan', now()->format('m'));
        $tahun = $request->input('tahun', now()->format('Y'));
        $jorongFilter = $request->input('jorong', '');

        $query = DataMeninggal::with('creator')
            ->whereYear('tanggal_meninggal', $tahun)
            ->whereMonth('tanggal_meninggal', $bulan);

        if ($jorongFilter) {
            $query->whereHas('creator', function ($q) use ($jorongFilter) {
                $q->where('jorong', $jorongFilter);
            });
        }

        $dataMeninggal = $query->orderBy('tanggal_meninggal')->get();

        $dataPerJorong = $dataMeninggal->groupBy(function ($item) {
            return $item->creator ? $item->creator->jorong : 'Tanpa Jorong';
        });

        $totalMeninggal = $dataMeninggal->count();
        $totalLaki = $dataMeninggal->where('jenis_kelamin', 'L')->count();
        $totalPerempuan = $dataMeninggal->where('jenis_kelamin', 'P')->count();

        $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $namaBulan = $bulanIndo[(int)$bulan - 1];

        $walinagari = Perangkat::where('jabatan_id', 1)->with('penduduk', 'jabatan')->first();

        return view('operator.laporan-meninggal.cetak', compact(
            'profil', 'dataMeninggal', 'dataPerJorong',
            'bulan', 'tahun', 'namaBulan', 'jorongFilter',
            'totalMeninggal', 'totalLaki', 'totalPerempuan',
            'walinagari'
        ));
    }
}
