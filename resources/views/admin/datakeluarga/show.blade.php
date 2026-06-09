@extends('admin.layouts.app')

@section('title', 'Detail Data Keluarga - Admin Desa')

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
    <a href="{{ route('data-keluarga.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Detail Data Keluarga</h2>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h3 style="margin: 0; color: var(--primary);"><i class="ri-home-4-line"></i> KK: {{ $keluarga->no_kk }}</h3>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('data-keluarga.edit', $keluarga->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.5rem 1rem; font-size: 0.85rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                <i class="ri-edit-line"></i> Edit
            </a>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <span class="detail-label">Nomor Kartu Keluarga</span>
            <span class="detail-value">{{ $keluarga->no_kk }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">NIK Kepala Keluarga</span>
            <span class="detail-value">{{ $keluarga->kepala_keluarga_nik ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Alamat</span>
            <span class="detail-value">{{ $keluarga->alamat }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Jorong</span>
            <span class="detail-value">{{ $keluarga->jorong ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Desa/Kelurahan (Kejorongan)</span>
            <span class="detail-value">{{ $keluarga->desa_kelurahan ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Kecamatan</span>
            <span class="detail-value">{{ $keluarga->kecamatan ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Kabupaten/Kota</span>
            <span class="detail-value">{{ $keluarga->kabupaten_kota ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Provinsi</span>
            <span class="detail-value">{{ $keluarga->provinsi ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Kode Pos</span>
            <span class="detail-value">{{ $keluarga->kode_pos ?? '-' }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Jumlah Anggota</span>
            <span class="detail-value">{{ $keluarga->jumlah_anggota }} Orang</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Status</span>
            <span class="detail-value">
                @if($keluarga->status == 'aktif')
                    <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">Aktif</span>
                @elseif($keluarga->status == 'pindah')
                    <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">Pindah</span>
                @else
                    <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">Non-Aktif</span>
                @endif
            </span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Terakhir Diperbarui</span>
            <span class="detail-value">{{ $keluarga->updated_at ? $keluarga->updated_at->format('d M Y, H:i') : '-' }}</span>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
@endsection
