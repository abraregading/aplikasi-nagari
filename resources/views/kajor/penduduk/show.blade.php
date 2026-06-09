@extends('kajor.layouts.app')

@section('title', 'Detail Penduduk - ' . $penduduk->nama_lengkap)

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
        color: #000;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .status-hidup { background: rgba(16, 185, 129, 0.2); color: #10b981; }
    .status-meninggal { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
    .status-pindah { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
</style>
@endsection

@section('konten')
<div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 2rem;">
    <div>
        <h2 style="margin-bottom: 0.5rem;">Detail Penduduk</h2>
        <a href="{{ route('kajor.penduduk.index') }}" style="color: #999; text-decoration: none;">
            <i class="ri-arrow-left-line"></i> Kembali ke Daftar
        </a>
    </div>
    <div style="font-size: 0.9rem; color: #999;">
        Jorong: <strong>{{ $jorongName }}</strong>
    </div>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div class="detail-card">
        <h3><i class="ri-user-line"></i> Data Pribadi</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">NIK</span>
                <span class="info-value" style="font-size: 1.1rem; font-weight: 600;">{{ $penduduk->nik }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nama Lengkap</span>
                <span class="info-value">{{ $penduduk->nama_lengkap }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jenis Kelamin</span>
                <span class="info-value">{{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tempat Lahir</span>
                <span class="info-value">{{ $penduduk->tempat_lahir ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Lahir</span>
                <span class="info-value">{{ $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('d F Y') : '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Agama</span>
                <span class="info-value">{{ $penduduk->agama ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status Perkawinan</span>
                <span class="info-value">{{ $penduduk->status_perkawinan ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status Hidup</span>
                <span class="info-value">
                    <span class="status-badge status-{{ $penduduk->status_hidup }}">
                        @switch($penduduk->status_hidup)
                            @case('hidup') Hidup @break
                            @case('meninggal') Meninggal @break
                            @case('pindah') Pindah @break
                            @default {{ $penduduk->status_hidup }}
                        @endswitch
                    </span>
                </span>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <h3><i class="ri-home-4-line"></i> Data Keluarga</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">No. KK</span>
                <span class="info-value">{{ $penduduk->no_kk }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Hubungan Keluarga</span>
                <span class="info-value">{{ $penduduk->hubungan_keluarga ?? '-' }}</span>
            </div>
            <div class="info-item" style="grid-column: span 2;">
                <span class="info-label">Alamat</span>
                <span class="info-value">{{ $penduduk->alamat ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <h3><i class="ri-briefcase-line"></i> Data Lainnya</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Pekerjaan</span>
                <span class="info-value">{{ $penduduk->pekerjaan ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Pendidikan Terakhir</span>
                <span class="info-value">{{ $penduduk->pendidikan_terakhir ?? '-' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection