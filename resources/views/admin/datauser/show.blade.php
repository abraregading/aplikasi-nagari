@extends('admin.layouts.app')

@section('title', 'Detail User - Admin Desa')

@section('head')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
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

    .profile-header {
        background: linear-gradient(135deg, var(--primary) 0%, #4a4a4a 100%);
        border-radius: 16px;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin-bottom: 1rem;
        border: 3px solid rgba(255,255,255,0.3);
    }
    .profile-name {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
    }
    .profile-username {
        opacity: 0.9;
        font-size: 1rem;
        margin: 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .info-card {
        background: var(--glass-bg);
        border: 1px solid var(--border-glass);
        border-radius: 12px;
        padding: 1.5rem;
    }
    .info-card-title {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-glass);
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-label {
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    .info-value {
        color: var(--text-main);
        font-weight: 500;
        text-align: right;
    }
    .role-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .role-admin { background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; }
    .role-operator { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .role-petugas { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    .role-kader { background: linear-gradient(135deg, #059669, #047857); color: white; }
    .role-kajor { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }
    .role-warga { background: linear-gradient(135deg, #6b7280, #4b5563); color: white; }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        transition: 0.2s;
        cursor: pointer;
        border: none;
    }
    .btn-edit {
        background: var(--primary);
        color: white;
    }
    .btn-edit:hover {
        background: #4a4a4a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .btn-delete {
        background: #ef4444;
        color: white;
    }
    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239,68,68,0.3);
    }

    @media (max-width: 768px) {
        .profile-header {
            padding: 1.5rem;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }
        .profile-name {
            font-size: 1.25rem;
        }
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('konten')
<div class="page-header">
    <div class="page-title">
        <a href="{{ route('data-user.index') }}" class="back-btn">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <h2>Detail User</h2>
    </div>
</div>

{{-- Profile Header --}}
<div class="profile-header">
    <div class="profile-avatar">
        <i class="ri-user-3-line"></i>
    </div>
    <h3 class="profile-name">{{ $datauser->name }}</h3>
    <p class="profile-username">&#64;{{ $datauser->username }}</p>
    <span class="role-badge role-{{ $datauser->role }}">
        @switch($datauser->role)
            @case('admin') <i class="ri-admin-line"></i> Admin @break
            @case('operator') <i class="ri-user-settings-line"></i> Operator @break
            @case('petugas') <i class="ri-user-star-line"></i> Petugas @break
            @case('kader') <i class="ri-user-heart-line"></i> Kader @break
            @case('kajor') <i class="ri-community-line"></i> Kepala Jorong @break
            @case('warga') <i class="ri-user-line"></i> Warga @break
            @default {{ $datauser->role }}
        @endswitch
    </span>
</div>

{{-- Info Cards --}}
<div class="info-grid">
    <div class="info-card">
        <div class="info-card-title"><i class="ri-mail-line"></i> Informasi Kontak</div>
        <div class="info-item">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $datauser->email }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">NIK</span>
            <span class="info-value">{{ $datauser->nik ?? '-' }}</span>
        </div>
            @if($datauser->role === 'kajor')
        <div class="info-item">
            <span class="info-label">Wilayah Jorong</span>
            <span class="info-value" style="color: #8b5cf6; font-weight: 600;">{{ $datauser->jorong ?? '-' }}</span>
        </div>
        @endif
        @if($datauser->role === 'kader')
        <div class="info-item">
            <span class="info-label">Pos Yandu</span>
            <span class="info-value" style="color: #059669; font-weight: 600;">{{ $datauser->posyandu->nama_posyandu ?? '-' }}</span>
        </div>
        @endif
    </div>
    <div class="info-card">
        <div class="info-card-title"><i class="ri-time-line"></i> Informasi Waktu</div>
        <div class="info-item">
            <span class="info-label">Dibuat</span>
            <span class="info-value">{{ $datauser->created_at->format('d M Y') }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Terakhir Update</span>
            <span class="info-value">{{ $datauser->updated_at->format('d M Y') }}</span>
        </div>
    </div>
</div>

{{-- Action Buttons --}}
<div class="action-buttons">
    <a href="{{ route('data-user.edit', $datauser->id) }}" class="btn-action btn-edit">
        <i class="ri-edit-line"></i> Edit User
    </a>
    <form action="{{ route('data-user.destroy', $datauser->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-action btn-delete">
            <i class="ri-delete-bin-line"></i> Hapus User
        </button>
    </form>
</div>
@endsection