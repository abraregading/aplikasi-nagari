# SiYanDuk App — Development Log

## Session 1: Warga Registration, Camera, & Permissions

### Files Changed
| File | Perubahan |
|---|---|
| `app/Http/Middleware/SecurityHeadersMiddleware.php` | `camera=()` → `camera=(self)` |
| `app/Http/Controllers/AuthController.php` | Fallback `orWhere('nik')` di `register()` & `cekNik()` untuk data penduduk lama dengan NULL `nik_hash` |
| `app/Http/Controllers/Operator/WargaController.php` | Fallback `nik` di `show()` jika `nik_hash` null |
| `app/Models/User.php` | Tambah `'status'`, `'photo'` ke `$fillable` |
| `resources/views/auth/register.blade.php` | Error banner selalu muncul, step2 auto-show jika ada error, NIK/email retain old value |

### Root Cause — Console Error Kamera
`Permissions-Policy: camera=()` di `SecurityHeadersMiddleware` memblokir akses kamera untuk semua halaman. Diubah jadi `camera=(self)`.

### Root Cause — Register Gagal Tanpa Pesan
1. `status` & `photo` tidak ada di `$fillable` User model → mass assignment protection hapus field tersebut
2. Step2 (`display:none`) menyembunyikan pesan error validasi setelah redirect
3. NIK & username tidak terisi ulang setelah error

---

## Session 2: Warga Role Features

### Routes Added

#### Warga Routes (auth + role:warga)
| Method | URI | Name |
|---|---|---|
| GET | `/warga/profil` | `warga.profil` |
| PUT | `/warga/profil` | `warga.profil.update` |
| PUT | `/warga/profil/password` | `warga.profil.updatePassword` |
| GET | `/warga/ubah-penduduk` | `warga.ubah-penduduk` |
| POST | `/warga/ubah-penduduk` | `warga.ubah-penduduk.store` |
| GET | `/warga/cari-penduduk` | `buatsuratwarga.cari-penduduk` |

#### Operator Routes (auth + role:operator)
| Method | URI | Name |
|---|---|---|
| GET | `/operator/pengajuan-perubahan` | `operator.pengajuan-perubahan.index` |
| GET | `/operator/pengajuan-perubahan/{id}` | `operator.pengajuan-perubahan.show` |
| POST | `/operator/pengajuan-perubahan/{id}/approve` | `operator.pengajuan-perubahan.approve` |
| POST | `/operator/pengajuan-perubahan/{id}/reject` | `operator.pengajuan-perubahan.reject` |

### New Files Created
| File | Kegunaan |
|---|---|
| `database/migrations/2026_05_27_000002_create_pengajuan_perubahan_penduduk_table.php` | Tabel `pengajuan_perubahan_penduduk` |
| `app/Models/PengajuanPerubahanPenduduk.php` | Model + casts `data_baru` sebagai array |
| `app/Http/Controllers/Operator/PengajuanPerubahanController.php` | Approve/reject perubahan data |
| `resources/views/warga/home/index.blade.php` | Dashboard warga dengan data real |
| `resources/views/warga/profil/index.blade.php` | Edit profil + ganti password + kamera |
| `resources/views/warga/ubah-penduduk/index.blade.php` | Form ubah data penduduk (current vs proposed) |
| `resources/views/operator/pengajuan-perubahan/index.blade.php` | Daftar pengajuan perubahan |
| `resources/views/operator/pengajuan-perubahan/show.blade.php` | Detail diff + approve/reject |

### Files Modified
| File | Perubahan |
|---|---|
| `routes/web.php` | 6 route warga baru + 4 route operator baru + import `PengajuanPerubahanController` |
| `app/Http/Controllers/Warga/WargaController.php` | Dashboard real data + profil + ubahPenduduk + simpanUbahPenduduk |
| `app/Http/Controllers/Warga/BuatsuratwargaController.php` | `create()` kirim data penduduk user ke view; `store()` simpan `user_id` |
| `resources/views/warga/buatsurat/create.blade.php` | NIK auto-fill dari user login + auto-trigger lookup + route API warga sendiri |
| `resources/views/warga/layouts/sidebar.blade.php` | Menu "Ubah Data Penduduk" (#2) + "Profil Saya" aktif |
| `resources/views/operator/layouts/sidebar.blade.php` | Menu "Pengajuan Perubahan" di Manajemen Warga |

### Migration Note
Tabel `penduduk` (bukan `penduduks`). Gunakan `constrained('penduduk')` untuk foreign key.

### Feature Details

#### 1. Dashboard Warga
- Profile card: foto, nama, NIK, email, alamat
- Statistik surat: diajukan / diproses / selesai / ditolak
- 5 surat terbaru dengan aksi (cetak/edit)
- Notifikasi pengajuan perubahan pending
- 4 tombol aksi cepat

#### 2. Buat Surat — Auto-fill
- NIK terisi otomatis dari data penduduk user
- AJAX lookup langsung ter-trigger
- User bisa hapus NIK dan cari NIK lain (untuk keluarga)
- Route API sendiri: `buatsuratwarga.cari-penduduk`

#### 3. Ubah Data Penduduk
- Field yang bisa diubah: nama_lengkap, tempat_lahir, tanggal_lahir, agama, pekerjaan, pendidikan_terakhir, alamat
- Data saat ini ditampilkan side-by-side dengan input perubahan
- Wajib mengisi alasan perubahan
- Status: pending → operator approve → update `penduduk`
- Cegah duplikat pengajuan pending

#### 4. Profil Warga
- Edit nama & email
- Update foto via kamera (base64 capture)
- Ganti password (perlu current password untuk validasi)

#### 5. Operator — Pengajuan Perubahan
- Daftar semua pengajuan dengan filter status + search
- Counter pending/approved/rejected
- Detail diff: current vs proposed data (color-coded)
- Tombol approve (update penduduk + log) & reject (dengan catatan)

---

## Session 3: Operator Create Surat — Custom Form Template Fix

### Root Cause
- `form_template` path di DB & admin panel salah: `surat-keterangan-penghasilan` → harusnya `surat-penghasilan` (nama file asli)
- `store()` & `update()` di kedua controller cuma simpan `dynamic` fields jika `form_fields` ada, padahal custom form template (surat-penghasilan) juga kirim `dynamic[*]` fields tanpa `form_fields`
- Operator `create.blade.php` belum punya render `$hasCustomForm`/`$formFields`/default fallback (sekarang sudah)

### Files Fixed

| File | Perubahan |
|---|---|
| `resources/views/admin/template/create.blade.php:116` | `surat-keterangan-penghasilan` → `surat-penghasilan` |
| `resources/views/admin/template/edit.blade.php:115` | `surat-keterangan-penghasilan` → `surat-penghasilan` |
| `database/migrations/2026_06_01_000002_fix_form_template_path.php` | Migrasi fix data existing di `template_surat` & `jenis_surat` |
| `app/Http/Controllers/Operator/BuatsuratController.php` | `store()` & `update()`: tangkap semua `dynamic` input, bukan cuma dari `form_fields` |
| `app/Http/Controllers/Warga/BuatsuratwargaController.php` | Sama: `store()` & `update()` fix |
| `resources/views/operator/buatsurat/create.blade.php` | Tambah `$hasCustomForm` include, `$formFields` foreach, default fallback, `autoFillAutofillFrom()`, Enter key handler |

### Migration Note
Jalankan `php artisan migrate` untuk fix data existing di DB.
