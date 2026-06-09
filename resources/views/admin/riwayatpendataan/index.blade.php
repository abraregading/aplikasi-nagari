@extends('admin.layouts.app')

@section('title', 'Riwayat Pendataan Keluarga')

@section('head')
<style>
    .stats-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: rgba(255,255,255,0.7);
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.8);
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
    .table-responsive { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: 0.75rem; font-size: 0.8rem; color: var(--text-muted); border-bottom: 2px solid rgba(0,0,0,0.08); text-transform: uppercase; }
    .data-table td { padding: 0.85rem 0.75rem; font-size: 0.9rem; border-bottom: 1px solid rgba(0,0,0,0.05); }
    .data-table tr:hover td { background: rgba(14, 165, 233, 0.03); }
    .petugas-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: rgba(14, 165, 233, 0.15);
        color: #0ea5e9;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
        margin-right: 0.5rem;
    }
    .btn { padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem; transition: all 0.2s; }
    .btn-info { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .btn-info:hover { background: rgba(59, 130, 246, 0.25); }
    .btn-primary { background: rgba(14, 165, 233, 0.15); color: #0ea5e9; }
    .btn-primary:hover { background: rgba(14, 165, 233, 0.25); }
    .badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .badge-success { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .badge-secondary { background: rgba(107, 114, 128, 0.15); color: #6b7280; }
    .empty-state { text-align: center; padding: 2rem; color: var(--text-muted); }
</style>
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Riwayat Pendataan Keluarga</h2>

<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="stats-card">
        <div class="stats-icon primary"><i class="ri-file-list-3-line"></i></div>
        <div class="stats-info">
            <p>Total Riwayat</p>
            <h3>{{ $totalRiwayat }}</h3>
        </div>
    </div>
    <div class="stats-card">
        <div class="stats-icon success"><i class="ri-user-follow-line"></i></div>
        <div class="stats-info">
            <p>Total Petugas</p>
            <h3>{{ $totalPetugas }}</h3>
        </div>
    </div>
    <div class="stats-card">
        <div class="stats-icon warning"><i class="ri-refresh-line"></i></div>
        <div class="stats-info">
            <p>Rata-rata per Petugas</p>
            <h3>{{ $totalPetugas > 0 ? round($totalRiwayat / $totalPetugas, 1) : 0 }}</h3>
        </div>
    </div>
</div>

<div class="glass" style="padding: 1.5rem; border-radius: 16px;">
    <h3 style="margin: 0 0 1.5rem 0; color: var(--primary);">Update Data Keluarga per Petugas</h3>
    
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Petugas</th>
                    <th>Jumlah Update</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($petugasStats as $index => $petugas)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <span class="petugas-avatar">{{ substr($petugas->name, 0, 1) }}</span>
                        {{ $petugas->name }}
                    </td>
                    <td>
                        @php $total = $petugas->total_update ?? 0; @endphp
                        <span class="badge {{ $total > 0 ? 'badge-success' : 'badge-secondary' }}">
                            {{ $total }}x update
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.riwayatpendataan.detail', $petugas->id) }}" class="btn btn-info">
                            <i class="ri-eye-line"></i> Lihat Detail
                        </a>
                        @php $total = $petugas->total_update ?? 0; @endphp
                        @if($total > 0)
                        <a href="{{ route('admin.riwayatpendataan.print', $petugas->id) }}" target="_blank" class="btn btn-primary">
                            <i class="ri-printer-line"></i> Print
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state">Belum ada data riwayat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection