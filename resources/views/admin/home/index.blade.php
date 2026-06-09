@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('head')
<style>
    .dashboard-welcome {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(139, 92, 246, 0.1) 100%);
        border-radius: 20px;
        border: 1px solid rgba(99, 102, 241, 0.2);
        animation: fadeSlideIn 0.5s ease-out;
    }
    .dashboard-welcome h2 {
        font-size: 1.6rem;
        margin-bottom: 0.3rem;
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .dashboard-welcome p {
        color: var(--text-muted);
        font-size: 0.95rem;
    }
    .dashboard-welcome p span {
        font-size: 1.1rem;
        margin-right: 0.3rem;
    }

    .stats-grid-extended {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    .mini-stat {
        padding: 1.25rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .mini-stat::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.05), transparent);
        transform: translateX(-100%);
        transition: 0.5s;
    }
    .mini-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }
    .mini-stat:hover::before {
        transform: translateX(100%);
    }
    .mini-stat .mini-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }
    .mini-stat:hover .mini-icon {
        transform: scale(1.1) rotate(5deg);
    }
    .mini-stat .mini-info h4 {
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }
    .mini-stat .mini-info p {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
        margin-top: 2px;
    }
    .bg-indigo { background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(99, 102, 241, 0.08) 100%); color: #6366f1; }
    .bg-emerald { background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(16, 185, 129, 0.08) 100%); color: #10b981; }
    .bg-amber { background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0.08) 100%); color: #f59e0b; }
    .bg-rose { background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(239, 68, 68, 0.08) 100%); color: #ef4444; }
    .bg-sky { background: linear-gradient(135deg, rgba(14, 165, 233, 0.2) 0%, rgba(14, 165, 233, 0.08) 100%); color: #0ea5e9; }
    .bg-violet { background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(139, 92, 246, 0.08) 100%); color: #8b5cf6; }
    .bg-cyan { background: linear-gradient(135deg, rgba(6, 182, 212, 0.2) 0%, rgba(6, 182, 212, 0.08) 100%); color: #06b6d4; }
    .bg-fuchsia { background: linear-gradient(135deg, rgba(217, 70, 239, 0.2) 0%, rgba(217, 70, 239, 0.08) 100%); color: #d946ef; }

    .charts-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 900px) {
        .charts-section { grid-template-columns: 1fr; }
    }

    .chart-box {
        padding: 1.5rem;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    .chart-box:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    .chart-box .chart-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .chart-box .chart-title h3 {
        margin: 0;
        font-size: 1.05rem;
        color: var(--text-main);
    }
    .chart-tabs {
        display: flex;
        gap: 0.35rem;
    }
    .chart-tab {
        padding: 0.4rem 0.9rem;
        border-radius: 8px;
        border: 1px solid var(--border-glass, rgba(255,255,255,0.1));
        background: transparent;
        color: var(--text-muted);
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .chart-tab.active, .chart-tab:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .surat-status-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 768px) {
        .surat-status-row { grid-template-columns: repeat(2, 1fr); }
    }
    .status-card {
        padding: 1.25rem;
        border-radius: 14px;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
    }
    .status-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 3px;
        background: var(--primary);
        border-radius: 0 0 14px 14px;
        transition: width 0.3s ease;
    }
    .status-card:hover {
        transform: translateY(-3px);
    }
    .status-card:hover::after {
        width: 80%;
    }
    .status-card .status-count {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }
    .status-card .status-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.3rem;
    }
    .status-card .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 4px;
    }

    .recent-table-section {
        margin-bottom: 2rem;
    }
    .recent-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .recent-table th {
        text-align: left;
        padding: 0.75rem 1rem;
        color: var(--text-muted);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .recent-table td {
        padding: 0.85rem 1rem;
        font-size: 0.9rem;
        border-bottom: 1px solid rgba(255,255,255,0.04);
        transition: background 0.2s;
    }
    .recent-table tr:hover td {
        background: rgba(255,255,255,0.03);
    }
    .recent-table tr td:first-child {
        border-radius: 8px 0 0 8px;
    }
    .recent-table tr td:last-child {
        border-radius: 0 8px 8px 0;
    }
    .status-pill {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .pill-diajukan { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .pill-diproses { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    .pill-selesai { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .pill-ditolak { background: rgba(239, 68, 68, 0.15); color: #ef4444; }

    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 768px) {
        .bottom-grid { grid-template-columns: 1fr; }
    }
    .info-card {
        padding: 1.5rem;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    .info-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    .info-card h3 {
        margin: 0 0 1.25rem 0;
        font-size: 1.05rem;
    }
    .demog-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .demog-row:last-child { border-bottom: none; }
    .demog-label { color: var(--text-muted); font-size: 0.9rem; }
    .demog-value { font-weight: 600; font-size: 1rem; }
    .progress-bar-bg {
        width: 100%;
        height: 8px;
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

    @keyframes fadeSlideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .stat-number {
        animation: fadeSlideIn 0.5s ease-out 0.1s both;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .section-title i {
        font-size: 1.2rem;
    }

    .glass-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: rgba(255,255,255,0.03);
        border-radius: 12px 12px 0 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .table-wrapper {
        overflow-x: auto;
        border-radius: 12px;
    }
    .table-wrapper table {
        min-width: 500px;
    }
</style>
@endsection

@section('konten')

{{-- Welcome --}}
<div class="dashboard-welcome">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);">
            <i class="ri-dashboard-3-line"></i>
        </div>
        <div>
            <h2><i class="ri-dashboard-3-line" style="display: none;"></i> Dashboard Administrator</h2>
            <p><span>👋</span> Selamat datang di Sistem Informasi Layanan Administrasi Kependudukan (SIYanDuk)</p>
        </div>
    </div>
    <div style="display: flex; gap: 0.5rem; margin-top: 1rem; flex-wrap: wrap;">
        <span style="padding: 0.35rem 0.75rem; background: rgba(99, 102, 241, 0.15); border-radius: 20px; font-size: 0.75rem; color: #818cf8;"><i class="ri-user-settings-line"></i> Admin Panel</span>
        <span style="padding: 0.35rem 0.75rem; background: rgba(16, 185, 129, 0.15); border-radius: 20px; font-size: 0.75rem; color: #34d399;"><i class="ri-checkbox-circle-line"></i> Terverifikasi</span>
    </div>
</div>

{{-- Stat Cards Row 1: Kependudukan --}}
<div class="stats-grid-extended">
    <div class="mini-stat glass">
        <div class="mini-icon bg-indigo"><i class="ri-group-line"></i></div>
        <div class="mini-info">
            <h4 class="stat-number">{{ number_format($jmlpenduduk) }}</h4>
            <p>Total Penduduk</p>
        </div>
    </div>
    <div class="mini-stat glass">
        <div class="mini-icon bg-sky"><i class="ri-men-line"></i></div>
        <div class="mini-info">
            <h4 class="stat-number">{{ number_format($jmllakilaki) }}</h4>
            <p>Laki-laki</p>
        </div>
    </div>
    <div class="mini-stat glass">
        <div class="mini-icon bg-fuchsia"><i class="ri-women-line"></i></div>
        <div class="mini-info">
            <h4 class="stat-number">{{ number_format($jmlperempuan) }}</h4>
            <p>Perempuan</p>
        </div>
    </div>
    <div class="mini-stat glass">
        <div class="mini-icon bg-emerald"><i class="ri-home-4-line"></i></div>
        <div class="mini-info">
            <h4 class="stat-number">{{ number_format($jmlkeluarga) }}</h4>
            <p>Keluarga (KK)</p>
        </div>
    </div>
</div>

{{-- Stat Cards Row 2: Layanan --}}
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

{{-- Charts Section --}}
<div class="charts-section">
    {{-- Line/Bar Chart: Laporan Layanan --}}
    <div class="chart-box glass">
        <div class="chart-title">
            <h3><i class="ri-bar-chart-2-line" style="color: var(--primary); margin-right: 0.3rem;"></i> Laporan Layanan Surat</h3>
            <div class="chart-tabs">
                <button class="chart-tab active" onclick="switchChart('harian')">Harian</button>
                <button class="chart-tab" onclick="switchChart('mingguan')">Mingguan</button>
                <button class="chart-tab" onclick="switchChart('bulanan')">Bulanan</button>
            </div>
        </div>
        <div style="position: relative; height: 300px;">
            <canvas id="layananChart"></canvas>
        </div>
    </div>

    {{-- Pie/Doughnut Chart: Jenis Layanan --}}
    <div class="chart-box glass">
        <div class="chart-title">
            <h3><i class="ri-pie-chart-2-line" style="color: var(--primary); margin-right: 0.3rem;"></i> Jenis Layanan</h3>
        </div>
        <div style="position: relative; height: 300px;">
            <canvas id="jenisChart"></canvas>
        </div>
    </div>
</div>

{{-- Bottom Grid: Recent + Demografi --}}
<div class="bottom-grid">
    {{-- Recent Surat --}}
    <div class="info-card glass recent-table-section" style="padding: 0; overflow: hidden;">
        <div class="glass-header">
            <h3 style="margin: 0; font-size: 1.05rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="ri-file-list-3-line" style="color: var(--primary);"></i> Surat Terbaru
            </h3>
            <a href="#" style="color: var(--primary); font-size: 0.85rem; text-decoration: none; display: flex; align-items: center; gap: 0.25rem;">
                Lihat Semua <i class="ri-arrow-right-line"></i>
            </a>
        </div>
        <div class="table-wrapper">
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Pemohon</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratTerbaru as $surat)
                    <tr>
                        <td style="font-weight: 600;">{{ $surat->penduduk->nama_lengkap ?? $surat->nik_pemohon }}</td>
                        <td>{{ Str::limit($surat->jenis_surat, 20) }}</td>
                        <td>{{ $surat->tanggal_pengajuan ? $surat->tanggal_pengajuan->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($surat->status == 'diajukan')
                                <span class="status-pill pill-diajukan">Diajukan</span>
                            @elseif($surat->status == 'diproses')
                                <span class="status-pill pill-diproses">Diproses</span>
                            @elseif($surat->status == 'selesai')
                                <span class="status-pill pill-selesai">Selesai</span>
                            @else
                                <span class="status-pill pill-ditolak">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada data surat</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Demografi --}}
    <div class="info-card glass">
        <h3 style="display: flex; align-items: center; gap: 0.5rem;"><i class="ri-user-heart-line" style="color: var(--primary);"></i> Demografi Penduduk</h3>

        <div class="demog-row">
            <span class="demog-label"><i class="ri-men-line" style="color: #0ea5e9;"></i> Laki-laki</span>
            <span class="demog-value">{{ $jmllakilaki }} <small style="color: var(--text-muted);">({{ $jmlpenduduk > 0 ? round(($jmllakilaki/$jmlpenduduk)*100, 1) : 0 }}%)</small></span>
        </div>
        <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width: {{ $jmlpenduduk > 0 ? ($jmllakilaki/$jmlpenduduk)*100 : 0 }}%; background: linear-gradient(90deg, #0ea5e9, #6366f1);"></div>
        </div>

        <div class="demog-row" style="margin-top: 1rem;">
            <span class="demog-label"><i class="ri-women-line" style="color: #d946ef;"></i> Perempuan</span>
            <span class="demog-value">{{ $jmlperempuan }} <small style="color: var(--text-muted);">({{ $jmlpenduduk > 0 ? round(($jmlperempuan/$jmlpenduduk)*100, 1) : 0 }}%)</small></span>
        </div>
        <div class="progress-bar-bg">
            <div class="progress-bar-fill" style="width: {{ $jmlpenduduk > 0 ? ($jmlperempuan/$jmlpenduduk)*100 : 0 }}%; background: linear-gradient(90deg, #d946ef, #ec4899);"></div>
        </div>

        <hr style="border: none; border-top: 1px solid rgba(255,255,255,0.06); margin: 1.25rem 0;">

        <div class="demog-row">
            <span class="demog-label"><i class="ri-home-4-line" style="color: #10b981;"></i> Total Keluarga</span>
            <span class="demog-value">{{ number_format($jmlkeluarga) }} KK</span>
        </div>
        <div class="demog-row">
            <span class="demog-label"><i class="ri-user-line" style="color: #6366f1;"></i> Total Pengguna</span>
            <span class="demog-value">{{ number_format($totalUser) }}</span>
        </div>
        <div class="demog-row">
            <span class="demog-label"><i class="ri-newspaper-line" style="color: #f59e0b;"></i> Total Berita</span>
            <span class="demog-value">{{ number_format($totalBerita) }}</span>
        </div>
        <div class="demog-row">
            <span class="demog-label"><i class="ri-mail-send-line" style="color: #3b82f6;"></i> Surat Menunggu</span>
            <span class="demog-value" style="color: #f59e0b;">{{ $suratDiajukan }}</span>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    // Data dari Controller
    const chartData = {
        harian: {
            labels: {!! json_encode($hariLabels) !!},
            data: {!! json_encode($hariData) !!}
        },
        mingguan: {
            labels: {!! json_encode($mingguLabels) !!},
            data: {!! json_encode($mingguData) !!}
        },
        bulanan: {
            labels: {!! json_encode($bulanLabels) !!},
            data: {!! json_encode($bulanData) !!}
        }
    };

    // Gradient
    const ctx = document.getElementById('layananChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.35)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.02)');

    let layananChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.harian.labels,
            datasets: [{
                label: 'Jumlah Layanan',
                data: chartData.harian.data,
                backgroundColor: gradient,
                borderColor: '#6366f1',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#e2e8f0',
                    borderColor: 'rgba(99, 102, 241, 0.3)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.parsed.y + ' surat';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: { color: 'rgba(255,255,255,0.5)', font: { size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: {
                        color: 'rgba(255,255,255,0.5)',
                        font: { size: 11 },
                        stepSize: 1,
                        callback: function(value) { if (Number.isInteger(value)) return value; }
                    }
                }
            }
        }
    });

    function switchChart(mode) {
        // Update tabs
        document.querySelectorAll('.chart-tab').forEach(t => t.classList.remove('active'));
        event.target.classList.add('active');

        // Update chart data
        const d = chartData[mode];
        layananChart.data.labels = d.labels;
        layananChart.data.datasets[0].data = d.data;

        // Switch chart type for monthly view
        if (mode === 'bulanan') {
            layananChart.config.type = 'line';
            layananChart.data.datasets[0].fill = true;
            layananChart.data.datasets[0].tension = 0.4;
            layananChart.data.datasets[0].pointBackgroundColor = '#6366f1';
            layananChart.data.datasets[0].pointBorderColor = '#fff';
            layananChart.data.datasets[0].pointBorderWidth = 2;
            layananChart.data.datasets[0].pointRadius = 5;
        } else {
            layananChart.config.type = 'bar';
            layananChart.data.datasets[0].fill = false;
            layananChart.data.datasets[0].borderRadius = 8;
            layananChart.data.datasets[0].borderSkipped = false;
        }

        layananChart.update();
    }

    // Pie/Doughnut Chart: Jenis Layanan
    const jenisLabels = {!! json_encode($jenisLabels) !!};
    const jenisData = {!! json_encode($jenisData) !!};

    const pieColors = [
        'rgba(99, 102, 241, 0.8)',
        'rgba(16, 185, 129, 0.8)',
        'rgba(245, 158, 11, 0.8)',
        'rgba(236, 72, 153, 0.8)',
        'rgba(14, 165, 233, 0.8)',
        'rgba(139, 92, 246, 0.8)'
    ];
    const pieBorders = [
        '#6366f1', '#10b981', '#f59e0b', '#ec4899', '#0ea5e9', '#8b5cf6'
    ];

    const ctx2 = document.getElementById('jenisChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: jenisLabels.length > 0 ? jenisLabels : ['Belum ada data'],
            datasets: [{
                data: jenisData.length > 0 ? jenisData : [1],
                backgroundColor: jenisData.length > 0 ? pieColors : ['rgba(100,100,100,0.2)'],
                borderColor: jenisData.length > 0 ? pieBorders : ['rgba(100,100,100,0.3)'],
                borderWidth: 2,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: 'rgba(255,255,255,0.7)',
                        padding: 12,
                        font: { size: 11 },
                        usePointStyle: true,
                        pointStyleWidth: 10,
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#e2e8f0',
                    borderColor: 'rgba(99, 102, 241, 0.3)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const pct = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                            return ' ' + context.parsed + ' surat (' + pct + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection