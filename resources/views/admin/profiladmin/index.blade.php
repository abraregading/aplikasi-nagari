@extends('admin.layouts.app')

@section('title', 'Profil Saya - Admin')

@section('head')
<style>
    .form-section-title {
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
        color: var(--primary);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding-bottom: 0.5rem;
    }
    .glass-select {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 8px;
        background: rgba(255,255,255,0.8);
        font-size: 0.95rem;
        transition: 0.2s;
    }
    .glass-select:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(42, 42, 42, 0.1);
    }
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
    }
    .input-icon {
        position: relative;
    }
    .input-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }
    .input-icon input {
        padding-left: 2.8rem;
    }
    .alert-success {
        background: #d4edda;
        color: #155724;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border: 1px solid #c3e6cb;
    }
    .alert-error {
        background: #f8d7da;
        color: #721c24;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border: 1px solid #f5c6cb;
    }
    .profile-card {
        background: linear-gradient(135deg, var(--primary) 0%, #4a4a4a 100%);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
    }
    .profile-card .avatar {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    .profile-card h3 {
        margin: 0;
        font-size: 1.5rem;
    }
    .profile-card p {
        margin: 0.5rem 0 0;
        opacity: 0.8;
    }
    .badge-role {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        font-size: 0.8rem;
        margin-top: 0.5rem;
        text-transform: uppercase;
    }
</style>
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Profil Saya</h2>

{{-- Profile Info Card --}}
<div class="profile-card">
    <div class="avatar">
        <i class="ri-user-3-line"></i>
    </div>
    <h3>{{ $user->name }}</h3>
    <p>{{ $user->email }}</p>
    <span class="badge-role">{{ $user->role }}</span>
</div>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-error">
        {{ session('error') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
    
    {{-- Edit Profil Pribadi --}}
    <div class="glass" style="padding: 2rem; border-radius: 16px;">
        <h3 class="form-section-title">Informasi Pribadi</h3>
        
        <form action="{{ route('profil-admin.updateProfile') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="glass-select" required>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="glass-select" required>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">Username</label>
                <input type="text" value="{{ $user->username }}" class="glass-select" disabled style="background: #f5f5f5; color: #999;">
                <small style="color: #999; font-size: 0.8rem;">Username tidak dapat diubah</small>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">NIK</label>
                <input type="text" value="{{ $user->nik ?? 'Belum diatur' }}" class="glass-select" disabled style="background: #f5f5f5; color: #999;">
            </div>

            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; cursor: pointer;">
                <i class="ri-save-line"></i> Simpan Profil
            </button>
        </form>
    </div>

    {{-- Ganti Password --}}
    <div class="glass" style="padding: 2rem; border-radius: 16px;">
        <h3 class="form-section-title">Ganti Password</h3>
        
        <form action="{{ route('profil-admin.updatePassword') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">Password Saat Ini</label>
                <div class="input-icon">
                    <i class="ri-lock-line"></i>
                    <input type="password" name="current_password" class="glass-select" required placeholder="Masukkan password saat ini">
                </div>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">Password Baru</label>
                <div class="input-icon">
                    <i class="ri-lock-unlock-line"></i>
                    <input type="password" name="new_password" class="glass-select" required placeholder="Masukkan password baru (min 6 karakter)">
                </div>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">Konfirmasi Password Baru</label>
                <div class="input-icon">
                    <i class="ri-checkbox-multiple-line"></i>
                    <input type="password" name="new_password_confirmation" class="glass-select" required placeholder="Masukkan ulang password baru">
                </div>
            </div>

            <button type="submit" class="glass-select" style="background: #dc3545; color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; cursor: pointer;">
                <i class="ri-refresh-line"></i> Ganti Password
            </button>
        </form>
    </div>

</div>
@endsection