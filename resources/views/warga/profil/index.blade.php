@extends('warga.layouts.app')

@section('title', 'Profil Saya')

@section('head')
<style>
    .page-header { margin-bottom: 1.5rem; }
    .page-header h2 { font-size: 1.4rem; margin: 0; }

    .profile-card {
        display: flex; align-items: center; gap: 1.5rem;
        background: var(--bg-glass); border: var(--border-glass);
        border-radius: 16px; padding: 2rem; margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .profile-avatar {
        width: 100px; height: 100px; border-radius: 50%;
        object-fit: cover; border: 4px solid var(--primary);
    }
    .profile-avatar-placeholder {
        width: 100px; height: 100px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 2.5rem; font-weight: 700;
    }
    .profile-detail h3 { margin: 0; font-size: 1.3rem; }
    .profile-detail p { margin: .3rem 0; color: var(--text-muted); font-size: .9rem; }

    .form-section { margin-bottom: 2rem; }
    .form-section h3 { font-size: 1rem; color: var(--primary); margin-bottom: 1rem; display: flex; align-items: center; gap: .5rem; }
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-size: .85rem; font-weight: 500; margin-bottom: .3rem; color: var(--text-main); }
    .form-control {
        width: 100%; padding: .8rem 1rem; border-radius: 10px;
        border: 1px solid rgba(0,0,0,.1); background: rgba(255,255,255,.8);
        font-size: .9rem; font-family: inherit; color: var(--text-main);
        outline: none; transition: all .3s; box-sizing: border-box;
    }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,.15); }
    .form-control:read-only, .form-control:disabled { background: rgba(0,0,0,.03); color: var(--text-muted); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .btn {
        padding: .7rem 1.5rem; border-radius: 10px; font-weight: 600; font-size: .9rem;
        border: none; cursor: pointer; font-family: inherit; transition: all .3s;
        display: inline-flex; align-items: center; gap: .5rem;
    }
    .btn-primary { background: var(--primary); color: white; }
    .btn-primary:hover { background: #0284c7; transform: translateY(-1px); }
    .btn-outline { background: transparent; border: 1px solid rgba(0,0,0,.15); color: var(--text-main); }
    .btn-outline:hover { background: rgba(0,0,0,.03); }
    .alert { padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: .9rem; display: flex; align-items: center; gap: .5rem; }
    .alert-success { background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.25); color: #065f46; }
    .alert-error { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.25); color: #991b1b; }
    .text-red { color: #ef4444; font-size: .8rem; margin-top: .25rem; }
    .text-muted { color: var(--text-muted); }
    @media(max-width: 768px) { .form-row { grid-template-columns: 1fr; } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-user-settings-line" style="color:var(--primary)"></i> Profil Saya</h2>
</div>

@if(session('success'))
<div class="alert alert-success"><i class="ri-check-line"></i> {{ session('success') }}</div>
@endif

<div class="profile-card">
    @if($user->photo)
        <img src="{{ asset('storage/photos/' . $user->photo) }}" alt="foto" class="profile-avatar" id="currentPhoto">
    @else
        <div class="profile-avatar-placeholder" id="currentPhotoPlaceholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
    @endif
    <div class="profile-detail">
        <h3>{{ $user->name }}</h3>
        <p><i class="ri-fingerprint-line"></i> NIK: {{ $user->nik ?? ($penduduk->nik ?? '-') }}</p>
        <p><i class="ri-mail-line"></i> {{ $user->email }}</p>
        <p><i class="ri-calendar-line"></i> Bergabung: {{ $user->created_at->format('d/m/Y') }}</p>
    </div>
</div>

<div class="glass" style="padding:2rem;border-radius:16px;margin-bottom:1.5rem;">
    <form action="{{ route('warga.profil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h3><i class="ri-information-line"></i> Informasi Akun</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="text-red">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="text-red">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" value="{{ $user->username }}" readonly disabled>
                </div>
                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" class="form-control" value="{{ $user->nik ?? ($penduduk->nik ?? '-') }}" readonly disabled>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3><i class="ri-camera-line"></i> Foto Profil</h3>
            <div class="form-group">
                <div id="cameraContainer">
                    <div id="cameraUnavailable" style="display:none;" class="alert" style="background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.25);color:#92400e;">
                        Kamera tidak terdeteksi di perangkat ini.
                    </div>
                    <video id="video" width="100%" height="auto" autoplay playsinline style="border-radius:10px;border:2px solid #ddd;max-width:320px;background:#000;display:none;"></video>
                    <div class="form-row" style="margin-top:.5rem;">
                        <button type="button" id="btnCamera" onclick="startCamera()" class="btn btn-outline"><i class="ri-camera-line"></i> Buka Kamera</button>
                        <button type="button" id="btnCapture" onclick="capturePhoto()" class="btn btn-primary" style="display:none;"><i class="ri-camera-fill"></i> Ambil Foto</button>
                    </div>
                    <canvas id="canvas" style="display:none;"></canvas>
                    <div id="photoPreview" class="form-row" style="display:none;margin-top:.5rem;">
                        <img id="photoImg" src="" alt="Preview" style="max-width:150px;border-radius:10px;border:3px solid var(--primary);">
                        <button type="button" onclick="retakePhoto()" class="btn btn-outline" style="font-size:.8rem;">Ambil Ulang</button>
                    </div>
                    <input type="hidden" id="photo_data" name="photo_data">
                </div>
                @error('photo_data') <div class="text-red">{{ $message }}</div> @enderror
            </div>
        </div>

        <div style="display:flex;gap:1rem;justify-content:flex-end;padding-top:1rem;border-top:1px solid rgba(0,0,0,.06);">
            <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>

<div class="glass" style="padding:2rem;border-radius:16px;">
    <form action="{{ route('warga.profil.updatePassword') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h3><i class="ri-lock-line"></i> Ubah Password</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Masukkan password saat ini" required>
                    @error('current_password') <div class="text-red">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    @error('password') <div class="text-red">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:1rem;justify-content:flex-end;padding-top:1rem;border-top:1px solid rgba(0,0,0,.06);">
            <button type="submit" class="btn btn-primary"><i class="ri-lock-line"></i> Ubah Password</button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
let stream = null;

function startCamera() {
    const video = document.getElementById('video');
    const btnCamera = document.getElementById('btnCamera');
    const btnCapture = document.getElementById('btnCapture');
    const camUnavail = document.getElementById('cameraUnavailable');

    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        camUnavail.style.display = 'block';
        return;
    }

    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } } })
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
        camUnavail.style.display = 'block';
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
    photoPreview.style.display = 'flex';
    photoData.value = dataUrl;

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
    document.getElementById('btnCamera').style.display = 'inline-block';
}
</script>
@endsection
