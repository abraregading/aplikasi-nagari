@extends('auth.app')

@section('login')
<div class="bg-gradient-to-br from-teal-700 to-emerald-900 md:w-5/12 p-8 text-white flex flex-col justify-center items-center text-center relative overflow-hidden">
    <div class="z-10">
        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e8/Pasaman_Barat.png" alt="Logo Kabupaten" class="mx-auto h-20 mb-6 drop-shadow-md">
        <h2 class="text-3xl font-bold mb-4">Pemerintah Kabupaten Pasaman Barat</h2>
        <h3 class="text-xs font-semibold tracking-widest text-emerald-100 uppercase">Nagari Kuamang Alai Ujung Gading</h3>
    </div>
</div>

<div class="md:w-7/12 p-8 md:p-12 bg-white flex flex-col justify-center items-center text-center">
    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
        <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Berhasil!</h2>
    <p class="text-gray-500 mb-6 max-w-md">
        Akun Anda telah berhasil dibuat dan saat ini dalam status <strong>menunggu persetujuan</strong> dari Operator Nagari.
    </p>

    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-6 py-4 rounded-xl mb-6 text-sm text-left max-w-md">
        <p class="font-semibold mb-1">Proses selanjutnya:</p>
        <ol class="list-decimal list-inside space-y-1">
            <li>Operator Nagari akan memverifikasi data Anda</li>
            <li>Jika disetujui, Anda akan bisa login menggunakan NIK sebagai username</li>
            <li>Proses persetujuan biasanya memakan waktu 1x24 jam</li>
        </ol>
    </div>

    <a href="{{ route('login') }}" class="w-full max-w-md bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg shadow-lg shadow-emerald-200 transition-all text-center block">
        Kembali ke Halaman Login
    </a>
</div>
@endsection
