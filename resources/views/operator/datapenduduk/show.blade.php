@extends('operator.layouts.app')

@section('title', 'Detail Data Penduduk - Operator')

@section('head')
<style>
    .profile-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
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
    .info-section {
        margin-bottom: 1.5rem;
    }
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
    .detail-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
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
    .detail-item .detail-label i {
        color: var(--primary);
        font-size: 1rem;
    }
    .detail-item .detail-value {
        color: #1f2937;
        font-size: 1rem;
        font-weight: 600;
        word-break: break-word;
    }
    .badge-jk {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .badge-laki { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
    .badge-perempuan { background: rgba(236, 72, 153, 0.12); color: #ec4899; }
    .badge-hidup { background: rgba(16, 185, 129, 0.12); color: #10b981; }
    .badge-meninggal { background: rgba(107, 114, 128, 0.12); color: #6b7280; }
    .badge-pindah { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
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
    .btn-edit {
        background: rgba(245, 158, 11, 0.12);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }
    .btn-edit:hover {
        background: #f59e0b;
        color: white;
    }
    .btn-back {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }
    .btn-back:hover {
        background: #6b7280;
        color: white;
    }
    .info-icon { font-size: 1.1rem; }
</style>
@endsection

@section('konten')
<div style="margin-bottom: 1.5rem;">
    <div class="action-buttons">
        <a href="{{ route('data-penduduk-operator.index') }}" class="btn-action btn-back">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <a href="{{ route('data-penduduk-operator.edit', $penduduk->id) }}" class="btn-action btn-edit">
            <i class="ri-edit-line"></i> Edit Data
        </a>
    </div>
</div>

<div class="profile-header">
    <div class="profile-avatar">
        <i class="ri-user-line"></i>
    </div>
    <div class="profile-info">
        <h2>{{ $penduduk->nama_lengkap }}</h2>
        <p>{{ $penduduk->alamat ?? 'Alamat belum diisi' }}</p>
        <div class="profile-badge">
            <i class="ri-id-card-line"></i> NIK: {{ $penduduk->nik }}
        </div>
    </div>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div class="info-section">
        <div class="section-title"><i class="ri-user-settings-line"></i> Data Pribadi</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label"><i class="ri-id-card-line info-icon"></i> NIK</span>
                <span class="detail-value">{{ $penduduk->nik }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-family-line info-icon"></i> No. KK</span>
                <span class="detail-value">{{ $penduduk->no_kk }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-user-line info-icon"></i> Nama Lengkap</span>
                <span class="detail-value">{{ $penduduk->nama_lengkap }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-map-pin-line info-icon"></i> Tempat Lahir</span>
                <span class="detail-value">{{ $penduduk->tempat_lahir ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-calendar-line info-icon"></i> Tanggal Lahir</span>
                <span class="detail-value">{{ $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('d F Y') : '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-gender-line info-icon"></i> Jenis Kelamin</span>
                <span class="detail-value">
                    @if($penduduk->jenis_kelamin == 'L')
                        <span class="badge-jk badge-laki"><i class="ri-men-line"></i> Laki-laki</span>
                    @else
                        <span class="badge-jk badge-perempuan"><i class="ri-women-line"></i> Perempuan</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <div class="section-title"><i class="ri-book-open-line"></i> Data Keagamaan & Sosial</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label"><i class="ri-book-mark-line info-icon"></i> Agama</span>
                <span class="detail-value">{{ $penduduk->agama ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-heart-line info-icon"></i> Status Perkawinan</span>
                <span class="detail-value">{{ $penduduk->status_perkawinan ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-group-line info-icon"></i> Hubungan Keluarga</span>
                <span class="detail-value">{{ $penduduk->hubungan_keluarga ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <div class="section-title"><i class="ri-briefcase-line"></i> Data Pendidikan & Pekerjaan</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label"><i class="ri-graduation-cap-line info-icon"></i> Pendidikan Terakhir</span>
                <span class="detail-value">{{ $penduduk->pendidikan_terakhir ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-building-line info-icon"></i> Pekerjaan</span>
                <span class="detail-value">{{ $penduduk->pekerjaan ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <div class="section-title"><i class="ri-home-line"></i> Data Alamat & Status</div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label"><i class="ri-map-2-line info-icon"></i> Alamat</span>
                <span class="detail-value">{{ $penduduk->alamat ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-heart-2-line info-icon"></i> Status Hidup</span>
                <span class="detail-value">
                    @if($penduduk->status_hidup == 'hidup')
                        <span class="badge-jk badge-hidup"><i class="ri-emotion-happy-line"></i> Hidup</span>
                    @elseif($penduduk->status_hidup == 'meninggal')
                        <span class="badge-jk badge-meninggal"><i class="ri-emotion-sad-line"></i> Meninggal</span>
                    @else
                        <span class="badge-jk badge-pindah"><i class="ri-logout-box-line"></i> Pindah</span>
                    @endif
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label"><i class="ri-time-line info-icon"></i> Terakhir Diperbarui</span>
                <span class="detail-value">{{ $penduduk->updated_at ? $penduduk->updated_at->format('d F Y, Pukul H:i') : '-' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
@endsection
