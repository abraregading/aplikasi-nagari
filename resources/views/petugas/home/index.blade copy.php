@extends('petugas.layouts.app')

@section('title', 'Dashboard Petugas')

@section('head')
<style>
    .dashboard-welcome { margin-bottom: 1.5rem; }
    .dashboard-welcome h2 { font-size: 1.5rem; margin-bottom: 0.3rem; }
    .dashboard-welcome p { color: var(--text-muted); font-size: 0.9rem; }
    
    /* Stats Grid - Mobile First */
    .stats-grid-extended { 
        display: grid; 
        grid-template-columns: repeat(2, 1fr); 
        gap: 0.75rem; 
        margin-bottom: 1.5rem; 
    }
    .mini-stat { 
        padding: 1rem; 
        border-radius: 12px; 
        display: flex; 
        align-items: center; 
        gap: 0.75rem; 
    }
    .mini-stat .mini-icon { 
        width: 40px; 
        height: 40px; 
        border-radius: 10px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 1.1rem; 
        flex-shrink: 0; 
    }
    .mini-stat .mini-info h4 { 
        font-size: 1.1rem; 
        font-weight: 700; 
        margin: 0; 
        line-height: 1.2; 
    }
    .mini-stat .mini-info p { 
        font-size: 0.7rem; 
        color: var(--text-muted); 
        margin: 0; 
        margin-top: 2px; 
    }
    
    /* Surat Status Row - Mobile */
    .surat-status-row { 
        display: grid; 
        grid-template-columns: repeat(2, 1fr); 
        gap: 0.75rem; 
        margin-bottom: 1.5rem; 
    }
    .status-card { 
        padding: 1rem; 
        border-radius: 12px; 
        text-align: center; 
    }
    .status-card .status-count { 
        font-size: 1.5rem; 
        font-weight: 700; 
        line-height: 1; 
    }
    .status-card .status-label { 
        font-size: 0.7rem; 
        color: var(--text-muted); 
        margin-top: 0.3rem; 
    }
    .status-card .status-dot { 
        width: 6px; 
        height: 6px; 
        border-radius: 50%; 
        display: inline-block; 
        margin-right: 3px; 
    }
    
    /* Charts Section */
    .charts-section { 
        display: grid; 
        grid-template-columns: 1fr; 
        gap: 1rem; 
        margin-bottom: 1.5rem; 
    }
    .chart-box { 
        padding: 1rem; 
        border-radius: 12px; 
    }
    .chart-box .chart-title { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 1rem; 
        flex-wrap: wrap; 
        gap: 0.5rem; 
    }
    .chart-box .chart-title h3 { 
        margin: 0; 
        font-size: 0.95rem; 
        color: var(--text-main); 
    }
    .chart-tabs { 
        display: flex; 
        gap: 0.25rem; 
    }
    .chart-tab { 
        padding: 0.5rem 0.75rem; 
        border-radius: 8px; 
        border: 1px solid var(--border-glass, rgba(255,255,255,0.1)); 
        background: transparent; 
        color: var(--text-muted); 
        font-size: 0.75rem; 
        font-weight: 500; 
        cursor: pointer; 
        transition: all 0.2s; 
    }
    .chart-tab.active, .chart-tab:hover { 
        background: var(--primary); 
        color: white; 
        border-color: var(--primary); 
    }
    
    /* Recent Table */
    .recent-table-section { margin-bottom: 1.5rem; }
    .recent-table { width: 100%; border-collapse: collapse; }
    .recent-table th { 
        text-align: left; 
        padding: 0.6rem 0.75rem; 
        color: var(--text-muted); 
        font-size: 0.7rem; 
        font-weight: 600; 
        text-transform: uppercase; 
        letter-spacing: 0.5px; 
        border-bottom: 1px solid rgba(255,255,255,0.06); 
        white-space: nowrap;
    }
    .recent-table td { 
        padding: 0.7rem 0.75rem; 
        font-size: 0.8rem; 
        border-bottom: 1px solid rgba(255,255,255,0.04); 
    }
    .status-pill { 
        padding: 0.2rem 0.6rem; 
        border-radius: 20px; 
        font-size: 0.7rem; 
        font-weight: 600; 
        display: inline-block;
    }
    .pill-diajukan { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .pill-diproses { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    .pill-selesai { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .pill-ditolak { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
    
    /* Bottom Grid */
    .bottom-grid { 
        display: grid; 
        grid-template-columns: 1fr; 
        gap: 1rem; 
        margin-bottom: 1.5rem; 
    }
    .info-card { 
        padding: 1rem; 
        border-radius: 12px; 
    }
    .info-card h3 { 
        margin: 0 0 1rem 0; 
        font-size: 0.95rem; 
    }
    .demog-row { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        padding: 0.5rem 0; 
        border-bottom: 1px solid rgba(255,255,255,0.05); 
    }
    .demog-row:last-child { border-bottom: none; }
    .demog-label { color: var(--text-muted); font-size: 0.85rem; }
    .demog-value { font-weight: 600; font-size: 0.9rem; }
    .progress-bar-bg { 
        width: 100%; 
        height: 6px; 
        background: rgba(255,255,255,0.08); 
        border-radius: 4px; 
        overflow: hidden; 
        margin-top: 0.4rem; 
    }
    .progress-bar-fill { 
        height: 100%; 
        border-radius: 4px; 
        transition: width 0.6s ease; 
    }
    
    /* Cek Data Section */
    .cek-data-section { 
        display: grid; 
        grid-template-columns: 1fr; 
        gap: 1rem; 
        margin-bottom: 1.5rem; 
    }
    .cek-card { 
        padding: 1rem; 
        border-radius: 12px; 
    }
    .cek-card h3 { 
        margin: 0 0 0.75rem 0; 
        font-size: 0.9rem; 
        display: flex; 
        align-items: center; 
        gap: 0.4rem; 
    }
    .cek-form { 
        display: flex; 
        gap: 0.5rem; 
    }
    .cek-form input { 
        flex: 1; 
        padding: 0.6rem 0.85rem; 
        border-radius: 8px; 
        border: 1px solid rgba(255,255,255,0.1); 
        background: rgba(255,255,255,0.05); 
        color: #94a3b8; 
        font-size: 0.9rem; 
    }
    .cek-form input:focus { outline: none; border-color: var(--primary); }
    .cek-form input::placeholder { font-size: 0.85rem; }
    .cek-form button { 
        padding: 0.6rem 1rem; 
        border-radius: 8px; 
        background: var(--primary); 
        color: white; 
        border: none; 
        font-weight: 600; 
        font-size: 0.85rem;
        cursor: pointer; 
        transition: all 0.2s; 
    }
    .cek-form button:hover { background: #4f46e5; }
    .cek-form button:disabled { opacity: 0.6; cursor: not-allowed; }
    
    .cek-result { 
        margin-top: 0.75rem; 
        padding: 0.85rem; 
        border-radius: 8px; 
        display: none; 
    }
    .cek-result.show { display: block; }
    .cek-result.success { background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); }
    .cek-result.notfound { background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); }
    .cek-result h4 { 
        margin: 0 0 0.5rem 0; 
        font-size: 0.85rem; 
        display: flex; 
        align-items: center; 
        gap: 0.3rem; 
    }
    .cek-result.success h4 { color: #10b981; }
    .cek-result.notfound h4 { color: #ef4444; }
    .cek-detail { 
        font-size: 0.8rem; 
        color: rgba(255,255,255,0.7); 
    }
    .cek-detail div { 
        display: flex; 
        justify-content: space-between; 
        padding: 0.25rem 0; 
        border-bottom: 1px solid rgba(255,255,255,0.05); 
    }
    .cek-detail div:last-child { border-bottom: none; }
    .cek-detail span:first-child { color: var(--text-muted); }
    .cek-detail span:last-child { font-weight: 600; color: #1e293b; }
    .cek-loading { opacity: 0.5; pointer-events: none; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* Touch-friendly inputs */
    input[type="text"],
    input[type="number"] {
        -webkit-appearance: none;
        appearance: none;
    }
    
    /* Table wrapper for horizontal scroll */
    .table-scroll-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 0 -1rem;
        padding: 0 1rem;
    }

    /* Extra small mobile */
    @media (max-width: 375px) {
        .stats-grid-extended { grid-template-columns: 1fr 1fr; gap: 0.5rem; }
        .mini-stat { padding: 0.75rem; gap: 0.5rem; }
        .mini-stat .mini-icon { width: 32px; height: 32px; font-size: 0.9rem; }
        .mini-stat .mini-info h4 { font-size: 1rem; }
        .mini-stat .mini-info p { font-size: 0.65rem; }
        
        .cek-form { flex-direction: column; }
        .cek-form button { width: 100%; }
    }

    /* Tablet and up */
    @media (min-width: 768px) {
        .dashboard-welcome { margin-bottom: 2rem; }
        .dashboard-welcome h2 { font-size: 1.6rem; }
        
        .stats-grid-extended { 
            grid-template-columns: repeat(4, 1fr); 
            gap: 1.25rem; 
            margin-bottom: 2rem; 
        }
        .mini-stat { 
            padding: 1.25rem; 
            gap: 1rem; 
        }
        .mini-stat .mini-icon { 
            width: 50px; 
            height: 50px; 
            font-size: 1.4rem; 
        }
        .mini-stat .mini-info h4 { font-size: 1.4rem; }
        .mini-stat .mini-info p { font-size: 0.8rem; }
        
        .surat-status-row { 
            grid-template-columns: repeat(4, 1fr); 
            gap: 1rem; 
            margin-bottom: 2rem; 
        }
        .status-card { 
            padding: 1.25rem; 
            border-radius: 14px; 
        }
        .status-card .status-count { font-size: 2rem; }
        .status-card .status-label { font-size: 0.8rem; }
        
        .charts-section { 
            grid-template-columns: 2fr 1fr; 
            gap: 1.5rem; 
            margin-bottom: 2rem; 
        }
        .chart-box { 
            padding: 1.5rem; 
            border-radius: 16px; 
        }
        .chart-box .chart-title h3 { font-size: 1.05rem; }
        .chart-tabs { gap: 0.35rem; }
        .chart-tab { 
            padding: 0.4rem 0.9rem; 
            font-size: 0.8rem; 
        }
        
        .recent-table-section { margin-bottom: 2rem; }
        .recent-table th { 
            padding: 0.75rem 1rem; 
            font-size: 0.8rem; 
        }
        .recent-table td { 
            padding: 0.85rem 1rem; 
            font-size: 0.9rem; 
        }
        
        .bottom-grid { 
            grid-template-columns: 1fr 1fr; 
            gap: 1.5rem; 
            margin-bottom: 2rem; 
        }
        .info-card { 
            padding: 1.5rem; 
            border-radius: 16px; 
        }
        .info-card h3 { font-size: 1.05rem; margin-bottom: 1.25rem; }
        .demog-row { padding: 0.6rem 0; }
        .demog-label { font-size: 0.9rem; }
        .demog-value { font-size: 1rem; }
        .progress-bar-bg { height: 8px; }
        
        .cek-data-section { 
            grid-template-columns: 1fr 1fr; 
            gap: 1.5rem; 
            margin-bottom: 2rem; 
        }
        .cek-card { 
            padding: 1.5rem; 
            border-radius: 16px; 
        }
        .cek-card h3 { 
            font-size: 1rem; 
            margin-bottom: 1rem; 
        }
        .cek-form { gap: 0.75rem; }
        .cek-form input { 
            padding: 0.6rem 1rem; 
            font-size: 0.95rem; 
        }
        .cek-form button { 
            padding: 0.6rem 1.25rem; 
        }
        .cek-result { 
            margin-top: 1rem; 
            padding: 1rem; 
        }
        .cek-result h4 { font-size: 0.9rem; margin-bottom: 0.75rem; }
        .cek-detail { font-size: 0.85rem; }
    }
</style>
@endsection

@section('konten')

<div class="dashboard-welcome">
    <h2><i class="ri-dashboard-3-line" style="color: var(--primary);"></i> Dashboard Petugas</h2>
    <p>Selamat datang di Panel Petugas SIYanDuk</p>
</div>

{{-- Stat Cards --}}
<div class="stats-grid-extended">
    <div class="mini-stat glass">
        <div class="mini-icon bg-indigo"><i class="ri-group-line"></i></div>
        <div class="mini-info"><h4>{{ number_format($jmlpenduduk) }}</h4><p>Total Penduduk</p></div>
    </div>
    <div class="mini-stat glass">
        <div class="mini-icon bg-sky"><i class="ri-men-line"></i></div>
        <div class="mini-info"><h4>{{ number_format($jmllakilaki) }}</h4><p>Laki-laki</p></div>
    </div>
    <div class="mini-stat glass">
        <div class="mini-icon bg-fuchsia"><i class="ri-women-line"></i></div>
        <div class="mini-info"><h4>{{ number_format($jmlperempuan) }}</h4><p>Perempuan</p></div>
    </div>
    <div class="mini-stat glass">
        <div class="mini-icon bg-emerald"><i class="ri-home-4-line"></i></div>
        <div class="mini-info"><h4>{{ number_format($jmlkeluarga) }}</h4><p>Keluarga (KK)</p></div>
    </div>
</div>

{{-- Cek Data Penduduk & Keluarga --}}
<div class="cek-data-section">
    <div class="cek-card glass">
        <h3><i class="ri-id-card-line" style="color: var(--primary);"></i> Pengecekkan NIK</h3>
        <div class="cek-form">
            <input type="text" id="cek-nik-input" placeholder="Masukkan 16 digit NIK" maxlength="16" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 16)">
            <button type="button" onclick="cekNik()">Cek</button>
        </div>
        <div id="cek-nik-result" class="cek-result">
            <h4><i class="ri-checkbox-circle-line"></i> <span id="nik-status-text">Data Ditemukan</span></h4>
            <div class="cek-detail" id="nik-detail"></div>
        </div>
    </div>
    <div class="cek-card glass">
        <h3><i class="ri-home-4-line" style="color: var(--primary);"></i> Pengecekkan No. KK</h3>
        <div class="cek-form">
            <input type="text" id="cek-kk-input" placeholder="Masukkan 16 digit No. KK" maxlength="16" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 16)">
            <button type="button" onclick="cekKk()">Cek</button>
        </div>
        <div id="cek-kk-result" class="cek-result">
            <h4><i class="ri-checkbox-circle-line"></i> <span id="kk-status-text">Data Ditemukan</span></h4>
            <div class="cek-detail" id="kk-detail"></div>
        </div>
    </div>
</div>

{{-- Surat Status --}}
<div class="surat-status-row">
    <div class="status-card glass">
        <div class="status-count" style="color: #6366f1;">{{ $totalSurat }}</div>
        <div class="status-label"><span class="status-dot" style="background: #6366f1;"></span>Total Surat</div>
    </div>
    <div class="status-card glass">
        <div class="status-count" style="color: #f59e0b;">{{ $suratDiproses }}</div>
        <div class="status-label"><span class="status-dot" style="background: #f59e0b;"></span>Sedang Diproses</div>
    </div>
    <div class="status-card glass">
        <div class="status-count" style="color: #10b981;">{{ $suratSelesai }}</div>
        <div class="status-label"><span class="status-dot" style="background: #10b981;"></span>Selesai</div>
    </div>
    <div class="status-card glass">
        <div class="status-count" style="color: #ef4444;">{{ $suratDitolak }}</div>
        <div class="status-label"><span class="status-dot" style="background: #ef4444;"></span>Ditolak</div>
    </div>
</div>


@endsection

@section('script')
<script>
function cekNik() {
    const input = document.getElementById('cek-nik-input');
    const btn = input.nextElementSibling;
    const result = document.getElementById('cek-nik-result');
    const detail = document.getElementById('nik-detail');
    const statusText = document.getElementById('nik-status-text');
    const nik = input.value;

    if (nik.length !== 16) {
        alert('NIK harus 16 digit');
        return;
    }

    btn.classList.add('cek-loading');
    btn.innerHTML = '<i class="ri-loader-4-line" style="animation: spin 1s linear infinite;"></i>';

    fetch(`{{ route('operator.ceknik') }}?nik=${nik}`)
        .then(res => res.json())
        .then(data => {
            btn.classList.remove('cek-loading');
            btn.innerHTML = 'Cek';
            result.classList.remove('success', 'notfound');
            result.classList.add('show');

            if (data.found) {
                result.classList.add('success');
                statusText.textContent = 'Data Ditemukan';
                detail.innerHTML = `
                    <div><span>Nama</span><span>${data.data.nama}</span></div>
                    <div><span>No. KK</span><span>${data.data.no_kk}</span></div>
                    <div><span>JK</span><span>${data.data.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}</span></div>
                    <div><span>Tempat Lahir</span><span>${data.data.tempat_lahir}</span></div>
                    <div><span>Tanggal Lahir</span><span>${data.data.tanggal_lahir}</span></div>
                    <div><span>Alamat</span><span>${data.data.alamat}</span></div>
                `;
            } else {
                result.classList.add('notfound');
                statusText.textContent = 'Data Tidak Ditemukan';
                detail.innerHTML = '<div style="text-align: center; padding: 0.5rem;">NIK tersebut belum terdaftar dalam database</div>';
            }
        })
        .catch(err => {
            btn.classList.remove('cek-loading');
            btn.innerHTML = 'Cek';
            alert('Terjadi kesalahan');
        });
}

function cekKk() {
    const input = document.getElementById('cek-kk-input');
    const btn = input.nextElementSibling;
    const result = document.getElementById('cek-kk-result');
    const detail = document.getElementById('kk-detail');
    const statusText = document.getElementById('kk-status-text');
    const no_kk = input.value;

    if (no_kk.length !== 16) {
        alert('No. KK harus 16 digit');
        return;
    }

    btn.classList.add('cek-loading');
    btn.innerHTML = '<i class="ri-loader-4-line" style="animation: spin 1s linear infinite;"></i>';

    fetch(`{{ route('operator.cekkk') }}?no_kk=${no_kk}`)
        .then(res => res.json())
        .then(data => {
            btn.classList.remove('cek-loading');
            btn.innerHTML = 'Cek';
            result.classList.remove('success', 'notfound');
            result.classList.add('show');

            if (data.found) {
                result.classList.add('success');
                statusText.textContent = 'Data Ditemukan';
                detail.innerHTML = `
                    <div><span>No. KK</span><span>${no_kk}</span></div>
                    <div><span>Alamat</span><span>${data.data.alamat}</span></div>
                    <div><span>RT/RW</span><span>${data.data.rt}/${data.data.rw}</span></div>
                    <div><span>Desa/Kelurahan</span><span>${data.data.desa_kelurahan}</span></div>
                    <div><span>Jumlah Anggota</span><span>${data.data.jumlah_anggota} orang</span></div>
                `;
            } else {
                result.classList.add('notfound');
                statusText.textContent = 'Data Tidak Ditemukan';
                detail.innerHTML = '<div style="text-align: center; padding: 0.5rem;">No. KK tersebut belum terdaftar dalam database</div>';
            }
        })
        .catch(err => {
            btn.classList.remove('cek-loading');
            btn.innerHTML = 'Cek';
            alert('Terjadi kesalahan');
        });
}
</script>
<script>
    const chartData = {
        harian: { labels: {!! json_encode($hariLabels) !!}, data: {!! json_encode($hariData) !!} },
        mingguan: { labels: {!! json_encode($mingguLabels) !!}, data: {!! json_encode($mingguData) !!} },
        bulanan: { labels: {!! json_encode($bulanLabels) !!}, data: {!! json_encode($bulanData) !!} }
    };

    const ctx = document.getElementById('layananChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.35)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.02)');

    let layananChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.harian.labels,
            datasets: [{ label: 'Jumlah Layanan', data: chartData.harian.data, backgroundColor: gradient, borderColor: '#6366f1', borderWidth: 2, borderRadius: 8, borderSkipped: false }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(15,23,42,0.9)', titleColor: '#fff', bodyColor: '#e2e8f0', borderColor: 'rgba(99,102,241,0.3)', borderWidth: 1, cornerRadius: 8, padding: 12, callbacks: { label: function(c) { return ' ' + c.parsed.y + ' surat'; } } } },
            scales: { x: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: 'rgba(255,255,255,0.5)', font: { size: 11 } } }, y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: 'rgba(255,255,255,0.5)', font: { size: 11 }, stepSize: 1, callback: function(v) { if (Number.isInteger(v)) return v; } } } }
        }
    });

    function switchChart(mode) {
        document.querySelectorAll('.chart-tab').forEach(t => t.classList.remove('active'));
        event.target.classList.add('active');
        const d = chartData[mode];
        layananChart.data.labels = d.labels;
        layananChart.data.datasets[0].data = d.data;
        if (mode === 'bulanan') { layananChart.config.type = 'line'; layananChart.data.datasets[0].fill = true; layananChart.data.datasets[0].tension = 0.4; layananChart.data.datasets[0].pointBackgroundColor = '#6366f1'; layananChart.data.datasets[0].pointBorderColor = '#fff'; layananChart.data.datasets[0].pointBorderWidth = 2; layananChart.data.datasets[0].pointRadius = 5; }
        else { layananChart.config.type = 'bar'; layananChart.data.datasets[0].fill = false; layananChart.data.datasets[0].borderRadius = 8; layananChart.data.datasets[0].borderSkipped = false; }
        layananChart.update();
    }

    const pieColors = ['rgba(99,102,241,0.8)','rgba(16,185,129,0.8)','rgba(245,158,11,0.8)','rgba(236,72,153,0.8)','rgba(14,165,233,0.8)','rgba(139,92,246,0.8)'];
    const pieBorders = ['#6366f1','#10b981','#f59e0b','#ec4899','#0ea5e9','#8b5cf6'];
    const jL = {!! json_encode($jenisLabels) !!};
    const jD = {!! json_encode($jenisData) !!};

    new Chart(document.getElementById('jenisChart').getContext('2d'), {
        type: 'doughnut',
        data: { labels: jL.length > 0 ? jL : ['Belum ada data'], datasets: [{ data: jD.length > 0 ? jD : [1], backgroundColor: jD.length > 0 ? pieColors : ['rgba(100,100,100,0.2)'], borderColor: jD.length > 0 ? pieBorders : ['rgba(100,100,100,0.3)'], borderWidth: 2, hoverOffset: 8 }] },
        options: { responsive: true, maintainAspectRatio: false, cutout: '60%', plugins: { legend: { position: 'bottom', labels: { color: 'rgba(255,255,255,0.7)', padding: 12, font: { size: 11 }, usePointStyle: true, pointStyleWidth: 10 } }, tooltip: { backgroundColor: 'rgba(15,23,42,0.9)', titleColor: '#fff', bodyColor: '#e2e8f0', cornerRadius: 8, padding: 12, callbacks: { label: function(c) { const t = c.dataset.data.reduce((a,b) => a+b, 0); return ' ' + c.parsed + ' surat (' + (t > 0 ? ((c.parsed/t)*100).toFixed(1) : 0) + '%)'; } } } } }
    });
</script>
@endsection