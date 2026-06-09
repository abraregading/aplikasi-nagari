@extends('admin.layouts.app')

@section('title', 'Edit Staf - Admin Desa')

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
    .preview-image {
        max-width: 200px;
        border-radius: 8px;
        margin-top: 0.5rem;
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('staf.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Edit Staf</h2>
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
    <form action="{{ route('staf.update', $staf->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="search_penduduk">Cari Nama/NIK Penduduk</label>
                    <input type="text" id="search_penduduk" class="glass-select" style="width: 100%; margin-bottom: 0.7rem;" placeholder="Ketik nama atau NIK penduduk..." onkeyup="filterPenduduk()">
                    <label for="nama_staf">Nama Staf <span class="required">*</span></label>
                    <select name="penduduk_id" id="penduduk_select" class="glass-select" style="width: 100%;">
                        <option>Pilih Nama Penduduk</option>
                        @foreach($penduduk as $data)
                        <option value="{{ $data->id }}" data-nama="{{ strtolower($data->nama_lengkap) }}" data-nik="{{ strtolower($data->nik ?? '') }}"
                            {{ $staf->penduduk_id == $data->id ? 'selected' : '' }}>
                            {{ $data->nama_lengkap }} @if($data->nik) ({{ $data->nik }}) @endif
                        </option>
                        @endforeach
                    </select>

                    <label for="jabatan_id">Nama Jabatan <span class="required">*</span></label>
                        <select name="jabatan_id" class="glass-select" style="width: 100%;">
                            <option>Pilih Nama Jabatan</option>
                            @foreach($jabatan as $data)
                            <option value="{{ $data->id }}" {{ $staf->jabatan_id == $data->id ? 'selected' : '' }}>
                                {{ $data->nama_jabatan }}
                            </option>
                            @endforeach
                        </select>
                    @error('nama_staf')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                    <label for="nama_staf">Foto Staf</label>
                    <input type="file" id="gambar" name="gambar" class="glass-select" style="width: 100%; padding: 0.5rem;">
                    @if($staf->gambar)
                        <img src="{{ asset($staf->gambar) }}" alt="Foto Staf" class="preview-image">
                    @endif
                    @error('nama_staf')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="profil">Profil <span class="required"></span></label>
                    <input type="text" id="profil" name="profil" value="{{ old('profil', $staf->profil) }}" placeholder="Isikan profil staf disini.." class="glass-select" style="width: 100%;">
                    @error('profil')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Simpan
            </button>
            <a href="{{ route('staf.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    function filterPenduduk() {
        var input = document.getElementById('search_penduduk');
        var filter = input.value.toLowerCase();
        var select = document.getElementById('penduduk_select');
        var options = select.options;
        for (var i = 0; i < options.length; i++) {
            var nama = options[i].getAttribute('data-nama') || '';
            var nik = options[i].getAttribute('data-nik') || '';
            if (i === 0) {
                options[i].style.display = '';
                continue;
            }
            if (nama.includes(filter) || nik.includes(filter)) {
                options[i].style.display = '';
            } else {
                options[i].style.display = 'none';
            }
        }
    }
</script>
@endsection
