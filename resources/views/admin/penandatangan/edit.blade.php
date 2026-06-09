@extends('admin.layouts.app')

@section('title', 'Edit Penandatangan Surat')

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
        position: relative;
        overflow: hidden;
    }
    .edit-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
    }

    .info-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid rgba(99, 102, 241, 0.2);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }
    .info-card i {
        color: #6366f1;
        font-size: 1.5rem;
    }
    .info-card p {
        margin: 0;
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    .info-card strong {
        color: #6366f1;
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
        color: #6366f1;
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
        border-color: #6366f1;
        background: white;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .glass-input::placeholder {
        color: #aaa;
    }
    .error-text {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.3rem;
        display: block;
    }

    .form-divider {
        height: 1px;
        background: var(--border-glass);
        margin: 2rem 0;
    }

    .checkbox-group {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    .checkbox-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        border: 1px solid var(--border-glass);
        border-radius: 10px;
        cursor: pointer;
        transition: 0.2s;
        flex: 1;
        min-width: 150px;
    }
    .checkbox-card:hover {
        background: rgba(255,255,255,0.5);
        border-color: #6366f1;
    }
    .checkbox-card input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: #6366f1;
        cursor: pointer;
    }
    .checkbox-card .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--text-main);
        font-weight: 500;
    }
    .checkbox-card .checkbox-label i.active {
        color: #10b981;
    }
    .checkbox-card .checkbox-label i.default {
        color: #f59e0b;
    }
    .checkbox-card input:checked + .checkbox-label {
        color: #6366f1;
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
        background: #6366f1;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn-submit:hover {
        background: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
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

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .status-active {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }
    .status-inactive {
        background: rgba(107, 114, 128, 0.15);
        color: #6b7280;
    }
    .status-default {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
    }

    @media (max-width: 768px) {
        .edit-card {
            padding: 1.5rem;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
        .checkbox-group {
            flex-direction: column;
        }
        .checkbox-card {
            min-width: 100%;
        }
    }
</style>
@endsection

@section('konten')
<div class="page-header">
    <div class="page-title">
        <a href="{{ route('penandatangan.index') }}" class="back-btn">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <h2>Edit Penandatangan</h2>
    </div>
    @if($penandatangan->is_default)
    <span class="status-badge status-default">
        <i class="ri-star-fill"></i> Default
    </span>
    @endif
</div>

{{-- Info Card --}}
<div class="info-card">
    <i class="ri-file-list-3-line"></i>
    <p>Penandatangan ini digunakan pada <strong>{{ $penandatangan->riwayatSurat()->count() }}</strong> surat. Perubahan akan mempengaruhi semua surat yang menggunakan penandatangan ini.</p>
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

<div class="edit-card">
    <form action="{{ route('penandatangan.update', $penandatangan->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Informasi Penandatangan --}}
        <div class="section-title">
            <i class="ri-user-line"></i> Informasi Penandatangan
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label for="nama">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $penandatangan->nama) }}" class="glass-input" placeholder="Contoh: MUHAMMAD ABRAR, A.Md" required>
                @error('nama')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" id="nip" name="nip" value="{{ old('nip', $penandatangan->nip) }}" class="glass-input" placeholder="Contoh: 198403302011011003">
                @error('nip')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan <span class="required">*</span></label>
                <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $penandatangan->jabatan) }}" class="glass-input" placeholder="Contoh: Wali Nagari" required>
                @error('jabatan')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="pangkat_golongan">Pangkat / Golongan</label>
                <input type="text" id="pangkat_golongan" name="pangkat_golongan" value="{{ old('pangkat_golongan', $penandatangan->pangkat_golongan) }}" class="glass-input" placeholder="Contoh: Penata Muda / III-a">
                @error('pangkat_golongan')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Pengaturan --}}
        <div class="form-divider"></div>
        <div class="section-title">
            <i class="ri-settings-3-line"></i> Pengaturan
        </div>
        <div class="checkbox-group">
            <label class="checkbox-card">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $penandatangan->is_active) ? 'checked' : '' }}>
                <span class="checkbox-label">
                    <i class="ri-checkbox-circle-line active"></i> Aktif
                </span>
            </label>
            <label class="checkbox-card">
                <input type="checkbox" name="is_default" value="1" {{ old('is_default', $penandatangan->is_default) ? 'checked' : '' }}>
                <span class="checkbox-label">
                    <i class="ri-star-line default"></i> Jadikan Default
                </span>
            </label>
        </div>

        {{-- Status Info --}}
        <div style="margin-top: 1rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            @if($penandatangan->is_active)
            <span class="status-badge status-active">
                <i class="ri-checkbox-circle-line"></i> Status: Aktif
            </span>
            @else
            <span class="status-badge status-inactive">
                <i="ri-close-circle-line"></i> Status: Nonaktif
            </span>
            @endif
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="ri-save-line"></i> Update Penandatangan
            </button>
            <a href="{{ route('penandatangan.index') }}" class="btn-cancel">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection