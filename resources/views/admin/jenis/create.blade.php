@extends('admin.layouts.app')

@section('title', 'Tambah Jenis Layanan Surat')

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
    .template-card {
        border: 2px solid var(--border-glass);
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }
    .template-card:hover {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.05);
    }
    .template-card.selected {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.1);
    }
    .template-card .check-icon {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    .template-card.selected .check-icon {
        display: flex;
    }
    .template-card .template-name {
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 4px;
    }
    .template-card .template-type {
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    .templates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
        margin-top: 0.5rem;
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('jenis-surat.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Tambah Jenis Layanan Surat</h2>
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
    <form action="{{ route('jenis-surat.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nama_layanan">Nama Jenis Layanan <span class="required">*</span></label>
            <input type="text" id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan') }}" placeholder="Contoh: Surat Keterangan Tidak Mampu" class="glass-select" style="width: 100%;" required>
            @error('nama_layanan')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" class="glass-select" rows="3" style="width: 100%; height: auto;" placeholder="Deskripsi singkat tentang jenis layanan ini...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="persyaratan">Persyaratan</label>
            <textarea id="persyaratan" name="persyaratan" class="glass-select" rows="3" style="width: 100%; height: auto;" placeholder="Persyaratan yang diperlukan untuk layanan ini...">{{ old('persyaratan') }}</textarea>
            @error('persyaratan')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="template_file">File Template Cetak</label>
            <input type="text" id="template_file" name="template_file" value="{{ old('template_file') }}" placeholder="Contoh: surat.penghasilan" class="glass-select" style="width: 100%;">
            <small style="color: var(--text-muted); font-size: 0.8rem;">Nama blade view untuk cetak, gunakan format titik (contoh: <code>surat.penghasilan</code>). Kosongkan untuk template default.</small>
            @error('template_file')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <input type="hidden" name="form_template" value="">
        @php
            $selectedTemplate = old('template_id');
        @endphp

        <div class="form-group">
            <label for="form_fields">Konfigurasi Form Field (JSON)</label>
            <textarea id="form_fields" name="form_fields" class="glass-select" rows="8" style="width: 100%; font-family: 'Courier New', monospace; font-size: 0.85rem;" placeholder='Contoh:
[
  {"name": "nama_siswa", "label": "Nama Siswa", "type": "text", "required": true},
  {"name": "nama_universitas", "label": "Nama Universitas", "type": "text", "required": true},
  {"name": "penghasilan_dari", "label": "Penghasilan Dari", "type": "number", "required": true},
  {"name": "penghasilan_sampai", "label": "Penghasilan Sampai", "type": "number", "required": true}
]'>{{ old('form_fields') }}</textarea>
            <small style="color: var(--text-muted); font-size: 0.8rem;">
                Isi JSON array untuk field tambahan. Tipe: <code>text</code>, <code>number</code>, <code>textarea</code>, <code>date</code>, <code>email</code>.
                Biarkan kosong jika tidak ada field khusus.
            </small>
            @error('form_fields')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Pilih Template Surat</label>
            <input type="hidden" name="template_id" id="template_id" value="{{ old('template_id') }}">

            @if($templates->count() > 0)
                <div class="templates-grid">
                    {{-- Opsi tanpa template --}}
                    <div class="template-card {{ old('template_id') == '' ? 'selected' : '' }}" onclick="selectTemplate(this, '', '', '')">
                        <div class="check-icon"><i class="ri-check-line"></i></div>
                        <div class="template-name" style="color: var(--text-muted);">
                            <i class="ri-close-circle-line"></i> Tanpa Template
                        </div>
                        <div class="template-type">Menggunakan form input & cetak default</div>
                    </div>

                    @foreach($templates as $template)
                    <div class="template-card {{ old('template_id') == $template->id ? 'selected' : '' }}" onclick="selectTemplate(this, '{{ $template->id }}', '{{ $template->form_template ?? '' }}', '{{ $template->cetak_template ?? '' }}')">
                        <div class="check-icon"><i class="ri-check-line"></i></div>
                        <div class="template-name">
                            <i class="ri-file-text-line" style="color: var(--primary);"></i>
                            {{ $template->nama_template }}
                        </div>
                        <div class="template-type">
                            @if($template->tipe)
                                <span style="background: rgba(99, 102, 241, 0.15); color: #818cf8; padding: 0.15rem 0.5rem; border-radius: 12px; font-size: 0.75rem;">
                                    {{ ucfirst($template->tipe) }}
                                </span>
                            @endif
                            @if($template->form_template)
                                <span style="margin-left: 4px; color: var(--text-muted); font-size: 0.75rem;">
                                    <i class="ri-input-field-line"></i> Form: {{ Str::afterLast($template->form_template, '.') }}
                                </span>
                            @else
                                <span style="margin-left: 4px; color: var(--text-muted); font-size: 0.75rem;">
                                    <i class="ri-input-field-line"></i> Form: Default
                                </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Info form & cetak yang akan digunakan --}}
                <div style="margin-top: 1rem; padding: 0.75rem 1rem; background: rgba(99, 102, 241, 0.08); border-radius: 10px; font-size: 0.85rem; color: var(--text-muted);">
                    <i class="ri-information-line" style="color: var(--primary);"></i>
                    <strong style="color: var(--text-main);">Info:</strong>
                    Form input & template cetak akan terisi <strong>otomatis</strong> berdasarkan template yang dipilih.
                </div>
            @else
                <div style="border: 2px dashed var(--border-glass); padding: 2rem; text-align: center; border-radius: 12px; color: var(--text-muted);">
                    <i class="ri-file-unknow-line" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                    <p style="margin: 0;">Belum ada template surat. <a href="{{ route('template-surat.create') }}" style="color: var(--primary);">Buat template baru</a></p>
                </div>
            @endif

            @error('template_id')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Simpan
            </button>
            <a href="{{ route('jenis-surat.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    function selectTemplate(card, id, formTemplate, cetakTemplate) {
        document.querySelectorAll('.template-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        document.getElementById('template_id').value = id;
        if (document.getElementById('form_template')) {
            document.getElementById('form_template').value = formTemplate;
        }
    }
</script>
@endsection
