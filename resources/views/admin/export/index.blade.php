@extends('admin.layouts.app')

@section('title', 'Export Data')

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
    select.glass-select option {
        background: white;
        color: #333;
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

<h2 style="margin-bottom: 2rem;">Export Data (Backup)</h2>
<p>Export seluruh data atau tabel tertentu dalam format CSV atau SQL.</p><br>

<form action="{{ route('export-data.export') }}" method="POST">
    @csrf

    <div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 2rem;">
        <h3 class="form-section-title">Pilihan Export</h3>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.75rem; font-weight:500;">Tipe Export:</label>
            <label class="radio-container">
                <input type="radio" name="export_type" value="all" class="radio-input" checked onchange="toggleTableSelect()">
                <span>Semua Tabel</span>
            </label>
            <label class="radio-container">
                <input type="radio" name="export_type" value="specific" class="radio-input" onchange="toggleTableSelect()">
                <span>Tabel Tertentu</span>
            </label>
        </div>

        <div id="table-select-wrapper" style="margin-bottom: 1.5rem; display: none;">
            <label for="table" style="display:block; margin-bottom:0.5rem; font-weight:500;">Pilih Tabel:</label>
            <select name="table" id="table" class="glass-select" style="width:100%; max-width:400px; padding:0.8rem 1rem; border-radius:12px; border:1px solid rgba(0,0,0,0.1); background:var(--bg-card, white);">
                <option value="">-- Pilih Tabel --</option>
                @foreach($tables as $tbl)
                    <option value="{{ $tbl }}">{{ $tbl }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.75rem; font-weight:500;">Format File:</label>
            <label class="radio-container">
                <input type="radio" name="format" value="csv" class="radio-input" checked>
                <span>CSV <small style="color:var(--text-muted);">(dapat dibuka di Excel / Spreadsheet)</small></span>
            </label>
            <label class="radio-container">
                <input type="radio" name="format" value="sql" class="radio-input">
                <span>SQL <small style="color:var(--text-muted);">(struktur tabel + data, siap import)</small></span>
            </label>
        </div>

        <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; cursor: pointer;">
            <i class="ri-download-2-line"></i> Export Data
        </button>
    </div>
</form>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <h3 class="form-section-title" style="margin-bottom: 1rem;">Keterangan</h3>
    <ul style="line-height: 1.8; padding-left: 1.2rem;">
        <li><strong>CSV</strong> — File comma-separated values. Setiap tabel menjadi 1 file. Jika memilih semua tabel, akan didownload sebagai <strong>ZIP</strong>.</li>
        <li><strong>SQL</strong> — Berisi perintah <code>CREATE TABLE</code> + <code>INSERT INTO</code>. Cocok untuk restore database. Jika memilih semua tabel, akan didownload sebagai <strong>ZIP</strong>.</li>
        <li>Tabel sistem (sessions, cache, jobs, dll) <strong>tidak</strong> disertakan.</li>
    </ul>
</div>

<script>
function toggleTableSelect() {
    var val = document.querySelector('input[name="export_type"]:checked').value;
    document.getElementById('table-select-wrapper').style.display = val === 'specific' ? 'block' : 'none';
}
</script>
@endsection
