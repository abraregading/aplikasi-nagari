@extends('kajor.layouts.app')

@section('title', 'Edit Data Meninggal - ' . $data->nama_lengkap)

@section('head')
<style>
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem; font-weight: 500; }
    .form-group label .required { color: #ef4444; margin-left: 2px; }
    .form-actions { margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; }
    .error-text { color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem; display: block; }
    .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('kajor.meninggal.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Edit Data Meninggal</h2>
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
    <form action="{{ route('kajor.meninggal.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="penduduk_id" name="penduduk_id" value="{{ old('penduduk_id', $data->penduduk_id) }}">

        <div class="form-row">
            <div class="form-group">
                <label for="nik">NIK <span class="required">*</span></label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $data->nik) }}" placeholder="NIK" class="glass-select" style="width: 100%;" required maxlength="20">
                @error('nik') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $data->nama_lengkap) }}" placeholder="Nama lengkap" class="glass-select" style="width: 100%;" required maxlength="100">
                @error('nama_lengkap') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="glass-select" style="width: 100%;" required>
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin', $data->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $data->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $data->tanggal_lahir ? $data->tanggal_lahir->format('Y-m-d') : '') }}" class="glass-select" style="width: 100%;">
                @error('tanggal_lahir') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="no_kk">No. KK</label>
            <input type="text" id="no_kk" name="no_kk" value="{{ old('no_kk', $data->no_kk) }}" placeholder="Nomor Kartu Keluarga" class="glass-select" style="width: 100%;" maxlength="20">
            @error('no_kk') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tanggal_meninggal">Tanggal Meninggal <span class="required">*</span></label>
                <input type="date" id="tanggal_meninggal" name="tanggal_meninggal" value="{{ old('tanggal_meninggal', $data->tanggal_meninggal->format('Y-m-d')) }}" class="glass-select" style="width: 100%;" required>
                @error('tanggal_meninggal') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="waktu_meninggal">Waktu Meninggal</label>
                <input type="time" id="waktu_meninggal" name="waktu_meninggal" value="{{ old('waktu_meninggal', $data->waktu_meninggal ? $data->waktu_meninggal->format('H:i') : '') }}" class="glass-select" style="width: 100%;">
                @error('waktu_meninggal') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tempat_meninggal">Tempat Meninggal</label>
                <input type="text" id="tempat_meninggal" name="tempat_meninggal" value="{{ old('tempat_meninggal', $data->tempat_meninggal) }}" placeholder="Contoh: Rumah, RSUD, dll" class="glass-select" style="width: 100%;" maxlength="100">
                @error('tempat_meninggal') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="sebab_meninggal">Sebab Meninggal</label>
                <input type="text" id="sebab_meninggal" name="sebab_meninggal" value="{{ old('sebab_meninggal', $data->sebab_meninggal) }}" placeholder="Penyebab kematian" class="glass-select" style="width: 100%;" maxlength="200">
                @error('sebab_meninggal') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="status_hubungan">Status Hubungan dalam KK</label>
                <select id="status_hubungan" name="status_hubungan" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih Hubungan --</option>
                    <option value="Kepala Keluarga" {{ old('status_hubungan', $data->status_hubungan) == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                    <option value="Istri" {{ old('status_hubungan', $data->status_hubungan) == 'Istri' ? 'selected' : '' }}>Istri</option>
                    <option value="Anak" {{ old('status_hubungan', $data->status_hubungan) == 'Anak' ? 'selected' : '' }}>Anak</option>
                    <option value="Menantu" {{ old('status_hubungan', $data->status_hubungan) == 'Menantu' ? 'selected' : '' }}>Menantu</option>
                    <option value="Cucu" {{ old('status_hubungan', $data->status_hubungan) == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                    <option value="Orang Tua" {{ old('status_hubungan', $data->status_hubungan) == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="Mertua" {{ old('status_hubungan', $data->status_hubungan) == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                    <option value="Famili Lain" {{ old('status_hubungan', $data->status_hubungan) == 'Famili Lain' ? 'selected' : '' }}>Famili Lain</option>
                    <option value="Lainnya" {{ old('status_hubungan', $data->status_hubungan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('status_hubungan') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="no_hp_saksi">No. HP Saksi</label>
                <input type="text" id="no_hp_saksi" name="no_hp_saksi" value="{{ old('no_hp_saksi', $data->no_hp_saksi) }}" placeholder="Nomor HP saksi" class="glass-select" style="width: 100%;" maxlength="20">
                @error('no_hp_saksi') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="nama_saksi">Nama Saksi</label>
            <input type="text" id="nama_saksi" name="nama_saksi" value="{{ old('nama_saksi', $data->nama_saksi ?? $authUser->name) }}" placeholder="Nama saksi" class="glass-select" style="width: 100%;" maxlength="100">
            @error('nama_saksi') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea id="keterangan" name="keterangan" placeholder="Keterangan tambahan..." class="glass-select" style="width: 100%; min-height: 80px;">{{ old('keterangan', $data->keterangan) }}</textarea>
            @error('keterangan') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Update
            </button>
            <a href="{{ route('kajor.meninggal.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
