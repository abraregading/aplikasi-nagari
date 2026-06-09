<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perangkat;
use App\Models\Jabatan;
use App\Models\Staf;
use App\Models\ProfilNagari;

class PemerintahansiteController extends Controller
{
    public function index()
    {
        $profilnagari = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();

        $jabatan = Jabatan::with('perangkat.penduduk')->get();
        
        $walinagari = Perangkat::whereHas('jabatan', function ($query) {
            $query->where('jabatan_id', 1);
        })->with('jabatan', 'penduduk')->first();
        $sekdes = Perangkat::whereHas('jabatan', function ($query) {
            $query->where('jabatan_id', 2);
        })->with('jabatan', 'penduduk')->first();
        $kasipeme = Perangkat::whereHas('jabatan', function ($query) {
            $query->where('jabatan_id', 3);
        })->with('jabatan', 'penduduk')->first();
        $kasi_kesra = Perangkat::whereHas('jabatan', function ($query) {
            $query->where('jabatan_id', 4);
        })->with('jabatan', 'penduduk')->first();
        $kaur_keuangan = Perangkat::whereHas('jabatan', function ($query) {
            $query->where('jabatan_id', 5);
        })->with('jabatan', 'penduduk')->first();
        $kaur_umum = Perangkat::whereHas('jabatan', function ($query) {
            $query->where('jabatan_id', 6);
        })->with('jabatan', 'penduduk')->first();
        $kepala_jorong_kuamang = Perangkat::whereHas('jabatan', function ($query) {
            $query->where('jabatan_id', 7);
        })->with('jabatan', 'penduduk')->first();
        $kepala_jorong_kuamangbarat = Perangkat::whereHas('jabatan', function ($query) {
            $query->where('jabatan_id', 8);
        })->with('jabatan', 'penduduk')->first();
        $kepala_jorong_kuamangtimur = Perangkat::whereHas('jabatan', function ($query) {
            $query->where('jabatan_id', 9);
        })->with('jabatan', 'penduduk')->first();
        $kepala_jorong_lubukalai = Perangkat::whereHas('jabatan', function ($query) {
            $query->where('jabatan_id', 10);
        })->with('jabatan', 'penduduk')->first();
        $kepala_jorong_lubukalaiselatan= Perangkat::whereHas('jabatan', function ($query) {
            $query->where('jabatan_id', 11);
        })->with('jabatan', 'penduduk')->first();
        
        // Ambil staf untuk setiap kasi/kaur
        $staf_kasipeme = Staf::where('jabatan_id', 3)->with('penduduk')->get();
        $staf_kasi_kesra = Staf::where('jabatan_id', 4)->with('penduduk')->get();
        $staf_kaur_keuangan = Staf::where('jabatan_id', 5)->with('penduduk')->get();
        $staf_kaur_umum = Staf::where('jabatan_id', 6)->with('penduduk')->get();

        return view('site.konten.pemerintahan.index', compact(
            'jabatan', 'walinagari', 'sekdes', 'kasipeme', 'kasi_kesra',
            'kaur_keuangan', 'kaur_umum',
            'kepala_jorong_kuamang', 'kepala_jorong_kuamangbarat',
            'kepala_jorong_kuamangtimur', 'kepala_jorong_lubukalai',
            'kepala_jorong_lubukalaiselatan', 'profilnagari',
            'staf_kasipeme', 'staf_kasi_kesra', 'staf_kaur_keuangan', 'staf_kaur_umum'
        ));
    }
}
