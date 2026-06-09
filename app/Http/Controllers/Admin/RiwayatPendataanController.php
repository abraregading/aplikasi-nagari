<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPendataanKeluarga;
use App\Models\User;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\ProfilNagari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatPendataanController extends Controller
{
    public function index(Request $request)
    {
        $petugasStats = User::where('role', 'petugas')
            ->select('users.id', 'users.name', DB::raw('COALESCE(COUNT(riwayat_pendataan_keluarga.id), 0) as total_update'))
            ->leftJoin('riwayat_pendataan_keluarga', 'users.id', '=', 'riwayat_pendataan_keluarga.petugas_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_update')
            ->get();

        $totalRiwayat = RiwayatPendataanKeluarga::count();
        $totalPetugas = User::where('role', 'petugas')->count();

        return view('admin.riwayatpendataan.index', compact('petugasStats', 'totalRiwayat', 'totalPetugas'));
    }

    public function detailPetugas(Request $request, string $petugasId)
    {
        $petugas = User::findOrFail($petugasId);
        
        $query = RiwayatPendataanKeluarga::with(['keluarga'])
            ->where('petugas_id', $petugasId)
            ->orderByDesc('tanggal_update');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', "%{$search}%")
                  ->orWhere('kepala_keluarga_nama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('aksi')) {
            $query->where('aksi', $request->aksi);
        }

        $riwayats = $query->paginate(15)->withQueryString();
        $totalUpdate = RiwayatPendataanKeluarga::where('petugas_id', $petugasId)->count();

        return view('admin.riwayatpendataan.detail', compact('petugas', 'riwayats', 'totalUpdate'));
    }

    public function printDetailPetugas(string $petugasId)
    {
        $petugas = User::findOrFail($petugasId);
        
        $riwayats = RiwayatPendataanKeluarga::with(['keluarga'])
            ->where('petugas_id', $petugasId)
            ->orderByDesc('tanggal_update')
            ->get();

        $totalUpdate = $riwayats->count();

        return view('admin.riwayatpendataan.print', compact('petugas', 'riwayats', 'totalUpdate'));
    }

    public function printKeluarga(string $petugasId, string $keluargaId)
    {
        $petugas = User::findOrFail($petugasId);
        $keluarga = Keluarga::with(['penduduks'])->findOrFail($keluargaId);
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        
        $riwayat = RiwayatPendataanKeluarga::where('petugas_id', $petugasId)
            ->where('keluarga_id', $keluargaId)
            ->orderByDesc('tanggal_update')
            ->first();

        return view('admin.riwayatpendataan.print-keluarga', compact('petugas', 'keluarga', 'profil', 'riwayat'));
    }
}