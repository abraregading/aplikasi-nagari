
@extends('admin.layouts.app')

@section('title', 'Dashboard Import Data Penduduk')

@section('head')
<style>
        .form-section-title {
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            color: var(--primary);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding-bottom: 0.5rem;
        }
        
        /* Custom Checkbox */
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            margin-bottom: 0.5rem;
        }
        .checkbox-input {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid var(--text-muted);
            border-radius: 6px;
            position: relative;
            cursor: pointer;
            transition: 0.2s;
        }
        .checkbox-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .checkbox-input:checked::after {
            content: '\eb7b'; /* Remix Icon Check */
            font-family: 'remixicon';
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
        }

        /* Custom Radio */
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

        /* Toggle Switch */
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
@if(session('success'))
    <div class="alert alert-success" style="background:#e6ffed; color:#155724; border:1px solid #c3e6cb; padding:1rem; margin-bottom:1.5rem;">
        {!! session('success') !!}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger" style="background:#ffe6e6; color:#721c24; border:1px solid #f5c6cb; padding:1rem; margin-bottom:1.5rem;">
        {!! session('error') !!}
    </div>
@endif
<h2 style="margin-bottom: 2rem;">Import Data Massal dan Download Data</h2>
<p>Upload data keluarga dan penduduk secara masal menggunakan file CSV.</p><br>

<div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 2rem;">
    <h3 class="form-section-title" style="margin-bottom: 1rem;">Import Data Keluarga</h3>
    <div class="alert alert-warning" style="background:#fffbe6; color:#856404; border:1px solid #ffeeba; padding:1rem; margin-bottom:1.5rem;">
        <b>Petunjuk:</b> Download template CSV terlebih dahulu, isi data sesuai format, kemudian upload kembali.
    </div>
    <div style="display:flex; gap:1rem; align-items:center; margin-bottom:1rem;">
        <a href="{{ asset('admin/import_template_keluarga.csv') }}" class="glass-select" style="background: var(--secondary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500;">
            <i class="ri-download-2-line"></i> Download Template
        </a>
    </div>
    <form action="{{ route('import.keluarga') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1rem;">
            <label for="file_keluarga" class="glass-select" style="background: var(--secondary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500;">
                <i class="ri-file-2-line"></i> Pilih File CSV
            </label>
            <input id="file_keluarga" name="file" type="file" accept=".csv" style="display:none;">
            <span id="file_keluarga_name">Belum ada file dipilih</span>
        </div>
        <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500;"></i> Upload Data Keluarga
        </button>
    </form>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <h3 class="form-section-title" style="margin-bottom: 1rem;">Import Data Penduduk</h3>
    <div class="alert alert-warning" style="background:#fffbe6; color:#856404; border:1px solid #ffeeba; padding:1rem; margin-bottom:1.5rem;">
        <b>Petunjuk:</b> Pastikan data keluarga sudah di-import terlebih dahulu sebelum import data penduduk.
    </div>
    <div style="display:flex; gap:1rem; align-items:center; margin-bottom:1rem;">
        <a href="{{ asset('admin/import_template_penduduk.csv') }}" class="glass-select" style="background: var(--secondary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500;">
            <i class="ri-download-2-line"></i> Download Template
        </a>
    </div>
    <form action="{{ route('import.penduduk') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1rem;">
            <label for="file_penduduk" class="glass-select" style="background: var(--secondary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500;">
                <i class="ri-file-2-line"></i> Pilih File CSV
            </label>
            <input id="file_penduduk" name="file" type="file" accept=".csv" style="display:none;">
            <span id="file_penduduk_name">Belum ada file dipilih</span>
        </div>
        <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500;"></i> Upload Data Penduduk
        </button>
    </form>
    
</div>
<br><br>
<div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 2rem;">
    <h3 class="form-section-title" style="margin-bottom: 1rem;">Import Data SQL (Overwrite / Backup Restore)</h3>
    <div class="alert alert-danger" style="background:#fff0f0; color:#721c24; border:1px solid #f5c6cb; padding:1rem; margin-bottom:1.5rem;">
        <b>Peringatan!</b> Import SQL akan <b>MENGHAPUS dan MENIMPA</b> data yang ada di database. Proses ini tidak bisa dibatalkan. Pastikan Anda memiliki backup terlebih dahulu.
    </div>
    <div class="alert alert-warning" style="background:#fffbe6; color:#856404; border:1px solid #ffeeba; padding:1rem; margin-bottom:1.5rem;">
        <b>Petunjuk:</b> Upload file <code>.sql</code> hasil export dari menu <b>Export Data</b>. Bisa juga upload file <code>.zip</code> (hasil export All Tables) yang berisi banyak file <code>.sql</code>.
    </div>
    <form action="{{ route('import.sql') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1rem;">
            <label for="file_sql" class="glass-select" style="background: var(--danger, #dc3545); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; cursor: pointer;">
                <i class="ri-file-2-line"></i> Pilih File SQL / ZIP
            </label>
            <input id="file_sql" name="file_sql" type="file" accept=".sql,.zip,.txt" style="display:none;">
            <span id="file_sql_name">Belum ada file dipilih</span>
        </div>
        <button type="submit" class="glass-select" style="background: var(--danger, #dc3545); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500;">
            <i class="ri-upload-2-line"></i> Import & Timpa Data
        </button>
    </form>
</div>
<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <h3 class="form-section-title" style="margin-bottom: 1rem;">Download Data Penduduk</h3>
    <div class="alert alert-info" style="background:#e9f7fe; color:#0c5460; border:1px solid #b8daff; padding:1rem; margin-bottom:1.5rem;">
        Download data penduduk (format CSV).
    </div>
    <a href="{{ route('export.penduduk.csv') }}" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500;">
        <i class="ri-download-2-line"></i> Download Data Penduduk (CSV)
    </a>
</div>

<script>
// Tampilkan nama file yang dipilih
document.getElementById('file_keluarga').addEventListener('change', function(e) {
    document.getElementById('file_keluarga_name').textContent = e.target.files[0]?.name || 'Belum ada file dipilih';
});
document.getElementById('file_penduduk').addEventListener('change', function(e) {
    document.getElementById('file_penduduk_name').textContent = e.target.files[0]?.name || 'Belum ada file dipilih';
});
document.getElementById('file_sql').addEventListener('change', function(e) {
    document.getElementById('file_sql_name').textContent = e.target.files[0]?.name || 'Belum ada file dipilih';
});
</script>
@endsection