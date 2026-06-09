@extends('warga.layouts.app')

@section('title', 'Riwayat Permohonan Surat')

@section('head')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
    }
    .page-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    /* Search */
    .search-bar {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .search-bar input {
        width: 100%;
        max-width: 400px;
        padding: 0.7rem 1rem 0.7rem 2.5rem;
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,0.1);
        background: rgba(255,255,255,0.8);
        font-size: 0.9rem;
        font-family: 'Outfit', sans-serif;
        color: var(--text-main);
        outline: none;
        transition: all 0.3s;
    }
    .search-bar input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
    }
    .search-bar-wrapper {
        position: relative;
        flex: 1;
        min-width: 200px;
    }
    .search-bar-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }
    .btn-search {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        font-family: 'Outfit', sans-serif;
        transition: all 0.3s;
        min-height: 44px;
    }
    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
    }
    .btn-clear {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(0,0,0,0.05);
        color: var(--text-muted);
        border: 1px solid rgba(0,0,0,0.08);
        padding: 0.7rem 1.2rem;
        border-radius: 10px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        font-family: 'Outfit', sans-serif;
        transition: all 0.3s;
        min-height: 44px;
    }
    .btn-clear:hover {
        background: rgba(0,0,0,0.08);
    }

    /* Table */
    .table-container {
        border-radius: 16px;
        padding: 0;
        overflow: hidden;
    }
    .table-wrapper {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    thead {
        background: linear-gradient(135deg, rgba(14,165,233,0.08), rgba(99,102,241,0.05));
    }
    thead th {
        padding: 1rem 1.25rem;
        text-align: left;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    tbody tr {
        border-bottom: 1px solid rgba(0,0,0,0.04);
        transition: background 0.2s;
    }
    tbody tr:hover {
        background: rgba(14, 165, 233, 0.03);
    }
    tbody tr:last-child {
        border-bottom: none;
    }
    tbody td {
        padding: 0.9rem 1.25rem;
        font-size: 0.88rem;
        color: var(--text-main);
        vertical-align: middle;
    }
    .td-nama {
        font-weight: 600;
    }
    .td-nik {
        font-family: monospace;
        font-size: 0.82rem;
        color: var(--text-muted);
    }
    .td-date {
        font-size: 0.82rem;
        color: var(--text-muted);
        white-space: nowrap;
    }
    .td-nomor {
        font-family: monospace;
        font-size: 0.82rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-selesai  { background: rgba(34,197,94,0.12);  color: #16a34a; }
    .status-ditolak  { background: rgba(239,68,68,0.12);  color: #dc2626; }

    .action-btns {
        display: flex;
        gap: 8px;
    }
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        min-height: 40px;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1rem;
        text-decoration: none;
    }
    .action-btn:hover {
        transform: translateY(-2px);
    }
    .btn-cetak {
        background: rgba(34,197,94,0.12);
        color: #16a34a;
    }
    .btn-cetak:hover { background: rgba(34,197,94,0.25); }
    .btn-detail {
        background: rgba(14,165,233,0.12);
        color: #0284c7;
    }
    .btn-detail:hover { background: rgba(14,165,233,0.25); }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 0.75rem;
        opacity: 0.3;
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .summary-card {
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .summary-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .summary-icon.green {
        background: rgba(34,197,94,0.12);
        color: #16a34a;
    }
    .summary-icon.red {
        background: rgba(239,68,68,0.12);
        color: #dc2626;
    }
    .summary-info h3 {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
    }
    .summary-info p {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* ===== Mobile Card Layout ===== */
    .surat-card {
        display: none;
        background: var(--bg-glass);
        border: var(--border-glass);
        border-radius: 14px;
        padding: 1rem;
        margin-bottom: 0.75rem;
    }
    .surat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .surat-card-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.6rem;
        margin-bottom: 0.75rem;
    }
    .surat-card-field {
        grid-column: span 1;
    }
    .surat-card-field.full {
        grid-column: 1 / -1;
    }
    .surat-card-field .label {
        font-size: 0.7rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.15rem;
    }
    .surat-card-field .value {
        font-size: 0.88rem;
        font-weight: 500;
        color: var(--text-main);
        word-break: break-word;
    }
    .surat-card-footer {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    @media (max-width: 768px) {
        .table-wrapper table {
            display: none;
        }
        .surat-card {
            display: block;
        }
    }
</style>
@endsection

@section('konten')

<div class="page-header">
    <div>
        <h2><i class="ri-history-line" style="color: var(--primary); margin-right: 8px;"></i>Riwayat Permohonan</h2>
        <p>Daftar surat yang sudah selesai diproses atau ditolak</p>
    </div>
</div>

@php
    $selesaiCount = $suratList->where('status', 'selesai')->count();
    $ditolakCount = $suratList->where('status', 'ditolak')->count();
@endphp
<div class="summary-cards">
    <div class="summary-card glass">
        <div class="summary-icon green">
            <i class="ri-checkbox-circle-line"></i>
        </div>
        <div class="summary-info">
            <h3>{{ $selesaiCount }}</h3>
            <p>Surat Selesai</p>
        </div>
    </div>
    <div class="summary-card glass">
        <div class="summary-icon red">
            <i class="ri-close-circle-line"></i>
        </div>
        <div class="summary-info">
            <h3>{{ $ditolakCount }}</h3>
            <p>Surat Ditolak</p>
        </div>
    </div>
</div>

<form action="{{ route('buatsuratwarga.riwayat') }}" method="GET" class="search-bar">
    <div class="search-bar-wrapper">
        <i class="ri-search-line"></i>
        <input type="text" name="search" placeholder="Cari NIK, nama, atau nomor surat..." value="{{ $search ?? '' }}">
    </div>
    <button type="submit" class="btn-search">
        <i class="ri-search-line"></i> Cari
    </button>
    @if($search)
    <a href="{{ route('buatsuratwarga.riwayat') }}" class="btn-clear">
        <i class="ri-close-line"></i> Reset
    </a>
    @endif
</form>

<div class="table-container glass">
    <div class="table-wrapper">
        @if($suratList->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tgl Pengajuan</th>
                    <th>Tgl Selesai</th>
                    <th>NIK / Nama</th>
                    <th>Jenis Surat</th>
                    <th>Nomor Surat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suratList as $index => $surat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="td-date">{{ $surat->tanggal_pengajuan ? $surat->tanggal_pengajuan->format('d/m/Y') : '-' }}</td>
                    <td class="td-date">{{ $surat->tanggal_selesai ? $surat->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                    <td>
                        <div class="td-nama">{{ $surat->penduduk->nama_lengkap ?? '-' }}</div>
                        <div class="td-nik">{{ $surat->nik_pemohon }}</div>
                    </td>
                    <td>{{ $surat->jenis_surat }}</td>
                    <td class="td-nomor">{{ $surat->nomor_surat ?? '-' }}</td>
                    <td>
                        <span class="status-badge status-{{ $surat->status }}">
                            {{ ucfirst($surat->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            @if($surat->status === 'selesai')
                            <a href="{{ route('buatsuratwarga.cetak', $surat->id) }}" class="action-btn btn-cetak" title="Cetak Ulang" target="_blank">
                                <i class="ri-printer-line"></i>
                            </a>
                            @endif
                            <a href="{{ route('buatsuratwarga.edit', $surat->id) }}" class="action-btn btn-detail" title="Lihat Detail">
                                <i class="ri-eye-line"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Mobile Cards --}}
        @foreach($suratList as $index => $surat)
        <div class="surat-card">
            <div class="surat-card-header">
                <span class="status-badge status-{{ $surat->status }}">{{ ucfirst($surat->status) }}</span>
                <span class="td-date">{{ $surat->tanggal_pengajuan ? $surat->tanggal_pengajuan->format('d/m/Y') : '-' }}</span>
            </div>
            <div class="surat-card-body">
                <div class="surat-card-field full">
                    <div class="label">NIK / Nama</div>
                    <div class="value">{{ $surat->penduduk->nama_lengkap ?? '-' }} ({{ $surat->nik_pemohon }})</div>
                </div>
                <div class="surat-card-field">
                    <div class="label">Jenis Surat</div>
                    <div class="value">{{ $surat->jenis_surat }}</div>
                </div>
                <div class="surat-card-field">
                    <div class="label">Nomor Surat</div>
                    <div class="value">{{ $surat->nomor_surat ?? '-' }}</div>
                </div>
                <div class="surat-card-field">
                    <div class="label">Tanggal Selesai</div>
                    <div class="value">{{ $surat->tanggal_selesai ? $surat->tanggal_selesai->format('d/m/Y') : '-' }}</div>
                </div>
            </div>
            <div class="surat-card-footer">
                @if($surat->status === 'selesai')
                <a href="{{ route('buatsuratwarga.cetak', $surat->id) }}" class="action-btn btn-cetak" target="_blank"><i class="ri-printer-line"></i></a>
                @endif
                <a href="{{ route('buatsuratwarga.edit', $surat->id) }}" class="action-btn btn-detail"><i class="ri-eye-line"></i></a>
            </div>
        </div>
        @endforeach

        @else
        <div class="empty-state">
            <i class="ri-file-search-line"></i>
            <h3>Tidak Ada Data</h3>
            <p>{{ $search ? 'Pencarian "' . $search . '" tidak menemukan hasil.' : 'Belum ada riwayat permohonan surat.' }}</p>
        </div>
        @endif
    </div>
</div>

@endsection
