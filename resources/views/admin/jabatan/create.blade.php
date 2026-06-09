@extends('admin.layouts.app')

@section('title', 'Tambah Daftar Jabatan - Admin Desa')

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
    .template-card {
        border: 2px solid var(--border-glass);
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }
    .template-card:hover {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.05);
    }
    .template-card.selected {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.1);
    }
    .template-card .check-icon {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    .template-card.selected .check-icon {
        display: flex;
    }
    .template-card .template-name {
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 4px;
    }
    .template-card .template-type {
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    .templates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
        margin-top: 0.5rem;
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('jabatan.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Tambah Daftar Jabatan</h2>
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
    <form action="{{ route('jabatan.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nama_jabatan">Nama Jabatan <span class="required">*</span></label>
            <input type="text" id="nama_jabatan" name="nama_jabatan" value="{{ old('nama_jabatan') }}" placeholder="Contoh: Kepala Desa" class="glass-select" style="width: 100%;" required>
            @error('nama_jabatan')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Simpan
            </button>
            <a href="{{ route('jenis-surat.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    function selectTemplate(card, id) {
        // Remove selected from all cards
        document.querySelectorAll('.template-card').forEach(c => c.classList.remove('selected'));
        // Select this card
        card.classList.add('selected');
        // Set hidden input value
        document.getElementById('template_id').value = id;
    }
</script>
@endsection
