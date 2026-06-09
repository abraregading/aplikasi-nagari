@extends('petugas.layouts.app')
@section('title', 'Detail Kartu Keluarga')

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

    /* Badges - scoped names */
    .status-badge { padding: .25rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600; display: inline-block; position: static; width: auto; height: auto; }
    .status-aktif { background: rgba(16,185,129,.12); color: #059669; }
    .status-pindah { background: rgba(245,158,11,.12); color: #d97706; }
    .status-non-aktif { background: rgba(239,68,68,.12); color: #dc2626; }
    .status-L { background: rgba(14,165,233,.12); color: #0369a1; }
    .status-P { background: rgba(217,70,239,.12); color: #a21caf; }
    .status-hidup { background: rgba(16,185,129,.12); color: #059669; }
    .status-meninggal { background: rgba(239,68,68,.12); color: #dc2626; }
    .status-pindah-text { background: rgba(245,158,11,.12); color: #d97706; }

    /* Table */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: .75rem; color: var(--text-muted); font-size: .8rem; font-weight: 600; text-transform: uppercase; border-bottom: 2px solid rgba(0,0,0,.08); }
    .data-table td { padding: .85rem .75rem; font-size: .9rem; border-bottom: 1px solid rgba(0,0,0,.05); }
    .data-table tr:hover td { background: rgba(14,165,233,.03); }

    /* Buttons */
    .btn { padding: .6rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: .9rem; text-decoration: none; display: inline-flex; align-items: center; gap: .4rem; transition: all .2s; cursor: pointer; border: none; font-family: inherit; }
    .btn-edit-action { background: rgba(245,158,11,.1); color: #d97706; border: 1px solid rgba(245,158,11,.2); }
    .btn-edit-action:hover { background: rgba(245,158,11,.2); }
    .btn-secondary { background: transparent; color: var(--text-main); border: 1px solid rgba(0,0,0,.15); }
    .btn-secondary:hover { background: rgba(0,0,0,.03); }
    .btn-group { display: flex; gap: .75rem; margin-top: 1.5rem; }

    @media(max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } .table-wrapper { overflow-x: auto; } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <a href="{{ route('petugas.pendataankeluarga.index') }}" class="glass-select" style="background: transparent; border: 1px solid var(--text-muted); padding: .5rem 1rem; color: var(--text-main); text-decoration: none;">
        <i class="ri-arrow-left-line"></i>
    </a>
    <h2>Detail Kartu Keluarga</h2>
</div>

<div class="glass" style="padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
    <div class="detail-section">
        <h3><i class="ri-home-line"></i> Informasi Kartu Keluarga</h3>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="label">No. KK</span>
                <span class="value">{{ $keluarga->no_kk }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Kepala Keluarga</span>
                <span class="value">{{ $kepalaKeluarga ? $kepalaKeluarga->nama_lengkap : ($keluarga->kepala_keluarga_nik ?? '-') }}</span>
            </div>
            <div class="detail-item">
                <span class="label">NIK Kepala Keluarga</span>
                <span class="value">{{ $keluarga->kepala_keluarga_nik ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Status</span>
                <span class="value">
                    @if($keluarga->status == 'aktif')<span class="status-badge status-aktif">Aktif</span>
                    @elseif($keluarga->status == 'pindah')<span class="status-badge status-pindah">Pindah</span>
                    @else<span class="status-badge status-non-aktif">Non-Aktif</span>@endif
                </span>
            </div>
            <div class="detail-item">
                <span class="label">Alamat</span>
                <span class="value">{{ $keluarga->alamat ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Jorong</span>
                <span class="value">{{ $keluarga->jorong ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Desa/Kelurahan</span>
                <span class="value">{{ $keluarga->desa_kelurahan ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Kecamatan</span>
                <span class="value">{{ $keluarga->kecamatan ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Kabupaten/Kota</span>
                <span class="value">{{ $keluarga->kabupaten_kota ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Provinsi</span>
                <span class="value">{{ $keluarga->provinsi ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Kode Pos</span>
                <span class="value">{{ $keluarga->kode_pos ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Jumlah Anggota</span>
                <span class="value">{{ $keluarga->jumlah_anggota }}</span>
            </div>
        </div>
    </div>
</div>

<div class="glass" style="padding: 1.5rem; border-radius: 16px;">
    <div class="detail-section">
        <h3><i class="ri-group-line"></i> Anggota Keluarga ({{ $anggota->count() }})</h3>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>Hub. Keluarga</th>
                        <th>Pekerjaan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota as $a)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="font-weight: 500;">{{ $a->nik }}</td>
                        <td>{{ $a->nama_lengkap }}</td>
                        <td><span class="status-badge status-{{ $a->jenis_kelamin }}">{{ $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span></td>
                        <td>{{ $a->hubungan_keluarga ?? '-' }}</td>
                        <td>{{ $a->pekerjaan ?? '-' }}</td>
                        <td>
                            @if(($a->status_hidup ?? 'hidup') == 'hidup')
                                <span class="status-badge status-hidup">Hidup</span>
                            @elseif($a->status_hidup == 'meninggal')
                                <span class="status-badge status-meninggal">Meninggal</span>
                            @else
                                <span class="status-badge status-pindah-text">Pindah</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada data anggota keluarga</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="btn-group">
        <a href="{{ route('petugas.pendataankeluarga.edit', $keluarga->id) }}" class="btn btn-edit-action"><i class="ri-edit-line"></i> Edit Data</a>
        <a href="{{ route('petugas.pendataankeluarga.index') }}" class="btn btn-secondary"><i class="ri-arrow-left-line"></i> Kembali</a>
    </div>
</div>
@endsection
