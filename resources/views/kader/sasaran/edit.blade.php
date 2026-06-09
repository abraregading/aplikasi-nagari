@extends('kader.layouts.app')

@section('title', 'Edit Sasaran Pos Yandu')

@section('head')
<style>
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem; font-weight: 500; }
    .form-group label .required { color: #ef4444; margin-left: 2px; }
    .form-actions { margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; }
    .error-text { color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem; display: block; }
    .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
    .info-card { background: rgba(255,255,255,0.05); border-radius: 12px; padding: 1rem; border: 1px solid var(--border-glass); margin-bottom: 1.5rem; }
    .info-card .label { font-size: 0.8rem; color: var(--text-muted); }
    .info-card .value { font-weight: 600; }

    @media (max-width: 480px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-actions {
            flex-direction: column;
        }
        .form-actions button,
        .form-actions a {
            justify-content: center;
            text-align: center;
            width: 100%;
        }
        #form-card {
            padding: 1rem !important;
        }
        .info-card > div {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('kader.sasaran.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Edit Sasaran</h2>
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

<div class="glass" style="padding: 2rem; border-radius: 16px;" id="form-card">
    <div class="info-card">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <div class="label">No. KK</div>
                <div class="value">{{ $sasaran->no_kk }}</div>
            </div>
            <div>
                <div class="label">KK Terdaftar</div>
                <div class="value">{{ $sasaran->keluarga ? 'Ya' : 'Tidak' }}</div>
            </div>
            <div>
                <div class="label">Data Penduduk</div>
                <div class="value">{{ $sasaran->penduduk ? 'Terdaftar' : 'Anggota Baru' }}</div>
            </div>
        </div>
    </div>

    <form action="{{ route('kader.sasaran.update', $sasaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $sasaran->nama_lengkap) }}" class="glass-select" style="width: 100%;" required>
                @error('nama_lengkap')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $sasaran->nik) }}" class="glass-select" style="width: 100%;" placeholder="16 digit NIK">
                @error('nik')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $sasaran->tempat_lahir) }}" class="glass-select" style="width: 100%;">
                @error('tempat_lahir')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $sasaran->tanggal_lahir ? $sasaran->tanggal_lahir->format('Y-m-d') : '') }}" class="glass-select" style="width: 100%;">
                @error('tanggal_lahir')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin', $sasaran->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $sasaran->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select id="status" name="status" class="glass-select" style="width: 100%;" required>
                    <option value="aktif" {{ old('status', $sasaran->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $sasaran->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="pindah" {{ old('status', $sasaran->status) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                </select>
                @error('status')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_ibu">Nama Ibu</label>
                <input type="text" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $sasaran->nama_ibu) }}" class="glass-select" style="width: 100%;" placeholder="Nama ibu kandung">
                @error('nama_ibu')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_ayah">Nama Ayah</label>
                <input type="text" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $sasaran->nama_ayah) }}" class="glass-select" style="width: 100%;" placeholder="Nama ayah">
                @error('nama_ayah')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea id="keterangan" name="keterangan" class="glass-select" style="width: 100%; min-height: 80px;" placeholder="Catatan tambahan (opsional)">{{ old('keterangan', $sasaran->keterangan) }}</textarea>
            @error('keterangan')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Update
            </button>
            <a href="{{ route('kader.sasaran.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
@endsection
