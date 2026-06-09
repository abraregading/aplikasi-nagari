@extends('admin.layouts.app')

@section('title', 'Tambah Penandatangan Surat')

@section('head')
<style>
    .form-group {
        margin-bottom: 1.5rem;
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
    .form-actions {
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .error-text {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.3rem;
        display: block;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; }
    }
    .checkbox-group {
        display: flex;
        gap: 2rem;
        margin-top: 0.5rem;
    }
    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    .checkbox-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--primary);
        cursor: pointer;
    }
    .checkbox-item span {
        font-size: 0.9rem;
        color: var(--text-main);
        font-weight: 500;
    }
    .info-card {
        background: rgba(14, 165, 233, 0.08);
        border: 1px solid rgba(14, 165, 233, 0.2);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        font-size: 0.85rem;
        color: var(--text-muted);
    }
    .info-card i {
        color: var(--primary);
        font-size: 1.1rem;
        margin-top: 2px;
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('penandatangan.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Tambah Penandatangan Surat</h2>
</div>

<div class="info-card">
    <i class="ri-information-line"></i>
    <div>
        <strong>Penandatangan Default</strong> akan otomatis digunakan saat operator membuat surat baru. Hanya satu penandatangan yang dapat ditetapkan sebagai default pada satu waktu.
    </div>
</div>

@if ($errors->any())
<div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
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

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <form action="{{ route('penandatangan.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="nama">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: MUHAMMAD ABRAR, A.Md" class="glass-select" style="width: 100%;" required>
                @error('nama')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Contoh: 198403302011011003" class="glass-select" style="width: 100%;">
                @error('nip')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jabatan">Jabatan <span class="required">*</span></label>
                <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Wali Nagari, Sekretaris Nagari, dll." class="glass-select" style="width: 100%;" required>
                @error('jabatan')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="pangkat_golongan">Pangkat / Golongan</label>
                <input type="text" id="pangkat_golongan" name="pangkat_golongan" value="{{ old('pangkat_golongan') }}" placeholder="Contoh: Penata Muda / III-a" class="glass-select" style="width: 100%;">
                @error('pangkat_golongan')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Pengaturan</label>
            <div class="checkbox-group">
                <label class="checkbox-item">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span><i class="ri-checkbox-circle-line" style="color: #10b981;"></i> Aktif</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
                    <span><i class="ri-star-line" style="color: #6366f1;"></i> Jadikan Default</span>
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Simpan
            </button>
            <a href="{{ route('penandatangan.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
