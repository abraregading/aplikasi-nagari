@extends('petugas.layouts.app')
@section('title', 'Riwayat Pendataan Saya')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .page-header .actions { display: flex; gap: .75rem; }

    .filter-bar { display: flex; gap: .75rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .filter-bar input, .filter-bar select { padding: .6rem 1rem; border-radius: 10px; border: 1px solid rgba(0,0,0,.1); font-size: .9rem; font-family: inherit; background: rgba(255,255,255,.8); }
    .filter-bar input:focus, .filter-bar select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,.15); }
    .filter-bar button { padding: .6rem 1.2rem; border-radius: 10px; background: var(--primary); color: #fff; border: none; cursor: pointer; font-weight: 600; font-family: inherit; font-size: .9rem; display: inline-flex; align-items: center; gap: .3rem; }
    .filter-bar button:hover { background: #0284c7; }

    .glass { background: rgba(255,255,255,.7); backdrop-filter: blur(10px); border-radius: 16px; padding: 1.5rem; border: 1px solid rgba(255,255,255,.8); }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: .75rem; color: var(--text-muted); font-size: .8rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; border-bottom: 2px solid rgba(0,0,0,.08); }
    .data-table td { padding: .85rem .75rem; font-size: .9rem; border-bottom: 1px solid rgba(0,0,0,.05); }
    .data-table tr:hover td { background: rgba(14,165,233,.03); }

    .btn { padding: .4rem .75rem; border-radius: 8px; font-size: .8rem; text-decoration: none; display: inline-flex; align-items: center; gap: .2rem; transition: all .2s; font-family: inherit; border: none; cursor: pointer; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #0284c7; }
    .btn-info { background: rgba(59,130,246,.15); color: #3b82f6; }
    .btn-info:hover { background: rgba(59,130,246,.25); }
    .btn-secondary { background: rgba(107,114,128,.15); color: #4b5563; }
    .btn-secondary:hover { background: rgba(107,114,128,.25); }

    .status-badge { padding: .25rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600; display: inline-block; }
    .badge-create { background: rgba(16,185,129,.15); color: #059669; }
    .badge-update { background: rgba(245,158,11,.15); color: #d97706; }

    .empty-state { text-align: center; padding: 3rem; color: var(--text-muted); }
    .pagination-wrap { display: flex; justify-content: center; gap: .5rem; margin-top: 1.5rem; }
    .pagination-wrap a, .pagination-wrap span { padding: .5rem .9rem; border-radius: 8px; font-size: .85rem; text-decoration: none; }
    .pagination-wrap a { background: rgba(255,255,255,.6); color: var(--text-main); border: 1px solid rgba(0,0,0,.08); }
    .pagination-wrap a:hover { background: rgba(14,165,233,.1); border-color: var(--primary); }
    .pagination-wrap span { background: var(--primary); color: #fff; }

    .table-wrapper { overflow-x: auto; }
    .qr-thumb { width: 40px; height: 40px; border-radius: 6px; }

    @media(max-width:768px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .filter-bar { flex-direction: column; }
        .filter-bar > * { width: 100%; }
    }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-history-line" style="color: var(--primary)"></i> Riwayat Pendataan Saya</h2>
    <div class="actions">
        <a href="{{ route('petugas.pendataankeluarga.index') }}" class="btn btn-secondary">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>
</div>

<div class="glass">
    <form method="GET" class="filter-bar">
        <input type="text" name="search" placeholder="Cari No. KK atau Nama Kepala Keluarga..." value="{{ request('search') }}">
        <select name="aksi">
            <option value="">Semua Aksi</option>
            <option value="create" {{ request('aksi') == 'create' ? 'selected' : '' }}>Dibuat</option>
            <option value="update" {{ request('aksi') == 'update' ? 'selected' : '' }}>Diperbarui</option>
        </select>
        <input type="date" name="tanggal" value="{{ request('tanggal') }}">
        <button type="submit"><i class="ri-search-line"></i> Filter</button>
        @if(request()->anyFilled(['search', 'aksi', 'tanggal']))
            <a href="{{ route('petugas.pendataankeluarga.riwayatsaya') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    <div class="table-wrapper">
        <table id="example" class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No. KK</th>
                    <th>Kepala Keluarga</th>
                    <th>Aksi</th>
                    <th>QR Code</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayats as $index => $riwayat)
                <tr>
                    <td>{{ $riwayats->firstItem() + $index }}</td>
                    <td>{{ $riwayat->tanggal_update->format('d/m/Y H:i') }}</td>
                    <td style="font-weight: 500;">{{ $riwayat->no_kk }}</td>
                    <td>{{ $riwayat->kepala_keluarga_nama ?? '-' }}</td>
                    <td>
                        @if($riwayat->aksi == 'create')
                            <span class="status-badge badge-create">Dibuat</span>
                        @else
                            <span class="status-badge badge-update">Diperbarui</span>
                        @endif
                    </td>
                    <td>
                        <img src="{{ $riwayat->qr_code_url }}" alt="QR" class="qr-thumb">
                    </td>
                    <td>
                        <div style="display: flex; gap: .3rem;">
                            <a href="{{ route('petugas.pendataankeluarga.riwayatshow', $riwayat->id) }}" class="btn btn-info" title="Detail">
                                <i class="ri-eye-line"></i>
                            </a>
                            <a href="{{ $riwayat->qr_url }}" target="_blank" class="btn btn-primary" title="Buka Link">
                                <i class="ri-external-link-line"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <i class="ri-folder-line" style="font-size: 2rem; display: block; margin-bottom: .5rem;"></i>
                        <p>Belum ada riwayat pendataan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: "Cari data keluarga...",
                    search: "",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    emptyTable: "Belum ada data keluarga",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>
@endsection