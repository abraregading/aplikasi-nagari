<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perangkat;
use App\Models\Penduduk;
use App\Models\Jabatan;
use App\Models\ProfilNagari;

class PerangkatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $perangkat = Perangkat::with(['penduduk', 'jabatan'])->get();
        $penduduk = Penduduk::all();
        $jabatan = Jabatan::all();
        return view('admin.perangkat.index', compact('perangkat', 'penduduk', 'jabatan', 'profil'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penduduk = Penduduk::all();
        $jabatan = Jabatan::all();
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        // dd($penduduk, $jabatan);
        return view('admin.perangkat.create', compact('penduduk', 'jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

            $request->validate([
                'penduduk_id' => 'required|exists:penduduk,id',
                'jabatan_id' => 'required|exists:jabatans,id',
                'profil' => 'nullable|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

        $perangkat = new Perangkat();
        $perangkat->penduduk_id = $request->penduduk_id;
        $perangkat->jabatan_id = $request->jabatan_id;
        $perangkat->profil = $request->profil;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/perangkat'), $filename);
            $perangkat->gambar = 'uploads/perangkat/' . $filename;
        }

        $perangkat->save();

        return redirect()->route('perangkat.index')->with('success', 'Perangkat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $perangkat = Perangkat::findOrFail($id);
        $penduduk = Penduduk::all();
        $jabatan = Jabatan::all();
        return view('admin.perangkat.edit', compact('perangkat', 'penduduk', 'jabatan', 'profil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'jabatan_id' => 'required|exists:jabatans,id',
            'profil' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $perangkat = Perangkat::findOrFail($id);
        $perangkat->penduduk_id = $request->penduduk_id;
        $perangkat->jabatan_id = $request->jabatan_id;
        $perangkat->profil = $request->profil;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($perangkat->gambar && file_exists(public_path($perangkat->gambar))) {
                unlink(public_path($perangkat->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/perangkat'), $filename);
            $perangkat->gambar = 'uploads/perangkat/' . $filename;
        }

        $perangkat->save();

        return redirect()->route('perangkat.index')->with('success', 'Perangkat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $perangkat = Perangkat::findOrFail($id);

        // Hapus gambar jika ada
        if ($perangkat->gambar && file_exists(public_path($perangkat->gambar))) {
            unlink(public_path($perangkat->gambar));
        }

        $perangkat->delete();

        return redirect()->route('perangkat.index')->with('success', 'Perangkat berhasil dihapus.');
    }
}
