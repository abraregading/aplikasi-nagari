@extends('admin.layouts.app')

@section('title', 'Detail Data Penduduk - Admin Desa')

@section('head')
<style>
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    .detail-item {
        margin-bottom: 1rem;
    }
    .detail-item .detail-label {
        display: block;
        color: var(--text-muted);
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    .detail-item .detail-value {
        color: var(--text-main);
        font-size: 1rem;
        font-weight: 600;
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('data-penduduk.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Detail Data Penduduk</h2>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h3 style="margin: 0; color: var(--primary);"><i class="ri-user-line"></i> {{ $penduduk->nama_lengkap }}</h3>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('data-penduduk.edit', $penduduk->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                <i class="ri-edit-line"></i> Edit
            </a>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <span class="detail-label">NIK</span>
            <span class="detail-value">{{ $penduduk->nik }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">No. KK</span>
            <span class="detail-value">{{ $penduduk->no_kk }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Nama Lengkap</span>
            <span class="detail-value">{{ $penduduk->nama_lengkap }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Tempat, Tanggal Lahir</span>
            <span class="detail-value">{{ $penduduk->tempat_lahir ?? '-' }}, {{ $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('d M Y') : '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Jenis Kelamin</span>
            <span class="detail-value">
                @if($penduduk->jenis_kelamin == 'L')
                    <span style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">Laki-laki</span>
                @else
                    <span style="background: rgba(236, 72, 153, 0.15); color: #ec4899; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">Perempuan</span>
                @endif
            </span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Agama</span>
            <span class="detail-value">{{ $penduduk->agama ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Status Perkawinan</span>
            <span class="detail-value">{{ $penduduk->status_perkawinan ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Hubungan Keluarga</span>
            <span class="detail-value">{{ $penduduk->hubungan_keluarga ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Pekerjaan</span>
            <span class="detail-value">{{ $penduduk->pekerjaan ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Pendidikan Terakhir</span>
            <span class="detail-value">{{ $penduduk->pendidikan_terakhir ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Alamat</span>
            <span class="detail-value">{{ $penduduk->alamat ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Status Hidup</span>
            <span class="detail-value">
                @if($penduduk->status_hidup == 'hidup')
                    <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">Hidup</span>
                @elseif($penduduk->status_hidup == 'meninggal')
                    <span style="background: rgba(107, 114, 128, 0.15); color: #6b7280; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">Meninggal</span>
                @else
                    <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">Pindah</span>
                @endif
            </span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Terakhir Diperbarui</span>
            <span class="detail-value">{{ $penduduk->updated_at ? $penduduk->updated_at->format('d M Y, H:i') : '-' }}</span>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
@endsection
