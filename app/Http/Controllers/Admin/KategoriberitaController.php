<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategoriberita;
use App\Models\ProfilNagari;

class KategoriberitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $kategoriberita = Kategoriberita::all();

        return view('admin.kategoriberita.index', compact('kategoriberita', 'profil'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.kategoriberita.create', compact('profil'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_berita' => 'required|string|max:255',
            'link' => 'required|string',
        ]);

        Kategoriberita::create($request->all());

        return redirect()->route('kategori-berita.index')->with('success', 'Kategori Berita created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategoriberita = Kategoriberita::findOrFail($id);
        return view('admin.kategoriberita.show', compact('kategoriberita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategoriberita = Kategoriberita::findOrFail($id);
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.kategoriberita.edit', compact('kategoriberita', 'profil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_berita' => 'required|string|max:255',
            'link' => 'required|string',
        ]);

        $kategoriberita = Kategoriberita::findOrFail($id);
        $kategoriberita->update($request->all());

        return redirect()->route('kategori-berita.index')->with('success', 'Kategori Berita updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategoriberita = Kategoriberita::findOrFail($id);
        $kategoriberita->delete();

        return redirect()->route('kategori-berita.index')->with('success', 'Kategori Berita deleted successfully.');
    }
}
