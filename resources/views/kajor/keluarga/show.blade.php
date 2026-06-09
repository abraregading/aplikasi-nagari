@extends('kajor.layouts.app')

@section('title', 'Detail Keluarga - ' . $keluarga->no_kk)

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
        color: #000;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .status-aktif { background: rgba(16, 185, 129, 0.2); color: #10b981; }
    .status-pindah { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
    .status-non-aktif { background: rgba(107, 114, 128, 0.2); color: #6b7280; }
    .status-hidup { background: rgba(16, 185, 129, 0.2); color: #10b981; }
    .status-meninggal { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
    .status-pindah_hidup { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
</style>
@endsection

@section('konten')
<div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 2rem;">
    <div>
        <h2 style="margin-bottom: 0.5rem;">Detail Keluarga</h2>
        <a href="{{ route('kajor.keluarga.index') }}" style="color: #999; text-decoration: none;">
            <i class="ri-arrow-left-line"></i> Kembali ke Daftar
        </a>
    </div>
    <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('kajor.keluarga.edit', $keluarga->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.2); color: #f59e0b; border: none; padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
            <i class="ri-edit-line"></i> Edit KK
        </a>
        <div style="font-size: 0.9rem; color: #999;">
            Jorong: <strong>{{ $jorongName }}</strong>
        </div>
    </div>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div class="detail-card">
        <h3><i class="ri-home-4-line"></i> Informasi Kartu Keluarga</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">No. KK</span>
                <span class="info-value" style="font-size: 1.1rem; font-weight: 600;">{{ $keluarga->no_kk }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">NIK Kepala Keluarga</span>
                <span class="info-value">{{ $keluarga->kepala_keluarga_nik ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jumlah Anggota</span>
                <span class="info-value">{{ $keluarga->jumlah_anggota }} orang</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="info-value">
                    <span class="status-badge status-{{ $keluarga->status }}">
                        @switch($keluarga->status)
                            @case('aktif') Aktif @break
                            @case('pindah') Pindah @break
                            @case('non-aktif') Nonaktif @break
                            @default {{ $keluarga->status }}
                        @endswitch
                    </span>
                </span>
            </div>
            <div class="info-item" style="grid-column: span 2;">
                <span class="info-label">Alamat</span>
                <span class="info-value">{{ $keluarga->alamat }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">RT/RW</span>
                <span class="info-value">{{ $keluarga->rt ?? '-' }}/{{ $keluarga->rw ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jorong</span>
                <span class="info-value">{{ $keluarga->jorong ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Desa/Kelurahan</span>
                <span class="info-value">{{ $keluarga->desa_kelurahan ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Kecamatan</span>
                <span class="info-value">{{ $keluarga->kecamatan ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Kabupaten/Kota</span>
                <span class="info-value">{{ $keluarga->kabupaten_kota ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Provinsi</span>
                <span class="info-value">{{ $keluarga->provinsi ?? '-' }}</span>
            </div>
        </div>
    </div>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px; margin-top: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="margin: 0; color: var(--primary);">
            <i class="ri-group-line"></i> Anggota Keluarga
        </h3>
        <a href="{{ route('kajor.penduduk.create', $keluarga->no_kk) }}" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1rem; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
            <i class="ri-add-line"></i> Tambah Anggota
        </a>
    </div>

    @if($keluarga->penduduks->count() > 0)
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: rgba(255,255,255,0.05);">
                    <th style="padding: 1rem; text-align: left; font-size: 0.8rem; color: #999;">NIK</th>
                    <th style="padding: 1rem; text-align: left; font-size: 0.8rem; color: #999;">Nama Lengkap</th>
                    <th style="padding: 1rem; text-align: left; font-size: 0.8rem; color: #999;">JK</th>
                    <th style="padding: 1rem; text-align: left; font-size: 0.8rem; color: #999;">Tgl Lahir</th>
                    <th style="padding: 1rem; text-align: left; font-size: 0.8rem; color: #999;">Hubungan</th>
                    <th style="padding: 1rem; text-align: left; font-size: 0.8rem; color: #999;">Pekerjaan</th>
                    <th style="padding: 1rem; text-align: left; font-size: 0.8rem; color: #999;">Status</th>
                    <th style="padding: 1rem; text-align: center; font-size: 0.8rem; color: #999;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keluarga->penduduks as $penduduk)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <td style="padding: 0.75rem;">{{ $penduduk->nik }}</td>
                    <td style="padding: 0.75rem;">{{ $penduduk->nama_lengkap }}</td>
                    <td style="padding: 0.75rem;">{{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td style="padding: 0.75rem;">{{ $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                    <td style="padding: 0.75rem;">{{ $penduduk->hubungan_keluarga ?? '-' }}</td>
                    <td style="padding: 0.75rem;">{{ $penduduk->pekerjaan ?? '-' }}</td>
                    <td style="padding: 0.75rem;">
                        <span class="status-badge status-{{ $penduduk->status_hidup }}">
                            @switch($penduduk->status_hidup)
                                @case('hidup') Hidup @break
                                @case('meninggal') Meninggal @break
                                @case('pindah') Pindah @break
                                @default {{ $penduduk->status_hidup }}
                            @endswitch
                        </span>
                    </td>
                    <td style="padding: 0.75rem;">
                        <a href="{{ route('kajor.penduduk.edit', $penduduk->id) }}" style="color: #f59e0b; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                            <i class="ri-edit-line"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p style="color: #999; font-style: italic;">Tidak ada data anggota keluarga.</p>
    @endif
</div>
@endsection