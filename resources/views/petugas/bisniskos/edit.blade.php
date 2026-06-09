@extends('petugas.layouts.app')
@section('title', 'Edit Usaha Kos/Kontrakan')

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
    @media(max-width:768px) { .form-row, .form-row-3 { grid-template-columns: 1fr; } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-edit-line" style="color: var(--primary)"></i> Edit Usaha Kos/Kontrakan</h2>
    <a href="{{ route('petugas.bisniskos.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
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

    <form method="POST" action="{{ route('petugas.bisniskos.update', $bisnis->id) }}">
        @csrf
        @method('PUT')

        <h4 style="margin-bottom: 1rem; color: var(--primary);">Informasi Usaha</h4>
        
        <div class="form-group">
            <label for="nama_usaha">Nama Usaha <span class="required">*</span></label>
            <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" value="{{ old('nama_usaha', $bisnis->nama_usaha) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jenis_usaha">Jenis Usaha <span class="required">*</span></label>
                <select name="jenis_usaha" id="jenis_usaha" class="form-control" required>
                    <option value="kos" {{ old('jenis_usaha', $bisnis->jenis_usaha) == 'kos' ? 'selected' : '' }}>Kos</option>
                    <option value="kontrakan" {{ old('jenis_usaha', $bisnis->jenis_usaha) == 'kontrakan' ? 'selected' : '' }}>Kontrakan</option>
                    <option value="rumah_petak" {{ old('jenis_usaha', $bisnis->jenis_usaha) == 'rumah_petak' ? 'selected' : '' }}>Rumah Petak</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jumlah_kamar">Jumlah Kamar</label>
                <input type="number" name="jumlah_kamar" id="jumlah_kamar" class="form-control" value="{{ old('jumlah_kamar', $bisnis->jumlah_kamar) }}" min="0">
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat <span class="required">*</span></label>
            <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat', $bisnis->alamat) }}</textarea>
        </div>

        <div class="form-row-3">
            <div class="form-group">
                <label for="rt">RT</label>
                <input type="text" name="rt" id="rt" class="form-control" value="{{ old('rt', $bisnis->rt) }}">
            </div>
            <div class="form-group">
                <label for="rw">RW</label>
                <input type="text" name="rw" id="rw" class="form-control" value="{{ old('rw', $bisnis->rw) }}">
            </div>
            <div class="form-group">
                <label for="desa_kelurahan">Desa/Kelurahan</label>
                <input type="text" name="desa_kelurahan" id="desa_kelurahan" class="form-control" value="{{ old('desa_kelurahan', $bisnis->desa_kelurahan) }}">
            </div>
        </div>

        <div class="form-group">
            <label for="fasilitas">Fasilitas</label>
            <input type="text" name="fasilitas" id="fasilitas" class="form-control" value="{{ old('fasilitas', $bisnis->fasilitas) }}">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="harga_sewa_min">Harga Sewa Min (Rp)</label>
                <input type="number" name="harga_sewa_min" id="harga_sewa_min" class="form-control" value="{{ old('harga_sewa_min', $bisnis->harga_sewa_min) }}" min="0">
            </div>
            <div class="form-group">
                <label for="harga_sewa_max">Harga Sewa Max (Rp)</label>
                <input type="number" name="harga_sewa_max" id="harga_sewa_max" class="form-control" value="{{ old('harga_sewa_max', $bisnis->harga_sewa_max) }}" min="0">
            </div>
        </div>

        <h4 style="margin: 1.5rem 0 1rem; color: var(--primary);">Informasi Pemilik</h4>

        <div class="form-row">
            <div class="form-group">
                <label for="pemilik_nama">Nama Pemilik <span class="required">*</span></label>
                <input type="text" name="pemilik_nama" id="pemilik_nama" class="form-control" value="{{ old('pemilik_nama', $bisnis->pemilik_nama) }}" required>
            </div>
            <div class="form-group">
                <label for="pemilik_nik">NIK Pemilik</label>
                <input type="text" name="pemilik_nik" id="pemilik_nik" class="form-control" value="{{ old('pemilik_nik', $bisnis->pemilik_nik) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="pemilik_telepon">No. Telepon</label>
                <input type="text" name="pemilik_telepon" id="pemilik_telepon" class="form-control" value="{{ old('pemilik_telepon', $bisnis->pemilik_telepon) }}">
            </div>
            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select name="status" id="status" class="form-control" required>
                    <option value="aktif" {{ old('status', $bisnis->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $bisnis->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="2">{{ old('catatan', $bisnis->catatan) }}</textarea>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">
                <i class="ri-save-line"></i> Update
            </button>
            <a href="{{ route('petugas.bisniskos.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection