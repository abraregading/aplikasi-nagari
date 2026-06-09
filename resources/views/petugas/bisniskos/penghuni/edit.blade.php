@extends('petugas.layouts.app')
@section('title', 'Edit Penghuni')

@section('head')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .glass { background: rgba(255,255,255,.7); backdrop-filter: blur(10px); border-radius: 16px; padding: 2rem; border: 1px solid rgba(255,255,255,.8); }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; margin-bottom: .5rem; font-weight: 500; font-size: .9rem; }
    .form-control { width: 100%; padding: .75rem 1rem; border-radius: 10px; border: 1px solid rgba(0,0,0,.15); font-size: .95rem; background: rgba(255,255,255,.8); transition: all .2s; }
    .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,.15); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
    .btn { padding: .7rem 1.5rem; border-radius: 10px; font-size: .9rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: .5rem; transition: all .2s; border: none; cursor: pointer; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #0284c7; }
    .btn-secondary { background: rgba(107,114,128,.15); color: #4b5563; }
    .btn-secondary:hover { background: rgba(107,114,128,.25); }
    .alert { padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: .5rem; }
    .alert-danger { background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.3); color: #dc2626; }
    .required { color: red; }
    .info-box { background: rgba(14,165,233,.1); border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; }
    .info-box h4 { margin: 0 0 .5rem 0; font-size: 1rem; color: #0ea5e9; }
    .info-box p { margin: 0; font-size: .9rem; color: var(--text-muted); }
    @media(max-width:768px) { .form-row, .form-row-3 { grid-template-columns: 1fr; } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-edit-line" style="color: var(--primary)"></i> Edit Penghuni</h2>
    <a href="{{ route('petugas.bisniskos.penghuni.index', $bisnis->id) }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
</div>

<div class="info-box">
    <h4>{{ $bisnis->nama_usaha }}</h4>
    <p>{{ $bisnis->alamat }}</p>
</div>

<div class="glass">
    @if($errors->any())
    <div class="alert alert-danger">
        <i class="ri-error-warning-line"></i>
        <div>
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin: .5rem 0 0 1rem;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('petugas.bisniskos.penghuni.update', [$bisnis->id, $penghuni->id]) }}">
        @csrf
        @method('PUT')

        <h4 style="margin-bottom: 1rem; color: var(--primary);">Data Penghuni</h4>

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $penghuni->nama_lengkap) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik', $penghuni->nik) }}">
            </div>
            <div class="form-group">
                <label for="jekel">Jenis Kelamin</label>
                <select name="jekel" id="jekel" class="form-control">
                    <option value="">Pilih</option>
                    <option value="L" {{ old('jekel', $penghuni->jekel) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jekel', $penghuni->jekel) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>

        <div class="form-row-3">
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $penghuni->tempat_lahir) }}">
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $penghuni->tanggal_lahir) }}">
            </div>
            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="{{ old('pekerjaan', $penghuni->pekerjaan) }}">
            </div>
        </div>

        <div class="form-group">
            <label for="asal_desa">Alamat Asal (Desa/Kelurahan)</label>
            <input type="text" name="asal_desa" id="asal_desa" class="form-control" value="{{ old('asal_desa', $penghuni->asal_desa) }}">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="asal_kecamatan">Kecamatan</label>
                <input type="text" name="asal_kecamatan" id="asal_kecamatan" class="form-control" value="{{ old('asal_kecamatan', $penghuni->asal_kecamatan) }}">
            </div>
            <div class="form-group">
                <label for="asal_kabupaten">Kabupaten</label>
                <input type="text" name="asal_kabupaten" id="asal_kabupaten" class="form-control" value="{{ old('asal_kabupaten', $penghuni->asal_kabupaten) }}">
            </div>
        </div>

        <h4 style="margin: 1.5rem 0 1rem; color: var(--primary);">Informasi Kamar</h4>

        <div class="form-row">
            <div class="form-group">
                <label for="no_kamar">No. Kamar</label>
                <input type="text" name="no_kamar" id="no_kamar" class="form-control" value="{{ old('no_kamar', $penghuni->no_kamar) }}">
            </div>
            <div class="form-group">
                <label for="harga_sewa">Harga Sewa (Rp)</label>
                <input type="number" name="harga_sewa" id="harga_sewa" class="form-control" value="{{ old('harga_sewa', $penghuni->harga_sewa) }}" min="0">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tanggal_masuk">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', $penghuni->tanggal_masuk) }}">
            </div>
            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select name="status" id="status" class="form-control" required>
                    <option value="aktif" {{ old('status', $penghuni->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="pindah" {{ old('status', $penghuni->status) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                    <option value="keluar" {{ old('status', $penghuni->status) == 'keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="tanggal_keluar">Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" value="{{ old('tanggal_keluar', $penghuni->tanggal_keluar) }}">
        </div>

        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="2">{{ old('catatan', $penghuni->catatan) }}</textarea>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">
                <i class="ri-save-line"></i> Update
            </button>
            <a href="{{ route('petugas.bisniskos.penghuni.index', $bisnis->id) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection