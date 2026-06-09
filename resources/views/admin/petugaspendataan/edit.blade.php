@extends('admin.layouts.app')

@section('title', 'Edit Petugas Pendataan')

@section('head')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-header h2 { margin: 0; }
    .glass { background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border-radius: 16px; padding: 2rem; border: 1px solid rgba(255,255,255,0.8); }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; }
    .form-control { width: 100%; padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid rgba(0,0,0,0.15); font-size: 0.95rem; background: rgba(255,255,255,0.8); transition: all 0.2s; }
    .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,0.15); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .btn { padding: 0.7rem 1.5rem; border-radius: 10px; font-size: 0.9rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s; border: none; cursor: pointer; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #0284c7; }
    .btn-secondary { background: rgba(107,114,128,0.15); color: #4b5563; }
    .btn-secondary:hover { background: rgba(107,114,128,0.25); }
    .error-msg { color: #dc2626; font-size: 0.8rem; margin-top: 0.25rem; }
    .alert { padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
    .alert-danger { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #dc2626; }
    .note { font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem; }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-edit-line" style="color: var(--primary)"></i> Edit Petugas Pendataan</h2>
    <a href="{{ route('admin.petugaspendataan.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
</div>

<div class="glass">
    @if($errors->any())
    <div class="alert alert-danger">
        <i class="ri-error-warning-line"></i>
        <div>
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin: 0.5rem 0 0 1rem;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.petugaspendataan.update', $petugas->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Lengkap <span style="color: red;">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $petugas->name) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="username">Username <span style="color: red;">*</span></label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $petugas->username) }}" required>
                <div class="note">Hanya huruf, angka, dan underscore</div>
            </div>
            <div class="form-group">
                <label for="email">Email <span style="color: red;">*</span></label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $petugas->email) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik', $petugas->nik) }}">
            </div>
            <div class="form-group">
                <label for="no_telepon">No. Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $petugas->no_telepon) }}">
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $petugas->alamat) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                <div class="note">Minimal 6 karakter</div>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>
        </div>

        <div class="form-group">
            <label for="status">Status <span style="color: red;">*</span></label>
            <select name="status" id="status" class="form-control" required>
                <option value="active" {{ old('status', $petugas->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status', $petugas->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">
                <i class="ri-save-line"></i> Update
            </button>
            <a href="{{ route('admin.petugaspendataan.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection