@extends('auth.app')

@section('login')

@php
$oldNik = old('nik', '');
$hasStep2Errors = $errors->has('email') || $errors->has('password') || $errors->has('photo_data') || $errors->has('nik_verified');
$showStep2 = $hasStep2Errors || old('nik_verified') === '1';
@endphp

<div class="bg-gradient-to-br from-teal-700 to-emerald-900 md:w-5/12 p-8 text-white flex flex-col justify-center items-center text-center relative overflow-hidden">
    <div class="z-10">
        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e8/Pasaman_Barat.png" alt="Logo Kabupaten" class="mx-auto h-20 mb-6 drop-shadow-md">
        <h2 class="text-3xl font-bold mb-4">Pemerintah Kabupaten Pasaman Barat</h2>
        <h3 class="text-xs font-semibold tracking-widest text-emerald-100 uppercase">Kecamatan Lembah Melintang</h3>

        <h3 class="text-xs font-semibold tracking-widest text-emerald-100 uppercase">Nagari Kuamang Alai Ujung Gading</h3><br>
        <p class="text-teal-100 text-sm leading-relaxed mb-8">Daftarkan diri Anda untuk mengakses layanan surat-menyurat, pelaporan warga, dan informasi publik nagari secara mandiri.</p>

        <div class="p-4 bg-white/10 rounded-xl border border-white/20 backdrop-blur-sm">
            <p class="text-xs text-teal-100 mb-2">Didukung oleh:</p>
            <div class="flex justify-center gap-3">
                <img src="https://placehold.co/70x30/ffffff/0f766e?text=Sponsor+1" alt="Sponsor" class="h-6 rounded">
                <img src="https://placehold.co/70x30/ffffff/0f766e?text=Sponsor+2" alt="Sponsor" class="h-6 rounded">
            </div>
        </div>
    </div>
</div>

<div class="md:w-7/12 p-8 md:p-12 bg-white flex flex-col justify-center">
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Pendaftaran Warga</h2>
    <p class="text-gray-500 text-sm mb-4">Langkah 1: Cek NIK Anda terlebih dahulu.</p>

    @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ session('error') }}</div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="registerForm" action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div id="step1" @if($showStep2) style="display:none" @endif>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Induk Kependudukan (NIK)</label>
                <div class="flex gap-2">
                    <input type="text" id="nik" name="nik" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="16 Digit NIK" maxlength="16" oninput="this.value=this.value.replace(/[^0-9]/g,'')" value="{{ old('nik') }}">
                    <button type="button" id="btnCekNik" onclick="cekNik()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-all whitespace-nowrap">Cek NIK</button>
                </div>
                @error('nik')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
                <div id="nikResult" class="mt-2" style="display:none;"></div>
            </div>
        </div>

        <div id="step2" @if(!$showStep2) style="display:none" @endif>
            <hr class="my-4">
            <p class="text-gray-500 text-sm mb-4">Langkah 2: Lengkapi data berikut.</p>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="namaDisplay" name="nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500" readonly value="{{ old('nama', '') }}">
                <input type="hidden" id="nikVerified" name="nik_verified" value="{{ old('nik_verified', '0') }}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Username (NIK)</label>
                <input type="text" id="usernameDisplay" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500" readonly value="{{ $oldNik }}">
                <input type="hidden" id="username" name="username" value="{{ $oldNik }}">
                @error('username')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp / Email</label>
                <input type="text" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="0812xxxx / email@domain.com" value="{{ old('email') }}">
                @error('email')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Minimal 6 karakter">
                    @error('password')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Ulangi kata sandi">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Verifikasi (Ambil foto langsung menggunakan kamera)</label>
                <div id="cameraContainer">
                    <div id="cameraUnavailable" style="display:none;" class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg text-sm">
                        <strong>⚠️ Kamera tidak terdeteksi</strong> di perangkat ini.<br>
                        Silakan daftar menggunakan <strong>smartphone</strong> Anda untuk mengambil foto verifikasi.
                    </div>
                    <video id="video" width="100%" height="auto" autoplay playsinline style="border-radius:8px;border:2px solid #ddd;max-width:320px;background:#000;display:none;"></video>
                    <div class="mt-2 flex gap-2">
                        <button type="button" id="btnCamera" onclick="startCamera()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all text-sm">Buka Kamera</button>
                        <button type="button" id="btnCapture" onclick="capturePhoto()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-all text-sm" style="display:none;">Ambil Foto</button>
                    </div>
                    <canvas id="canvas" style="display:none;"></canvas>
                    <div id="photoPreview" class="mt-2" style="display:none;">
                        <img id="photoImg" src="" alt="Preview" style="max-width:200px;border-radius:8px;border:2px solid #0f766e;">
                        <p class="text-xs text-green-600 mt-1">Foto berhasil diambil ✓</p>
                        <button type="button" onclick="retakePhoto()" class="text-xs text-blue-600 underline mt-1">Ambil ulang</button>
                    </div>
                    <input type="hidden" id="photo_data" name="photo_data">
                </div>
                @error('photo_data')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-0.5">
                    Daftar Sekarang
                </button>
            </div>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Sudah memiliki akun? <a href="{{ route('login') }}" class="text-emerald-600 font-bold hover:underline">Masuk di sini</a>
    </p>
</div>

<script>
let stream = null;
let fotoDiambil = false;

function cekNik() {
    const nik = document.getElementById('nik').value.trim();
    const resultDiv = document.getElementById('nikResult');
    const btnCek = document.getElementById('btnCekNik');

    if (nik.length !== 16 || !/^\d{16}$/.test(nik)) {
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = '<div style="color: #dc3545; font-size: 0.85rem;"><strong>⚠️ NIK harus 16 digit angka</strong></div>';
        return;
    }

    btnCek.disabled = true;
    btnCek.textContent = 'Mengecek...';

    fetch('{{ route("cek.nik") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ nik: nik })
    })
    .then(response => response.json())
    .then(data => {
        resultDiv.style.display = 'block';

        if (data.found && !data.already_registered) {
            resultDiv.innerHTML = '<div style="color: #28a745; font-size: 0.85rem; padding: 0.5rem; background: rgba(40,167,69,0.1); border-radius: 6px;"><strong>✅ NIK ditemukan!</strong> Atas nama: <strong>' + data.nama + '</strong></div>';
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
            document.getElementById('namaDisplay').value = data.nama;
            document.getElementById('usernameDisplay').value = nik;
            document.getElementById('username').value = nik;
            document.getElementById('nikVerified').value = '1';
        } else if (data.found && data.already_registered) {
            resultDiv.innerHTML = '<div style="color: #dc3545; font-size: 0.85rem; padding: 0.5rem; background: rgba(220,53,69,0.1); border-radius: 6px;"><strong>⚠️ NIK sudah terdaftar sebagai akun.</strong> Silakan <a href="{{ route("login") }}">login di sini</a>.</div>';
        } else {
            resultDiv.innerHTML = '<div style="color: #dc3545; font-size: 0.85rem; padding: 1rem; background: rgba(220,53,69,0.1); border-radius: 6px;"><strong>❌ NIK tidak ditemukan</strong> dalam data kependudukan.<br>Silakan minta <strong>Operator Nagari</strong> untuk mendaftarkan Kartu Keluarga beserta seluruh anggota keluarga terlebih dahulu.</div>';
        }
    })
    .catch(error => {
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = '<div style="color: #dc3545; font-size: 0.85rem;"><strong>⚠️ Terjadi kesalahan. Coba lagi.</strong></div>';
    })
    .finally(() => {
        btnCek.disabled = false;
        btnCek.textContent = 'Cek NIK';
    });
}

function showCameraUnavailable() {
    document.getElementById('btnCamera').style.display = 'none';
    document.getElementById('cameraUnavailable').style.display = 'block';
}

function startCamera() {
    const video = document.getElementById('video');
    const btnCamera = document.getElementById('btnCamera');
    const btnCapture = document.getElementById('btnCapture');
    const camUnavail = document.getElementById('cameraUnavailable');

    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        showCameraUnavailable();
        return;
    }

    navigator.mediaDevices.getUserMedia({
        video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } }
    })
    .then(function(s) {
        stream = s;
        video.style.display = 'block';
        video.srcObject = stream;
        video.play();
        btnCamera.style.display = 'none';
        btnCapture.style.display = 'inline-block';
        camUnavail.style.display = 'none';
    })
    .catch(function(err) {
        console.error(err);
        showCameraUnavailable();
    });
}

function capturePhoto() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const photoImg = document.getElementById('photoImg');
    const photoPreview = document.getElementById('photoPreview');
    const photoData = document.getElementById('photo_data');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);

    const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
    photoImg.src = dataUrl;
    photoPreview.style.display = 'block';
    photoData.value = dataUrl;

    fotoDiambil = true;

    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    video.srcObject = null;
    document.getElementById('btnCamera').style.display = 'none';
    document.getElementById('btnCapture').style.display = 'none';
}

function retakePhoto() {
    document.getElementById('photoPreview').style.display = 'none';
    document.getElementById('photo_data').value = '';
    fotoDiambil = false;
    document.getElementById('btnCamera').style.display = 'inline-block';
}

document.getElementById('registerForm').addEventListener('submit', function(e) {
    if (document.getElementById('nikVerified').value !== '1') {
        e.preventDefault();
        alert('Silakan cek NIK Anda terlebih dahulu.');
        return;
    }
    if (!fotoDiambil && document.getElementById('cameraUnavailable').style.display !== 'block') {
        e.preventDefault();
        alert('Silakan ambil foto verifikasi menggunakan kamera.');
        return;
    }
});
</script>
@endsection
