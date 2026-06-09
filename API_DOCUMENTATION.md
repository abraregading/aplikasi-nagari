# API Documentation - Siyanduk App

Base URL: `http://localhost:8000/api`

## Authentication

### Login
```
POST /api/login
Content-Type: application/json

Request Body:
{
  "email": "admin@email.com",
  "password": "password"
}

Response:
{
  "user": {...},
  "token": "your-api-token-here"
}
```

### Logout
```
POST /api/logout
Headers: Authorization: Bearer <token>
```

---

## Endpoints

### Penduduk

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/penduduk` | Get all penduduk |
| POST | `/api/penduduk` | Create new penduduk |
| GET | `/api/penduduk/{id}` | Get penduduk by ID |
| PUT | `/api/penduduk/{id}` | Update penduduk |
| DELETE | `/api/penduduk/{id}` | Delete penduduk |

#### Create Penduduk Example
```json
POST /api/penduduk
{
  "nik": "1234567890123456",
  "no_kk": "1234567890123456",
  "nama_lengkap": "John Doe",
  "tempat_lahir": "Jakarta",
  "tanggal_lahir": "1990-01-01",
  "jenis_kelamin": "L",
  "agama": "Islam",
  "status_perkawinan": "Belum Kawin",
  "hubungan_keluarga": "Anak",
  "pekerjaan": "Petani",
  "pendidikan_terakhir": "SMA",
  "alamat": "Jl. Raya No. 1",
  "status_hidup": "hidup"
}
```

### Keluarga

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/keluarga` | Get all keluarga |
| POST | `/api/keluarga` | Create new keluarga |
| GET | `/api/keluarga/{id}` | Get keluarga by ID |
| PUT | `/api/keluarga/{id}` | Update keluarga |
| DELETE | `/api/keluarga/{id}` | Delete keluarga |

#### Create Keluarga Example
```json
POST /api/keluarga
{
  "no_kk": "1234567890123456",
  "kepala_keluarga_nik": "1234567890123456",
  "alamat": "Jl. Raya No. 1",
  "rt": "01",
  "rw": "01",
  "desa_kelurahan": "Desa Example",
  "kecamatan": "Kec Example",
  "kabupaten_kota": "Kab Example",
  "provinsi": "Prov Example",
  "kode_pos": "12345",
  "jumlah_anggota": 4,
  "status": "aktif"
}
```

---

## Usage Example with cURL

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@email.com","password":"password"}'
```

### Get All Penduduk
```bash
curl -X GET http://localhost:8000/api/penduduk \
  -H "Authorization: Bearer your-token-here"
```

### Create Penduduk
```bash
curl -X POST http://localhost:8000/api/penduduk \
  -H "Authorization: Bearer your-token-here" \
  -H "Content-Type: application/json" \
  -d '{"nik":"1234567890123456","no_kk":"1234567890123456","nama_lengkap":"John Doe","tempat_lahir":"Jakarta","tanggal_lahir":"1990-01-01","jenis_kelamin":"L","agama":"Islam","status_perkawinan":"Belum Kawin","hubungan_keluarga":"Anak","pekerjaan":"Petani","pendidikan_terakhir":"SMA","alamat":"Jl. Raya No. 1","status_hidup":"hidup"}'
```

---

## Notes

- All endpoints except `/login` require authentication token
- Token is obtained from login response
- Include token in Authorization header: `Authorization: Bearer <token>`
- Token tidak expire (lihat config `sanctum.php` untuk customize expiration)