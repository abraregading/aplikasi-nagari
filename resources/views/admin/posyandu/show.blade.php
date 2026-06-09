@extends('admin.layouts.app')

@section('title', 'Detail Posyandu - Admin Desa')

@section('head')
<style>
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    .info-item {
        padding: 1rem;
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        border: 1px solid var(--border-glass);
    }
    .info-item .label {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 0.3rem;
    }
    .info-item .value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-main);
    }
    .kader-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }
    .kader-table th {
        text-align: left;
        padding: 0.75rem 1rem;
        color: var(--text-muted);
        font-size: 0.85rem;
        border-bottom: 1px solid var(--border-glass);
    }
    .kader-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-glass);
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('posyandu.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Detail Posyandu</h2>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
        <div>
            <h3 style="margin: 0 0 0.3rem 0;">{{ $posyandu->nama_posyandu }}</h3>
            <span style="font-size: 0.9rem; color: var(--text-muted);">{{ $posyandu->kode_posyandu }}</span>
        </div>
        <span style="display: inline-block; padding: 0.35rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500; {{ $posyandu->status == 'aktif' ? 'background: rgba(16, 185, 129, 0.15); color: #10b981;' : 'background: rgba(239, 68, 68, 0.15); color: #ef4444;' }}">
            {{ ucfirst($posyandu->status) }}
        </span>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <div class="label">Jorong / Wilayah</div>
            <div class="value">{{ $posyandu->jorong ?? '-' }}</div>
        </div>
        <div class="info-item">
            <div class="label">Alamat</div>
            <div class="value">{{ $posyandu->alamat ?? '-' }}</div>
        </div>
        <div class="info-item">
            <div class="label">Jumlah Kader</div>
            <div class="value">{{ $posyandu->kaders->count() }} Orang</div>
        </div>
        <div class="info-item">
            <div class="label">Tanggal Dibuat</div>
            <div class="value">{{ $posyandu->created_at->format('d F Y') }}</div>
        </div>
    </div>

    @if($posyandu->deskripsi)
    <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(255,255,255,0.05); border-radius: 12px; border: 1px solid var(--border-glass);">
        <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.3rem;">Deskripsi</div>
        <div style="color: var(--text-main);">{{ $posyandu->deskripsi }}</div>
    </div>
    @endif
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <h3 style="margin: 0 0 1rem 0;">Daftar Kader</h3>

    @if($posyandu->kaders->count() > 0)
    <table class="kader-table">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="35%">Nama Kader</th>
                <th width="30%">Jabatan</th>
                <th width="25%">No. HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posyandu->kaders as $index => $kader)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="font-weight: 600;">{{ $kader->nama_kader }}</td>
                <td>{{ $kader->jabatan ?? '-' }}</td>
                <td>{{ $kader->no_hp ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p style="color: var(--text-muted);">Belum ada kader terdaftar.</p>
    @endif

    <div style="margin-top: 1.5rem;">
        <a href="{{ route('posyandu.edit', $posyandu->id) }}" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.7rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="ri-edit-line"></i> Edit Posyandu
        </a>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
@endsection
