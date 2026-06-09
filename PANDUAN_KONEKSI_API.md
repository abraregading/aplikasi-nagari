# Panduan Menghubungkan Aplikasi Eksternal ke Backend Siyanduk

## Prerequisites

- Server backend sudah running: `php artisan serve`
- Port default: `http://localhost:8000`

---

## Langkah 1: Login untuk Mendapatkan Token

Setiap aplikasi eksternal harus login terlebih dahulu untuk mendapatkan token akses.

### Endpoint
```
POST /api/login
```

### Request Headers
```
Content-Type: application/json
Accept: application/json
```

### Request Body
```json
{
  "email": "api@sianduk.com",
  "password": "api123456"
}
```

### Response (Berhasil)
```json
{
  "user": {
    "id": 1,
    "name": "API User",
    "email": "api@sianduk.com",
    "role": "admin"
  },
  "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ1234567890"
}
```

### Response (Gagal)
```json
{
  "message": "Invalid credentials"
}
```

---

## Langkah 2: Menggunakan Token

Simpan token yang получен dari response login. Token digunakan untuk semua request ke API dengan header:

```
Authorization: Bearer <token_anda>
```

**Contoh:**
```
Authorization: Bearer 1|aBcDeFgHiJkLmNoPqRsTuVwXyZ1234567890
```

---

## Langkah 3: Mengakses Endpoint API

### A. Data Penduduk

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/penduduk` | Ambil semua data penduduk |
| POST | `/api/penduduk` | Tambah penduduk baru |
| GET | `/api/penduduk/{id}` | Ambil data penduduk by ID |
| PUT | `/api/penduduk/{id}` | Update data penduduk |
| DELETE | `/api/penduduk/{id}` | Hapus data penduduk |

**Contoh GET /api/penduduk:**
```bash
curl -X GET http://localhost:8000/api/penduduk \
  -H "Authorization: Bearer 1|aBcDeFgHiJkLmNoPqRsTuVwXyZ1234567890" \
  -H "Accept: application/json"
```

**Contoh POST /api/penduduk:**
```bash
curl -X POST http://localhost:8000/api/penduduk \
  -H "Authorization: Bearer 1|aBcDeFgHiJkLmNoPqRsTuVwXyZ1234567890" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
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
  }'
```

### B. Data Keluarga

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/keluarga` | Ambil semua data keluarga |
| POST | `/api/keluarga` | Tambah keluarga baru |
| GET | `/api/keluarga/{id}` | Ambil data keluarga by ID |
| PUT | `/api/keluarga/{id}` | Update data keluarga |
| DELETE | `/api/keluarga/{id}` | Hapus data keluarga |

**Contoh POST /api/keluarga:**
```bash
curl -X POST http://localhost:8000/api/keluarga \
  -H "Authorization: Bearer 1|aBcDeFgHiJkLmNoPqRsTuVwXyZ1234567890" \
  -H "Content-Type: application/json" \
  -d '{
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
  }'
```

### C. Logout

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/api/logout` | Logout dan invalidasi token |

---

## Contoh Implementasi di Berbagai Bahasa Pemrograman

### 1. JavaScript (Fetch API)

```javascript
// Konfigurasi
const BASE_URL = 'http://localhost:8000/api';
let token = null;

// Login
async function login(email, password) {
  const response = await fetch(`${BASE_URL}/login`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ email, password })
  });

  const data = await response.json();

  if (response.ok) {
    token = data.token;
    localStorage.setItem('api_token', token);
    return data;
  } else {
    throw new Error(data.message);
  }
}

// Ambil Data Penduduk
async function getPenduduk() {
  const response = await fetch(`${BASE_URL}/penduduk`, {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    }
  });
  return response.json();
}

// Tambah Penduduk
async function createPenduduk(data) {
  const response = await fetch(`${BASE_URL}/penduduk`, {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify(data)
  });
  return response.json();
}

// Logout
async function logout() {
  await fetch(`${BASE_URL}/logout`, {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    }
  });
  token = null;
  localStorage.removeItem('api_token');
}

// Penggunaan
await login('api@sianduk.com', 'api123456');
const penduduk = await getPenduduk();
```

### 2. PHP (cURL)

```php
<?php

class ApiClient {
    private $baseUrl = 'http://localhost:8000/api';
    private $token = null;

    public function login($email, $password) {
        $ch = curl_init($this->baseUrl . '/login');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'email' => $email,
            'password' => $password
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (isset($response['token'])) {
            $this->token = $response['token'];
        }

        return $response;
    }

    public function getPenduduk() {
        $ch = curl_init($this->baseUrl . '/penduduk');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $response;
    }

    public function createPenduduk($data) {
        $ch = curl_init($this->baseUrl . '/penduduk');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json',
            'Accept: application/json'
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $response;
    }

    public function logout() {
        $ch = curl_init($this->baseUrl . '/logout');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);
        curl_close($ch);

        $this->token = null;
    }
}

// Penggunaan
$api = new ApiClient();
$api->login('api@sianduk.com', 'api123456');
$penduduk = $api->getPenduduk();
$api->createPenduduk([
    'nik' => '1234567890123456',
    'nama_lengkap' => 'John Doe',
    // ... field lainnya
]);
$api->logout();
```

### 3. Flutter (Dart)

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiClient {
  final String baseUrl = 'http://localhost:8000/api';
  String? token;

  Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: jsonEncode({
        'email': email,
        'password': password,
      }),
    );

    final data = jsonDecode(response.body);
    if (response.statusCode == 200) {
      token = data['token'];
      return data;
    } else {
      throw Exception(data['message']);
    }
  }

  Future<List<dynamic>> getPenduduk() async {
    final response = await http.get(
      Uri.parse('$baseUrl/penduduk'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );

    return jsonDecode(response.body);
  }

  Future<Map<String, dynamic>> createPenduduk(Map<String, dynamic> data) async {
    final response = await http.post(
      Uri.parse('$baseUrl/penduduk'),
      headers: {
        'Authorization': 'Bearer $token',
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: jsonEncode(data),
    );

    return jsonDecode(response.body);
  }

  Future<void> logout() async {
    await http.post(
      Uri.parse('$baseUrl/logout'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );
    token = null;
  }
}

// Penggunaan
final api = ApiClient();
await api.login('api@sianduk.com', 'api123456');
final penduduk = await api.getPenduduk();
await api.createPenduduk({
  'nik': '1234567890123456',
  'nama_lengkap': 'John Doe',
  // ... field lainnya
});
await api.logout();
```

### 4. Python (requests)

```python
import requests

class ApiClient:
    def __init__(self):
        self.base_url = 'http://localhost:8000/api'
        self.token = None

    def login(self, email, password):
        response = requests.post(
            f'{self.base_url}/login',
            json={'email': email, 'password': password},
            headers={'Content-Type': 'application/json', 'Accept': 'application/json'}
        )
        data = response.json()
        if response.status_code == 200:
            self.token = data['token']
        return data

    def get_penduduk(self):
        response = requests.get(
            f'{self.base_url}/penduduk',
            headers={'Authorization': f'Bearer {self.token}', 'Accept': 'application/json'}
        )
        return response.json()

    def create_penduduk(self, data):
        response = requests.post(
            f'{self.base_url}/penduduk',
            json=data,
            headers={
                'Authorization': f'Bearer {self.token}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        )
        return response.json()

    def logout(self):
        requests.post(
            f'{self.base_url}/logout',
            headers={'Authorization': f'Bearer {self.token}', 'Accept': 'application/json'}
        )
        self.token = None

# Penggunaan
api = ApiClient()
api.login('api@sianduk.com', 'api123456')
penduduk = api.get_penduduk()
api.create_penduduk({
    'nik': '1234567890123456',
    'nama_lengkap': 'John Doe',
    # ... field lainnya
})
api.logout()
```

### 5. Android (Kotlin)

```kotlin
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

// Setup Retrofit
val retrofit = Retrofit.Builder()
    .baseUrl("http://localhost:8000/api/")
    .addConverterFactory(GsonConverterFactory.create())
    .build()

interface ApiService {
    @POST("login")
    suspend fun login(@Body request: LoginRequest): Response<LoginResponse>

    @GET("penduduk")
    suspend fun getPenduduk(@Header("Authorization") token: String): Response<List<Penduduk>>

    @POST("penduduk")
    suspend fun createPenduduk(
        @Header("Authorization") token: String,
        @Body penduduk: Penduduk
    ): Response<Penduduk>

    @POST("logout")
    suspend fun logout(@Header("Authorization") token: String): Response<Unit>
}

// Penggunaan
val apiService = retrofit.create(ApiService::class.java)

val loginResponse = apiService.login(LoginRequest("api@sianduk.com", "api123456"))
val token = loginResponse.body()?.token

val penduduk = apiService.getPenduduk("Bearer $token")
val newPenduduk = apiService.createPenduduk("Bearer $token", newPenduduk)
```

---

## Troubleshooting

### 1. CORS Error
Jika mendapat error CORS, pastikan:
- Server sudah dijalankan: `php artisan serve`
- Atau gunakan `php artisan serve --host=0.0.0.0` untuk allow semua IP

### 2. Token Expired
Token tidak expire secara default. Jika ingin mengamankan:
- Edit `config/sanctum.php` -> ubah `expiration` ke nilai menit (contoh: 60)

### 3. Invalid Credentials
Pastikan:
- Email dan password benar
- User status masih aktif

---

## Catatan Keamanan (Production)

1. **Jangan gunakan `allowed_origins: ['*']` di production**
   - Ganti dengan domain spesifik aplikasi Anda

2. **Ganti password default**
   - Buat user API baru melalui menu Admin

3. **Gunakan HTTPS**
   - Di server production, gunakan SSL/HTTPS

4. **Batasi akses token**
   - Jika perlu, implementasikan token expiration