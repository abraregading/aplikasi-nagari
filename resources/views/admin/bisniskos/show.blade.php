@extends('admin.layouts.app')

@section('title', 'Detail Usaha - Admin')

@section('head')
<style>
    .detail-card {
        background: rgba(255,255,255,0.05);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .detail-card h3 {
        font-size: 1.1rem;
        color: var(--primary);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    .info-label {
        font-size: 0.8rem;
        color: #999;
    }
    .info-value {
        font-size: 0.95rem;
        color: #fff;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .status-aktif { background: rgba(16, 185, 129, 0.2); color: #10b981; }
    .status-nonaktif { background: rgba(107, 114, 128, 0.2); color: #6b7280; }
    .status-pindah { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
    .status-keluar { background: rgba(239, 68, 68, 0.2); color: #ef4444; }

    .table-penghuni {
        width: 100%;
        border-collapse: collapse;
    }
    .table-penghuni th, .table-penghuni td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .table-penghuni th {
        font-size: 0.8rem;
        color: #999;
        font-weight: 500;
    }
    .table-penghuni td {
        font-size: 0.9rem;
    }
</style>
@endsection

@section('konten')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin-bottom: 0.5rem;">Detail Usaha</h2>
        <a href="{{ route('admin.bisniskos.index') }}" style="color: #999; text-decoration: none;">
            <i class="ri-arrow-left-line"></i> Kembali ke Daftar
        </a>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('admin.bisniskos.print', $bisnis->id) }}" target="_blank" class="btn-action" style="background: rgba(16, 185, 129, 0.2); color: #10b981;">
            <i class="ri-printer-line"></i> Print Data
        </a>
    </div>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div class="detail-card">
        <h3><i class="ri-store-2-line"></i> Informasi Usaha</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama Usaha</span>
                <span class="info-value" style="font-size: 1.1rem; font-weight: 600;">{{ $bisnis->nama_usaha }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jenis Usaha</span>
                <span class="info-value">
                    @switch($bisnis->jenis_usaha)
                        @case('kos') Kos @break
                        @case('kontrakan') Kontrakan @break
                        @case('rumah_petak') Rumah Petak @break
                        @default {{ $bisnis->jenis_usaha }}
                    @endswitch
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="info-value">
                    <span class="status-badge status-{{ $bisnis->status }}">
                        {{ $bisnis->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Jumlah Kamar</span>
                <span class="info-value">{{ $bisnis->jumlah_kamar ?? '-' }} kamar</span>
            </div>
            <div class="info-item" style="grid-column: span 2;">
                <span class="info-label">Alamat</span>
                <span class="info-value">{{ $bisnis->alamat }}</span>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <h3><i class="ri-user-line"></i> Informasi Pemilik</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama Pemilik</span>
                <span class="info-value">{{ $bisnis->pemilik_nama }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">NIK Pemilik</span>
                <span class="info-value">{{ $bisnis->pemilik_nik ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">No. Telepon</span>
                <span class="info-value">{{ $bisnis->pemilik_telepon ?? '-' }}</span>
            </div>
        </div>
    </div>

    @if($bisnis->catatan)
    <div class="detail-card">
        <h3><i class="ri-file-info-line"></i> Catatan</h3>
        <p style="color: #ccc;">{{ $bisnis->catatan }}</p>
    </div>
    @endif
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px; margin-top: 1.5rem;">
    <h3 style="margin-bottom: 1.5rem; color: var(--primary);">
        <i class="ri-group-line"></i> Data Penghuni
    </h3>

    @if($penghuniAktif->count() > 0)
    <h4 style="color: #10b981; margin-bottom: 1rem; font-size: 0.9rem;">Penghuni Aktif ({{ $penghuniAktif->count() }})</h4>
    <div style="overflow-x: auto; margin-bottom: 2rem;">
        <table class="table-penghuni">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NIK</th>
                    <th>JK</th>
                    <th>No. Kamar</th>
                    <th>Tgl Masuk</th>
                    <th>Pekerjaan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penghuniAktif as $penghuni)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $penghuni->nama_lengkap }}</td>
                    <td>{{ $penghuni->nik ?? '-' }}</td>
                    <td>{{ $penghuni->jekel == 'L' ? 'L' : 'P' }}</td>
                    <td>{{ $penghuni->no_kamar ?? '-' }}</td>
                    <td>{{ $penghuni->tanggal_masuk ? $penghuni->tanggal_masuk->format('d/m/Y') : '-' }}</td>
                    <td>{{ $penghuni->pekerjaan ?? '-' }}</td>
                    <td>
                        <span class="status-badge status-aktif">Aktif</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p style="color: #999; font-style: italic;">Belum ada penghuni aktif.</p>
    @endif

    @if($penghuniNonaktif->count() > 0)
    <h4 style="color: #f59e0b; margin-bottom: 1rem; font-size: 0.9rem;">Riwayat Penghuni Nonaktif ({{ $penghuniNonaktif->count() }})</h4>
    <div style="overflow-x: auto;">
        <table class="table-penghuni">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NIK</th>
                    <th>JK</th>
                    <th>No. Kamar</th>
                    <th>Tgl Masuk</th>
                    <th>Tgl Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penghuniNonaktif as $penghuni)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $penghuni->nama_lengkap }}</td>
                    <td>{{ $penghuni->nik ?? '-' }}</td>
                    <td>{{ $penghuni->jekel == 'L' ? 'L' : 'P' }}</td>
                    <td>{{ $penghuni->no_kamar ?? '-' }}</td>
                    <td>{{ $penghuni->tanggal_masuk ? $penghuni->tanggal_masuk->format('d/m/Y') : '-' }}</td>
                    <td>{{ $penghuni->tanggal_keluar ? $penghuni->tanggal_keluar->format('d/m/Y') : '-' }}</td>
                    <td>
                        <span class="status-badge status-{{ $penghuni->status }}">
                            @switch($penghuni->status)
                                @case('pindah') Pindah @break
                                @case('keluar') Keluar @break
                                @default {{ $penghuni->status }}
                            @endswitch
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection