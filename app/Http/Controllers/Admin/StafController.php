<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staf;
use App\Models\Penduduk;
use App\Models\Jabatan;
use App\Models\ProfilNagari;

class StafController extends Controller
{
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $staf = Staf::with(['penduduk', 'jabatan'])->get();
        $penduduk = Penduduk::all();
        $jabatan = Jabatan::all();
        return view('admin.staf.index', compact('staf', 'penduduk', 'jabatan', 'profil'));
    }

    public function create()
    {
        $penduduk = Penduduk::all();
        $jabatan = Jabatan::all();
        return view('admin.staf.create', compact('penduduk', 'jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'jabatan_id' => 'required|exists:jabatans,id',
            'profil' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $staf = new Staf();
        $staf->penduduk_id = $request->penduduk_id;
        $staf->jabatan_id = $request->jabatan_id;
        $staf->profil = $request->profil;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/staf'), $filename);
            $staf->gambar = 'uploads/staf/' . $filename;
        }

        $staf->save();

        return redirect()->route('staf.index')->with('success', 'Staf berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $staf = Staf::findOrFail($id);
        $penduduk = Penduduk::all();
        $jabatan = Jabatan::all();
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.staf.edit', compact('staf', 'penduduk', 'jabatan', 'profil'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'jabatan_id' => 'required|exists:jabatans,id',
            'profil' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $staf = Staf::findOrFail($id);
        $staf->penduduk_id = $request->penduduk_id;
        $staf->jabatan_id = $request->jabatan_id;
        $staf->profil = $request->profil;

        if ($request->hasFile('gambar')) {
            if ($staf->gambar && file_exists(public_path($staf->gambar))) {
                unlink(public_path($staf->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/staf'), $filename);
            $staf->gambar = 'uploads/staf/' . $filename;
        }

        $staf->save();

        return redirect()->route('staf.index')->with('success', 'Staf berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $staf = Staf::findOrFail($id);

        if ($staf->gambar && file_exists(public_path($staf->gambar))) {
            unlink(public_path($staf->gambar));
        }

        $staf->delete();

        return redirect()->route('staf.index')->with('success', 'Staf berhasil dihapus.');
    }
}
