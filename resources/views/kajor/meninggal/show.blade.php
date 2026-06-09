@extends('kajor.layouts.app')

@section('title', 'Detail Data Meninggal - ' . $data->nama_lengkap)

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
        color: var(--text-main);
    }
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .status-L { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
    .status-P { background: rgba(236, 72, 153, 0.2); color: #ec4899; }
</style>
@endsection

@section('konten')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin-bottom: 0.5rem;">Detail Data Meninggal</h2>
        <a href="{{ route('kajor.meninggal.index') }}" style="color: #999; text-decoration: none;">
            <i class="ri-arrow-left-line"></i> Kembali ke Daftar
        </a>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('kajor.meninggal.edit', $data->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
            <i class="ri-edit-line"></i> Edit
        </a>
    </div>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div class="detail-card">
        <h3><i class="ri-user-line"></i> Data Pribadi</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">NIK</span>
                <span class="info-value" style="font-size: 1.1rem; font-weight: 600;">{{ $data->nik }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nama Lengkap</span>
                <span class="info-value">{{ $data->nama_lengkap }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jenis Kelamin</span>
                <span class="info-value"><span class="status-badge status-{{ $data->jenis_kelamin }}">{{ $data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span></span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Lahir</span>
                <span class="info-value">{{ $data->tanggal_lahir ? $data->tanggal_lahir->format('d F Y') : '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">No. KK</span>
                <span class="info-value">{{ $data->no_kk ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jorong</span>
                <span class="info-value">{{ $data->jorong ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <h3><i class="ri-information-line"></i> Data Kematian</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Tanggal Meninggal</span>
                <span class="info-value" style="font-size: 1.1rem; font-weight: 600; color: #ef4444;">{{ $data->tanggal_meninggal->format('d F Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Waktu Meninggal</span>
                <span class="info-value">{{ $data->waktu_meninggal ? $data->waktu_meninggal->format('H:i') : '-' }} WIB</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tempat Meninggal</span>
                <span class="info-value">{{ $data->tempat_meninggal ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Sebab Meninggal</span>
                <span class="info-value">{{ $data->sebab_meninggal ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <h3><i class="ri-user-star-line"></i> Data Saksi & Hubungan</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Status Hubungan dalam KK</span>
                <span class="info-value">{{ $data->status_hubungan ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nama Saksi</span>
                <span class="info-value">{{ $data->nama_saksi ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">No. HP Saksi</span>
                <span class="info-value">{{ $data->no_hp_saksi ?? '-' }}</span>
            </div>
        </div>
    </div>

    @if($data->keterangan)
    <div class="detail-card">
        <h3><i class="ri-file-text-line"></i> Keterangan</h3>
        <p>{{ $data->keterangan }}</p>
    </div>
    @endif

    <div class="detail-card">
        <h3><i class="ri-time-line"></i> Informasi Sistem</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Data Dibuat</span>
                <span class="info-value">{{ $data->created_at ? $data->created_at->format('d M Y, H:i') : '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Terakhir Diperbarui</span>
                <span class="info-value">{{ $data->updated_at ? $data->updated_at->format('d M Y, H:i') : '-' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
