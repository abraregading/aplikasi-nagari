@extends('operator.layouts.app')

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
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .page-header h2 i { color: var(--primary); font-size: 1.75rem; }
    .page-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    /* Search Bar */
    .search-bar {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .search-bar input {
        flex: 1;
        max-width: 400px;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,0.08);
        background: white;
        font-size: 0.9rem;
        color: #1f2937;
        outline: none;
        transition: all 0.2s ease;
    }
    .search-bar input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
    }
    .search-bar-wrapper {
        position: relative;
        flex: 1;
        max-width: 400px;
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

    /* Status Badges */
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

    /* Action Buttons */
    .action-btns {
        display: flex;
        gap: 6px;
    }
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.9rem;
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

    /* Empty */
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

    /* Summary Cards */
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

    @media (max-width: 768px) {
        thead th, tbody td {
            padding: 0.7rem 0.8rem;
            font-size: 0.8rem;
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

<!-- Summary Cards -->
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

<!-- Search -->
<form action="{{ route('buatsurat.riwayat') }}" method="GET" class="search-bar">
    <div class="search-bar-wrapper">
        <i class="ri-search-line"></i>
        <input type="text" name="search" placeholder="Cari berdasarkan NIK, nama, atau nomor surat..." value="{{ $search ?? '' }}">
    </div>
    <button type="submit" class="btn-search">
        <i class="ri-search-line"></i> Cari
    </button>
    @if($search)
    <a href="{{ route('buatsurat.riwayat') }}" class="btn-clear">
        <i class="ri-close-line"></i> Reset
    </a>
    @endif
</form>

<!-- Table -->
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
                            <a href="{{ route('buatsurat.cetak', $surat->id) }}" class="action-btn btn-cetak" title="Cetak Ulang" target="_blank">
                                <i class="ri-printer-line"></i>
                            </a>
                            @endif
                            <a href="{{ route('buatsurat.edit', $surat->id) }}" class="action-btn btn-detail" title="Lihat Detail">
                                <i class="ri-eye-line"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
