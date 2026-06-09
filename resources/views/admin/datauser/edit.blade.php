@extends('admin.layouts.app')

@section('title', 'Edit User - Admin Desa')

@section('head')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-title {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .page-title h2 {
        margin: 0;
        font-size: 1.5rem;
        color: var(--text-main);
    }
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1rem;
        background: transparent;
        color: var(--text-muted);
        border: 1px solid var(--border-glass);
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: 0.2s;
    }
    .back-btn:hover {
        background: var(--glass-bg);
        color: var(--text-main);
        border-color: var(--text-muted);
    }

    .edit-card {
        background: var(--glass-bg);
        border: 1px solid var(--border-glass);
        border-radius: 16px;
        padding: 2rem;
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-glass);
    }
    .section-title i {
        color: var(--primary);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .form-group {
        margin-bottom: 0;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
    }
    .form-group label .required {
        color: #ef4444;
        margin-left: 2px;
    }
    .glass-input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid var(--border-glass);
        border-radius: 8px;
        background: rgba(255,255,255,0.5);
        font-size: 0.95rem;
        transition: 0.2s;
    }
    .glass-input:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(42, 42, 42, 0.1);
    }
    .glass-input:disabled {
        background: #f5f5f5;
        color: #999;
        cursor: not-allowed;
    }
    .glass-select {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid var(--border-glass);
        border-radius: 8px;
        background: rgba(255,255,255,0.5);
        font-size: 0.95rem;
        transition: 0.2s;
        cursor: pointer;
    }
    .glass-select:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(42, 42, 42, 0.1);
    }
    .error-text {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.3rem;
        display: block;
    }
    .password-hint {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.3rem;
    }

    .form-divider {
        height: 1px;
        background: var(--border-glass);
        margin: 2rem 0;
    }

    .form-actions {
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 2rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn-submit:hover {
        background: #4a4a4a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(42, 42, 42, 0.2);
    }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.5rem;
        background: transparent;
        color: var(--text-muted);
        border: 1px solid var(--border-glass);
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: 0.2s;
    }
    .btn-cancel:hover {
        background: var(--glass-bg);
        color: var(--text-main);
        border-color: var(--text-muted);
    }

    .user-info-bar {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: linear-gradient(135deg, var(--primary) 0%, #4a4a4a 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }
    .user-avatar {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .user-details h4 {
        margin: 0 0 0.25rem 0;
        font-size: 1.1rem;
    }
    .user-details p {
        margin: 0;
        opacity: 0.8;
        font-size: 0.9rem;
    }

    .jorong-section {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    .jorong-section.active {
        display: block;
    }
    .jorong-info {
        background: rgba(139, 92, 246, 0.1);
        border: 1px solid rgba(139, 92, 246, 0.2);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }
    .jorong-info-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #8b5cf6;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .jorong-info p {
        margin: 0;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .edit-card {
            padding: 1.5rem;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('konten')
<div class="page-header">
    <div class="page-title">
        <a href="{{ route('data-user.index') }}" class="back-btn">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <h2>Edit User</h2>
    </div>
</div>

{{-- Error Alert --}}
@if ($errors->any())
<div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; font-weight: 600;">
        <i class="ri-error-warning-line"></i> Terdapat kesalahan:
    </div>
    <ul style="margin: 0; padding-left: 1.5rem;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- User Info Bar --}}
<div class="user-info-bar">
    <div class="user-avatar">
        <i class="ri-user-3-line"></i>
    </div>
    <div class="user-details">
        <h4>Edit: {{ $datauser->name }}</h4>
        <p>&#64;{{ $datauser->username }} &bull; {{ $datauser->email }}</p>
    </div>
</div>

<div class="edit-card">
    <form action="{{ route('data-user.update', $datauser->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Informasi Dasar --}}
        <div class="section-title">
            <i class="ri-user-line"></i> Informasi Dasar
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label for="name">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $datauser->name) }}" class="glass-input" placeholder="Masukkan nama lengkap" required>
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="username">Username <span class="required">*</span></label>
                <input type="text" id="username" name="username" value="{{ old('username', $datauser->username) }}" class="glass-input" placeholder="Masukkan username" required>
                @error('username')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Kontak & Role --}}
        <div class="section-title" style="margin-top: 1rem;">
            <i class="ri-contacts-line"></i> Kontak & Role
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $datauser->email) }}" class="glass-input" placeholder="Masukkan email" required>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="nik">NIK (Opsional)</label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $datauser->nik) }}" class="glass-input" placeholder="Masukkan NIK">
                @error('nik')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="role">Role <span class="required">*</span></label>
                    <select id="role" name="role" class="glass-select" required onchange="toggleRoleFields()">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role', $datauser->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="operator" {{ old('role', $datauser->role) == 'operator' ? 'selected' : '' }}>Operator</option>
                    <option value="petugas" {{ old('role', $datauser->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="kader" {{ old('role', $datauser->role) == 'kader' ? 'selected' : '' }}>Kader</option>
                    <option value="kajor" {{ old('role', $datauser->role) == 'kajor' ? 'selected' : '' }}>Kepala Jorong</option>
                    <option value="warga" {{ old('role', $datauser->role) == 'warga' ? 'selected' : '' }}>Warga</option>
                </select>
                @error('role')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Wilayah Jorong (Hanya untuk Kepala Jorong) --}}
        <div id="jorong-section" class="jorong-section">
            <div class="section-title" style="margin-top: 1rem;">
                <i class="ri-map-pin-line"></i> Wilayah Jorong
            </div>
            <div class="jorong-info">
                <div class="jorong-info-title">
                    <i class="ri-information-line"></i> Informasi
                </div>
                <p>Untuk role <strong>Kepala Jorong</strong>, Anda harus menentukan wilayah jorong yang menjadi tanggung jawab user.</p>
            </div>
            <div class="form-grid" style="margin-top: 1rem;">
                <div class="form-group">
                    <label for="jorong">Pilih Wilayah Jorong <span class="required">*</span></label>
                    <select id="jorong" name="jorong" class="glass-select">
                        <option value="">-- Pilih Jorong --</option>
                        @foreach($jorongs as $jorong)
                            <option value="{{ $jorong }}" {{ old('jorong', $datauser->jorong) == $jorong ? 'selected' : '' }}>{{ $jorong }}</option>
                        @endforeach
                    </select>
                    @error('jorong')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Pos Yandu (Hanya untuk Kader) --}}
        <div id="posyandu-section" class="jorong-section">
            <div class="section-title" style="margin-top: 1rem;">
                <i class="ri-hospital-line"></i> Pos Yandu
            </div>
            <div class="jorong-info">
                <div class="jorong-info-title">
                    <i class="ri-information-line"></i> Informasi
                </div>
                <p>Untuk role <strong>Kader</strong>, Anda harus menentukan pos yandu tempat user bertugas.</p>
            </div>
            <div class="form-grid" style="margin-top: 1rem;">
                <div class="form-group">
                    <label for="posyandu_id">Pilih Pos Yandu <span class="required">*</span></label>
                    <select id="posyandu_id" name="posyandu_id" class="glass-select">
                        <option value="">-- Pilih Pos Yandu --</option>
                        @foreach($posyanduList as $posyandu)
                            <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $datauser->posyandu_id) == $posyandu->id ? 'selected' : '' }}>{{ $posyandu->nama_posyandu }} ({{ $posyandu->kode_posyandu }})</option>
                        @endforeach
                    </select>
                    @error('posyandu_id')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Password --}}
        <div class="form-divider"></div>
        <div class="section-title">
            <i class="ri-lock-line"></i> Ubah Password
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" class="glass-input" placeholder="Kosongkan jika tidak ingin mengubah">
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @else
                    <span class="password-hint">Kosongkan jika tidak ingin mengubah password</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="glass-input" placeholder="Masukkan ulang password baru">
            </div>
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="ri-save-line"></i> Update User
            </button>
            <a href="{{ route('data-user.index') }}" class="btn-cancel">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
function toggleRoleFields() {
    var role = document.getElementById('role').value;
    var jorongSection = document.getElementById('jorong-section');
    var posyanduSection = document.getElementById('posyandu-section');
    var jorong = document.getElementById('jorong');
    var posyandu = document.getElementById('posyandu_id');
    
    if (role === 'kajor') {
        jorongSection.classList.add('active');
        posyanduSection.classList.remove('active');
        jorong.setAttribute('required', 'required');
        posyandu.removeAttribute('required');
    } else if (role === 'kader') {
        posyanduSection.classList.add('active');
        jorongSection.classList.remove('active');
        posyandu.setAttribute('required', 'required');
        jorong.removeAttribute('required');
    } else {
        jorongSection.classList.remove('active');
        posyanduSection.classList.remove('active');
        jorong.removeAttribute('required');
        posyandu.removeAttribute('required');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleRoleFields();
});
</script>
@endsection