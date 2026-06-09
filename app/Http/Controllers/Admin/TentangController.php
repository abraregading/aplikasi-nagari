<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tentang;
use App\Models\ProfilNagari;

class TentangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $tentang = Tentang::get()->first();
        // dd($tentang);
        return view('admin.tentang.index', compact('tentang', 'profil'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tentang = Tentang::findOrFail($id);
        $tentang->isi_1 = $request->input('isi_1');
        $tentang->isi_2 = $request->input('isi_2');
        $gambar = $request->file('gambar');
        if ($gambar) {
            $gambarPath = $gambar->store('tentang', 'public');
            $tentang->gambar = $gambarPath;
        }   
        $tentang->save();

        return redirect()->route('tentang.index')->with('success', 'Data berhasil diperbarui');
    }

}
