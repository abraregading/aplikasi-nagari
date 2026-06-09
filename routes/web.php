<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\{
    HomeController,
    KategoriberitaController,
    BeritaController,
    CommentController,
    TemplatesuratController,
    DatakeluargaController,
    DatapendudukController,
    DatauserController,
    DownloaddataController,
    ExportdataController,
    ImportdataController,
    JenissuratController,
    PenandatanganController,
    ProfiladminController,
    ProfilnagariController,
    SuratketeranganController,
    JabatanController,
    PerangkatController,
    TentangController,
    LaporanController,
    ApiUserController,
    BisnisKosAdminController,
    PengumumanController,
    StafController,
    PosyanduController
    };
    
use App\Http\Controllers\Operator\{
    HomeoperatorController,
    BuatsuratController,
    DatakeluargaopController,
    DatapendudukopController,
    ProfiloperatorController,
    WargaController as OperatorWargaController,
    PengumumanController as OperatorPengumumanController
    };

use App\Http\Controllers\Kader\{
    HomekaderController,
    SasaranController,
    ProfilkaderController,
};
use App\Http\Controllers\Petugas\{
    HomepetugasController,
    PendataanPendudukController,
    PendataanKeluargaController,
    ProfilpetugasController
    };

use App\Http\Controllers\Site\{
    SiteoperatorController,
    BeritasiteController,
    PemerintahansiteController,
    CommentSiteController,
    LaporansiteController
    };
use App\Http\Controllers\Warga\{
    WargaController,
    BuatsuratwargaController
    };

use App\Http\Controllers\Operator\PengajuanPerubahanController;
use App\Http\Controllers\Operator\BltNagariController;
use App\Http\Controllers\Kajor\{
    KajorController,
    ProfilkajorController,
    MeninggalController
    };

use App\Http\Controllers\AuthController;

// =====================================================
// AUTH ROUTES (Publik - tidak perlu login)
// =====================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::post('/cek-nik', [AuthController::class, 'cekNik'])->name('cek.nik');
    Route::get('/register/pending', [AuthController::class, 'pending'])->name('register.pending');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// =====================================================
// SITE ROUTES (Publik - Website Nagari)
// =====================================================
Route::get('/', [SiteoperatorController::class, 'index'])->name('site.home');
Route::get('/profil', [SiteoperatorController::class, 'profil'])->name('site.profil');
Route::get('/layanan', [SiteoperatorController::class, 'layanan'])->name('site.layanan');
Route::get('/galeri', [SiteoperatorController::class, 'galeri'])->name('site.galeri');
Route::get('/layanan-kontak', [SiteoperatorController::class, 'kontak'])->name('site.kontak');
Route::post('/layanan-kontak', [LaporansiteController::class, 'store'])->name('site.laporan.store');
Route::get('/layanan-umkm', [SiteoperatorController::class, 'umkm'])->name('site.umkm');
Route::get('/layanan-kesehatan', [SiteoperatorController::class, 'kesehatan'])->name('site.kesehatan');
Route::get('/berita', [BeritasiteController::class, 'index'])->name('site.berita');
Route::get('/list-berita', [BeritasiteController::class, 'berita'])->name('list.berita');
Route::get('/detail-berita/{slug}', [BeritasiteController::class, 'show'])->name('site.berita.show');
Route::post('/detail-berita/{slug}/komentar', [CommentSiteController::class, 'store'])->name('site.komentar.store');
Route::get('/detail-berita/{slug}/komentar/json', [CommentSiteController::class, 'getComments'])->name('site.komentar.json');
Route::get('/pemerintahan', [PemerintahansiteController::class, 'index'])->name('site.pemerintahan');
Route::get('/statistik-penduduk', [SiteoperatorController::class, 'statistik'])->name('site.statistik');

// =====================================================
// KADER ROUTES (Harus login + role kader)
// =====================================================
Route::middleware(['auth', 'role:kader'])->prefix('kader')->name('kader.')->group(function () {
    Route::get('/dashboard', [HomekaderController::class, 'index'])->name('home');

    // AJAX routes harus SEBELUM resource agar tidak tertimpa route show {sasaran}
    Route::get('/sasaran/cari-kk', [SasaranController::class, 'cariKk'])->name('sasaran.cariKk');
    Route::get('/sasaran/anggota-kk', [SasaranController::class, 'anggotaByKk'])->name('sasaran.anggotaByKk');
    Route::resource('sasaran', SasaranController::class);

    // Profil Saya
    Route::get('/profil', [ProfilkaderController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfilkaderController::class, 'updateProfile'])->name('profil.updateProfile');
    Route::put('/profil/password', [ProfilkaderController::class, 'updatePassword'])->name('profil.updatePassword');
});


// =====================================================
// ADMIN ROUTES (Harus login + role admin)
// =====================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/administrator', [HomeController::class, 'index'])->name('admin.home');
    Route::resource('jenis-surat', JenissuratController::class);
    Route::resource('template-surat', TemplatesuratController::class);
    Route::resource('data-keluarga', DatakeluargaController::class);
    Route::resource('data-penduduk', DatapendudukController::class);
    Route::get('cari-kk', [DatapendudukController::class, 'cariKk'])->name('data-penduduk.carikk');
    Route::resource('kategori-berita', KategoriberitaController::class);
    Route::resource('import-data', ImportdataController::class);
    Route::resource('download-data', DownloaddataController::class);
    Route::resource('daftar-berita', BeritaController::class);
    Route::resource('profil-nagari', ProfilnagariController::class);
    Route::resource('data-user', DatauserController::class);
    Route::resource('posyandu', PosyanduController::class);
    Route::get('/profil-admin', [ProfiladminController::class, 'index'])->name('profil-admin.index');
    Route::put('/profil-admin', [ProfiladminController::class, 'update'])->name('profil-admin.update');
    Route::put('/profil-admin/password', [ProfiladminController::class, 'updatePassword'])->name('profil-admin.updatePassword');
    Route::put('/profil-admin/profile', [ProfiladminController::class, 'updateProfile'])->name('profil-admin.updateProfile');
    Route::resource('penandatangan', PenandatanganController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('perangkat', PerangkatController::class);
    Route::resource('staf', StafController::class);
    Route::resource('surat-keterangan', SuratketeranganController::class);
    Route::resource('tentang', TentangController::class);
    Route::resource('laporan', LaporanController::class)->except(['update']);
    Route::post('/laporan/{id}/update-status', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
    Route::post('/laporan/bulk-action', [LaporanController::class, 'bulkAction'])->name('laporan.bulkAction');

    Route::resource('api-user', \App\Http\Controllers\Admin\ApiUserController::class);

    Route::post('/import-keluarga', [ImportdataController::class, 'importKeluarga'])->name('import.keluarga');
    Route::post('/import-penduduk', [ImportdataController::class, 'importPenduduk'])->name('import.penduduk');
    Route::post('/import-sql', [ImportdataController::class, 'importSql'])->name('import.sql');
    Route::get('/export-penduduk-csv', [ImportdataController::class, 'exportPendudukCsv'])->name('export.penduduk.csv');

    Route::get('/export-data', [ExportdataController::class, 'index'])->name('export-data.index');
    Route::post('/export-data', [ExportdataController::class, 'export'])->name('export-data.export');

    Route::post('/komentar/bulk-action', [CommentController::class, 'bulkAction'])->name('komentar.bulkAction');
    Route::get('/komentar/pending', [CommentController::class, 'pending'])->name('komentar.pending');
    Route::get('/komentar/{komentar}/action/{action}', [CommentController::class, 'action'])->name('komentar.action');
    Route::resource('komentar', CommentController::class)->parameters(['komentar' => 'komentar']);

    // Route untuk cetak surat keterangan umum
    Route::get('cetak-surat-keterangan-umum', [TemplatesuratController::class, 'cetakSuratKeteranganUmum'])->name('cetak.surat.keterangan.umum');

    // Bisnis Kos/Kontrakan Routes (Admin)
    Route::get('bisniskos', [BisnisKosAdminController::class, 'index'])->name('admin.bisniskos.index');
    Route::get('bisniskos/{id}', [BisnisKosAdminController::class, 'show'])->name('admin.bisniskos.show');
    Route::get('bisniskos/{id}/print', [BisnisKosAdminController::class, 'print'])->name('admin.bisniskos.print');
    Route::delete('bisniskos/{id}', [BisnisKosAdminController::class, 'destroy'])->name('admin.bisniskos.destroy');

    // Riwayat Pendataan Keluarga Routes
    Route::get('/riwayat-pendataan-keluarga', [\App\Http\Controllers\Admin\RiwayatPendataanController::class, 'index'])->name('admin.riwayatpendataan.index');
    Route::get('/riwayat-pendataan-keluarga/petugas/{id}', [\App\Http\Controllers\Admin\RiwayatPendataanController::class, 'detailPetugas'])->name('admin.riwayatpendataan.detail');
    Route::get('/riwayat-pendataan-keluarga/petugas/{id}/print', [\App\Http\Controllers\Admin\RiwayatPendataanController::class, 'printDetailPetugas'])->name('admin.riwayatpendataan.print');
    Route::get('/riwayat-pendataan-keluarga/petugas/{petugasId}/keluarga/{keluargaId}/print', [\App\Http\Controllers\Admin\RiwayatPendataanController::class, 'printKeluarga'])->name('admin.riwayatpendataan.printKeluarga');

    // Petugas Pendataan Routes (Admin)
    Route::resource('admin-petugas-pendataan', \App\Http\Controllers\Admin\PetugasPendataanController::class)->parameters(['admin-petugas-pendataan' => 'id'])->names('admin.petugaspendataan');
    Route::post('/admin-petugas-pendataan/{id}/status', [\App\Http\Controllers\Admin\PetugasPendataanController::class, 'updateStatus'])->name('admin.petugaspendataan.updateStatus');

    // Dokumentasi
    Route::get('/dokumentasi', [\App\Http\Controllers\Admin\DokumentasiController::class, 'index'])->name('admin.dokumentasi.index');

    // Laporan Meninggal
    Route::get('/laporan-meninggal', [\App\Http\Controllers\Admin\LaporanMeninggalController::class, 'index'])->name('admin.laporan-meninggal.index');
    Route::get('/laporan-meninggal/cetak', [\App\Http\Controllers\Admin\LaporanMeninggalController::class, 'cetak'])->name('admin.laporan-meninggal.cetak');

    // Pengumuman
    Route::resource('pengumuman', PengumumanController::class);
    Route::get('cari-warga', [PengumumanController::class, 'cariWarga'])->name('pengumuman.cari-warga');
});


// =====================================================
// OPERATOR ROUTES (Harus login + role operator)
// =====================================================
Route::middleware(['auth', 'role:operator'])->group(function () {
    Route::get('/operator', [HomeoperatorController::class, 'index'])->name('operator.home');
    Route::get('/operator/ceknik', [HomeoperatorController::class, 'ceknik'])->name('operator.ceknik');
    Route::get('/operator/cekkk', [HomeoperatorController::class, 'cekkk'])->name('operator.cekkk');
    
    // Profil Saya
    Route::get('/operator-profil', [ProfiloperatorController::class, 'index'])->name('operator.profil.index');
    Route::put('/operator-profil', [ProfiloperatorController::class, 'update'])->name('operator.profil.update');
    Route::put('/operator-profil/password', [ProfiloperatorController::class, 'updatePassword'])->name('operator.profil.updatePassword');
    Route::put('/operator-profil/profile', [ProfiloperatorController::class, 'updateProfile'])->name('operator.profil.updateProfile');
    Route::resource('buat-surat', BuatsuratController::class)->names('buatsurat');
    Route::get('proses-surat', [BuatsuratController::class, 'proses'])->name('buatsurat.proses');
    Route::put('proses-surat/{id}/status', [BuatsuratController::class, 'updateStatus'])->name('buatsurat.updateStatus');
    Route::get('cetak-surat/{id}', [BuatsuratController::class, 'cetak'])->name('buatsurat.cetak');
    Route::get('riwayat-surat', [BuatsuratController::class, 'riwayat'])->name('buatsurat.riwayat');
    Route::get('api/cari-penduduk', [BuatsuratController::class, 'cariPenduduk'])->name('api.cari-penduduk');

    Route::resource('data-keluarga-operator', DatakeluargaopController::class);
    Route::resource('data-penduduk-operator', DatapendudukopController::class);
    Route::get('cari-keluarga', [DatapendudukopController::class, 'cariKeluarga'])->name('data-penduduk-operator.cariKeluarga');
    Route::get('cari-kk', [DatapendudukopController::class, 'cariKk'])->name('data-penduduk-operator.cariKk');

    // Manajemen Warga (approve/reject)
    Route::get('/operator/warga', [OperatorWargaController::class, 'index'])->name('operator.warga.index');
    Route::get('/operator/warga/{id}', [OperatorWargaController::class, 'show'])->name('operator.warga.show');
    Route::post('/operator/warga/{id}/approve', [OperatorWargaController::class, 'approve'])->name('operator.warga.approve');
    Route::post('/operator/warga/{id}/reject', [OperatorWargaController::class, 'reject'])->name('operator.warga.reject');

    // Laporan Meninggal
    Route::get('/operator/laporan-meninggal', [\App\Http\Controllers\Operator\LaporanMeninggalController::class, 'index'])->name('operator.laporan-meninggal.index');
    Route::get('/operator/laporan-meninggal/cetak', [\App\Http\Controllers\Operator\LaporanMeninggalController::class, 'cetak'])->name('operator.laporan-meninggal.cetak');

    // Pengajuan Perubahan Data Penduduk
    Route::get('/operator/pengajuan-perubahan', [PengajuanPerubahanController::class, 'index'])->name('operator.pengajuan-perubahan.index');
    Route::get('/operator/pengajuan-perubahan/{id}', [PengajuanPerubahanController::class, 'show'])->name('operator.pengajuan-perubahan.show');
    Route::post('/operator/pengajuan-perubahan/{id}/approve', [PengajuanPerubahanController::class, 'approve'])->name('operator.pengajuan-perubahan.approve');
    Route::post('/operator/pengajuan-perubahan/{id}/reject', [PengajuanPerubahanController::class, 'reject'])->name('operator.pengajuan-perubahan.reject');

    // Pengumuman
    Route::get('/operator/pengumuman', [OperatorPengumumanController::class, 'index'])->name('operator.pengumuman.index');
    Route::get('/operator/pengumuman/create', [OperatorPengumumanController::class, 'create'])->name('operator.pengumuman.create');
    Route::post('/operator/pengumuman', [OperatorPengumumanController::class, 'store'])->name('operator.pengumuman.store');
    Route::get('/operator/pengumuman/{id}/edit', [OperatorPengumumanController::class, 'edit'])->name('operator.pengumuman.edit');
    Route::put('/operator/pengumuman/{id}', [OperatorPengumumanController::class, 'update'])->name('operator.pengumuman.update');
    Route::delete('/operator/pengumuman/{id}', [OperatorPengumumanController::class, 'destroy'])->name('operator.pengumuman.destroy');
    Route::get('/operator/cari-warga', [OperatorPengumumanController::class, 'cariWarga'])->name('operator.pengumuman.cari-warga');

    // BLT Nagari (static routes BEFORE parameterized routes)
    Route::get('/operator/blt-nagari', [BltNagariController::class, 'index'])->name('operator.blt-nagari.index');
    Route::get('/operator/blt-nagari/create', [BltNagariController::class, 'create'])->name('operator.blt-nagari.create');
    Route::post('/operator/blt-nagari', [BltNagariController::class, 'store'])->name('operator.blt-nagari.store');
    Route::get('/operator/blt-nagari/cetak', [BltNagariController::class, 'cetak'])->name('operator.blt-nagari.cetak');
    Route::get('/operator/blt-nagari/get-penduduk', [BltNagariController::class, 'getPenduduk'])->name('operator.blt-nagari.getPenduduk');
    Route::get('/operator/blt-nagari/{id}/edit', [BltNagariController::class, 'edit'])->name('operator.blt-nagari.edit');
    Route::put('/operator/blt-nagari/{id}', [BltNagariController::class, 'update'])->name('operator.blt-nagari.update');
    Route::delete('/operator/blt-nagari/{id}', [BltNagariController::class, 'destroy'])->name('operator.blt-nagari.destroy');
});

// =====================================================
 // PETUGAS ROUTES (Harus login + role petugas)
 // =====================================================
Route::middleware(['auth', 'role:petugas'])->group(function () {
      Route::get('/petugas', [HomepetugasController::class, 'index'])->name('petugas.home');
      Route::get('/petugas-ceknik', [HomepetugasController::class, 'ceknik'])->name('petugas.ceknik');
      Route::get('/petugas-cekkk', [HomepetugasController::class, 'cekkk'])->name('petugas.cekkk');
      
      // Profil Nagari & Profil Saya
      Route::get('/petugas-profil', [ProfilpetugasController::class, 'index'])->name('petugas.profil.index');
      Route::put('/petugas-profil', [ProfilpetugasController::class, 'update'])->name('petugas.profil.update');
      Route::put('/petugas-profil/password', [ProfilpetugasController::class, 'updatePassword'])->name('petugas.profil.updatePassword');
      Route::put('/petugas-profil/profile', [ProfilpetugasController::class, 'updateProfile'])->name('petugas.profil.updateProfile');

     
     // Pendataan Penduduk Routes
     Route::resource('petugas-pendataan', PendataanPendudukController::class)->names('petugas.pendataan');
     Route::get('/petugas-cek-nik', [PendataanPendudukController::class, 'cekNik'])->name('petugas.pendataan.ceknik');
     Route::get('/petugas-cek-kk', [PendataanPendudukController::class, 'cekKk'])->name('petugas.pendataan.cekkk');

// Pendataan Kartu Keluarga Routes
      Route::resource('petugas-pendataan-keluarga', PendataanKeluargaController::class)->names('petugas.pendataankeluarga');
      Route::get('/petugas-cari-kk', [PendataanKeluargaController::class, 'cariKk'])->name('petugas.pendataankeluarga.carikk');
      Route::get('/petugas-riwayat-saya', [PendataanKeluargaController::class, 'riwayatSaya'])->name('petugas.pendataankeluarga.riwayatsaya');
      Route::get('/petugas-semua-riwayat', [PendataanKeluargaController::class, 'riwayat'])->name('petugas.pendataankeluarga.riwayat');
      Route::get('/petugas-riwayat-detail/{id}', [PendataanKeluargaController::class, 'riwayatDetail'])->name('petugas.pendataankeluarga.riwayatshow');
      Route::post('/petugas-pendataan-keluarga/sync-all', [PendataanKeluargaController::class, 'syncAll'])->name('petugas.pendataankeluarga.syncAll');

      // Bisnis Kos/Kontrakan Routes
      Route::resource('petugas-bisniskos', \App\Http\Controllers\Petugas\BisnisKosController::class)->parameters(['petugas-bisniskos' => 'id'])->names('petugas.bisniskos');
      Route::get('/petugas-bisniskos/{id}/penghuni', [\App\Http\Controllers\Petugas\BisnisKosController::class, 'penghuniIndex'])->name('petugas.bisniskos.penghuni.index');
      Route::get('/petugas-bisniskos/{id}/penghuni/create', [\App\Http\Controllers\Petugas\BisnisKosController::class, 'penghuniCreate'])->name('petugas.bisniskos.penghuni.create');
      Route::post('/petugas-bisniskos/{id}/penghuni', [\App\Http\Controllers\Petugas\BisnisKosController::class, 'penghuniStore'])->name('petugas.bisniskos.penghuni.store');
      Route::get('/petugas-bisniskos/{bisnisId}/penghuni/{penghuniId}/edit', [\App\Http\Controllers\Petugas\BisnisKosController::class, 'penghuniEdit'])->name('petugas.bisniskos.penghuni.edit');
      Route::put('/petugas-bisniskos/{bisnisId}/penghuni/{penghuniId}', [\App\Http\Controllers\Petugas\BisnisKosController::class, 'penghuniUpdate'])->name('petugas.bisniskos.penghuni.update');
      Route::delete('/petugas-bisniskos/{bisnisId}/penghuni/{penghuniId}', [\App\Http\Controllers\Petugas\BisnisKosController::class, 'penghuniDestroy'])->name('petugas.bisniskos.penghuni.destroy');
      Route::get('/petugas-search-nik', [\App\Http\Controllers\Petugas\BisnisKosController::class, 'searchNik'])->name('petugas.bisniskos.searchnik');
      Route::get('/petugas-search-penduduk', [\App\Http\Controllers\Petugas\BisnisKosController::class, 'searchNikByName'])->name('petugas.bisniskos.searchpenduduk');
  });


 // =====================================================
// WARGA ROUTES (Harus login + role warga)
// =====================================================
Route::middleware(['auth', 'role:warga'])->group(function () {
    Route::get('/warga', [WargaController::class, 'index'])->name('warga.home');
    Route::get('/warga/profil', [WargaController::class, 'profil'])->name('warga.profil');
    Route::put('/warga/profil', [WargaController::class, 'updateProfil'])->name('warga.profil.update');
    Route::put('/warga/profil/password', [WargaController::class, 'updatePassword'])->name('warga.profil.updatePassword');
    Route::get('/warga/ubah-penduduk', [WargaController::class, 'ubahPenduduk'])->name('warga.ubah-penduduk');
    Route::post('/warga/ubah-penduduk', [WargaController::class, 'simpanUbahPenduduk'])->name('warga.ubah-penduduk.store');

    Route::resource('buat-surat-warga', BuatsuratwargaController::class)->names('buatsuratwarga');
    Route::get('proses-surat-warga', [BuatsuratwargaController::class, 'proses'])->name('buatsuratwarga.proses');
    Route::get('cetak-surat-warga/{id}', [BuatsuratwargaController::class, 'cetak'])->name('buatsuratwarga.cetak');
    Route::get('riwayat-surat-warga', [BuatsuratwargaController::class, 'riwayat'])->name('buatsuratwarga.riwayat');
    Route::put('proses-surat-warga/{id}/status', [BuatsuratwargaController::class, 'updateStatus'])->name('buatsuratwarga.updateStatus');
    Route::get('/warga/cari-penduduk', [BuatsuratwargaController::class, 'cariPenduduk'])->name('buatsuratwarga.cari-penduduk');
});


// =====================================================
 // KEPALA JORONG ROUTES (Harus login + role kajor)
 // =====================================================
Route::middleware(['auth', 'role:kajor'])->group(function () {
      Route::get('/kepala-jorong', [KajorController::class, 'index'])->name('kajor.home');
      Route::get('/kepala-jorong-ceknik', [KajorController::class, 'ceknik'])->name('kajor.ceknik');
      Route::get('/kepala-jorong-cekkk', [KajorController::class, 'cekkk'])->name('kajor.cekkk');
      
      // Profil Saya
      Route::get('/kepala-jorong-profil', [ProfilkajorController::class, 'index'])->name('kajor.profil.index');
      Route::put('/kepala-jorong-profil', [ProfilkajorController::class, 'update'])->name('kajor.profil.update');
      Route::put('/kepala-jorong-profil/password', [ProfilkajorController::class, 'updatePassword'])->name('kajor.profil.updatePassword');
      Route::put('/kepala-jorong-profil/profile', [ProfilkajorController::class, 'updateProfile'])->name('kajor.profil.updateProfile');

       // Data Keluarga
      Route::get('/kepala-jorong/keluarga', [KajorController::class, 'keluarga'])->name('kajor.keluarga.index');
      Route::get('/kepala-jorong/keluarga/create', [KajorController::class, 'keluargaCreate'])->name('kajor.keluarga.create');
      Route::post('/kepala-jorong/keluarga', [KajorController::class, 'keluargaStore'])->name('kajor.keluarga.store');
      Route::get('/kepala-jorong/keluarga/{id}/edit', [KajorController::class, 'keluargaEdit'])->name('kajor.keluarga.edit');
       Route::post('/kepala-jorong/keluarga/sync-jumlah', [KajorController::class, 'syncJumlahAnggota'])->name('kajor.keluarga.sync');
       Route::put('/kepala-jorong/keluarga/{id}', [KajorController::class, 'keluargaUpdate'])->name('kajor.keluarga.update');
       Route::get('/kepala-jorong/keluarga/{id}', [KajorController::class, 'keluargaShow'])->name('kajor.keluarga.show');
       
       // Data Penduduk
      Route::get('/kepala-jorong/penduduk', [KajorController::class, 'penduduk'])->name('kajor.penduduk.index');
      Route::get('/kepala-jorong/penduduk/{id}/edit', [KajorController::class, 'pendudukEdit'])->name('kajor.penduduk.edit');
      Route::put('/kepala-jorong/penduduk/{id}', [KajorController::class, 'pendudukUpdate'])->name('kajor.penduduk.update');
      Route::get('/kepala-jorong/penduduk/{id}', [KajorController::class, 'pendudukShow'])->name('kajor.penduduk.show');

      // Tambah Anggota (spesifik dari halaman detail keluarga)
      Route::get('/kepala-jorong/keluarga/{no_kk}/anggota/create', [KajorController::class, 'pendudukCreate'])->name('kajor.penduduk.create');
      Route::post('/kepala-jorong/penduduk', [KajorController::class, 'pendudukStore'])->name('kajor.penduduk.store');
      
      // Data Usaha Kos/Kontrakan
      Route::get('/kepala-jorong/bisniskos', [KajorController::class, 'bisnisKos'])->name('kajor.bisniskos.index');
      Route::get('/kepala-jorong/bisniskos/{id}', [KajorController::class, 'bisnisKosShow'])->name('kajor.bisniskos.show');
      Route::get('/kepala-jorong/bisniskos/{id}/print', [KajorController::class, 'bisnisKosPrint'])->name('kajor.bisniskos.print');
      
       // Scanner QR
       Route::get('/kepala-jorong/scanner', [KajorController::class, 'scanner'])->name('kajor.scanner');
       Route::post('/kepala-jorong/qr/verify', [KajorController::class, 'verifyQr'])->name('kajor.qr.verify');

       // Data Meninggal CRUD
       Route::get('/kepala-jorong/meninggal/get-penduduk', [MeninggalController::class, 'getPendudukByNik'])->name('kajor.meninggal.getPenduduk');
       Route::get('/kepala-jorong/meninggal', [MeninggalController::class, 'index'])->name('kajor.meninggal.index');
       Route::get('/kepala-jorong/meninggal/create', [MeninggalController::class, 'create'])->name('kajor.meninggal.create');
       Route::post('/kepala-jorong/meninggal', [MeninggalController::class, 'store'])->name('kajor.meninggal.store');
       Route::get('/kepala-jorong/meninggal/{id}', [MeninggalController::class, 'show'])->name('kajor.meninggal.show');
       Route::get('/kepala-jorong/meninggal/{id}/edit', [MeninggalController::class, 'edit'])->name('kajor.meninggal.edit');
       Route::put('/kepala-jorong/meninggal/{id}', [MeninggalController::class, 'update'])->name('kajor.meninggal.update');
       Route::delete('/kepala-jorong/meninggal/{id}', [MeninggalController::class, 'destroy'])->name('kajor.meninggal.destroy');

       // Laporan Meninggal
       Route::get('/kepala-jorong/laporan-meninggal', [MeninggalController::class, 'laporanIndex'])->name('kajor.laporan-meninggal.index');
       Route::get('/kepala-jorong/laporan-meninggal/cetak', [MeninggalController::class, 'laporanCetak'])->name('kajor.laporan-meninggal.cetak');

       // AJAX
       Route::get('/kepala-jorong/cari-kk', [KajorController::class, 'cariKk'])->name('kajor.cariKk');
  });
