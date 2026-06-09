@extends('petugas.layouts.app')
@section('title', 'Detail Riwayat Pendataan')

@section('head')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .glass { background: rgba(255,255,255,.7); backdrop-filter: blur(10px); border-radius: 16px; padding: 1.5rem; border: 1px solid rgba(255,255,255,.8); }
    .btn { padding: .6rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: .9rem; text-decoration: none; display: inline-flex; align-items: center; gap: .4rem; transition: all .2s; cursor: pointer; border: none; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #0284c7; }
    .btn-secondary { background: rgba(107,114,128,.15); color: #4b5563; }
    .btn-secondary:hover { background: rgba(107,114,128,.25); }
    .btn-success { background: rgba(16,185,129,.15); color: #059669; }
    .btn-success:hover { background: rgba(16,185,129,.25); }
    .info-card { background: rgba(255,255,255,.8); border-radius: 12px; padding: 1.25rem; margin-bottom: 1rem; }
    .info-label { font-size: .75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: .25rem; }
    .info-value { font-size: .95rem; font-weight: 500; }
    .status-badge { padding: .25rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600; display: inline-block; }
    .badge-create { background: rgba(16,185,129,.15); color: #059669; }
    .badge-update { background: rgba(245,158,11,.15); color: #d97706; }
    .qr-section { text-align: center; padding: 1.5rem; background: rgba(255,255,255,.8); border-radius: 12px; }
    .qr-section img { border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,.1); }
    .qr-section p { font-size: .85rem; color: var(--text-muted); margin-top: .75rem; }
    .token-info { background: rgba(255,255,255,.6); border-radius: 8px; padding: 1rem; font-size: .85rem; }
    .token-info code { display: block; margin-top: .25rem; word-break: break-all; }
    .action-buttons { display: flex; flex-direction: column; gap: .5rem; margin-top: 1rem; }
    .table-responsive { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: .5rem; font-size: .8rem; color: var(--text-muted); border-bottom: 1px solid rgba(0,0,0,.1); }
    .data-table td { padding: .5rem; font-size: .85rem; border-bottom: 1px solid rgba(0,0,0,.05); }
    .empty-state { text-align: center; padding: 2rem; color: var(--text-muted); }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-file-info-line" style="color: var(--primary)"></i> Detail Riwayat Pendataan</h2>
    <a href="{{ route('petugas.pendataankeluarga.riwayatsaya') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <div>
        <div class="glass">
            <h5 style="margin-bottom: 1rem; font-weight: 600;">Informasi Riwayat</h5>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                <div class="info-card">
                    <div class="info-label">No. KK</div>
                    <div class="info-value">{{ $riwayat->no_kk }}</div>
                </div>
                <div class="info-card">
                    <div class="info-label">Nama Kepala Keluarga</div>
                    <div class="info-value">{{ $riwayat->kepala_keluarga_nama ?? '-' }}</div>
                </div>
                <div class="info-card">
                    <div class="info-label">Tanggal Update</div>
                    <div class="info-value">{{ $riwayat->tanggal_update->format('d/m/Y H:i') }}</div>
                </div>
                <div class="info-card">
                    <div class="info-label">Aksi</div>
                    <div>
                        @if($riwayat->aksi == 'create')
                            <span class="status-badge badge-create">Dibuat</span>
                        @else
                            <span class="status-badge badge-update">Diperbarui</span>
                        @endif
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-label">Petugas</div>
                    <div class="info-value">{{ $riwayat->petugas->name ?? '-' }}</div>
                </div>
                <div class="info-card">
                    <div class="info-label">Catatan</div>
                    <div class="info-value">{{ $riwayat->catatan ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="glass" style="margin-top: 1.5rem;">
            <h5 style="margin-bottom: 1rem; font-weight: 600;">Perbandingan Data</h5>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <h6 style="font-size: .9rem; margin-bottom: .75rem; color: var(--text-muted);">Data Sebelum</h6>
                    @if($riwayat->data_sebelum)
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr><th>Field</th><th>Nilai</th></tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat->data_sebelum as $key => $value)
                                <tr>
                                    <td class="text-capitalize">{{ str_replace('_', ' ', $key) }}</td>
                                    <td>{{ $value ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="empty-state">Tidak ada data sebelumnya (Data Baru)</p>
                    @endif
                </div>
                <div>
                    <h6 style="font-size: .9rem; margin-bottom: .75rem; color: var(--text-muted);">Data Sesudah</h6>
                    @if($riwayat->data_sesudah)
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr><th>Field</th><th>Nilai</th></tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat->data_sesudah as $key => $value)
                                <tr>
                                    <td class="text-capitalize">{{ str_replace('_', ' ', $key) }}</td>
                                    <td>{{ $value ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="empty-state">Tidak ada data setelahnya</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="qr-section">
            <h5 style="margin-bottom: 1rem;">QR Code</h5>
            <img src="{{ $riwayat->qr_code_url }}" alt="QR Code" style="max-width: 180px;">
            <p>Scan untuk edit data keluarga</p>
            <div class="action-buttons">
                <a href="{{ $riwayat->qr_url }}" target="_blank" class="btn btn-primary">
                    <i class="ri-external-link-line"></i> Buka Link
                </a>
                <a href="{{ route('petugas.pendataankeluarga.edit', $riwayat->keluarga_id) }}" class="btn btn-success">
                    <i class="ri-edit-line"></i> Edit Keluarga
                </a>
            </div>
        </div>
        <div class="glass" style="margin-top: 1rem;">
            <div class="info-label">QR Token</div>
            <div class="token-info">
                <code>{{ $riwayat->qr_token }}</code>
            </div>
            <div class="info-label" style="margin-top: .75rem;">URL</div>
            <div class="token-info">
                <small style="word-break: break-all;">{{ $riwayat->qr_url }}</small>
            </div>
        </div>
    </div>
</div>
@endsection