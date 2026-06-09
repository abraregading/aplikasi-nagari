<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Kategoriberita;
use App\Models\ProfilNagari;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $berita = Berita::with('kategoriberita')->get();
        $kategoriberita = Kategoriberita::all();

        // dd($kategoriberita);
        return view('admin.berita.index', compact('berita', 'kategoriberita', 'profil'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $kategoriberita = Kategoriberita::all();
        return view('admin.berita.create', compact('kategoriberita', 'profil'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul_berita' => 'required|string|max:255',
            'kategoriberita_id' => 'required|exists:kategoriberitas,id',
            'slug' => 'nullable|string|max:255',
            'isi_berita1' => 'required|string',
            'isi_berita2' => 'nullable|string',
            'isi_berita3' => 'nullable|string',
            'quote' => 'nullable|string|max:255',
            'gambar_berita' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar_berita')) {
            $gambarPath = $request->file('gambar_berita')->store('berita', 'public');
            $validatedData['gambar_berita'] = $gambarPath;
        } else {
            $validatedData['gambar_berita'] = 'berita/default.jpg';
        }
        // Generate slug dan pastikan unik
        $slug = $validatedData['slug'] ?? Str::slug($validatedData['judul_berita']);
        $originalSlug = $slug;
        $counter = 1;
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $validatedData['slug'] = $slug;
        Berita::create($validatedData);
        

        return redirect()->route('daftar-berita.index')->with('success', 'Berita berhasil ditambahkan.');
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
        $berita = Berita::findOrFail($id);
        $kategoriberita = Kategoriberita::all();
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.berita.edit', compact('berita', 'kategoriberita', 'profil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $berita = Berita::findOrFail($id);

        $validatedData = $request->validate([
            
            'judul_berita' => 'required|string|max:255',
            'kategoriberita_id' => 'required|exists:kategoriberitas,id',
            'slug' => 'nullable|string|max:255',
            'isi_berita1' => 'required|string',
            'isi_berita2' => 'nullable|string',
            'isi_berita3' => 'nullable|string',
            'quote' => 'nullable|string|max:255',
            'gambar_berita' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar_berita')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar_berita && $berita->gambar_berita != 'berita/default.jpg') {
                Storage::disk('public')->delete($berita->gambar_berita);
            }

            $gambarPath = $request->file('gambar_berita')->store('berita', 'public');
            $validatedData['gambar_berita'] = $gambarPath;
        }

        // Generate slug dan pastikan unik
        $slug = $validatedData['slug'] ?? Str::slug($validatedData['judul_berita']);
        $originalSlug = $slug;
        $counter = 1;
        while (Berita::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $validatedData['slug'] = $slug;

        $berita->update($validatedData);

        return redirect()->route('daftar-berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus gambar jika ada
        if ($berita->gambar_berita) {
            Storage::disk('public')->delete($berita->gambar_berita);
        }

        $berita->delete();

        return redirect()->route('daftar-berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
