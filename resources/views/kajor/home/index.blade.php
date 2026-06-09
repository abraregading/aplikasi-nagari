@extends('kajor.layouts.app')

@section('title', 'Dashboard Kepala Jorong')

@section('head')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        color: white;
    }
    .dashboard-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.25rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .dashboard-header p { margin: 0; opacity: 0.9; font-size: 0.95rem; }
    .dashboard-header .header-meta { display: flex; gap: 1.5rem; margin-top: 1rem; font-size: 0.85rem; opacity: 0.85; }
    .dashboard-header .header-meta span { display: flex; align-items: center; gap: 0.4rem; }
    .jorong-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.2);
        padding: 0.4rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    .section-title {
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--primary);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (min-width: 768px) { .stats-grid { grid-template-columns: repeat(4, 1fr); } }

    .stat-card {
        background: rgba(255,255,255,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .stat-icon.primary { background: rgba(99, 102, 241, 0.15); color: #6366f1; }
    .stat-icon.success { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .stat-icon.info { background: rgba(14, 165, 233, 0.15); color: #0ea5e9; }
    .stat-icon.purple { background: rgba(139, 92, 246, 0.15); color: #8b5cf6; }
    .stat-icon.warning { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }

    .stat-info h3 { margin: 0; font-size: 1.5rem; font-weight: 700; color: #1f2937; }
    .stat-info p { margin: 0.2rem 0 0; font-size: 0.8rem; color: #6b7280; font-weight: 500; }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    @media (min-width: 992px) { .content-grid { grid-template-columns: 1fr 1fr; } }

    .quick-links-card {
        background: rgba(255,255,255,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 1.25rem;
    }
    .quick-links-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    @media (min-width: 768px) { .quick-links-grid { grid-template-columns: repeat(3, 1fr); } }

    .quick-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.25rem;
        background: rgba(255,255,255,0.5);
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 12px;
        text-decoration: none;
        color: #1f2937;
        transition: all 0.2s ease;
    }
    .quick-link:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
    }
    .quick-link i { font-size: 1.75rem; margin-bottom: 0.5rem; }
    .quick-link span { font-size: 0.85rem; font-weight: 600; }

    .demography-card {
        background: rgba(255,255,255,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .demo-item { margin-bottom: 1.25rem; }
    .demo-item:last-child { margin-bottom: 0; }
    .demo-header { display: flex; justify-content: space-between; margin-bottom: 0.5rem; }
    .demo-label { font-size: 0.85rem; color: #6b7280; font-weight: 600; }
    .demo-value { font-size: 0.85rem; color: #1f2937; font-weight: 700; }
    .progress-bg { height: 8px; background: rgba(0,0,0,0.08); border-radius: 4px; overflow: hidden; }
    .progress-fill { height: 100%; border-radius: 4px; transition: width 0.6s ease; }
    .progress-laki { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
    .progress-perempuan { background: linear-gradient(90deg, #ec4899, #f472b6); }

    .tools-grid { display: grid; grid-template-columns: 1fr; gap: 1rem; margin-bottom: 1.5rem; }
    @media (min-width: 768px) { .tools-grid { grid-template-columns: 1fr 1fr; } }

    .tool-card {
        background: rgba(255,255,255,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 1.25rem;
    }
    .tool-card h3 { margin: 0 0 1rem 0; font-size: 0.95rem; color: #1f2937; display: flex; align-items: center; gap: 0.5rem; }
    .tool-card h3 i { color: var(--primary); }
    .tool-form { display: flex; gap: 0.5rem; }
    .tool-input {
        flex: 1;
        padding: 0.65rem 1rem;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 10px;
        background: white;
        font-size: 0.9rem;
    }
    .tool-input:focus { outline: none; border-color: var(--primary); }
    .tool-btn {
        padding: 0.65rem 1rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .tool-btn:hover { background: #4f46e5; }

    .tool-result { margin-top: 1rem; padding: 1rem; border-radius: 10px; display: none; }
    .tool-result.show { display: block; }
    .tool-result.success { background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); }
    .tool-result.error { background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); }
    .tool-result h4 { margin: 0 0 0.75rem 0; font-size: 0.9rem; display: flex; align-items: center; gap: 0.4rem; }
    .tool-result.success h4 { color: #10b981; }
    .tool-result.error h4 { color: #ef4444; }
    .tool-detail { font-size: 0.8rem; }
    .tool-detail div { display: flex; justify-content: space-between; padding: 0.3rem 0; border-bottom: 1px solid rgba(0,0,0,0.05); }
    .tool-detail div:last-child { border-bottom: none; }
    .tool-detail span:first-child { color: #6b7280; }
    .tool-detail span:last-child { font-weight: 600; color: #1f2937; }
</style>
@endsection

@section('konten')

<div class="dashboard-header">
    <h1><i class="ri-dashboard-3-line"></i> Dashboard Kepala Jorong</h1>
    <p>Selamat bertugas! Berikut ringkasan data {{ ucwords(strtolower($jorongName)) }}.</p>
    <div class="header-meta">
        <span><i class="ri-map-pin-line"></i> Jorong {{ ucwords(strtolower($jorongName)) }}</span>
        <span><i class="ri-calendar-today-line"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
        <span><i class="ri-time-line"></i> {{ \Carbon\Carbon::now()->format('H:i') }} WIB</span>
    </div>
</div>

{{-- Stats Cards - Data Penduduk Jorong --}}
<div class="section-title"><i class="ri-group-line"></i> Data Penduduk Jorong</div>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary"><i class="ri-home-4-line"></i></div>
        <div class="stat-info"><h3>{{ number_format($jmlkeluarga) }}</h3><p>Total Keluarga (KK)</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon success"><i class="ri-group-line"></i></div>
        <div class="stat-info"><h3>{{ number_format($jmlpenduduk) }}</h3><p>Total Penduduk</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon info"><i class="ri-men-line"></i></div>
        <div class="stat-info"><h3>{{ number_format($jmllakilaki) }}</h3><p>Laki-laki</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="ri-women-line"></i></div>
        <div class="stat-info"><h3>{{ number_format($jmlperempuan) }}</h3><p>Perempuan</p></div>
    </div>
</div>

{{-- Stats Cards - Bisnis Kos --}}
<div class="section-title"><i class="ri-building-line"></i> Data Usaha Kos/Kontrakan</div>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon warning"><i class="ri-store-line"></i></div>
        <div class="stat-info"><h3>{{ number_format($totalKos) }}</h3><p>Total Usaha</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon primary"><i class="ri-door-open-line"></i></div>
        <div class="stat-info"><h3>{{ number_format($totalKamar) }}</h3><p>Total Kamar</p></div>
    </div>
</div>

{{-- Quick Links --}}
<div class="section-title"><i class="ri-links-line"></i> Menu Cepat</div>
<div class="content-grid">
    <div class="quick-links-card">
        <div class="quick-links-grid">
            <a href="{{ route('kajor.keluarga.index') }}" class="quick-link">
                <i class="ri-family-line"></i>
                <span>Data Keluarga</span>
            </a>
            <a href="{{ route('kajor.penduduk.index') }}" class="quick-link">
                <i class="ri-user-line"></i>
                <span>Data Penduduk</span>
            </a>
            <a href="{{ route('kajor.bisniskos.index') }}" class="quick-link">
                <i class="ri-store-2-line"></i>
                <span>Bisnis Kos</span>
            </a>
            <a href="{{ route('kajor.scanner') }}" class="quick-link">
                <i class="ri-qr-scan-line"></i>
                <span>Scanner QR</span>
            </a>
        </div>
    </div>
</div>

{{-- Demography --}}
<div class="demography-card">
    <div class="section-title"><i class="ri-pie-chart-line"></i> Demografi Penduduk Jorong</div>
    <div class="demo-item">
        <div class="demo-header">
            <span class="demo-label"><i class="ri-men-line" style="color: #3b82f6;"></i> Laki-laki</span>
            <span class="demo-value">{{ number_format($jmllakilaki) }} ({{ $jmlpenduduk > 0 ? round(($jmllakilaki/$jmlpenduduk)*100, 1) : 0 }}%)</span>
        </div>
        <div class="progress-bg">
            <div class="progress-fill progress-laki" style="width: {{ $jmlpenduduk > 0 ? ($jmllakilaki/$jmlpenduduk)*100 : 0 }}%"></div>
        </div>
    </div>
    <div class="demo-item">
        <div class="demo-header">
            <span class="demo-label"><i class="ri-women-line" style="color: #ec4899;"></i> Perempuan</span>
            <span class="demo-value">{{ number_format($jmlperempuan) }} ({{ $jmlpenduduk > 0 ? round(($jmlperempuan/$jmlpenduduk)*100, 1) : 0 }}%)</span>
        </div>
        <div class="progress-bg">
            <div class="progress-fill progress-perempuan" style="width: {{ $jmlpenduduk > 0 ? ($jmlperempuan/$jmlpenduduk)*100 : 0 }}%"></div>
        </div>
    </div>
</div>

{{-- Quick Tools --}}
<div class="section-title"><i class="ri-search-line"></i> Alat Pengecekkan Cepat</div>
<div class="tools-grid">
    <div class="tool-card">
        <h3><i class="ri-id-card-line"></i> Cek NIK Penduduk</h3>
        <div class="tool-form">
            <input type="text" id="cek-nik-input" class="tool-input" placeholder="Masukkan 16 digit NIK" maxlength="16">
            <button class="tool-btn" onclick="cekNik()">Cek</button>
        </div>
        <div id="cek-nik-result" class="tool-result">
            <h4 id="nik-status-text"></h4>
            <div id="nik-detail" class="tool-detail"></div>
        </div>
    </div>

    <div class="tool-card">
        <h3><i class="ri-family-line"></i> Cek Nomor KK</h3>
        <div class="tool-form">
            <input type="text" id="cek-kk-input" class="tool-input" placeholder="Masukkan 16 digit No. KK" maxlength="16">
            <button class="tool-btn" onclick="cekKk()">Cek</button>
        </div>
        <div id="cek-kk-result" class="tool-result">
            <h4 id="kk-status-text"></h4>
            <div id="kk-detail" class="tool-detail"></div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
function cekNik() {
    const input = document.getElementById('cek-nik-input');
    const result = document.getElementById('cek-nik-result');
    const detail = document.getElementById('nik-detail');
    const statusText = document.getElementById('nik-status-text');
    const nik = input.value;

    if (nik.length !== 16) { alert('NIK harus 16 digit'); return; }

    fetch(`{{ route('kajor.ceknik') }}?nik=${nik}`)
        .then(res => res.json())
        .then(data => {
            result.classList.remove('success', 'error');
            result.classList.add('show');
            if (data.found) {
                result.classList.add('success');
                statusText.innerHTML = '<i class="ri-checkbox-circle-line"></i> Data Ditemukan';
                detail.innerHTML = `
                    <div><span>Nama</span><span>${data.data.nama}</span></div>
                    <div><span>No. KK</span><span>${data.data.no_kk}</span></div>
                    <div><span>Jenis Kelamin</span><span>${data.data.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}</span></div>
                    <div><span>Alamat</span><span>${data.data.alamat || '-'}</span></div>
                `;
            } else {
                result.classList.add('error');
                statusText.innerHTML = '<i class="ri-error-warning-line"></i> Data Tidak Ditemukan';
                detail.innerHTML = '<div style="text-align: center; padding: 0.5rem;">NIK tersebut belum terdaftar dalam database</div>';
            }
        })
        .catch(err => { alert('Terjadi kesalahan'); });
}

function cekKk() {
    const input = document.getElementById('cek-kk-input');
    const result = document.getElementById('cek-kk-result');
    const detail = document.getElementById('kk-detail');
    const statusText = document.getElementById('kk-status-text');
    const no_kk = input.value;

    if (no_kk.length !== 16) { alert('No. KK harus 16 digit'); return; }

    fetch(`{{ route('kajor.cekkk') }}?no_kk=${no_kk}`)
        .then(res => res.json())
        .then(data => {
            result.classList.remove('success', 'error');
            result.classList.add('show');
            if (data.found) {
                result.classList.add('success');
                statusText.innerHTML = '<i class="ri-checkbox-circle-line"></i> Data Ditemukan';
                detail.innerHTML = `
                    <div><span>No. KK</span><span>${no_kk}</span></div>
                    <div><span>Alamat</span><span>${data.data.alamat}</span></div>
                    <div><span>RT/RW</span><span>${data.data.rt || '-'}/${data.data.rw || '-'}</span></div>
                    <div><span>Desa/Kelurahan</span><span>${data.data.desa_kelurahan || '-'}</span></div>
                    <div><span>Jumlah Anggota</span><span>${data.data.jumlah_anggota} orang</span></div>
                `;
            } else {
                result.classList.add('error');
                statusText.innerHTML = '<i class="ri-error-warning-line"></i> Data Tidak Ditemukan';
                detail.innerHTML = '<div style="text-align: center; padding: 0.5rem;">No. KK tersebut belum terdaftar dalam database</div>';
            }
        })
        .catch(err => { alert('Terjadi kesalahan'); });
}
</script>
@endsection