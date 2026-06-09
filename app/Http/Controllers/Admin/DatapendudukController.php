<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilNagari;
use App\Models\Penduduk;
use App\Models\Keluarga;

class DatapendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $penduduks = Penduduk::all();
        $jmlpenduduk = Penduduk::count();
        $jmllakilaki = Penduduk::where('jenis_kelamin', 'L')->count();
        $jmlperempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $jmlkeluarga = Keluarga::count();

        return view('admin.datapenduduk.index', compact('profil', 'penduduks', 'jmlpenduduk', 'jmllakilaki', 'jmlperempuan', 'jmlkeluarga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $keluargas = Keluarga::all();
        return view('admin.datapenduduk.create', compact('profil', 'keluargas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            'status_hidup' => 'required|in:hidup,meninggal,pindah',
        ]);

        Penduduk::create($request->only([
            'nik', 'no_kk', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'agama', 'status_perkawinan', 'hubungan_keluarga',
            'pekerjaan', 'pendidikan_terakhir', 'alamat', 'status_hidup',
        ]));

        return redirect()->route('data-penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $penduduk = Penduduk::findOrFail($id);
        return view('admin.datapenduduk.show', compact('profil', 'penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $penduduk = Penduduk::findOrFail($id);
        $keluargas = Keluarga::all();
        return view('admin.datapenduduk.edit', compact('profil', 'penduduk', 'keluargas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $request->validate([
            'nik' => 'required|string|max:20|unique:penduduk,nik,' . $penduduk->id,
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

        $penduduk->update($request->only([
            'nik', 'no_kk', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'agama', 'status_perkawinan', 'hubungan_keluarga',
            'pekerjaan', 'pendidikan_terakhir', 'alamat', 'status_hidup',
        ]));

        return redirect()->route('data-penduduk.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();

        return redirect()->route('data-penduduk.index')->with('success', 'Data penduduk berhasil dihapus.');
    }

    /**
     * Search KK untuk autocomplete
     */
    public function cariKk(Request $request)
    {
        $search = $request->get('q', '');
        
        $keluargas = Keluarga::where('no_kk', 'like', '%' . $search . '%')
            ->orWhere('kepala_keluarga_nik', 'like', '%' . $search . '%')
            ->limit(20)
            ->get(['no_kk', 'kepala_keluarga_nik', 'alamat', 'rt', 'rw', 'desa_kelurahan']);

        return response()->json($keluargas);
    }
}
