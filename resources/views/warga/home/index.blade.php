@extends('warga.layouts.app')

@section('title', 'Dashboard Warga')

@section('head')
<style>
    .welcome-card {
        background: linear-gradient(135deg, #0f766e, #065f46);
        border-radius: 16px;
        padding: 2rem;
        color: white;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .welcome-card h2 { margin: 0; font-size: 1.5rem; }
    .welcome-card p { margin: .3rem 0 0; opacity: .85; font-size: .9rem; }

    .profile-card {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        background: var(--bg-glass);
        border: var(--border-glass);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .profile-avatar {
        width: 70px; height: 70px; border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary);
    }
    .profile-avatar-placeholder {
        width: 70px; height: 70px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1.8rem; font-weight: 700;
    }
    .profile-info h3 { margin: 0; font-size: 1.1rem; }
    .profile-info p { margin: .2rem 0; font-size: .85rem; color: var(--text-muted); }
    .profile-info .nik { font-family: monospace; font-size: .9rem; color: var(--primary); font-weight: 600; }

    .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
    .stat-card { padding: 1.25rem; border-radius: 14px; background: var(--bg-glass); border: var(--border-glass); }
    .stat-card .number { font-size: 1.6rem; font-weight: 700; color: var(--text-main); }
    .stat-card .label { font-size: .8rem; color: var(--text-muted); margin-top: .2rem; }
    .stat-card .icon { font-size: 1.5rem; margin-bottom: .5rem; }
    .stat-card.diajukan .icon { color: #f59e0b; }
    .stat-card.diproses .icon { color: #3b82f6; }
    .stat-card.selesai .icon { color: #10b981; }
    .stat-card.ditolak .icon { color: #ef4444; }

    .section-title { font-size: 1rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: .5rem; }

    .recent-table { width: 100%; border-collapse: collapse; font-size: .85rem; }
    .recent-table th { text-align: left; padding: .6rem .5rem; color: var(--text-muted); font-weight: 600; border-bottom: 1px solid rgba(0,0,0,.06); text-transform: uppercase; font-size: .75rem; letter-spacing: .5px; }
    .recent-table td { padding: .6rem .5rem; border-bottom: 1px solid rgba(0,0,0,.04); }
    .badge { display: inline-block; padding: .2rem .6rem; border-radius: 12px; font-size: .75rem; font-weight: 600; }
    .badge-diajukan { background: rgba(245,158,11,.15); color: #d97706; }
    .badge-diproses { background: rgba(59,130,246,.15); color: #2563eb; }
    .badge-selesai { background: rgba(16,185,129,.15); color: #059669; }
    .badge-ditolak { background: rgba(239,68,68,.15); color: #dc2626; }

    .quick-actions { display: flex; gap: .75rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
    .quick-action {
        display: flex; align-items: center; gap: .5rem;
        padding: .75rem 1.25rem; border-radius: 12px;
        background: var(--bg-glass); border: var(--border-glass);
        text-decoration: none; color: var(--text-main); font-size: .85rem; font-weight: 500;
        transition: all .2s;
    }
    .quick-action:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.08); }

    .alert-pending {
        background: rgba(245,158,11,.1); border: 1px solid rgba(245,158,11,.25);
        color: #92400e; padding: 1rem 1.25rem; border-radius: 12px;
        margin-bottom: 1.5rem; font-size: .85rem; display: flex; align-items: center; gap: .5rem;
    }
    .alert-success { background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.25); color: #065f46; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: .85rem; display: flex; align-items: center; gap: .5rem; }
    .alert-error { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.25); color: #991b1b; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: .85rem; display: flex; align-items: center; gap: .5rem; }

    .alamat-text { font-size: .82rem; color: var(--text-muted); line-height: 1.5; }

    .pengumuman-card {
        background: var(--bg-glass);
        border: var(--border-glass);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all .2s;
    }
    .pengumuman-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,.06);
    }
    .pengumuman-card .pengumuman-date {
        font-size: .75rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: .3rem;
        margin-bottom: .3rem;
    }
    .pengumuman-card .pengumuman-judul {
        font-size: .95rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: .5rem;
    }
    .pengumuman-card .pengumuman-isi {
        font-size: .85rem;
        color: var(--text-muted);
        line-height: 1.6;
        white-space: pre-line;
    }
    .pengumuman-badge-khusus {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        font-size: .7rem;
        font-weight: 600;
        padding: .15rem .5rem;
        border-radius: 10px;
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        margin-bottom: .5rem;
    }
    .pengumuman-badge-umum {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        font-size: .7rem;
        font-weight: 600;
        padding: .15rem .5rem;
        border-radius: 10px;
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        margin-bottom: .5rem;
    }

    @media(max-width: 768px) { .welcome-card { flex-direction: column; align-items: flex-start; } .profile-card { flex-direction: column; text-align: center; } }
</style>
@endsection

@section('konten')

@if(session('success'))
<div class="alert-success"><i class="ri-check-line"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert-error"><i class="ri-error-warning-line"></i> {{ session('error') }}</div>
@endif

@if($pendingPerubahan)
<div class="alert-pending">
    <i class="ri-time-line"></i>
    Anda memiliki pengajuan perubahan data penduduk yang sedang menunggu persetujuan Operator Nagari.
    <a href="{{ route('warga.ubah-penduduk') }}" style="margin-left:auto;color:#d97706;font-weight:600;text-decoration:underline;">Lihat</a>
</div>
@endif

<div class="welcome-card">
    <div>
        <h2>Selamat Datang, {{ ucwords(strtolower($user->name)) }}!</h2>
        <p>{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>
    <div style="text-align:right;font-size:.85rem;opacity:.85;">
        @if($penduduk && $penduduk->no_kk)
            No. KK: {{ $penduduk->no_kk }}
        @endif
        @if($keluarga && $keluarga->jorong)
            <br>Jorong: {{ ucwords(strtolower($keluarga->jorong)) }}
        @endif
    </div>
</div>

<div class="profile-card">
    @if($user->photo)
        <img src="{{ asset('storage/photos/' . $user->photo) }}" alt="foto" class="profile-avatar">
    @else
        <div class="profile-avatar-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
    @endif
    <div class="profile-info">
        <h3>{{ ucwords(strtolower($user->name)) }}</h3>
        <p class="nik"><i class="ri-fingerprint-line"></i> NIK: {{ $user->nik ?? ($penduduk->nik ?? '-') }}</p>
        <p><i class="ri-mail-line"></i> {{ $user->email }}</p>
        @if($penduduk)
        <p><i class="ri-map-pin-line"></i> {{ ucwords(strtolower($penduduk->alamat ?? '-')) }}</p>
        @endif
    </div>
</div>

<div class="quick-actions">
    <a href="{{ route('buatsuratwarga.index') }}" class="quick-action">
        <i class="ri-file-edit-line" style="color:var(--primary)"></i> Buat Surat
    </a>
    <a href="{{ route('buatsuratwarga.proses') }}" class="quick-action">
        <i class="ri-file-list-3-line" style="color:#f59e0b"></i> Proses Permohonan
    </a>
    <a href="{{ route('warga.ubah-penduduk') }}" class="quick-action">
        <i class="ri-edit-box-line" style="color:#10b981"></i> Ubah Data Penduduk
    </a>
    <a href="{{ route('warga.profil') }}" class="quick-action">
        <i class="ri-user-settings-line" style="color:#6366f1"></i> Profil Saya
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card diajukan">
        <div class="icon"><i class="ri-time-line"></i></div>
        <div class="number">{{ $suratStats->diajukan ?? 0 }}</div>
        <div class="label">Diajukan</div>
    </div>
    <div class="stat-card diproses">
        <div class="icon"><i class="ri-refresh-line"></i></div>
        <div class="number">{{ $suratStats->diproses ?? 0 }}</div>
        <div class="label">Diproses</div>
    </div>
    <div class="stat-card selesai">
        <div class="icon"><i class="ri-check-double-line"></i></div>
        <div class="number">{{ $suratStats->selesai ?? 0 }}</div>
        <div class="label">Selesai</div>
    </div>
    <div class="stat-card ditolak">
        <div class="icon"><i class="ri-close-circle-line"></i></div>
        <div class="number">{{ $suratStats->ditolak ?? 0 }}</div>
        <div class="label">Ditolak</div>
    </div>
</div>

@if($pengumuman->count() > 0)
<div class="glass" style="padding:1.5rem;border-radius:16px;margin-bottom:1.5rem;">
    <div class="section-title"><i class="ri-megaphone-line" style="color:var(--primary)"></i> Informasi & Pengumuman</div>

    @foreach($pengumuman as $p)
    <div class="pengumuman-card">
        <div class="pengumuman-date">
            <i class="ri-calendar-line"></i> {{ $p->created_at->translatedFormat('d F Y') }}
        </div>
        @if($p->tipe == 'khusus')
        <div class="pengumuman-badge-khusus">
            <i class="ri-user-star-line"></i> Khusus untuk Anda
        </div>
        @endif
        <div class="pengumuman-judul">{{ $p->judul }}</div>
        <div class="pengumuman-isi">{{ $p->isi }}</div>
    </div>
    @endforeach
</div>
@endif

<div class="glass" style="padding:1.5rem;border-radius:16px;margin-bottom:1.5rem;">
    <div class="section-title"><i class="ri-file-text-line" style="color:var(--primary)"></i> Surat Terbaru</div>
    @if($recentSurat->count() > 0)
    <div style="overflow-x:auto;">
        <table class="recent-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Surat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentSurat as $s)
                <tr>
                    <td>{{ $s->created_at->format('d/m/Y') }}</td>
                    <td>{{ $s->jenis_surat }}</td>
                    <td>
                        <span class="badge badge-{{ $s->status }}">
                            {{ ucfirst($s->status) }}
                        </span>
                    </td>
                    <td>
                        @if($s->status == 'selesai' || $s->status == 'ditolak')
                            <a href="{{ route('buatsuratwarga.cetak', $s->id) }}" class="quick-action" style="padding:.3rem .7rem;font-size:.8rem;display:inline-flex;">
                                <i class="ri-printer-line"></i>
                            </a>
                        @else
                            <a href="{{ route('buatsuratwarga.edit', $s->id) }}" class="quick-action" style="padding:.3rem .7rem;font-size:.8rem;display:inline-flex;">
                                <i class="ri-edit-line"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p style="text-align:center;color:var(--text-muted);padding:1.5rem;">
        <i class="ri-inbox-line" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
        Belum ada surat. <a href="{{ route('buatsuratwarga.index') }}" style="color:var(--primary);">Buat surat sekarang</a>
    </p>
    @endif
</div>

@endsection
