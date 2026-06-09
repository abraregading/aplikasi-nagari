<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuratKeteranganController extends Controller
{
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
