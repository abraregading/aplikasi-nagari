@extends('kajor.layouts.app')

@section('title', 'Laporan Meninggal - Jorong ' . $jorongName)

@section('head')
<style>
    .stat-card {
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
    }
    .stat-card h3 { font-size: 2rem; margin: 0; }
    .stat-card p { margin: 0.3rem 0 0; font-size: 0.85rem; color: #999; }

    table { width: 100%; border-collapse: collapse; margin-top: 1rem; font-size: 0.9rem; }
    th, td { padding: 0.75rem; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
    th { background: rgba(99, 102, 241, 0.1); color: var(--primary); font-weight: 600; }
    tr:hover { background: rgba(255,255,255,0.03); }
</style>
@endsection

@section('konten')
<div style="margin-bottom: 2rem;">
    <h2 style="margin-bottom: 0.5rem;">Laporan Meninggal Bulanan</h2>
    <p style="color: #999;">Jorong: <strong>{{ $jorongName }}</strong></p>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 1.5rem;">
    <form method="GET" action="{{ route('kajor.laporan-meninggal.index') }}" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
        <div style="display: flex; flex-direction: column; gap: 0.3rem;">
            <label style="font-size: 0.8rem; color: #999;">Bulan</label>
            <select name="bulan" class="glass-select" style="padding: 0.5rem 1rem; border-radius: 8px;">
                @php $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; @endphp
                @foreach(range(1, 12) as $b)
                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>{{ $bulanIndo[$b - 1] }}</option>
                @endforeach
            </select>
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.3rem;">
            <label style="font-size: 0.8rem; color: #999;">Tahun</label>
            <select name="tahun" class="glass-select" style="padding: 0.5rem 1rem; border-radius: 8px;">
                @for($t = now()->year; $t >= now()->year - 5; $t--)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 8px; cursor: pointer;">
            <i class="ri-search-line"></i> Tampilkan
        </button>
        <a href="{{ route('kajor.laporan-meninggal.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" class="glass-select" style="background: #10b981; color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
            <i class="ri-printer-line"></i> Cetak Laporan
        </a>
    </form>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div class="glass stat-card">
        <h3 style="color: #ef4444;">{{ $totalMeninggal }}</h3>
        <p>Total Meninggal</p>
    </div>
    <div class="glass stat-card">
        <h3 style="color: #3b82f6;">{{ $totalLaki }}</h3>
        <p>Laki-laki</p>
    </div>
    <div class="glass stat-card">
        <h3 style="color: #ec4899;">{{ $totalPerempuan }}</h3>
        <p>Perempuan</p>
    </div>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <h3 style="margin: 0 0 1rem; color: var(--primary);">
        Data Meninggal Bulan {{ $namaBulan }} {{ $tahun }}
    </h3>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="ri-check-line"></i> {{ session('success') }}
        </div>
    @endif

    @if($dataMeninggal->count() > 0)
        <div style="overflow-x: auto;">
        <table style="min-width: 600px;">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">NIK</th>
                    <th width="25%">Nama Lengkap</th>
                    <th width="5%">JK</th>
                    <th width="15%">Tgl Meninggal</th>
                    <th width="15%">Tempat</th>
                    <th width="20%">Sebab</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataMeninggal as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                    <td>{{ $item->tanggal_meninggal->format('d/m/Y') }}</td>
                    <td>{{ $item->tempat_meninggal ?? '-' }}</td>
                    <td>{{ $item->sebab_meninggal ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @else
        <div style="text-align: center; padding: 3rem; color: #999;">
            <i class="ri-inbox-line" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></i>
            <p>Tidak ada data meninggal pada bulan {{ $namaBulan }} {{ $tahun }}.</p>
        </div>
    @endif
</div>
@endsection
