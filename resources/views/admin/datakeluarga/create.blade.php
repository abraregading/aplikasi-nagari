@extends('admin.layouts.app')

@section('title', 'Tambah Data Keluarga - Admin Desa')

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
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('data-keluarga.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Tambah Data Keluarga</h2>
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
    <form action="{{ route('data-keluarga.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="no_kk">Nomor Kartu Keluarga <span class="required">*</span></label>
                <input type="text" id="no_kk" name="no_kk" value="{{ old('no_kk') }}" placeholder="Masukkan No. KK (16 digit)" class="glass-select" style="width: 100%;" required maxlength="20">
                @error('no_kk')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="kepala_keluarga_nik">NIK Kepala Keluarga</label>
                <input type="text" id="kepala_keluarga_nik" name="kepala_keluarga_nik" value="{{ old('kepala_keluarga_nik') }}" placeholder="Masukkan NIK Kepala Keluarga" class="glass-select" style="width: 100%;" maxlength="20">
                @error('kepala_keluarga_nik')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat <span class="required">*</span></label>
            <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" class="glass-select" style="width: 100%; min-height: 80px;" required>{{ old('alamat') }}</textarea>
            @error('alamat')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="rt">RT</label>
                <input type="text" id="rt" name="rt" value="{{ old('rt') }}" placeholder="Contoh: 001" class="glass-select" style="width: 100%;" maxlength="5">
                @error('rt')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="rw">RW</label>
                <input type="text" id="rw" name="rw" value="{{ old('rw') }}" placeholder="Contoh: 002" class="glass-select" style="width: 100%;" maxlength="5">
                @error('rw')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jorong">Jorong</label>
                <input type="text" id="jorong" name="jorong" value="{{ old('jorong') }}" placeholder="Nama Jorong" class="glass-select" style="width: 100%;" maxlength="50">
                @error('jorong')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="desa_kelurahan">Desa/Kelurahan (Kejorongan)</label>
                <input type="text" id="desa_kelurahan" name="desa_kelurahan" value="{{ old('desa_kelurahan') }}" placeholder="Masukkan nama desa/kelurahan" class="glass-select" style="width: 100%;" maxlength="50">
                @error('desa_kelurahan')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" placeholder="Masukkan kecamatan" class="glass-select" style="width: 100%;" maxlength="50">
                @error('kecamatan')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="kabupaten_kota">Kabupaten/Kota</label>
                <input type="text" id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota') }}" placeholder="Masukkan kabupaten/kota" class="glass-select" style="width: 100%;" maxlength="50">
                @error('kabupaten_kota')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <input type="text" id="provinsi" name="provinsi" value="{{ old('provinsi') }}" placeholder="Masukkan provinsi" class="glass-select" style="width: 100%;" maxlength="50">
                @error('provinsi')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="kode_pos">Kode Pos</label>
                <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" placeholder="Masukkan kode pos" class="glass-select" style="width: 100%;" maxlength="10">
                @error('kode_pos')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jumlah_anggota">Jumlah Anggota</label>
                <input type="number" id="jumlah_anggota" name="jumlah_anggota" value="{{ old('jumlah_anggota', 0) }}" placeholder="0" class="glass-select" style="width: 100%;" min="0">
                @error('jumlah_anggota')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="status">Status <span class="required">*</span></label>
            <select id="status" name="status" class="glass-select" style="width: 100%;" required>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="pindah" {{ old('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
            @error('status')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Simpan
            </button>
            <a href="{{ route('data-keluarga.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
@endsection
