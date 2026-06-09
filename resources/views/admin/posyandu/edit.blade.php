@extends('admin.layouts.app')

@section('title', 'Edit Posyandu - Admin Desa')

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
    .kader-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
        padding: 1rem;
        background: rgba(255,255,255,0.03);
        border-radius: 12px;
        border: 1px solid var(--border-glass);
    }
    .kader-row .kader-number {
        font-weight: 600;
        color: var(--primary);
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }
    @media (max-width: 768px) {
        .kader-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('posyandu.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Edit Posyandu</h2>
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
    <form action="{{ route('posyandu.update', $posyandu->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="kode_posyandu">Kode Posyandu <span class="required">*</span></label>
                <input type="text" id="kode_posyandu" name="kode_posyandu" value="{{ old('kode_posyandu', $posyandu->kode_posyandu) }}" placeholder="Contoh: PY-001" class="glass-select" style="width: 100%;" required>
                @error('kode_posyandu')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_posyandu">Nama Posyandu <span class="required">*</span></label>
                <input type="text" id="nama_posyandu" name="nama_posyandu" value="{{ old('nama_posyandu', $posyandu->nama_posyandu) }}" placeholder="Contoh: Posyandu Mawar" class="glass-select" style="width: 100%;" required>
                @error('nama_posyandu')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jorong">Jorong / Wilayah</label>
                <input type="text" id="jorong" name="jorong" value="{{ old('jorong', $posyandu->jorong) }}" placeholder="Contoh: Jorong Koto" class="glass-select" style="width: 100%;">
                @error('jorong')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select id="status" name="status" class="glass-select" style="width: 100%;" required>
                    <option value="aktif" {{ old('status', $posyandu->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $posyandu->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" class="glass-select" style="width: 100%; min-height: 80px;" placeholder="Masukkan alamat lengkap">{{ old('alamat', $posyandu->alamat) }}</textarea>
            @error('alamat')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="glass-select" style="width: 100%; min-height: 80px;" placeholder="Deskripsi singkat tentang pos yandu">{{ old('deskripsi', $posyandu->deskripsi) }}</textarea>
            @error('deskripsi')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <hr style="border: none; border-top: 1px solid var(--border-glass); margin: 2rem 0;">

        <h3 style="margin: 0 0 1rem 0;">Data Kader (Maksimal 5 Orang)</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Isikan nama kader yang bertugas di pos yandu ini. Kosongi jika tidak ada.</p>

        @php
            $existingKaders = $posyandu->kaders->toArray();
        @endphp

        @for($i = 0; $i < 5; $i++)
        <div class="kader-row">
            <div style="grid-column: 1 / -1;">
                <span class="kader-number">Kader {{ $i + 1 }}</span>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label for="kaders_{{ $i }}_nama_kader">Nama Kader</label>
                <input type="text" id="kaders_{{ $i }}_nama_kader" name="kaders[{{ $i }}][nama_kader]" value="{{ old('kaders.' . $i . '.nama_kader', $existingKaders[$i]['nama_kader'] ?? '') }}" placeholder="Nama lengkap" class="glass-select" style="width: 100%;">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label for="kaders_{{ $i }}_jabatan">Jabatan</label>
                <input type="text" id="kaders_{{ $i }}_jabatan" name="kaders[{{ $i }}][jabatan]" value="{{ old('kaders.' . $i . '.jabatan', $existingKaders[$i]['jabatan'] ?? '') }}" placeholder="Contoh: Ketua, Anggota" class="glass-select" style="width: 100%;">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label for="kaders_{{ $i }}_no_hp">No. HP</label>
                <input type="text" id="kaders_{{ $i }}_no_hp" name="kaders[{{ $i }}][no_hp]" value="{{ old('kaders.' . $i . '.no_hp', $existingKaders[$i]['no_hp'] ?? '') }}" placeholder="Contoh: 0812xxxx" class="glass-select" style="width: 100%;">
            </div>
        </div>
        @endfor

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Update
            </button>
            <a href="{{ route('posyandu.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
@endsection
