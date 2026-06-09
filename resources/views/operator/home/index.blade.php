@extends('operator.layouts.app')

@section('title', 'Dashboard Operator')

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
    .stat-icon.danger { background: rgba(239, 68, 68, 0.15); color: #ef4444; }

    .stat-info h3 { margin: 0; font-size: 1.5rem; font-weight: 700; color: #1f2937; }
    .stat-info p { margin: 0.2rem 0 0; font-size: 0.8rem; color: #6b7280; font-weight: 500; }

    .surat-status-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    @media (min-width: 768px) { .surat-status-grid { grid-template-columns: repeat(4, 1fr); } }

    .status-card {
        background: rgba(255,255,255,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    .status-card:hover { transform: translateY(-2px); }
    .status-card .status-num { font-size: 1.75rem; font-weight: 700; line-height: 1; }
    .status-card .status-lbl { font-size: 0.75rem; color: #6b7280; margin-top: 0.4rem; font-weight: 600; }
    .status-card.diajukan .status-num { color: #3b82f6; }
    .status-card.diproses .status-num { color: #f59e0b; }
    .status-card.selesai .status-num { color: #10b981; }
    .status-card.ditolak .status-num { color: #ef4444; }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    @media (min-width: 992px) { .content-grid { grid-template-columns: 2fr 1fr; } }

    .chart-card, .table-card {
        background: rgba(255,255,255,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 1.25rem;
    }
    .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem; }
    .chart-header h3 { margin: 0; font-size: 1rem; color: #1f2937; }
    .chart-tabs { display: flex; gap: 0.25rem; }
    .chart-tab {
        padding: 0.4rem 0.75rem;
        border-radius: 8px;
        border: 1px solid rgba(0,0,0,0.08);
        background: transparent;
        color: #6b7280;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .chart-tab:hover, .chart-tab.active { background: var(--primary); color: white; border-color: var(--primary); }

    .recent-table { width: 100%; border-collapse: collapse; }
    .recent-table th {
        text-align: left;
        padding: 0.75rem;
        color: #6b7280;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid rgba(0,0,0,0.08);
    }
    .recent-table td { padding: 0.75rem; font-size: 0.85rem; border-bottom: 1px solid rgba(0,0,0,0.05); }
    .recent-table tr:hover { background: rgba(99,102,241,0.05); }
    .status-badge {
        padding: 0.25rem 0.6rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .badge-diajukan { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .badge-diproses { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    .badge-selesai { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .badge-ditolak { background: rgba(239, 68, 68, 0.15); color: #ef4444; }

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

    .empty-state { text-align: center; padding: 2rem; color: #9ca3af; }
    .empty-state i { font-size: 2rem; margin-bottom: 0.5rem; display: block; }
    .empty-state p { margin: 0; font-size: 0.85rem; }
</style>
@endsection

@section('konten')

<div class="dashboard-header">
    <h1><i class="ri-dashboard-3-line"></i> Dashboard Operator</h1>
    <p>Selamat bekerja! Berikut ringkasan data nagari hari ini.</p>
    <div class="header-meta">
        <span><i class="ri-calendar-today-line"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
        <span><i class="ri-time-line"></i> {{ \Carbon\Carbon::now()->format('H:i') }} WIB</span>
    </div>
</div>

{{-- Stats Cards - Data Nagari --}}
<div class="section-title"><i class="ri-bar-chart-box-line"></i> Data Nagari</div>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary"><i class="ri-group-line"></i></div>
        <div class="stat-info"><h3>{{ number_format($jmlpenduduk) }}</h3><p>Total Penduduk</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon success"><i class="ri-home-4-line"></i></div>
        <div class="stat-info"><h3>{{ number_format($jmlkeluarga) }}</h3><p>Kartu Keluarga</p></div>
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

{{-- Status Surat --}}
<div class="section-title"><i class="ri-mail-send-line"></i> Status Pengajuan Surat</div>
<div class="surat-status-grid">
    <div class="status-card diajukan">
        <div class="status-num">{{ number_format($suratDiajukan) }}</div>
        <div class="status-lbl">Diajukan</div>
    </div>
    <div class="status-card diproses">
        <div class="status-num">{{ number_format($suratDiproses) }}</div>
        <div class="status-lbl">Diproses</div>
    </div>
    <div class="status-card selesai">
        <div class="status-num">{{ number_format($suratSelesai) }}</div>
        <div class="status-lbl">Selesai</div>
    </div>
    <div class="status-card ditolak">
        <div class="status-num">{{ number_format($suratDitolak) }}</div>
        <div class="status-lbl">Ditolak</div>
    </div>
</div>

{{-- Charts & Tables --}}
<div class="content-grid">
    <div class="chart-card">
        <div class="chart-header">
            <h3><i class="ri-bar-chart-line" style="color: var(--primary);"></i> Grafik Pengajuan Surat</h3>
            <div class="chart-tabs">
                <button class="chart-tab active" onclick="switchChart('harian')">Harian</button>
                <button class="chart-tab" onclick="switchChart('mingguan')">Mingguan</button>
                <button class="chart-tab" onclick="switchChart('bulanan')">Bulanan</button>
            </div>
        </div>
        <div style="height: 250px;">
            <canvas id="suratChart"></canvas>
        </div>
    </div>

    <div class="table-card">
        <div class="chart-header">
            <h3><i class="ri-file-list-3-line" style="color: var(--primary);"></i> Riwayat Surat Terbaru</h3>
        </div>
        @if($suratTerbaru->count() > 0)
        <div style="overflow-x: auto;">
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Jenis Surat</th>
                        <th>Pemohon</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suratTerbaru as $surat)
                    <tr>
                        <td>{{ $surat->jenis_surat }}</td>
                        <td>{{ $surat->penduduk->nama_lengkap ?? '-' }}</td>
                        <td>
                            @if($surat->status == 'diajukan')
                                <span class="status-badge badge-diajukan">Diajukan</span>
                            @elseif($surat->status == 'diproses')
                                <span class="status-badge badge-diproses">Diproses</span>
                            @elseif($surat->status == 'selesai')
                                <span class="status-badge badge-selesai">Selesai</span>
                            @else
                                <span class="status-badge badge-ditolak">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="ri-inbox-line"></i>
            <p>Belum ada pengajuan surat</p>
        </div>
        @endif
    </div>
</div>

{{-- Demography --}}
<div class="demography-card">
    <div class="section-title"><i class="ri-pie-chart-line"></i> Demografi Penduduk</div>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function cekNik() {
    const input = document.getElementById('cek-nik-input');
    const result = document.getElementById('cek-nik-result');
    const detail = document.getElementById('nik-detail');
    const statusText = document.getElementById('nik-status-text');
    const nik = input.value;

    if (nik.length !== 16) { alert('NIK harus 16 digit'); return; }

    fetch(`{{ route('operator.ceknik') }}?nik=${nik}`)
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
                    <div><span>Tempat Lahir</span><span>${data.data.tempat_lahir || '-'}</span></div>
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

    fetch(`{{ route('operator.cekkk') }}?no_kk=${no_kk}`)
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

// Chart Configuration
const chartData = {
    harian: { labels: @json($hariLabels), data: @json($hariData) },
    mingguan: { labels: @json($mingguLabels), data: @json($mingguData) },
    bulanan: { labels: @json($bulanLabels), data: @json($bulanData) }
};

const ctx = document.getElementById('suratChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 250);
gradient.addColorStop(0, 'rgba(99, 102, 241, 0.35)');
gradient.addColorStop(1, 'rgba(99, 102, 241, 0.02)');

let suratChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: chartData.harian.labels,
        datasets: [{
            label: 'Jumlah Surat',
            data: chartData.harian.data,
            backgroundColor: gradient,
            borderColor: '#6366f1',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { color: '#6b7280', font: { size: 11 } } },
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { color: '#6b7280', font: { size: 11 }, stepSize: 1, callback: function(v) { if (Number.isInteger(v)) return v; } } }
        }
    }
});

function switchChart(mode) {
    document.querySelectorAll('.chart-tab').forEach(t => t.classList.remove('active'));
    event.target.classList.add('active');
    const d = chartData[mode];
    suratChart.data.labels = d.labels;
    suratChart.data.datasets[0].data = d.data;
    if (mode === 'bulanan') {
        suratChart.config.type = 'line';
        suratChart.data.datasets[0].fill = true;
        suratChart.data.datasets[0].tension = 0.4;
    } else {
        suratChart.config.type = 'bar';
        suratChart.data.datasets[0].fill = false;
    }
    suratChart.update();
}
</script>
@endsection