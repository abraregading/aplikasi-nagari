@extends('kajor.layouts.app')

@section('title', 'Data Penduduk - Jorong ' . $jorongName)

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .status-hidup { background: rgba(16, 185, 129, 0.2); color: #10b981; }
    .status-meninggal { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
    .status-pindah { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }

    .btn-action {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .btn-view { background: rgba(99, 102, 241, 0.2); color: #6366f1; }

    .filter-section {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: rgba(0,0,0,0.02);
        border-radius: 12px;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    .filter-group label {
        font-size: 0.8rem;
        color: #666;
    }
    .filter-group select, .filter-group input {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
    }
</style>
@endsection

@section('konten')
<div style="margin-bottom: 2rem;">
    <h2 style="margin-bottom: 0.5rem;">Data Penduduk</h2>
    <p style="color: #999;">Jorong: <strong>{{ $jorongName }}</strong></p>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="margin: 0; color: var(--primary);">Daftar Penduduk</h3>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="ri-check-line"></i> {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="filter-section">
        <div class="filter-group">
            <label>Cari NIK / Nama</label>
<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." style="min-width: 120px; width: 200px; max-width: 100%;">
        </div>
        <div class="filter-group">
            <label>Jenis Kelamin</label>
            <select name="jk" style="min-width: 100px; width: 120px;">
        </div>
        <div class="filter-group">
            <label>Status Hidup</label>
            <select name="status" style="min-width: 100px; width: 120px;">
                <option value="">Semua</option>
                <option value="hidup" {{ request('status') == 'hidup' ? 'selected' : '' }}>Hidup</option>
                <option value="meninggal" {{ request('status') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
            </select>
        </div>
        <div class="filter-group" style="justify-content: flex-end;">
            <label>&nbsp;</label>
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;">
                <i class="ri-search-line"></i> Filter
            </button>
            @if(request()->hasAny(['search', 'jk', 'status']))
                <a href="{{ route('kajor.penduduk.index') }}" class="glass-select" style="background: #6b7280; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                    <i class="ri-refresh-line"></i> Reset
                </a>
            @endif
        </div>
    </form>

    <div class="table-overlay">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">NIK</th>
                    <th width="20%">Nama Lengkap</th>
                    <th width="8%">JK</th>
                    <th width="12%">Tgl Lahir</th>
                    <th width="15%">Pekerjaan</th>
                    <th width="12%">No. KK</th>
                    <th width="8%">Status</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penduduks as $penduduk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $penduduk->nik }}</td>
                    <td>{{ $penduduk->nama_lengkap }}</td>
                    <td>{{ $penduduk->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                    <td>{{ $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                    <td>{{ $penduduk->pekerjaan ?? '-' }}</td>
                    <td>{{ $penduduk->no_kk }}</td>
                    <td>
                        <span class="status-badge status-{{ $penduduk->status_hidup }}">
                            @switch($penduduk->status_hidup)
                                @case('hidup') Hidup @break
                                @case('meninggal') Meninggal @break
                                @case('pindah') Pindah @break
                                @default {{ $penduduk->status_hidup }}
                            @endswitch
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('kajor.penduduk.show', $penduduk->id) }}" class="btn-action btn-view" title="Lihat Detail">
                            <i class="ri-eye-line"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.childRowImmediate,
                        type: 'inline'
                    }
                },
                columnDefs: [
                    { responsivePriority: 6, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 1, targets: [2, 8] },
                    { responsivePriority: 5, targets: [3, 4] },
                    { responsivePriority: 4, targets: [5, 7] },
                    { responsivePriority: 3, targets: 6 }
                ],
                language: {
                    searchPlaceholder: "Cari data penduduk...",
                    search: "",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    emptyTable: "Belum ada data penduduk",
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