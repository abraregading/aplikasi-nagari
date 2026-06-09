<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function login()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Proses login dengan rate limiting dan keamanan
     */
    public function authenticate(Request $request)
    {
        // Rate Limiting: max 5 percobaan per menit per IP+username
        $throttleKey = Str::lower($request->input('username')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
                ]);
        }

        // Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'username.required' => 'Username harus diisi.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // Percobaan login
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $user = Auth::user();

            // Cek status akun
            if ($user->status === 'pending') {
                Auth::logout();
                $request->session()->invalidate();
                return back()
                    ->withInput($request->only('username'))
                    ->withErrors([
                        'username' => 'Akun Anda masih menunggu persetujuan Operator Nagari.',
                    ]);
            }

            if ($user->status === 'rejected') {
                Auth::logout();
                $request->session()->invalidate();
                return back()
                    ->withInput($request->only('username'))
                    ->withErrors([
                        'username' => 'Akun Anda ditolak. Silakan hubungi Operator Nagari untuk informasi lebih lanjut.',
                    ]);
            }

            // Reset rate limiter setelah berhasil
            RateLimiter::clear($throttleKey);

            // Regenerasi session untuk mencegah session fixation attack
            $request->session()->regenerate();

            // Log aktivitas login
            \Log::info('User logged in', [
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Redirect ke dashboard sesuai role
            return $this->redirectByRole($user);
        }

        // Login gagal, tambah counter rate limiter
        RateLimiter::hit($throttleKey, 60); // decay 60 detik

        return back()
            ->withInput($request->only('username'))
            ->withErrors([
                'username' => 'Username atau password salah.',
            ]);
    }

    /**
     * Tampilkan halaman registrasi warga
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi warga dengan verifikasi NIK
     */
    public function register(Request $request)
    {
        // Rate Limiting untuk registrasi
        $throttleKey = 'register|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors([
                    'nik' => "Terlalu banyak percobaan registrasi. Coba lagi dalam {$seconds} detik.",
                ]);
        }

        // Validasi input
        $request->validate([
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'nik_verified' => ['required', 'in:1'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'photo_data' => ['required', 'string'],
        ], [
            'nik.required' => 'NIK harus diisi.',
            'nik.size' => 'NIK harus tepat 16 digit.',
            'nik.regex' => 'NIK hanya boleh berisi angka.',
            'nik_verified.in' => 'Silakan cek NIK terlebih dahulu.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'photo_data.required' => 'Foto verifikasi wajib diambil menggunakan kamera.',
        ]);

        // Cek apakah NIK terdaftar di database penduduk
        $nikHash = hash('sha256', $request->nik);
        $penduduk = Penduduk::where('nik_hash', $nikHash)->orWhere('nik', $request->nik)->first();

        if (!$penduduk) {
            RateLimiter::hit($throttleKey, 120);
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors([
                    'nik' => 'NIK tidak ditemukan dalam data kependudukan. Pastikan Anda sudah terdaftar sebagai penduduk.',
                ]);
        }

        // Cek apakah NIK sudah pernah mendaftar akun
        $existingUser = User::where('nik_hash', $nikHash)->orWhere('nik', $request->nik)->first();
        if ($existingUser) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors([
                    'nik' => 'NIK ini sudah terdaftar sebagai akun. Silakan login dengan akun yang sudah ada.',
                ]);
        }

        // Simpan foto verifikasi
        $photoData = $request->photo_data;
        $photoFileName = 'warga_' . time() . '_' . $request->nik . '.jpg';

        if (preg_match('/^data:image\/(\w+);base64,/', $photoData)) {
            $base64 = substr($photoData, strpos($photoData, ',') + 1);
            $decoded = base64_decode($base64);
            Storage::disk('public')->put('photos/' . $photoFileName, $decoded);
        }

        // Buat akun warga dengan status pending
        $user = User::create([
            'name' => $penduduk->nama_lengkap,
            'username' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'warga',
            'status' => 'pending',
            'nik' => $request->nik,
            'photo' => $photoFileName,
        ]);

        // Log registrasi
        \Log::info('New warga registered', [
            'user_id' => $user->id,
            'username' => $user->username,
            'nik' => $user->nik,
            'ip' => $request->ip(),
        ]);

        // Redirect ke halaman pending (tidak auto-login)
        return redirect()->route('register.pending')
            ->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu persetujuan Operator Nagari.');
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        // Log aktivitas logout
        if (Auth::check()) {
            \Log::info('User logged out', [
                'user_id' => Auth::id(),
                'username' => Auth::user()->username,
                'ip' => $request->ip(),
            ]);
        }

        Auth::logout();

        // Invalidasi session & regenerasi token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('site.home')
            ->with('success', 'Anda telah berhasil keluar.');
    }

    /**
     * Redirect user berdasarkan role
     */
    protected function redirectByRole($user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.home'),
            'operator' => redirect()->route('operator.home'),
            'petugas' => redirect()->route('petugas.home'),
            'kader' => redirect()->route('kader.home'),
            'warga' => redirect()->route('warga.home'),
            'kajor' => redirect()->route('kajor.home'),
            default => redirect()->route('login'),
        };
    }

    /**
     * Tampilkan halaman setelah registrasi (menunggu approval)
     */
    public function pending()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.pending');
    }

    /**
     * API endpoint: cek NIK di database penduduk (AJAX)
     */
    public function cekNik(Request $request)
    {
        $request->validate(['nik' => 'required|string|size:16']);

        $nikHash = hash('sha256', $request->nik);
        $penduduk = Penduduk::where('nik_hash', $nikHash)->orWhere('nik', $request->nik)->first();

        if ($penduduk) {
            // Cek apakah sudah punya akun
            $sudahDaftar = User::where('nik_hash', $nikHash)->orWhere('nik', $request->nik)->exists();

            return response()->json([
                'found' => true,
                'already_registered' => $sudahDaftar,
                'nama' => $penduduk->nama_lengkap,
            ]);
        }

        return response()->json([
            'found' => false,
            'already_registered' => false,
            'nama' => null,
        ]);
    }
}
