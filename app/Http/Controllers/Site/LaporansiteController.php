<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LaporansiteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'kategori' => 'required|string|max:100',
            'isi_laporan' => 'required|string',
        ]);

        Laporan::create($validated);

        Session::flash('success', 'Laporan Anda berhasil dikirim. Terima kasih atas partisipasi Anda.');
        return redirect()->back();
    }
}