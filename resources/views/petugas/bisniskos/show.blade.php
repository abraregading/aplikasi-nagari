@extends('petugas.layouts.app')
@section('title', 'Detail ' . $bisnis->nama_usaha)

@section('head')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .page-header .actions { display: flex; gap: .5rem; }
    .glass { background: rgba(255,255,255,.7); backdrop-filter: blur(10px); border-radius: 16px; padding: 1.5rem; border: 1px solid rgba(255,255,255,.8); }
    .btn { padding: .5rem 1rem; border-radius: 8px; font-size: .85rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: .3rem; transition: all .2s; border: none; cursor: pointer; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #0284c7; }
    .btn-secondary { background: rgba(107,114,128,.15); color: #4b5563; }
    .btn-secondary:hover { background: rgba(107,114,128,.25); }
    .btn-success { background: rgba(16,185,129,.15); color: #059669; }
    .btn-success:hover { background: rgba(16,185,129,.25); }
    .detail-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .detail-card { background: rgba(255,255,255,.6); border-radius: 12px; padding: 1rem; }
    .detail-label { font-size: .75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: .25rem; }
    .detail-value { font-size: .95rem; font-weight: 500; }
    .badge { padding: .25rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600; }
    .badge-kos { background: rgba(14,165,233,.15); color: #0ea5e9; }
    .badge-kontrakan { background: rgba(245,158,11,.15); color: #d97706; }
    .badge-rumah_petak { background: rgba(139,92,246,.15); color: #8b5cf6; }
    .badge-aktif { background: rgba(16,185,129,.15); color: #059669; }
    .badge-nonaktif { background: rgba(239,68,68,.15); color: #dc2626; }
    .section-title { font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; color: var(--primary); }
    .table-responsive { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: .75rem; color: var(--text-muted); font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; border-bottom: 2px solid rgba(0,0,0,.08); }
    .data-table td { padding: .75rem; font-size: .9rem; border-bottom: 1px solid rgba(0,0,0,.05); }
    .data-table tr:hover td { background: rgba(14,165,233,.03); }
    .empty-state { text-align: center; padding: 2rem; color: var(--text-muted); }
    @media(max-width:768px) { .detail-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-home-4-line" style="color: var(--primary)"></i> {{ $bisnis->nama_usaha }}</h2>
    <div class="actions">
        <a href="{{ route('petugas.bisniskos.index') }}" class="btn btn-secondary">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <a href="{{ route('petugas.bisniskos.edit', $bisnis->id) }}" class="btn btn-primary">
            <i class="ri-edit-line"></i> Edit
        </a>
    </div>
</div>

<div class="glass" style="margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <div>
            @if($bisnis->jenis_usaha == 'kos')
                <span class="badge badge-kos">Kos</span>
            @elseif($bisnis->jenis_usaha == 'kontrakan')
                <span class="badge badge-kontrakan">Kontrakan</span>
            @else
                <span class="badge badge-rumah_petak">Rumah Petak</span>
            @endif
            @if($bisnis->status == 'aktif')
                <span class="badge badge-aktif" style="margin-left: .5rem;">Aktif</span>
            @else
                <span class="badge badge-nonaktif" style="margin-left: .5rem;">Nonaktif</span>
            @endif
        </div>
        <a href="{{ route('petugas.bisniskos.penghuni.index', $bisnis->id) }}" class="btn btn-success">
            <i class="ri-user-add-line"></i> Kelola Penghuni
        </a>
    </div>

    <div class="detail-grid">
        <div class="detail-card">
            <div class="detail-label">Alamat</div>
            <div class="detail-value">{{ $bisnis->alamat }}</div>
            <div style="font-size: .85rem; color: var(--text-muted);">
                RT {{ $bisnis->rt ?? '-' }} / RW {{ $bisnis->rw ?? '-' }}, {{ $bisnis->desa_kelurahan ?? '' }}
            </div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Jumlah Kamar</div>
            <div class="detail-value">{{ $bisnis->jumlah_kamar }} Kamar</div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Harga Sewa</div>
            <div class="detail-value">
                @if($bisnis->harga_sewa_min && $bisnis->harga_sewa_max)
                    Rp {{ number_format($bisnis->harga_sewa_min, 0, ',', '.') }} - Rp {{ number_format($bisnis->harga_sewa_max, 0, ',', '.') }}
                @elseif($bisnis->harga_sewa_min)
                    Rp {{ number_format($bisnis->harga_sewa_min, 0, ',', '.') }}
                @else
                    -
                @endif
            </div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Nama Pemilik</div>
            <div class="detail-value">{{ $bisnis->pemilik_nama }}</div>
        </div>
        <div class="detail-card">
            <div class="detail-label">NIK Pemilik</div>
            <div class="detail-value">{{ $bisnis->pemilik_nik ?? '-' }}</div>
        </div>
        <div class="detail-card">
            <div class="detail-label">Telepon</div>
            <div class="detail-value">{{ $bisnis->pemilik_telepon ?? '-' }}</div>
        </div>
    </div>

    @if($bisnis->fasilitas)
    <div class="detail-card">
        <div class="detail-label">Fasilitas</div>
        <div class="detail-value">{{ $bisnis->fasilitas }}</div>
    </div>
    @endif

    @if($bisnis->catatan)
    <div class="detail-card" style="margin-top: 1rem;">
        <div class="detail-label">Catatan</div>
        <div class="detail-value">{{ $bisnis->catatan }}</div>
    </div>
    @endif
</div>

<div class="glass">
    <div class="section-title">Daftar Penghuni Aktif ({{ $penghuniAktif->count() }})</div>
    
    @if($penghuniAktif->count() > 0)
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No. Kamar</th>
                    <th>Harga Sewa</th>
                    <th>Tanggal Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penghuniAktif as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->no_kamar ?? '-' }}</td>
                    <td>Rp {{ number_format($p->harga_sewa, 0, ',', '.') }}</td>
                    <td>{{ $p->tanggal_masuk ? $p->tanggal_masuk->format('d/m/Y') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <i class="ri-user-line" style="font-size: 2rem; display: block; margin-bottom: .5rem;"></i>
        <p>Belum ada penghuni aktif</p>
    </div>
    @endif
</div>
@endsection