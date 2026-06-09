@extends('site.konten.app')

@section('judul', 'Statistik Penduduk - ' . ($profilnagari['bentuk_pemerintahan'] ?? 'Desa') . ' ' . ($profilnagari['nama_pemerintahan'] ?? 'Digital'))

@section('sub_judul', 'Statistik Penduduk')

@section('konten1')

<header class="page-header" style="background-image: url('{{asset('site')}}/assets/hero.png');">
    <h1>Statistik Penduduk</h1>
</header>

<div class="stats container">
    <div class="stat-card">
        <i class="fa-solid fa-users" style="font-size: 2rem; color: var(--accent-color); margin-bottom: 0.5rem;"></i>
        <div class="stat-number">{{ $jmlpenduduk }}</div>
        <div class="stat-label">Total Penduduk</div>
    </div>
    <div class="stat-card">
        <i class="fa-solid fa-house-chimney" style="font-size: 2rem; color: var(--accent-color); margin-bottom: 0.5rem;"></i>
        <div class="stat-number">{{ $jmlkeluarga }}</div>
        <div class="stat-label">Total Keluarga</div>
    </div>
</div>

<section id="statistik-data" style="background-color: #f0f7f4;">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Rekap Data</span>
            <h2>Klasifikasi Penduduk</h2>
        </div>

        <div class="services-grid">
            <div class="stat-card-table">
                <div class="stat-card-header">
                    <div class="stat-card-icon">
                        <i class="fa-solid fa-calendar"></i>
                    </div>
                    <h3>Kelompok Umur</h3>
                </div>
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>Kelompok Umur</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelompokUmur as $item)
                        <tr>
                            <td>{{ $item->kategori }}</td>
                            <td style="text-align: right; font-weight: 600;">{{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="text-align: center; color: #999;">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="stat-card-table">
                <div class="stat-card-header">
                    <div class="stat-card-icon">
                        <i class="fa-solid fa-place-of-worship"></i>
                    </div>
                    <h3>Agama</h3>
                </div>
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>Agama</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agama as $item)
                        <tr>
                            <td>{{ $item->agama ?: '-' }}</td>
                            <td style="text-align: right; font-weight: 600;">{{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="text-align: center; color: #999;">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="stat-card-table">
                <div class="stat-card-header">
                    <div class="stat-card-icon">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <h3>Jenis Pekerjaan</h3>
                </div>
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>Pekerjaan</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pekerjaan as $item)
                        <tr>
                            <td>{{ $item->pekerjaan ?: '-' }}</td>
                            <td style="text-align: right; font-weight: 600;">{{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="text-align: center; color: #999;">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<style>
.stat-card-table {
    background: white;
    padding: 1.5rem;
    border-radius: 20px;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    border: 1px solid #eee;
}

.stat-card-table:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.stat-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f7f4;
}

.stat-card-header h3 {
    font-size: 1.15rem;
    color: var(--primary-color);
    margin: 0;
}

.stat-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: #f0f7f4;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: var(--accent-color);
    flex-shrink: 0;
}

.stat-card-table .info-table {
    margin-top: 0;
    box-shadow: none;
    border-radius: 8px;
}

.stat-card-table .info-table th {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.75rem 1rem;
}

.stat-card-table .info-table td {
    padding: 0.7rem 1rem;
    font-size: 0.92rem;
}

.stat-card-table .info-table tbody tr:hover {
    background-color: #f0f7f4;
}

.stat-card-table .info-table tbody tr:last-child td {
    border-bottom: none;
}
</style>

@endsection
