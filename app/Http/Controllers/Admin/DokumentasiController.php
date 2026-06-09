<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DokumentasiController extends Controller
{
    public function index()
    {
        $data = $this->getDokumentasiData();
        return view('admin.dokumentasi.index', compact('data'));
    }

    private function getDokumentasiData()
    {
        return [
            'title' => 'Dokumentasi Aplikasi SIYanDuk',
            'subtitle' => 'Sistem Informasi Layanan Administrasi Kependudukan Nagari Kuamangalai',
            'generated' => now()->format('d-m-Y H:i:s'),
            'roles' => [
                [
                    'name' => 'Admin',
                    'slug' => 'admin',
                    'route' => '/administrator',
                    'middleware' => 'auth + role:admin',
                    'deskripsi' => 'Pengelola seluruh sistem dengan akses penuh ke semua fitur.',
                    'fitur' => [
                        ['nama' => 'Dashboard', 'deskripsi' => 'Statistik lengkap, grafik, surat terbaru, demografi'],
                        ['nama' => 'Manajemen Data Penduduk', 'deskripsi' => 'CRUD penduduk, keluarga, import/export data'],
                        ['nama' => 'Manajemen Surat', 'deskripsi' => 'CRUD jenis, template, penanda tangan surat'],
                        ['nama' => 'Manajemen Konten', 'deskripsi' => 'CRUD berita, kategori, moderasi komentar'],
                        ['nama' => 'Manajemen Pengguna', 'deskripsi' => 'CRUD user, API user, akun petugas'],
                        ['nama' => 'Struktur Organisasi', 'deskripsi' => 'CRUD jabatan dan perangkat nagari'],
                        ['nama' => 'Layanan & Pelaporan', 'deskripsi' => 'Kelola laporan masyarakat, download data'],
                        ['nama' => 'Bisnis Kos', 'deskripsi' => 'View semua bisnis kos di nagari'],
                        ['nama' => 'Riwayat Pendataan', 'deskripsi' => 'Lihat riwayat pendataan per petugas'],
                        ['nama' => 'Profil', 'deskripsi' => 'Edit profil dan password'],
                    ]
                ],
                [
                    'name' => 'Operator',
                    'slug' => 'operator',
                    'route' => '/operator',
                    'middleware' => 'auth + role:operator',
                    'deskripsi' => 'Petugas yang membuat dan memproses surat-surat keterangan.',
                    'fitur' => [
                        ['nama' => 'Dashboard', 'deskripsi' => 'Statistik, grafik layanan, surat terbaru'],
                        ['nama' => 'Pembuatan Surat', 'deskripsi' => 'Buat, edit, proses surat baru'],
                        ['nama' => 'Proses Surat', 'deskripsi' => 'Update status, cetak PDF'],
                        ['nama' => 'Riwayat Surat', 'deskripsi' => 'Lihat semua riwayat surat'],
                        ['nama' => 'Data Penduduk', 'deskripsi' => 'CRUD penduduk dan keluarga'],
                        ['nama' => 'Pencarian', 'deskripsi' => 'Cek NIK dan KK'],
                        ['nama' => 'Profil', 'deskripsi' => 'Edit profil dan password'],
                    ]
                ],
                [
                    'name' => 'Petugas',
                    'slug' => 'petugas',
                    'route' => '/petugas',
                    'middleware' => 'auth + role:petugas',
                    'deskripsi' => 'Petugas lapangan yang melakukan pendataan data penduduk dan keluarga.',
                    'fitur' => [
                        ['nama' => 'Dashboard', 'deskripsi' => 'Statistik pendataan, grafik, riwayat terbaru'],
                        ['nama' => 'Pendataan Penduduk', 'deskripsi' => 'Input data penduduk baru dengan validasi NIK'],
                        ['nama' => 'Pendataan Keluarga', 'deskripsi' => 'Input data KK dan anggota keluarga'],
                        ['nama' => 'Bisnis Kos/Kontrakan', 'deskripsi' => 'CRUD bisnis dan penghuni kos'],
                        ['nama' => 'Riwayat', 'deskripsi' => 'Riwayat pendataan sendiri dan semua petugas'],
                        ['nama' => 'Pencarian', 'deskripsi' => 'Cek NIK dan KK'],
                        ['nama' => 'Profil', 'deskripsi' => 'Edit profil dan password'],
                    ]
                ],
                [
                    'name' => 'Warga',
                    'slug' => 'warga',
                    'route' => '/warga',
                    'middleware' => 'auth + role:warga',
                    'deskripsi' => 'Masyarakat nagari yang mengajukan permohonan layanan surat.',
                    'fitur' => [
                        ['nama' => 'Dashboard', 'deskripsi' => 'Informasi pengajuan surat'],
                        ['nama' => 'Ajukan Surat', 'deskripsi' => 'Buat pengajuan surat baru'],
                        ['nama' => 'Proses Surat', 'deskripsi' => 'Monitor status pengajuan'],
                        ['nama' => 'Riwayat', 'deskripsi' => 'Lihat semua riwayat pengajuan'],
                        ['nama' => 'Cetak', 'deskripsi' => 'Download PDF surat yang sudah selesai'],
                    ]
                ],
                [
                    'name' => 'Kepala Jorong (Kajor)',
                    'slug' => 'kajor',
                    'route' => '/kepala-jorong',
                    'middleware' => 'auth + role:kajor',
                    'deskripsi' => 'Pemimpin jorong yang mengelola dan melihat data di tingkat jorong.',
                    'fitur' => [
                        ['nama' => 'Dashboard', 'deskripsi' => 'Statistik berdasarkan jorong, grafik data'],
                        ['nama' => 'Data Keluarga', 'deskripsi' => 'View semua KK di jorong'],
                        ['nama' => 'Data Penduduk', 'deskripsi' => 'View semua penduduk di jorong'],
                        ['nama' => 'Bisnis Kos', 'deskripsi' => 'View usaha kos di jorong'],
                        ['nama' => 'Scanner QR', 'deskripsi' => 'Scan dan verifikasi QR code'],
                        ['nama' => 'Pencarian', 'deskripsi' => 'Cek NIK dan KK'],
                        ['nama' => 'Profil', 'deskripsi' => 'Edit profil dan password'],
                    ]
                ],
                [
                    'name' => 'Public/Guest',
                    'slug' => 'public',
                    'route' => '/',
                    'middleware' => 'none (public)',
                    'deskripsi' => 'Pengunjung website yang dapat mengakses informasi publik.',
                    'fitur' => [
                        ['nama' => 'Beranda', 'deskripsi' => 'Halaman utama dengan info nagari'],
                        ['nama' => 'Profil', 'deskripsi' => 'Profil nagari'],
                        ['nama' => 'Layanan', 'deskripsi' => 'Informasi layanan tersedia'],
                        ['nama' => 'Galeri', 'deskripsi' => 'Galerie foto kegiatan'],
                        ['nama' => 'Berita', 'deskripsi' => 'Artikel dan informasi terkini'],
                        ['nama' => 'Pemerintahan', 'deskripsi' => 'Struktur pemerintahan nagari'],
                        ['nama' => 'Kontak/Laporan', 'deskripsi' => 'Form pengaduan masyarakat'],
                        ['nama' => 'UMKM', 'deskripsi' => 'Data pelaku usaha'],
                        ['nama' => 'Kesehatan', 'deskripsi' => 'Informasi kesehatan'],
                        ['nama' => 'Komentar', 'deskripsi' => 'Komentari berita (login/registrasi)'],
                    ]
                ],
            ],
        ];
    }
}