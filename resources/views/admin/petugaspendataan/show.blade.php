@extends('admin.layouts.app')

@section('title', 'Detail Petugas Pendataan')

@section('head')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .page-header h2 { margin: 0; }
    .btn { padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem; transition: all 0.2s; border: none; cursor: pointer; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #0284c7; }
    .btn-secondary { background: rgba(107,114,128,0.15); color: #4b5563; }
    .btn-secondary:hover { background: rgba(107,114,128,0.25); }
    .glass { background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border-radius: 16px; padding: 1.5rem; border: 1px solid rgba(255,255,255,0.8); }
    .detail-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
    .detail-card { background: rgba(255,255,255,0.6); border-radius: 12px; padding: 1.25rem; }
    .detail-label { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem; }
    .detail-value { font-size: 1rem; font-weight: 500; }
    .badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-success { background: rgba(16,185,129,0.15); color: #10b981; }
    .badge-danger { background: rgba(239,68,68,0.15); color: #dc2626; }
    .avatar-lg { width: 80px; height: 80px; border-radius: 50%; background: rgba(14,165,233,0.15); color: #0ea5e9; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 600; }
    .profile-card { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.5rem; }
    .profile-info h3 { margin: 0 0 0.25rem 0; }
    .profile-info p { margin: 0; color: var(--text-muted); }
    .actions { display: flex; gap: 0.5rem; }
    .info-section { margin-bottom: 1.5rem; }
    .info-section h4 { margin: 0 0 1rem 0; font-size: 1rem; color: var(--primary); }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-user-line" style="color: var(--primary)"></i> Detail Petugas Pendataan</h2>
    <div class="actions">
        <a href="{{ route('admin.petugaspendataan.index') }}" class="btn btn-secondary">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <a href="{{ route('admin.petugaspendataan.edit', $petugas->id) }}" class="btn btn-primary">
            <i class="ri-edit-line"></i> Edit
        </a>
    </div>
</div>

<div class="glass">
    <div class="profile-card">
        <div class="avatar-lg">{{ substr($petugas->name, 0, 2) }}</div>
        <div class="profile-info">
            <h3>{{ $petugas->name }}</h3>
            <p>{{ $petugas->email }}</p>
            <div style="margin-top: 0.5rem;">
                @if($petugas->status == 'active')
                <span class="badge badge-success">Aktif</span>
                @else
                <span class="badge badge-danger">Nonaktif</span>
                @endif
            </div>
        </div>
    </div>

    <div class="detail-grid">
        <div class="info-section">
            <h4>Informasi Akun</h4>
            <div class="detail-card">
                <div class="detail-label">Username</div>
                <div class="detail-value">{{ $petugas->username }}</div>
            </div>
            <div class="detail-card" style="margin-top: 0.75rem;">
                <div class="detail-label">Email</div>
                <div class="detail-value">{{ $petugas->email }}</div>
            </div>
            <div class="detail-card" style="margin-top: 0.75rem;">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    @if($petugas->status == 'active')
                    <span class="badge badge-success">Aktif</span>
                    @else
                    <span class="badge badge-danger">Nonaktif</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="info-section">
            <h4>Informasi Pribadi</h4>
            <div class="detail-card">
                <div class="detail-label">NIK</div>
                <div class="detail-value">{{ $petugas->nik ?? '-' }}</div>
            </div>
            <div class="detail-card" style="margin-top: 0.75rem;">
                <div class="detail-label">No. Telepon</div>
                <div class="detail-value">{{ $petugas->no_telepon ?? '-' }}</div>
            </div>
            <div class="detail-card" style="margin-top: 0.75rem;">
                <div class="detail-label">Alamat</div>
                <div class="detail-value">{{ $petugas->alamat ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="detail-grid" style="margin-top: 1rem;">
        <div class="detail-card">
            <div class="detail-label">Dibuat</div>
            <div class="detail-value">{{ $petugas->created_at->format('d/m/Y H:i') }}</div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Terakhir Diupdate</div>
            <div class="detail-value">{{ $petugas->updated_at->format('d/m/Y H:i') }}</div>
        </div>
    </div>
</div>
@endsection