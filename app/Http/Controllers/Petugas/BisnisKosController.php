<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\BisnisKos;
use App\Models\PenghuniKos;
use App\Models\ProfilNagari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BisnisKosController extends Controller
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
                  ->orWhere('pemilik_nama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis_usaha')) {
            $query->where('jenis_usaha', $request->jenis_usaha);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bisnis = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('petugas.bisniskos.index', compact('bisnis', 'profil'));
    }

    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('petugas.bisniskos.create', compact('profil'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:100',
            'jenis_usaha' => 'required|in:kos,kontrakan,rumah_petak',
            'alamat' => 'required|string|max:255',
            'jorong' => 'nullable|string|max:10',
            'desa_kelurahan' => 'nullable|string|max:100',
            'jumlah_kamar' => 'nullable|integer|min:0',
            'pemilik_nama' => 'required|string|max:100',
            'pemilik_nik' => 'nullable|string|max:20',
            'pemilik_telepon' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
            'catatan' => 'nullable|string',
        ]);

        $validated['petugas_id'] = Auth::id();

        BisnisKos::create($validated);

        return redirect()->route('petugas.bisniskos.index')
            ->with('success', 'Data bisnis berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $bisnis = BisnisKos::with('penghunis')->findOrFail($id);
        $penghuniAktif = $bisnis->penghunis()->where('status', 'aktif')->get();

        return view('petugas.bisniskos.show', compact('bisnis', 'penghuniAktif', 'profil'));
    }

    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $bisnis = BisnisKos::findOrFail($id);
        return view('petugas.bisniskos.edit', compact('bisnis', 'profil'));
    }

    public function update(Request $request, string $id)
    {
        $bisnis = BisnisKos::findOrFail($id);

        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:100',
            'jenis_usaha' => 'required|in:kos,kontrakan,rumah_petak',
            'alamat' => 'required|string|max:255',
            'jorong' => 'nullable|string|max:10',
            'desa_kelurahan' => 'nullable|string|max:100',
            'jumlah_kamar' => 'nullable|integer|min:0',
            'pemilik_nama' => 'required|string|max:100',
            'pemilik_nik' => 'nullable|string|max:20',
            'pemilik_telepon' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
            'catatan' => 'nullable|string',
        ]);

        $bisnis->update($validated);

        return redirect()->route('petugas.bisniskos.index')
            ->with('success', 'Data bisnis berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $bisnis = BisnisKos::findOrFail($id);
        $bisnis->delete();

        return redirect()->route('petugas.bisniskos.index')
            ->with('success', 'Data bisnis berhasil dihapus.');
    }

    public function penghuniIndex(Request $request, string $bisnisId)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $bisnis = BisnisKos::findOrFail($bisnisId);
        
        $query = PenghuniKos::where('bisnis_kos_id', $bisnisId);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_kamar', 'like', "%{$search}%");
            });
        }

        $penghunis = $query->orderByDesc('tanggal_masuk')->paginate(15)->withQueryString();

        return view('petugas.bisniskos.penghuni.index', compact('bisnis', 'penghunis', 'profil'));
    }

    public function penghuniCreate(string $bisnisId)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $bisnis = BisnisKos::findOrFail($bisnisId);
        return view('petugas.bisniskos.penghuni.create', compact('bisnis', 'profil'));
    }

    public function penghuniStore(Request $request, string $bisnisId)
    {
        
        $bisnis = BisnisKos::findOrFail($bisnisId);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nik' => 'nullable|string|max:20',
            'jekel' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'asal_desa' => 'nullable|string|max:100',
            'asal_kecamatan' => 'nullable|string|max:100',
            'asal_kabupaten' => 'nullable|string|max:100',
            'no_kamar' => 'nullable|string|max:20',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => 'nullable|date',
            'status' => 'required|in:aktif,pindah,keluar',
            'catatan' => 'nullable|string',
        ]);

        $validated['bisnis_kos_id'] = $bisnisId;
        $validated['petugas_id'] = Auth::id();

        PenghuniKos::create($validated);

        return redirect()->route('petugas.bisniskos.penghuni.index', $bisnisId)
            ->with('success', 'Data penghuni berhasil ditambahkan.');
    }

    public function penghuniEdit(string $bisnisId, string $penghuniId)
    {
        $bisnis = BisnisKos::findOrFail($bisnisId);
        $penghuni = PenghuniKos::where('bisnis_kos_id', $bisnisId)->findOrFail($penghuniId);
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('petugas.bisniskos.penghuni.edit', compact('bisnis', 'penghuni', 'profil'));
    }

    public function penghuniUpdate(Request $request, string $bisnisId, string $penghuniId)
    {
        $penghuni = PenghuniKos::where('bisnis_kos_id', $bisnisId)->findOrFail($penghuniId);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nik' => 'nullable|string|max:20',
            'jekel' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'asal_desa' => 'nullable|string|max:100',
            'asal_kecamatan' => 'nullable|string|max:100',
            'asal_kabupaten' => 'nullable|string|max:100',
            'no_kamar' => 'nullable|string|max:20',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => 'nullable|date',
            'status' => 'required|in:aktif,pindah,keluar',
            'catatan' => 'nullable|string',
        ]);

        $penghuni->update($validated);

        return redirect()->route('petugas.bisniskos.penghuni.index', $bisnisId)
            ->with('success', 'Data penghuni berhasil diperbarui.');
    }

    public function penghuniDestroy(string $bisnisId, string $penghuniId)
    {
        $penghuni = PenghuniKos::where('bisnis_kos_id', $bisnisId)->findOrFail($penghuniId);
        $penghuni->delete();

        return redirect()->route('petugas.bisniskos.penghuni.index', $bisnisId)
            ->with('success', 'Data penghuni berhasil dihapus.');
    }

    public function searchNik(Request $request)
    {
        $nik = $request->nik;
        
        $penduduk = \App\Models\Penduduk::where('nik', $nik)->first();
        
        if ($penduduk) {
            return response()->json([
                'found' => true,
                'data' => [
                    'nik' => $penduduk->nik,
                    'nama_lengkap' => $penduduk->nama_lengkap,
                    'tempat_lahir' => $penduduk->tempat_lahir,
                    'tanggal_lahir' => $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('Y-m-d') : null,
                    'jenis_kelamin' => $penduduk->jenis_kelamin,
                    'pekerjaan' => $penduduk->pekerjaan,
                    'alamat' => $penduduk->alamat,
                ]
            ]);
        }
        
        return response()->json(['found' => false]);
    }

    public function searchNikByName(Request $request)
    {
        $search = $request->search;
        
        $penduduks = \App\Models\Penduduk::where('nama_lengkap', 'like', "%{$search}%")
            ->orWhere('nik', 'like', "%{$search}%")
            ->limit(10)
            ->get();
        
        return response()->json($penduduks);
    }
}