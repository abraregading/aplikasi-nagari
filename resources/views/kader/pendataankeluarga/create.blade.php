@extends('petugas.layouts.app')
@section('title', 'Tambah Kartu Keluarga')

@section('head')
<style>
    .page-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .form-section { margin-bottom: 1.5rem; }
    .form-section h3 { font-size: 1rem; margin-bottom: 1rem; color: var(--primary); }
    .form-grid { display: grid; gap: 1rem; }
    .form-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
    .form-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }
    @media(max-width: 768px) { .form-grid.cols-2, .form-grid.cols-3 { grid-template-columns: 1fr; } }
    .form-group { display: flex; flex-direction: column; gap: .4rem; }
    .form-group label { font-size: .9rem; font-weight: 500; color: var(--text-muted); }
    .form-group label .required { color: #dc2626; }
    .form-input {
        padding: .7rem 1rem;
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,.12);
        background: rgba(255,255,255,.7);
        color: var(--text-main);
        font-size: .95rem;
        font-family: inherit;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,.12); }
    .form-input::placeholder { color: var(--text-muted); }
    select.form-input { cursor: pointer; }
    textarea.form-input { resize: vertical; min-height: 80px; }
    .btn { padding: .8rem 1.5rem; border-radius: 10px; font-weight: 600; font-size: .9rem; text-decoration: none; display: inline-flex; align-items: center; gap: .5rem; transition: all .2s; cursor: pointer; border: none; font-family: inherit; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #0284c7; }
    .btn-secondary { background: transparent; color: var(--text-main); border: 1px solid rgba(0,0,0,.15); }
    .btn-secondary:hover { background: rgba(0,0,0,.03); }
    .btn-group { display: flex; gap: 1rem; margin-top: 1.5rem; }
    .alert { padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; }
    .alert-error { background: rgba(239,68,68,.08); border: 1px solid rgba(239,68,68,.2); color: #dc2626; }
    .alert ul { margin: .5rem 0 0 1.5rem; }
</style>
@endsection

@section('konten')
<div class="page-header">
    <a href="{{ route('petugas.pendataankeluarga.index') }}" class="glass-select" style="background: transparent; border: 1px solid var(--text-muted); padding: .5rem 1rem; color: var(--text-main); text-decoration: none;">
        <i class="ri-arrow-left-line"></i>
    </a>
    <h2>Tambah Data Kartu Keluarga</h2>
</div>

@if($errors->any())
<div class="alert alert-error">
    <i class="ri-error-warning-line"></i> Terdapat kesalahan:
    <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="glass" style="padding: 1.5rem; border-radius: 16px;">
    <form action="{{ route('petugas.pendataankeluarga.store') }}" method="POST">
        @csrf
        <div class="form-section">
            <h3><i class="ri-home-line"></i> Informasi Kartu Keluarga</h3>
            <div class="form-grid cols-2">
                <div class="form-group">
                    <label>No. KK <span class="required">*</span></label>
                    <input type="text" name="no_kk" class="form-input" value="{{ old('no_kk') }}" placeholder="16 digit No. KK" maxlength="16" required>
                </div>
                <div class="form-group">
                    <label>NIK Kepala Keluarga</label>
                    <input type="text" name="kepala_keluarga_nik" class="form-input" value="{{ old('kepala_keluarga_nik') }}" placeholder="NIK Kepala Keluarga" maxlength="20">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Alamat <span class="required">*</span></label>
                    <textarea name="alamat" class="form-input" placeholder="Alamat lengkap" required>{{ old('alamat') }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3><i class="ri-map-pin-line"></i> Wilayah</h3>
            <div class="form-grid cols-3">
                <div class="form-group">
                    <label>Jorong</label>
                    <input type="text" name="jorong" class="form-input" value="{{ old('jorong') }}" placeholder="Jorong" maxlength="5">
                </div>
                <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" name="kode_pos" class="form-input" value="{{ old('kode_pos') }}" placeholder="Kode Pos" maxlength="10">
                </div>
                <div class="form-group">
                    <label>Desa/Kelurahan</label>
                    <input type="text" name="desa_kelurahan" class="form-input" value="{{ old('desa_kelurahan') }}" placeholder="Desa/Kelurahan">
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-input" value="{{ old('kecamatan') }}" placeholder="Kecamatan">
                </div>
                <div class="form-group">
                    <label>Kabupaten/Kota</label>
                    <input type="text" name="kabupaten_kota" class="form-input" value="{{ old('kabupaten_kota') }}" placeholder="Kabupaten/Kota">
                </div>
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" name="provinsi" class="form-input" value="{{ old('provinsi') }}" placeholder="Provinsi">
                </div>
                <div class="form-group">
                    <label>Jumlah Anggota</label>
                    <input type="number" name="jumlah_anggota" class="form-input" value="{{ old('jumlah_anggota', 0) }}" min="0">
                </div>
                <div class="form-group">
                    <label>Status <span class="required">*</span></label>
                    <select name="status" class="form-input" required>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="pindah" {{ old('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                        <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Simpan Data</button>
            <a href="{{ route('petugas.pendataankeluarga.index') }}" class="btn btn-secondary"><i class="ri-close-line"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
