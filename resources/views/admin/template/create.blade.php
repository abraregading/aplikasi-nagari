@extends('admin.layouts.app')

@section('title', 'Tambah Template Surat')

@section('head')
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
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
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('template-surat.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Tambah Template Surat</h2>
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
    <form action="{{ route('template-surat.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nama_template">Nama Template <span class="required">*</span></label>
            <input type="text" id="nama_template" name="nama_template" value="{{ old('nama_template') }}" placeholder="Contoh: Surat Keterangan Umum" class="glass-select" style="width: 100%;" required>
            @error('nama_template')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="tipe">Tipe Surat</label>
                <div style="position: relative;">
                    <select id="tipe" name="tipe" class="glass-select" style="width: 100%;">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="keterangan" {{ old('tipe') == 'keterangan' ? 'selected' : '' }}>Surat Keterangan</option>
                        <option value="pengantar" {{ old('tipe') == 'pengantar' ? 'selected' : '' }}>Surat Pengantar</option>
                        <option value="pernyataan" {{ old('tipe') == 'pernyataan' ? 'selected' : '' }}>Surat Pernyataan</option>
                        <option value="rekomendasi" {{ old('tipe') == 'rekomendasi' ? 'selected' : '' }}>Surat Rekomendasi</option>
                        <option value="undangan" {{ old('tipe') == 'undangan' ? 'selected' : '' }}>Surat Undangan</option>
                        <option value="lainnya" {{ old('tipe') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <i class="ri-arrow-down-s-line" style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); pointer-events:none; color:var(--text-muted);"></i>
                </div>
                @error('tipe')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Status</label>
                <div style="display: flex; align-items: center; gap: 1rem; height: 44px;">
                    <label class="switch">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <span style="color: var(--text-main);">Aktif</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="glass-select" rows="3" style="width: 100%; height: auto;" placeholder="Deskripsi singkat tentang template surat ini...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="form_template">Form Input Template (Operator)</label>
                <select id="form_template" name="form_template" class="glass-select" style="width: 100%;">
                    <option value="">Default (Keterangan & Keperluan)</option>
                    <option value="operator.buatsurat.forms.surat-penghasilan" {{ old('form_template') == 'operator.buatsurat.forms.surat-penghasilan' ? 'selected' : '' }}>
                        Surat Keterangan Penghasilan
                    </option>
                </select>
                <small style="color: var(--text-muted); font-size: 0.8rem;">Pilih form input untuk operator saat membuat surat jenis ini.</small>
                @error('form_template')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="cetak_template">Template Cetak (Print)</label>
                <select id="cetak_template" name="cetak_template" class="glass-select" style="width: 100%;">
                    <option value="">Default (cetak standar)</option>
                    <option value="surat.penghasilan" {{ old('cetak_template') == 'surat.penghasilan' ? 'selected' : '' }}>
                        Surat Penghasilan
                    </option>
                </select>
                <small style="color: var(--text-muted); font-size: 0.8rem;">Pilih template untuk mencetak surat.</small>
                @error('cetak_template')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="isi_template">Isi Template <span class="required">*</span></label>
            <div style="background: rgba(255,255,255,0.05); border: 1px solid var(--border-glass); border-radius: 12px; overflow: hidden;">
                <textarea id="isi_template" name="isi_template" rows="20" style="width: 100%; min-height: 400px; padding: 1rem; background: transparent; border: none; color: var(--text-main); font-family: 'Courier New', monospace; font-size: 0.9rem; resize: vertical; outline: none;">{{ old('isi_template') }}</textarea>
            </div>
            <span style="display:block; font-size:0.8rem; color:var(--text-muted); margin-top:0.5rem;">
                <i class="ri-information-line"></i> Gunakan HTML untuk membuat template surat. Variabel yang tersedia: @verbatim<code>{{ $nama }}</code>, <code>{{ $nik }}</code>, <code>{{ $alamat }}</code>@endverbatim, dll.
            </span>
            @error('isi_template')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Simpan Template
            </button>
            <a href="{{ route('template-surat.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
@endsection
