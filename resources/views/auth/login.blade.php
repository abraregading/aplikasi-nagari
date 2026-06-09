@extends('auth.app')

@section('login')
<!-- Bagian Kiri: Branding Pemerintahan & Sponsor -->
        <div class="bg-gradient-to-br from-emerald-600 to-teal-900 md:w-1/2 p-8 text-white flex flex-col justify-between items-center text-center relative overflow-hidden">
            <!-- Aksen Dekoratif -->
            <div class="absolute top-0 left-0 w-full h-full bg-white opacity-5 pointer-events-none" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>

            <!-- Header: Logo Kabupaten -->
            <div class="mt-4 z-10">
                <!-- Ganti 'src' dengan URL logo kabupaten Anda -->
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e8/Pasaman_Barat.png" alt="Logo Kabupaten" class="mx-auto h-20 mb-2 drop-shadow-md">
                <p class="text-xs font-semibold tracking-widest text-emerald-100 uppercase">Pemerintah Kabupaten Pasaman Barat</p>
                <p class="text-xs font-semibold tracking-widest text-emerald-100 uppercase">Kecamatan Lembah Melintang</p>
                <p class="text-xs font-semibold tracking-widest text-emerald-100 uppercase">Nagari Kuamang Alai Ujung Gading</p>
            </div>

            <!-- Tengah: Nama Aplikasi -->
            <div class="my-10 z-10">
                <h1 class="text-4xl font-extrabold mb-3 tracking-tight">NagariDigital Terpadu</h1>
                <p class="text-emerald-100 text-sm leading-relaxed max-w-xs mx-auto">Sistem Informasi & Pelayanan Administrasi NagariDigital yang cepat, transparan, dan akuntabel.</p>
            </div>

            <!-- Bawah: Logo Sponsor -->
            <div class="mb-4 w-full z-10">
                <p class="text-xs text-emerald-200 mb-3 uppercase tracking-wider font-medium">Didukung Oleh:</p>
                <div class="flex justify-center items-center gap-4 bg-white/10 p-3 rounded-xl backdrop-blur-sm border border-white/20">
                    <!-- Ganti 'src' dengan URL logo sponsor -->
                    <img src="https://placehold.co/90x35/ffffff/10b981?text=Bank+Daerah" alt="Sponsor 1" class="h-8 rounded">
                    <img src="https://placehold.co/90x35/ffffff/10b981?text=Kemenkominfo" alt="Sponsor 2" class="h-8 rounded">
                </div>
            </div>
        </div>

        <!-- Bagian Kanan: Form Login -->
        <div class="md:w-1/2 p-8 md:p-12 bg-white flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
            <p class="text-gray-500 text-sm mb-8">Silakan masuk menggunakan Username/NIK dan kata sandi Anda.</p>

            <form action="{{ route('login.authenticate') }}" method="POST">
            @csrf
                <!-- Input NIK -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Username/ Nomor Induk Kependudukan (NIK)</label>
                    <input type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" id="username" name="username"  placeholder="Masukkan Username atau 16 digit NIK Anda">
                    @error('username')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Password -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" placeholder="••••••••">
                </div>

                <!-- Lupa Sandi & Ingat Saya -->
                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" class="mr-2 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500"> Ingat saya
                    </label>
                    <a href="#" class="text-sm text-emerald-600 hover:text-emerald-800 font-semibold transition-colors">Lupa sandi?</a>
                </div>

                <!-- Tombol Login -->
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-0.5">
                    Masuk ke Sistem
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Belum terdaftar sebagai warga digital? <br class="block sm:hidden">
                <a href="{{ route('register') }}" class="text-emerald-600 font-bold hover:underline">Daftar sekarang</a>
            </p>
        </div>
@endsection
