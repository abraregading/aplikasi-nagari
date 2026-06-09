@extends('operator.layouts.app')

@section('title', 'Edit Pengumuman')

@section('head')
<style>
    .form-section-title {
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
        color: var(--primary);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding-bottom: 0.5rem;
    }
    .radio-container {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        margin-bottom: 0.5rem;
    }
    .radio-input {
        appearance: none;
        width: 20px;
        height: 20px;
        border: 2px solid var(--text-muted);
        border-radius: 50%;
        position: relative;
        cursor: pointer;
        transition: 0.2s;
    }
    .radio-input:checked {
        border-color: var(--primary);
    }
    .radio-input:checked::after {
        content: '';
        width: 10px;
        height: 10px;
        background: var(--primary);
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 24px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: var(--text-muted);
        transition: .4s;
        border-radius: 24px;
        opacity: 0.5;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: var(--primary);
        opacity: 1;
    }
    input:checked + .slider:before {
        transform: translateX(24px);
    }
</style>
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Edit Pengumuman</h2>

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
    <h3 class="form-section-title">Informasi Pengumuman</h3>

    <form method="POST" action="{{ route('operator.pengumuman.update', $pengumuman->id) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Judul Pengumuman <span style="color:#ef4444;">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}" class="glass-select" style="width:100%;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Isi Pengumuman <span style="color:#ef4444;">*</span></label>
            <textarea name="isi" class="glass-select" rows="6" style="width:100%; height:auto;" required>{{ old('isi', $pengumuman->isi) }}</textarea>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Tipe Pengumuman <span style="color:#ef4444;">*</span></label>
            <label class="radio-container">
                <input type="radio" name="tipe" value="umum" class="radio-input" {{ old('tipe', $pengumuman->tipe) == 'umum' ? 'checked' : '' }} onchange="toggleTarget()">
                Umum (Semua Warga)
            </label>
            <label class="radio-container">
                <input type="radio" name="tipe" value="khusus" class="radio-input" {{ old('tipe', $pengumuman->tipe) == 'khusus' ? 'checked' : '' }} onchange="toggleTarget()">
                Khusus (Warga Tertentu)
            </label>
        </div>

        <div id="target-warga-field" style="margin-bottom: 1.5rem; {{ old('tipe', $pengumuman->tipe) == 'khusus' ? '' : 'display:none;' }}">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Target Warga <span style="color:#ef4444;">*</span></label>
            <select name="target_user_id" class="glass-select" style="width:100%;">
                <option value="">Pilih Warga</option>
                @foreach($warga as $w)
                <option value="{{ $w->id }}" {{ old('target_user_id', $pengumuman->target_user_id) == $w->id ? 'selected' : '' }}>
                    {{ $w->name }} ({{ $w->nik ?? '-' }})
                </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Status Aktif</label>
            <label class="switch">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $pengumuman->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
            <span style="margin-left: 0.5rem; font-size: 0.85rem; color: var(--text-muted);">Aktif</span>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Jadwal Tayang (kosongkan jika langsung tayang)</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', $pengumuman->published_at ? $pengumuman->published_at->format('Y-m-d\TH:i') : '') }}" class="glass-select" style="width:100%;">
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <a href="{{ route('operator.pengumuman.index') }}" class="glass-select" style="padding: 0.8rem 1.5rem; text-decoration:none; display:inline-flex; align-items:center; gap:.5rem; margin-right: 0.5rem;">
                <i class="ri-arrow-left-line"></i> Batal
            </a>
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; display:inline-flex; align-items:center; gap:.5rem; cursor:pointer;">
                <i class="ri-save-line"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    function toggleTarget() {
        const isKhusus = document.querySelector('input[name="tipe"]:checked').value === 'khusus';
        document.getElementById('target-warga-field').style.display = isKhusus ? 'block' : 'none';
    }
</script>
@endsection
