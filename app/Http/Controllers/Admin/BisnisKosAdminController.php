<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BisnisKos;
use App\Models\PenghuniKos;
use App\Models\ProfilNagari;
use Illuminate\Http\Request;

class BisnisKosAdminController extends Controller
{
    public function index(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $query = BisnisKos::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('pemilik_nama', 'like', "%{$search}%")
                  ->orWhere('pemilik_nik', 'like', "%{$search}%");
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

        return view('admin.bisniskos.index', compact('bisnis', 'profil'));
    }

    public function show(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $bisnis = BisnisKos::with(['penghunis' => function ($q) {
            $q->orderByDesc('tanggal_masuk');
        }])->findOrFail($id);

        $penghuniAktif = $bisnis->penghunis()->where('status', 'aktif')->get();
        $penghuniNonaktif = $bisnis->penghunis()->where('status', '!=', 'aktif')->get();

        return view('admin.bisniskos.show', compact('bisnis', 'penghuniAktif', 'penghuniNonaktif', 'profil'));
    }

    public function print(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $bisnis = BisnisKos::with(['penghunis' => function ($q) {
            $q->orderBy('status')->orderByDesc('tanggal_masuk');
        }])->findOrFail($id);

        return view('admin.bisniskos.print', compact('bisnis', 'profil'));
    }

    public function destroy(string $id)
    {
        $bisnis = BisnisKos::findOrFail($id);
        $bisnis->penghunis()->delete();
        $bisnis->delete();

        return redirect()->route('admin.bisniskos.index')
            ->with('success', 'Data usaha berhasil dihapus.');
    }
}