@extends('operator.layouts.app')

@section('title', 'Detail Warga')

@section('head')
<style>
    .page-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .detail-section { margin-bottom: 1.5rem; }
    .detail-section h3 { font-size: 1rem; margin-bottom: 1rem; color: var(--primary); }
    .detail-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem; }
    .detail-item { display: flex; flex-direction: column; gap: .25rem; }
    .detail-item .label { font-size: .8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
    .detail-item .value { font-size: .95rem; font-weight: 500; color: var(--text-main); }

    .profile-photo { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,.1); }

    .badge { display: inline-block; padding: .25rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600; }
    .badge-pending { background: rgba(245,158,11,.15); color: #d97706; }
    .badge-approved { background: rgba(16,185,129,.15); color: #059669; }
    .badge-rejected { background: rgba(239,68,68,.15); color: #dc2626; }

    .btn { padding: .6rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: .9rem; text-decoration: none; display: inline-flex; align-items: center; gap: .4rem; transition: all .2s; cursor: pointer; border: none; font-family: inherit; }
    .btn-approve { background: rgba(16,185,129,.15); color: #059669; border: 1px solid rgba(16,185,129,.25); }
    .btn-approve:hover { background: rgba(16,185,129,.25); }
    .btn-reject { background: rgba(239,68,68,.1); color: #dc2626; border: 1px solid rgba(239,68,68,.2); }
    .btn-reject:hover { background: rgba(239,68,68,.2); }
    .btn-secondary { background: transparent; color: var(--text-main); border: 1px solid rgba(0,0,0,.15); }
    .btn-secondary:hover { background: rgba(0,0,0,.03); }
    .btn-group { display: flex; gap: .75rem; margin-top: 1.5rem; flex-wrap: wrap; }

    @media(max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <a href="{{ route('operator.warga.index') }}" class="glass-select" style="background: transparent; border: 1px solid var(--text-muted); padding: .5rem 1rem; color: var(--text-main); text-decoration: none;">
        <i class="ri-arrow-left-line"></i>
    </a>
    <h2>Detail Warga</h2>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 1.5rem;">
    <div style="display: flex; gap: 2rem; align-items: center; flex-wrap: wrap; margin-bottom: 2rem;">
        <div style="text-align: center;">
            @if($user->photo)
                <img src="{{ asset('storage/photos/' . $user->photo) }}" alt="foto" class="profile-photo">
            @else
                <div style="width:150px;height:150px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;border:4px solid #e5e7eb;">
                    <i class="ri-user-line" style="font-size:3rem;color:#9ca3af;"></i>
                </div>
            @endif
        </div>
        <div>
            <h3 style="margin:0;font-size:1.3rem;">{{ $user->name }}</h3>
            <p style="margin:.3rem 0;color:var(--text-muted);">@ {{ $user->username }}</p>
            <p style="margin:.3rem 0;">
                @if($user->status == 'pending')
                    <span class="badge badge-pending">Pending</span>
                @elseif($user->status == 'approved')
                    <span class="badge badge-approved">Disetujui</span>
                @else
                    <span class="badge badge-rejected">Ditolak</span>
                @endif
            </p>
        </div>
    </div>

    <div class="detail-section">
        <h3><i class="ri-user-settings-line"></i> Informasi Akun</h3>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="label">Username</span>
                <span class="value">{{ $user->username }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Email</span>
                <span class="value">{{ $user->email ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">NIK</span>
                <span class="value">{{ $user->nik ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Role</span>
                <span class="value">{{ ucfirst($user->role) }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Status</span>
                <span class="value">{{ ucfirst($user->status) }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Tanggal Daftar</span>
                <span class="value">{{ $user->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>

    @if($penduduk)
    <div class="detail-section">
        <h3><i class="ri-group-line"></i> Data Kependudukan</h3>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="label">Nama Lengkap</span>
                <span class="value">{{ $penduduk->nama_lengkap }}</span>
            </div>
            <div class="detail-item">
                <span class="label">No. KK</span>
                <span class="value">{{ $penduduk->no_kk ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Jenis Kelamin</span>
                <span class="value">{{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Tempat / Tgl Lahir</span>
                <span class="value">{{ $penduduk->tempat_lahir ?? '-' }}@if($penduduk->tanggal_lahir), {{ $penduduk->tanggal_lahir->format('d/m/Y') }}@endif</span>
            </div>
            <div class="detail-item">
                <span class="label">Hubungan Keluarga</span>
                <span class="value">{{ $penduduk->hubungan_keluarga ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Pekerjaan</span>
                <span class="value">{{ $penduduk->pekerjaan ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Alamat</span>
                <span class="value">{{ $penduduk->alamat ?? '-' }}</span>
            </div>
        </div>
    </div>
    @endif

    <div class="btn-group">
        @if($user->status == 'pending')
            <form action="{{ route('operator.warga.approve', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Setujui akun {{ $user->name }}?')">
                @csrf
                <button type="submit" class="btn btn-approve"><i class="ri-check-line"></i> Setujui Akun</button>
            </form>
            <form action="{{ route('operator.warga.reject', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tolak akun {{ $user->name }}?')">
                @csrf
                <button type="submit" class="btn btn-reject"><i class="ri-close-line"></i> Tolak Akun</button>
            </form>
        @endif
        <a href="{{ route('operator.warga.index') }}" class="btn btn-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
    </div>
</div>
@endsection
