@extends('kajor.layouts.app')

@section('title', 'Tambah Anggota Keluarga - ' . $keluarga->no_kk)

@section('head')
<style>
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; color: #999; font-size: 0.9rem; font-weight: 500; }
    .form-group label .required { color: #ef4444; margin-left: 2px; }
    .form-actions { margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; }
    .error-text { color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem; display: block; }
    .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }
    .info-kk { background: rgba(99, 102, 241, 0.1); padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; }
    .info-kk span { font-weight: 600; }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('kajor.keluarga.show', $keluarga->id) }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Tambah Anggota Keluarga</h2>
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

<div class="info-kk">
    <strong>No. KK:</strong> {{ $keluarga->no_kk }} &nbsp;|&nbsp;
    <strong>Alamat:</strong> {{ $keluarga->alamat }}
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <form action="{{ route('kajor.penduduk.store') }}" method="POST">
        @csrf

        <input type="hidden" name="no_kk" value="{{ $keluarga->no_kk }}">

        <div class="form-row">
            <div class="form-group">
                <label for="nik">NIK <span class="required">*</span></label>
                <input type="text" id="nik" name="nik" value="{{ old('nik') }}" placeholder="Masukkan NIK (16 digit)" class="glass-select" style="width: 100%;" required maxlength="20">
                @error('nik') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" class="glass-select" style="width: 100%;" required maxlength="100">
                @error('nama_lengkap') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Padang" class="glass-select" style="width: 100%;" maxlength="50">
                @error('tempat_lahir') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="glass-select" style="width: 100%;">
                @error('tanggal_lahir') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="glass-select" style="width: 100%;" required>
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="agama">Agama</label>
                <select id="agama" name="agama" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih --</option>
                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                </select>
                @error('agama') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="status_perkawinan">Status Perkawinan</label>
                <select id="status_perkawinan" name="status_perkawinan" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih --</option>
                    <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                    <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                    <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                    <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                </select>
                @error('status_perkawinan') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="hubungan_keluarga">Hubungan Keluarga</label>
                <select id="hubungan_keluarga" name="hubungan_keluarga" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih --</option>
                    <option value="Kepala Keluarga" {{ old('hubungan_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                    <option value="Istri" {{ old('hubungan_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                    <option value="Anak" {{ old('hubungan_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                    <option value="Menantu" {{ old('hubungan_keluarga') == 'Menantu' ? 'selected' : '' }}>Menantu</option>
                    <option value="Cucu" {{ old('hubungan_keluarga') == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                    <option value="Orang Tua" {{ old('hubungan_keluarga') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="Mertua" {{ old('hubungan_keluarga') == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                    <option value="Famili Lain" {{ old('hubungan_keluarga') == 'Famili Lain' ? 'selected' : '' }}>Famili Lain</option>
                    <option value="Lainnya" {{ old('hubungan_keluarga') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('hubungan_keluarga') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Contoh: Petani, PNS, Wiraswasta" class="glass-select" style="width: 100%;" maxlength="50">
                @error('pekerjaan') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                <select id="pendidikan_terakhir" name="pendidikan_terakhir" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih --</option>
                    <option value="Tidak/Belum Sekolah" {{ old('pendidikan_terakhir') == 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                    <option value="SD/Sederajat" {{ old('pendidikan_terakhir') == 'SD/Sederajat' ? 'selected' : '' }}>SD/Sederajat</option>
                    <option value="SMP/Sederajat" {{ old('pendidikan_terakhir') == 'SMP/Sederajat' ? 'selected' : '' }}>SMP/Sederajat</option>
                    <option value="SMA/Sederajat" {{ old('pendidikan_terakhir') == 'SMA/Sederajat' ? 'selected' : '' }}>SMA/Sederajat</option>
                    <option value="D1/D2/D3" {{ old('pendidikan_terakhir') == 'D1/D2/D3' ? 'selected' : '' }}>D1/D2/D3</option>
                    <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                    <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                    <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                </select>
                @error('pendidikan_terakhir') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" class="glass-select" style="width: 100%; min-height: 80px;">{{ old('alamat', $keluarga->alamat) }}</textarea>
            <small style="color: #888; font-size: 0.8rem;">Alamat otomatis dari data keluarga. Dapat diubah jika diperlukan.</small>
            @error('alamat') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Simpan
            </button>
            <a href="{{ route('kajor.keluarga.show', $keluarga->id) }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
