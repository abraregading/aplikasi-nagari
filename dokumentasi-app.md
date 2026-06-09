# Dokumentasi Aplikasi SIYanDuk
## Sistem Informasi Layanan Administrasi Kependudukan Nagari Kuamangalai

---

## DAFTAR ROLE & FITUR

| No | Role | Deskripsi | Route |
|----|------|-----------|-------|
| 1 | **Admin** | Pengelola seluruh sistem | `/administrator` |
| 2 | **Operator** | Pembuat & proses surat | `/operator` |
| 3 | **Petugas** | Pendataan data penduduk | `/petugas` |
| 4 | **Warga** | Pemohon layanan surat | `/warga` |
| 5 | **Kajor** | Pengelola data tingkat jorong | `/kepala-jorong` |
| 6 | **Public** | Pengunjung website | `/` |

---

## 1. ADMIN

### Akses
```
URL: https://domain.com/administrator
Route Name: admin.home
Middleware: auth + role:admin
```

### Fitur Utama & Detail

#### 1.1 Dashboard (`/administrator`)
| Fitur | Deskripsi |
|-------|-----------|
| Statistik Penduduk | Total, Laki-laki, Perempuan |
| Statistik Keluarga | Total KK |
| Grafik Layanan Surat | Harian (7 hari), Mingguan (4 minggu), Bulanan (6 bulan) |
| Pie Chart Jenis Layanan | Distribusi jenis surat |
| Tabel Surat Terbaru | 5 surat terbaru dengan status |
| Demografi | Progress bar gender ratio |
| Info Sistem | Total user, berita, surat menunggu |

#### 1.2 Manajemen Data Penduduk
| Route | Method | Deskripsi |
|-------|--------|-----------|
| `/data-penduduk` | GET | List semua penduduk |
| `/data-penduduk/create` | GET | Form tambah penduduk |
| `/data-penduduk` | POST | Simpan penduduk baru |
| `/data-penduduk/{id}` | GET | Detail penduduk |
| `/data-penduduk/{id}/edit` | GET | Form edit penduduk |
| `/data-penduduk/{id}` | PUT | Update penduduk |
| `/data-penduduk/{id}` | DELETE | Hapus penduduk |
| `/data-keluarga` | GET | List keluarga |
| `/data-keluarga/create` | GET | Form tambah keluarga |
| `/import-penduduk` | POST | Import Excel |
| `/import-keluarga` | POST | Import Excel |
| `/export-penduduk-csv` | GET | Export CSV |

#### 1.3 Manajemen Surat
| Route | Deskripsi |
|-------|-----------|
| `/jenis-surat` | CRUD jenis surat |
| `/template-surat` | CRUD template surat |
| `/penandatangan` | CRUD penanda tangan |
| `/cetak-surat-keterangan-umum` | Cetak surat keterangan |

#### 1.4 Manajemen Konten
| Route | Deskripsi |
|-------|-----------|
| `/kategori-berita` | CRUD kategori |
| `/daftar-berita` | CRUD berita |
| `/komentar` | Moderasi komentar |
| `/komentar/pending` | Komentar menunggu moderasi |
| `/tentang` | Kelola halaman tentang |

#### 1.5 Manajemen Pengguna
| Route | Deskripsi |
|-------|-----------|
| `/data-user` | CRUD user semua role |
| `/data-user/create` | Tambah user baru |
| `/api-user` | Kelola API token |
| `/admin-petugas-pendataan` | Kelola akun petugas |

#### 1.6 Struktur Organisasi
| Route | Deskripsi |
|-------|-----------|
| `/jabatan` | CRUD jabatan |
| `/perangkat` | CRUD perangkat nagari |

#### 1.7 Layanan & Pelaporan
| Route | Deskripsi |
|-------|-----------|
| `/surat-keterangan` | Kelola surat keterangan |
| `/laporan` | Kelola laporan masyarakat |
| `/laporan/{id}/update-status` | Update status laporan |
| `/download-data` | Download data statistik |

#### 1.8 Bisnis Kos (Admin View)
| Route | Deskripsi |
|-------|-----------|
| `/bisniskos` | View semua bisnis kos |
| `/bisniskos/{id}` | Detail bisnis |
| `/bisniskos/{id}/print` | Print laporan |
| `/bisniskos/{id}` (DELETE) | Hapus bisnis |

#### 1.9 Riwayat Pendataan
| Route | Deskripsi |
|-------|-----------|
| `/admin-riwayat-pendataan` | View semua riwayat |
| `/admin-riwayat-pendataan/petugas/{id}` | Detail per petugas |
| `/admin-riwayat-pendataan/petugas/{id}/print` | Print laporan |

#### 1.10 Profil Admin
| Route | Deskripsi |
|-------|-----------|
| `/profil-admin` | View profil |
| `/profil-admin` (PUT) | Update profil nagari |
| `/profil-admin/password` (PUT) | Ganti password |
| `/profil-admin/profile` (PUT) | Update data diri |

---

## 2. OPERATOR

### Akses
```
URL: https://domain.com/operator
Route Name: operator.home
Middleware: auth + role:operator
```

### Fitur Utama & Detail

#### 2.1 Dashboard (`/operator`)
| Fitur | Deskripsi |
|-------|-----------|
| Statistik | Total penduduk, keluarga |
| Grafik Layanan | Chart pengajuan surat |
| Surat Terbaru | 5 pengajuan terbaru |

#### 2.2 Pembuatan & Proses Surat
| Route | Method | Deskripsi |
|-------|--------|-----------|
| `/buat-surat` | GET | Form buat surat |
| `/buat-surat` | POST | Simpan surat baru |
| `/proses-surat` | GET | List semua surat |
| `/proses-surat/{id}/edit` | GET | Edit surat |
| `/proses-surat/{id}` | GET | Detail surat |
| `/proses-surat/{id}/status` | PUT | Update status |
| `/cetak-surat/{id}` | GET | Cetak/Preview PDF |
| `/riwayat-surat` | GET | Riwayat semua surat |

#### 2.3 Pencarian Data
| Route | Deskripsi |
|-------|-----------|
| `/operator-ceknik` | Cek NIK (API endpoint) |
| `/operator-cekkk` | Cek KK (API endpoint) |
| `/api/cari-penduduk` | Search penduduk |

#### 2.4 Data Penduduk (Operator)
| Route | Deskripsi |
|-------|-----------|
| `/data-keluarga-operator` | CRUD keluarga |
| `/data-penduduk-operator` | CRUD penduduk |
| `/cari-keluarga` | Search keluarga |
| `/cari-kk` | Search KK |

#### 2.5 Profil Operator
| Route | Deskripsi |
|-------|-----------|
| `/operator-profil` | View/Edit profil |
| `/operator-profil/password` | Ganti password |
| `/operator-profil/profile` | Update data diri |

---

## 3. PETUGAS

### Akses
```
URL: https://domain.com/petugas
Route Name: petugas.home
Middleware: auth + role:petugas
```

### Fitur Utama & Detail

#### 3.1 Dashboard (`/petugas`)
| Fitur | Deskripsi |
|-------|-----------|
| Statistik Penduduk | Total, Laki, Perempuan, KK |
| Statistik Pendataan | Total, Baru, Edit |
| Statistik Bisnis | Total, Kos, Kontrakan, Aktif |
| Grafik Pendataan | Harian, Mingguan, Bulanan |
| Riwayat Terbaru | 5 pendataan terakhir |

#### 3.2 Pendataan Penduduk
| Route | Deskripsi |
|-------|-----------|
| `/petugas-pendataan` | List pendataan |
| `/petugas-pendataan/create` | Form pendataan baru |
| `/petugas-pendataan/{id}` | Detail pendataan |
| `/petugas-pendataan/{id}/edit` | Edit pendataan |
| `/petugas-cek-nik` | Validasi NIK |
| `/petugas-cek-kk` | Validasi KK |

#### 3.3 Pendataan Keluarga
| Route | Deskripsi |
|-------|-----------|
| `/petugas-pendataan-keluarga` | List KK |
| `/petugas-pendataan-keluarga/create` | Tambah KK baru |
| `/petugas-pendataan-keluarga/{id}` | Detail KK |
| `/petugas-pendataan-keluarga/{id}/edit` | Edit KK |
| `/petugas-pendataan-keluarga/{id}` (DELETE) | Hapus KK |
| `/petugas-cari-kk` | Search KK |
| `/petugas-riwayat-saya` | Riwayat sendiri |
| `/petugas-semua-riwayat` | Semua riwayat |
| `/petugas-riwayat-detail/{id}` | Detail riwayat |

#### 3.4 Bisnis Kos/Kontrakan
| Route | Deskripsi |
|-------|-----------|
| `/petugas-bisniskos` | List bisnis |
| `/petugas-bisniskos/create` | Tambah bisnis |
| `/petugas-bisniskos/{id}` | Detail bisnis |
| `/petugas-bisniskos/{id}/edit` | Edit bisnis |
| `/petugas-bisniskos/{id}` (DELETE) | Hapus bisnis |
| `/petugas-bisniskos/{id}/penghuni` | List penghuni |
| `/petugas-bisniskos/{id}/penghuni/create` | Tambah penghuni |
| `/petugas-bisniskos/{id}/penghuni/{pid}/edit` | Edit penghuni |
| `/petugas-search-nik` | Search NIK |
| `/petugas-search-penduduk` | Search nama |

#### 3.5 Profil Petugas
| Route | Deskripsi |
|-------|-----------|
| `/petugas-profil` | View/Edit profil |
| `/petugas-profil/password` | Ganti password |
| `/petugas-profil/profile` | Update data diri |

---

## 4. WARGA

### Akses
```
URL: https://domain.com/warga
Route Name: warga.home
Middleware: auth + role:warga
```

### Fitur Utama & Detail

#### 4.1 Dashboard (`/warga`)
| Fitur | Deskripsi |
|-------|-----------|
| Info Pengajuan | Status pengajuan surat |

#### 4.2 Pembuatan Surat
| Route | Deskripsi |
|-------|-----------|
| `/buat-surat-warga` | Ajukan surat baru |
| `/proses-surat-warga` | Lihat status |
| `/riwayat-surat-warga` | Riwayat pengajuan |
| `/cetak-surat-warga/{id}` | Download PDF |

#### 4.3 Alur Layanan Warga
```
1. REGISTRASI
   - Buka /register
   - Input NIK (validasi otomatis)
   - Buat username & password
   - Submit → Akun dibuat

2. LOGIN
   - Buka /login
   - Input username/password
   - Redirect ke dashboard warga

3. AJUKAN SURAT
   - Klik "Buat Surat"
   - Pilih jenis surat
   - Isi data pemohon
   - Submit pengajuan
   - Dapat nomor pengajuan

4. MONITOR STATUS
   - Buka "Proses Surat"
   - Lihat status: Diajukan → Diproses → Selesai/Ditolak

5. AMBIL SURAT
   - Jika status "Selesai"
   - Klik "Cetak" → Download PDF
```

---

## 5. KEPALA JORONG (KAJOR)

### Akses
```
URL: https://domain.com/kepala-jorong
Route Name: kajor.home
Middleware: auth + role:kajor
```

### Fitur Utama & Detail

#### 5.1 Dashboard (`/kepala-jorong`)
| Fitur | Deskripsi |
|-------|-----------|
| Statistik Penduduk | Berdasarkan jorong user |
| Statistik Keluarga | KK di jorong |
| Statistik Bisnis Kos | Total kos, kamar |
| Grafik Data | Chart pendataan |

#### 5.2 Data Keluarga (Jorong)
| Route | Deskripsi |
|-------|-----------|
| `/kepala-jorong/keluarga` | List KK di jorong |
| `/kepala-jorong/keluarga/{id}` | Detail KK & anggota |

#### 5.3 Data Penduduk (Jorong)
| Route | Deskripsi |
|-------|-----------|
| `/kepala-jorong/penduduk` | List penduduk jorong |
| `/kepala-jorong/penduduk/{id}` | Detail penduduk |

#### 5.4 Bisnis Kos (Jorong)
| Route | Deskripsi |
|-------|-----------|
| `/kepala-jorong/bisniskos` | List bisnis di jorong |
| `/kepala-jorong/bisniskos/{id}` | Detail bisnis |
| `/kepala-jorong/bisniskos/{id}/print` | Print laporan |

#### 5.5 Scanner QR
| Route | Deskripsi |
|-------|-----------|
| `/kepala-jorong/scanner` | Scan QR code |
| `/kepala-jorong/qr/verify` | Verifikasi QR |

#### 5.6 Pencarian
| Route | Deskripsi |
|-------|-----------|
| `/kepala-jorong-ceknik` | Cek NIK |
| `/kepala-jorong-cekkk` | Cek KK |

#### 5.7 Profil Kajor
| Route | Deskripsi |
|-------|-----------|
| `/kepala-jorong-profil` | View/Edit profil |
| `/kepala-jorong-profil/password` | Ganti password |
| `/kepala-jorong-profil/profile` | Update data diri |

---

## 6. PUBLIC / GUEST

### Akses
```
URL: https://domain.com/
Middleware: none (public)
```

### Fitur Utama

#### 6.1 Halaman Publik
| Route | Deskripsi |
|-------|-----------|
| `/` | Beranda/Home |
| `/profil` | Profil nagari |
| `/layanan` | Layanan tersedia |
| `/galeri` | Galerie foto |
| `/berita` | List berita |
| `/detail-berita/{slug}` | Detail berita |
| `/pemerintahan` | Struktur pemerintahan |
| `/layanan-kontak` | Form pengaduan |
| `/layanan-umkm` | Data UMKM |
| `/layanan-kesehatan` | Info kesehatan |

#### 6.2 Interaksi
| Route | Method | Deskripsi |
|-------|--------|-----------|
| `/register` | GET/POST | Registrasi warga |
| `/login` | GET/POST | Login |
| `/logout` | POST | Logout |
| `/cek-nik` | POST | Validasi NIK |
| `/detail-berita/{slug}/komentar` | POST | Post komentar |
| `/detail-berita/{slug}/komentar/json` | GET | Get komentar |
| `/layanan-kontak` | POST | Kirim pengaduan |

---

## TABEL PERBANDINGAN FITUR

| Fitur | Admin | Operator | Petugas | Warga | Kajor | Public |
|-------|:-----:|:--------:|:-------:|:-----:|:-----:|:------:|
| Dashboard | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| CRUD Penduduk | ✅ | ✅ | Read | ❌ | Read | ❌ |
| CRUD Keluarga | ✅ | ✅ | ✅ | ❌ | Read | ❌ |
| Buat Surat | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| Proses Surat | ✅ | ✅ | ❌ | Read | ❌ | ❌ |
| Import/Export | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Moderasi Konten | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Manajemen User | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| View Bisnis Kos | ✅ | ❌ | ✅ | ❌ | ✅ | ❌ |
| CRUD Bisnis Kos | ❌ | ❌ | ✅ | ❌ | Read | ❌ |
| Lihat Profil | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Ganti Password | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Akses Website | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ |
| Komentar Berita | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ |

---

## DIAGRAM ALUR SISTEM

```
┌─────────────────────────────────────────────────────────────┐
│                     PUBLIC WEBSITE                          │
│  / → /profil → /layanan → /berita → /pemerintahan → etc    │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                     AUTHENTICATION                          │
│         /login  ───  /register  ───  /logout                │
└─────────────────────────────────────────────────────────────┘
                              │
        ┌──────────┬──────────┼──────────┬──────────┐
        │          │          │          │          │
        ▼          ▼          ▼          ▼          ▼
    ┌───────┐ ┌────────┐ ┌─────────┐ ┌────────┐ ┌────────┐
    │ ADMIN │ │OPERATOR│ │ PETUGAS │ │ WARGA  │ │ KAJOR  │
    └───┬───┘ └───┬────┘ └────┬────┘ └────┬────┘ └───┬───┘
        │         │           │           │          │
        ▼         ▼           ▼           ▼          ▼
    ┌───────┐ ┌────────┐ ┌─────────┐ ┌────────┐ ┌────────┐
    │Full   │ │Surat & │ │Pendataan│ │Buat    │ │View    │
    │Access │ │Data    │ │& Bisnis │ │Surat   │ │Data    │
    │       │ │Penduduk│ │Kos      │ │        │ │Jorong  │
    └───────┘ └────────┘ └─────────┘ └────────┘ └────────┘
```

---

*Generated: 2026-05-18*
*SIYanDuk App - Sistem Informasi Layanan Administrasi Kependudukan Nagari Kuamangalai*