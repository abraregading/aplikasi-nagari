@extends('admin.layouts.app')

@section('title', 'Tambah API User')

@section('konten')
<h2 style="margin-bottom: 2rem;">Tambah API User</h2>

@if($errors->any())
<div class="alert alert-danger" style="margin-bottom: 1rem;">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <form action="{{ route('api-user.store') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="name">Nama User <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="glass-input" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" class="glass-input" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input type="password" id="password" name="password" class="glass-input" required minlength="8">
            </div>

            <div class="form-group">
                <label for="app_name">Nama Aplikasi <span class="required">*</span></label>
                <input type="text" id="app_name" name="app_name" class="glass-input" value="{{ old('app_name') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="app_description">Deskripsi Aplikasi</label>
            <textarea id="app_description" name="app_description" class="glass-input" rows="3">{{ old('app_description') }}</textarea>
        </div>

        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn" style="background: var(--primary); color: white; padding: 0.75rem 2rem; border-radius: 8px;">
                <i class="ri-save-line"></i> Simpan
            </button>
            <a href="{{ route('api-user.index') }}" class="btn" style="background: #6b7280; color: white; padding: 0.75rem 2rem; border-radius: 8px; margin-left: 0.5rem;">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

<style>
.glass-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    background: rgba(255,255,255,0.05);
    color: var(--text);
    font-size: 0.95rem;
}
.glass-input:focus {
    outline: none;
    border-color: var(--primary);
    background: rgba(255,255,255,0.1);
}
.required {
    color: #ef4444;
}
</style>