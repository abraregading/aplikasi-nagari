# PANDUAN DEPLOY APLIKASI NAGARI (LARAVEL)

**Domain:** https://demo-aplikasi.nagaridigital.web.id/
**GitHub:** https://github.com/abraregading/aplikasi-nagari.git
**VPS:** Ubuntu/Debian + aapanel

---

## A. PERSIAPAN DI LOCAL (WINDOWS)

### A1. Backup Database

Buka phpMyAdmin atau terminal, export database `db-yanduk` ke file SQL.

### A2. Bersihkan Cache Laravel

Jalankan perintah berikut di terminal (cmd/powershell) dari folder project:

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

### A3. Update File .env untuk Production

Edit file `.env` dengan nilai berikut:

```env
APP_NAME=Nagari
APP_ENV=production
APP_DEBUG=false
APP_URL=https://demo-aplikasi.nagaridigital.web.id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
# DB_DATABASE, DB_USERNAME, DB_PASSWORD akan diisi setelah setup DB di VPS

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

LOG_LEVEL=warning
```

> **Catatan:** `.env` sudah dilindungi `.gitignore`, tidak akan ikut terpush ke GitHub.

### A4. Ganti Remote Repository ke Repo Baru

```bash
git remote set-url origin https://github.com/abraregading/aplikasi-nagari.git
git remote set-url --delete origin pushurl
```

Verifikasi:
```bash
git remote -v
```

Hasil harus menampilkan:
```
origin  https://github.com/abraregading/aplikasi-nagari.git (fetch)
origin  https://github.com/abraregading/aplikasi-nagari.git (push)
```

### A5. Build Asset Frontend

```bash
npm install
npm run build
```

### A6. Commit & Push ke GitHub

```bash
git add .
git commit -m "Initial commit - Aplikasi Nagari"
git push -u origin main
```

> Jika pertama kali push, GitHub akan meminta login. Gunakan **Personal Access Token (PAT)** sebagai password.
> Cara buat PAT: GitHub.com → Settings → Developer settings → Personal access tokens → Fine-grained tokens

---

## B. SETUP DOMAIN & DATABASE DI AAPANEL (SEBELUM CLONE)

### B1. Login ke aapanel

Buka `http://ip-vps-anda:8888` di browser.

### B2. Setup Database

1. Kiri menu → **Database** → **phpMyAdmin**
2. Klik **Add Database**
3. Isi:
   - **Database Name:** `db_aplikasi_nagari`
   - **Username:** `user_nagari`
   - **Password:** *(buat password kuat)*
4. Klik **Submit**
5. Simpan credential: DB name, username, password

### B3. Setup Domain di aapanel

1. Kiri menu → **Website** → **Add Site**
2. Isi:
   - **Domain:** `demo-aplikasi.nagaridigital.web.id`
   - **Root Path:** `demo-aplikasi.nagaridigital.web.id`
   - **Create Database:** Tidak perlu (sudah dibuat manual)
   - **PHP Version:** Pilih PHP 8.2 atau 8.3
3. Klik **Submit**

---

## C. DEPLOY KE VPS (UBUNTU/DEBIAN)

### C1. SSH ke VPS

```bash
ssh root@ip-vps-anda
```

### C2. Clone Repository dari GitHub

```bash
cd /www/wwwroot/
git clone https://github.com/abraregading/aplikasi-nagari.git demo-aplikasi.nagaridigital.web.id
cd demo-aplikasi.nagaridigital.web.id
```

### C3. Buat & Konfigurasi .env

```bash
cp .env.example .env
nano .env
```

Sesuaikan nilai berikut:

```env
APP_NAME=Nagari
APP_ENV=production
APP_DEBUG=false
APP_URL=https://demo-aplikasi.nagaridigital.web.id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_aplikasi_nagari
DB_USERNAME=user_nagari
DB_PASSWORD=password_yang_dibuat_tadi

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

LOG_LEVEL=warning
```

Simpan: `CTRL+X`, lalu `Y`, lalu `Enter`

### C4. Install Dependencies

```bash
composer install --optimize --no-dev
```

### C5. Generate Application Key

```bash
php artisan key:generate
```

### C6. Jalankan Migration

```bash
php artisan migrate --force
```

### C7. Import Database Lama (Jika Ada)

1. Buka aapanel → **Database** → **phpMyAdmin**
2. Pilih database `db_aplikasi_nagari`
3. Tab **Import**
4. Pilih file SQL backup dari langkah A1
5. Klik **Go**

### C8. Optimasi Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### C9. Set Permission Folder

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### C10. Setup SSL (HTTPS) di aapanel

1. Buka aapanel → **Website** → klik domain `demo-aplikasi.nagaridigital.web.id`
2. Pilih **SSL** di tab menu atas
3. Pilih **Let's Encrypt**
4. Centang domain, klik **Apply**
5. Tunggu hingga SSL terpasang

### C11. Konfigurasi Nginx ( jika perlu )

Di aapanel, buka **Website** → **Settings** → **URL Rewrite**.
Pilih template **Laravel** (jika tersedia).

Jika tidak ada, tambahkan rule rewrite manual di **Config**:

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

---

## D. VERIFIKASI

| No | Item | Cara Cek |
|----|------|----------|
| 1 | Akses website | Buka `https://demo-aplikasi.nagaridigital.web.id` |
| 2 | Halaman login | Pastikan muncul halaman login |
| 3 | Login admin | Coba login dengan akun admin |
| 4 | Login role lain | Coba login kader/petugas/kajor |
| 5 | Error log | `cat /www/wwwroot/demo-aplikasi.nagaridigital.web.id/storage/logs/laravel.log` |
| 6 | Debug mode mati | Pastikan browser tidak menampilkan error detail Laravel |
| 7 | HTTPS berfungsi | Pastikan ada gembok hijau di browser |

---

## E. TROUBLESHOOTING

### E1. Error 403 Forbidden
```bash
chmod -R 775 /www/wwwroot/demo-aplikasi.nagaridigital.web.id/storage
chmod -R 775 /www/wwwroot/demo-aplikasi.nagaridigital.web.id/bootstrap/cache
```

### E2. Error 500 Internal Server Error
Cek log:
```bash
cat /www/wwwroot/demo-aplikasi.nagaridigital.web.id/storage/logs/laravel.log
```

### E3. Class Not Found
```bash
composer dump-autoload
```

### E4. APP_KEY Not Set
```bash
php artisan key:generate
```

### E5. Git Push Ditolak
```bash
git pull origin main --rebase
git push origin main
```

### E6. Database Connection Error
Cek file `.env` — pastikan DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD benar.

---

## F. CATATAN PENTING

1. **Jangan commit/push file `.env`** — sudah diamankan `.gitignore`
2. **Jangan commit folder `vendor/` dan `node_modules/`** — sudah diamankan `.gitignore`
3. **Gunakan Personal Access Token (PAT)** untuk push ke GitHub (bukan password biasa)
4. **Backup database sebelum migrate** jika ada data produksi
5. **Setelah deploy**, hapus file installer atau file debug jika ada

---

*Panduan ini dibuat untuk deploy Aplikasi Nagari (Laravel) ke VPS Ubuntu/Debian dengan aapanel.*
