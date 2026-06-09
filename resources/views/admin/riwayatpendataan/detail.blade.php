@extends('admin.layouts.app')

@section('title', 'Detail Riwayat - ' . $petugas->name)

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
    .page-title {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .page-title h2 {
        margin: 0;
        font-size: 1.5rem;
        color: var(--text-main);
    }
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1rem;
        background: transparent;
        color: var(--text-muted);
        border: 1px solid var(--border-glass);
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: 0.2s;
    }
    .back-btn:hover {
        background: var(--glass-bg);
        color: var(--text-main);
        border-color: var(--text-muted);
    }
    .btn-print {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn-print:hover {
        background: #4a4a4a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(42, 42, 42, 0.2);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stats-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: var(--glass-bg);
        border: 1px solid var(--border-glass);
        border-radius: 16px;
    }
    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .stats-icon.primary { background: rgba(14, 165, 233, 0.15); color: #0ea5e9; }
    .stats-icon.success { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .stats-icon.warning { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    .stats-info p { margin: 0; font-size: 0.85rem; color: var(--text-muted); }
    .stats-info h3 { margin: 5px 0 0 0; font-size: 1.5rem; font-weight: 600; }

    .glass-card {
        background: var(--glass-bg);
        border: 1px solid var(--border-glass);
        border-radius: 16px;
        padding: 1.5rem;
    }
    .card-title {
        margin: 0 0 1.5rem 0;
        color: var(--primary);
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-bar {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        align-items: center;
    }
    .glass-input {
        padding: 0.6rem 1rem;
        border-radius: 10px;
        border: 1px solid var(--border-glass);
        font-size: 0.9rem;
        background: rgba(255,255,255,0.8);
        flex: 1;
        min-width: 200px;
    }
    .glass-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(14,165,233,0.15);
    }
    .glass-select {
        padding: 0.6rem 1rem;
        border-radius: 10px;
        border: 1px solid var(--border-glass);
        font-size: 0.9rem;
        background: rgba(255,255,255,0.8);
        cursor: pointer;
    }
    .glass-select:focus {
        outline: none;
        border-color: var(--primary);
    }
    .btn-filter {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.6rem 1rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn-filter:hover {
        background: #4a4a4a;
    }
    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.6rem 1rem;
        background: rgba(107, 114, 128, 0.15);
        color: #4b5563;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        text-decoration: none;
        transition: 0.2s;
    }
    .btn-reset:hover {
        background: rgba(107, 114, 128, 0.25);
    }

    .table-responsive {
        overflow-x: auto;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        text-align: left;
        padding: 0.75rem;
        font-size: 0.8rem;
        color: var(--text-muted);
        border-bottom: 2px solid rgba(0,0,0,0.08);
        text-transform: uppercase;
        white-space: nowrap;
    }
    .data-table td {
        padding: 0.85rem 0.75rem;
        font-size: 0.9rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .data-table tr:hover td {
        background: rgba(14, 165, 233, 0.03);
    }
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-success {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }
    .badge-warning {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
    }
    .code-text {
        font-family: monospace;
        font-size: 0.75rem;
        background: rgba(0,0,0,0.05);
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
    }
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--text-muted);
    }
    .pagination-wrap {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }
    .action-btns {
        display: flex;
        gap: 0.5rem;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-view {
        background: rgba(14, 165, 233, 0.15);
        color: #0ea5e9;
    }
    .btn-view:hover {
        background: #0ea5e9;
        color: white;
    }
    .btn-print-row {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }
    .btn-print-row:hover {
        background: #10b981;
        color: white;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .filter-bar {
            flex-direction: column;
        }
        .glass-input, .glass-select {
            width: 100%;
        }
    }
</style>
@endsection

@section('konten')
<div class="page-header">
    <div class="page-title">
        <a href="{{ route('admin.riwayatpendataan.index') }}" class="back-btn">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <h2>Riwayat Pendataan - {{ $petugas->name }}</h2>
    </div>
    <a href="{{ route('admin.riwayatpendataan.print', $petugas->id) }}" target="_blank" class="btn-print">
        <i class="ri-printer-line"></i> Print Semua
    </a>
</div>

{{-- Stats Cards --}}
<div class="stats-grid">
    <div class="stats-card">
        <div class="stats-icon primary"><i class="ri-user-line"></i></div>
        <div class="stats-info">
            <p>Petugas</p>
            <h3>{{ $petugas->name }}</h3>
            <small style="color: var(--text-muted);">{{ $petugas->email ?? '-' }}</small>
        </div>
    </div>
    <div class="stats-card">
        <div class="stats-icon success"><i class="ri-refresh-line"></i></div>
        <div class="stats-info">
            <p>Total Update</p>
            <h3>{{ $totalUpdate }}x</h3>
        </div>
    </div>
    <div class="stats-card">
        <div class="stats-icon warning"><i class="ri-calendar-line"></i></div>
        <div class="stats-info">
            <p>Terakhir Update</p>
            <h3>{{ $riwayats->first() ? $riwayats->first()->tanggal_update->format('d M Y') : '-' }}</h3>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="glass-card">
    <h3 class="card-title">
        <i class="ri-file-list-3-line"></i> Riwayat Pendataan Keluarga
    </h3>
    
    <form method="GET" class="filter-bar">
        <input type="text" name="search" placeholder="Cari No. KK atau Nama Kepala Keluarga..." value="{{ request('search') }}" class="glass-input">
        <select name="aksi" class="glass-select">
            <option value="">Semua Aksi</option>
            <option value="create" {{ request('aksi') == 'create' ? 'selected' : '' }}>Dibuat</option>
            <option value="update" {{ request('aksi') == 'update' ? 'selected' : '' }}>Diperbarui</option>
        </select>
        <button type="submit" class="btn-filter">
            <i class="ri-search-line"></i> Cari
        </button>
        @if(request()->anyFilled(['search', 'aksi']))
        <a href="{{ route('admin.riwayatpendataan.detail', $petugas->id) }}" class="btn-reset">
            <i class="ri-refresh-line"></i> Reset
        </a>
        @endif
    </form>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No. KK</th>
                    <th>Kepala Keluarga</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                    <th>Aksi Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayats as $index => $riwayat)
                <tr>
                    <td>{{ $riwayats->firstItem() + $index }}</td>
                    <td>{{ $riwayat->tanggal_update->format('d/m/Y H:i') }}</td>
                    <td><span class="code-text">{{ $riwayat->no_kk }}</span></td>
                    <td>{{ $riwayat->kepala_keluarga_nama ?? '-' }}</td>
                    <td>{{ $riwayat->alamat ?? '-' }}</td>
                    <td>
                        @if($riwayat->aksi == 'create')
                        <span class="badge badge-success"><i class="ri-add-circle-line"></i> Dibuat</span>
                        @else
                        <span class="badge badge-warning"><i class="ri-edit-line"></i> Diperbarui</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('data-keluarga.show', $riwayat->keluarga_id) }}" class="btn-action btn-view" title="Lihat Detail Keluarga" target="_blank">
                                <i class="ri-eye-line"></i>
                            </a>
                            <a href="{{ route('admin.riwayatpendataan.printKeluarga', [$petugas->id, $riwayat->keluarga_id]) }}" class="btn-action btn-print-row" title="Print Data Keluarga" target="_blank">
                                <i class="ri-printer-line"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">Belum ada riwayat pendataan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $riwayats->links() }}</div>
</div>
@endsection