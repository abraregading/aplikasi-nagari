<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplateSurat;
use App\Models\ProfilNagari;

class TemplatesuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $templates = TemplateSurat::orderBy('created_at', 'desc')->get();
        return view('admin.template.index', compact('templates', 'profil'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.template.create', compact('profil'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'isi_template' => 'required|string',
            'tipe' => 'nullable|string|max:50',
            'form_template' => 'nullable|string|max:100',
            'cetak_template' => 'nullable|string|max:100',
        ]);

        TemplateSurat::create([
            'nama_template' => $request->nama_template,
            'deskripsi' => $request->deskripsi,
            'isi_template' => $request->isi_template,
            'tipe' => $request->tipe,
            'is_active' => $request->has('is_active') ? true : false,
            'form_template' => $request->form_template,
            'cetak_template' => $request->cetak_template,
        ]);

        return redirect()->route('template-surat.index')->with('success', 'Template surat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $template = TemplateSurat::findOrFail($id);
        return view('admin.template.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = TemplateSurat::findOrFail($id);
        return view('admin.template.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_template' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'isi_template' => 'required|string',
            'tipe' => 'nullable|string|max:50',
            'form_template' => 'nullable|string|max:100',
            'cetak_template' => 'nullable|string|max:100',
        ]);

        $template = TemplateSurat::findOrFail($id);
        $template->update([
            'nama_template' => $request->nama_template,
            'deskripsi' => $request->deskripsi,
            'isi_template' => $request->isi_template,
            'tipe' => $request->tipe,
            'is_active' => $request->has('is_active') ? true : false,
            'form_template' => $request->form_template,
            'cetak_template' => $request->cetak_template,
        ]);

        return redirect()->route('template-surat.index')->with('success', 'Template surat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $template = TemplateSurat::findOrFail($id);
        $template->delete();

        return redirect()->route('template-surat.index')->with('success', 'Template surat berhasil dihapus.');
    }

    /**
     * Cetak surat keterangan umum (existing feature).
     */
    public function cetakSuratKeteranganUmum(Request $request)
    {
        // Contoh data, bisa diambil dari database atau request
        $data = [
            'nomor_surat' => '400.7.22/55/WN-KA-UG/IV/2026',
            'nama' => 'HILMAN ZUHDI',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '23 Maret 2005',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'status' => 'Belum Kawin',
            'pekerjaan' => 'Pelajar/mahasiswa',
            'nik' => '1312022304050002',
            'alamat' => 'Jl. Torondai Jorong Kuamang Timur Nagari Kuamang Alai Ujung Gading Kecamatan Lembah Melintang Kabupaten Pasaman Barat',
            'keterangan' => 'Miskin',
            'keperluan' => 'persyaratan pengurusan bantuan',
            'tanggal_surat' => now()->format('d F Y'),
            'nama_wali_nagari' => 'MUHAMMAD ABRAR, A.Md',
            'nip_wali_nagari' => '198403302011011003',
        ];

        return view('admin.template.template_surat_keterangan_1', $data);
    }
}
