@extends('operator.layouts.app')

@section('title', 'Edit Penerima BLT Nagari')

@section('head')
<style>
    .form-section-title {
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
        color: var(--primary);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding-bottom: 0.5rem;
    }
</style>
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Edit Penerima BLT Nagari</h2>

@if($errors->any())
<div style="background: #fee; border: 1px solid #fcc; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
    <strong style="color: #c00;">Terjadi kesalahan:</strong>
    <ul style="margin: 0.5rem 0 0 1rem; color: #c00;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <h3 class="form-section-title">Data Penerima</h3>

    <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(99,102,241,0.05); border-radius: 8px; border-left: 3px solid var(--primary);">
        <strong>Penerima:</strong> {{ $data->nama }} (NIK: {{ $data->nik }})
    </div>

    <form method="POST" action="{{ route('operator.blt-nagari.update', $data->id) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">NIK <span style="color:#ef4444;">*</span></label>
            <input type="text" name="nik" value="{{ old('nik', $data->nik) }}" class="glass-select" style="width:100%;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Nama Lengkap <span style="color:#ef4444;">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $data->nama) }}" class="glass-select" style="width:100%;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">No KK</label>
            <input type="text" name="no_kk" value="{{ old('no_kk', $data->no_kk) }}" class="glass-select" style="width:100%;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $data->tempat_lahir) }}" class="glass-select" style="width:100%;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $data->tanggal_lahir ? $data->tanggal_lahir->format('Y-m-d') : '') }}" class="glass-select" style="width:100%;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Alamat (Jalan)</label>
            <textarea name="alamat_jalan" class="glass-select" rows="2" style="width:100%; height:auto;">{{ old('alamat_jalan', $data->alamat_jalan) }}</textarea>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Jorong</label>
            <input type="text" name="alamat_jorong" value="{{ old('alamat_jorong', $data->alamat_jorong) }}" class="glass-select" style="width:100%;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Pekerjaan</label>
            <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $data->pekerjaan) }}" class="glass-select" style="width:100%;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Jumlah Anggota Keluarga</label>
            <input type="number" name="jumlah_anggota_keluarga" value="{{ old('jumlah_anggota_keluarga', $data->jumlah_anggota_keluarga) }}" class="glass-select" style="width:200px;">
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <a href="{{ route('operator.blt-nagari.index') }}" class="glass-select" style="padding: 0.8rem 1.5rem; text-decoration:none; display:inline-flex; align-items:center; gap:.5rem; margin-right: 0.5rem;">
                <i class="ri-arrow-left-line"></i> Batal
            </a>
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; display:inline-flex; align-items:center; gap:.5rem; cursor:pointer;">
                <i class="ri-save-line"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
