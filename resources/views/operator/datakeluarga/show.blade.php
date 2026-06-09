@extends('operator.layouts.app')

@section('title', 'Detail Data Keluarga - Operator')

@section('head')
<style>
    .profile-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
        border-radius: 16px;
        color: white;
        margin-bottom: 2rem;
    }
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        border: 3px solid rgba(255,255,255,0.3);
    }
    .profile-info h2 {
        margin: 0 0 0.25rem 0;
        font-size: 1.5rem;
        font-weight: 700;
    }
    .profile-info p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }
    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.2);
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }
    .info-section { margin-bottom: 1.5rem; }
    .section-title {
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--primary);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary);
        display: inline-block;
    }
    .detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem; }
    .detail-item {
        background: rgba(255,255,255,0.5);
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    .detail-item:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .detail-item .detail-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .detail-item .detail-label i { color: var(--primary); font-size: 1rem; }
    .detail-item .detail-value { color: #1f2937; font-size: 1rem; font-weight: 600; word-break: break-word; }
    .badge-aktif { background: rgba(16, 185, 129, 0.12); color: #10b981; }
    .badge-pindah { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
    .badge-nonaktif { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
    .action-buttons { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-edit { background: rgba(245, 158, 11, 0.12); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); }
    .btn-edit:hover { background: #f59e0b; color: white; }
    .btn-back { background: rgba(107, 114, 128, 0.1); color: #6b7280; border: 1px solid rgba(107, 114, 128, 0.2); }
    .btn-back:hover { background: #6b7280; color: white; }
    .info-icon { font-size: 1.1rem; }
</style>
@endsection

@section('konten')
<div class="action-buttons">
    <a href="{{ route('data-keluarga-operator.index') }}" class="btn-action btn-back">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <a href="{{ route('data-keluarga-operator.edit', $keluarga->id) }}" class="btn-action btn-edit">
        <i class="ri-edit-line"></i> Edit Data
    </a>
</div>

<div class="profile-header">
    <div class="profile-avatar">
        <i class="ri-home-heart-line"></i>
    </div>
    <div class="profile-info">
        <h2>{{ $keluarga->no_kk }}</h2>
        <p>{{ $keluarga->alamat ?? 'Alamat belum diisi' }}</p>
        <div class="profile-badge">
            <i class="ri-group-line"></i> {{ $keluarga->jumlah_anggota }} Anggota
        </div>
    </div>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div class="info-section">
        <div class="section-title"><i class="ri-id-card-line"></i> Data Kartu Keluarga</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label"><i class="ri-number-1 info-icon"></i> Nomor KK</span>
                <span class="detail-value">{{ $keluarga->no_kk }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-user-line info-icon"></i> NIK Kepala Keluarga</span>
                <span class="detail-value">{{ $keluarga->kepala_keluarga_nik ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-map-pin-line info-icon"></i> Alamat</span>
                <span class="detail-value">{{ $keluarga->alamat }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-map-line info-icon"></i> Jorong</span>
                <span class="detail-value">{{ $keluarga->jorong ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <div class="section-title"><i class="ri-map-2-line"></i> Data Wilayah</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label"><i class="ri-community-line info-icon"></i> Desa/Kelurahan</span>
                <span class="detail-value">{{ $keluarga->desa_kelurahan ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-building-line info-icon"></i> Kecamatan</span>
                <span class="detail-value">{{ $keluarga->kecamatan ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-office-line info-icon"></i> Kabupaten/Kota</span>
                <span class="detail-value">{{ $keluarga->kabupaten_kota ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-government-line info-icon"></i> Provinsi</span>
                <span class="detail-value">{{ $keluarga->provinsi ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-mail-send-line info-icon"></i> Kode Pos</span>
                <span class="detail-value">{{ $keluarga->kode_pos ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <div class="section-title"><i class="ri-group-line"></i> Data Anggota & Status</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label"><i class="ri-team-line info-icon"></i> Jumlah Anggota</span>
                <span class="detail-value">{{ $keluarga->jumlah_anggota }} Orang</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-checkbox-multiple-line info-icon"></i> Status Keluarga</span>
                <span class="detail-value">
                    @if($keluarga->status == 'aktif')
                        <span class="badge-aktif"><i class="ri-checkbox-circle-line"></i> Aktif</span>
                    @elseif($keluarga->status == 'pindah')
                        <span class="badge-pindah"><i class="ri-logout-box-line"></i> Pindah</span>
                    @else
                        <span class="badge-nonaktif"><i class="ri-close-circle-line"></i> Non-Aktif</span>
                    @endif
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-time-line info-icon"></i> Terakhir Diperbarui</span>
                <span class="detail-value">{{ $keluarga->updated_at ? $keluarga->updated_at->format('d F Y, Pukul H:i') : '-' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
@endsection
