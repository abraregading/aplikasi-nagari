@extends('warga.layouts.app')

@section('title', 'Buat Surat - Pilih Jenis Layanan')

@section('head')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .page-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
    }
    .page-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }
    .surat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    .surat-card {
        padding: 0;
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    .surat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(14, 165, 233, 0.15);
    }
    .surat-card-header {
        height: 140px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .surat-card-header::before {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        top: -40px;
        right: -30px;
    }
    .surat-card-header::after {
        content: '';
        position: absolute;
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
        bottom: -20px;
        left: -10px;
    }
    .surat-card-header i {
        font-size: 3rem;
        color: rgba(255,255,255,0.9);
        z-index: 1;
    }
    .surat-card-body {
        padding: 1.25rem 1.5rem;
    }
    .surat-card-body h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }
    .surat-card-body p {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin-bottom: 1rem;
    }
    .surat-card-footer {
        padding: 0 1.5rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .surat-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        background: rgba(14, 165, 233, 0.1);
        color: var(--primary);
        font-weight: 500;
    }
    .btn-buat-surat {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        font-family: 'Outfit', sans-serif;
    }
    .btn-buat-surat:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
    }
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
</style>
@endsection

@section('konten')

<div class="page-header">
    <div>
        <h2><i class="ri-file-add-line" style="color: var(--primary); margin-right: 8px;"></i>Buat Surat</h2>
        <p>Pilih jenis layanan surat yang ingin Anda buat</p>
    </div>
</div>

@if($jenisSurat->count() > 0)
<div class="surat-grid">
    @foreach($jenisSurat as $item)
    <div class="surat-card glass">
        <div class="surat-card-header">
            <i class="ri-file-text-line"></i>
        </div>
        <div class="surat-card-body">
            <h3>{{ $item->nama_layanan }}</h3>
            <p>{{ $item->deskripsi ?? 'Layanan pembuatan surat resmi dari pemerintah nagari.' }}</p>
        </div>
        <div class="surat-card-footer">
            <span class="surat-badge">
                <i class="ri-file-list-3-line"></i>
                {{ $item->riwayat_surat_count ?? 0 }} surat dibuat
            </span>
            <a href="{{ route('buatsuratwarga.create', ['jenis' => $item->id]) }}" class="btn-buat-surat">
                <i class="ri-add-line"></i> Buat Surat
            </a>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state glass" style="border-radius: 16px;">
    <i class="ri-file-unknow-line"></i>
    <h3>Belum Ada Jenis Layanan</h3>
    <p>Silakan hubungi administrator untuk menambahkan jenis layanan surat.</p>
</div>
@endif

@endsection