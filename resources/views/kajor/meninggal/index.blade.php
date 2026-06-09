@extends('kajor.layouts.app')

@section('title', 'Data Meninggal - Jorong ' . $jorongName)

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
    .status-L { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
    .status-P { background: rgba(236, 72, 153, 0.2); color: #ec4899; }

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
    .btn-edit { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
    .btn-delete { background: rgba(239, 68, 68, 0.2); color: #ef4444; }

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
        color: #999;
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
    <h2 style="margin-bottom: 0.5rem;">Data Meninggal Dunia</h2>
    <p style="color: #999;">Jorong: <strong>{{ $jorongName }}</strong></p>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.5rem;">
        <h3 style="margin: 0; color: var(--primary);">Daftar Kejadian Meninggal</h3>
        <a href="{{ route('kajor.meninggal.create') }}" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.6rem 1.2rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
            <i class="ri-add-line"></i> Tambah Data
        </a>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="ri-check-line"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="ri-error-warning-line"></i> {{ session('error') }}
        </div>
    @endif

    <form method="GET" class="filter-section">
        <div class="filter-group">
            <label>Cari NIK / Nama</label>
<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." style="min-width: 120px; width: 200px; max-width: 100%;">
        </div>
        <div class="filter-group">
            <label>Bulan</label>
            <select name="bulan" style="min-width: 90px; width: 130px;">
        </div>
        <div class="filter-group">
            <label>Tahun</label>
            <select name="tahun" style="min-width: 80px; width: 100px;">
                <option value="">Semua</option>
                @for($t = now()->year; $t >= now()->year - 5; $t--)
                    <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endfor
            </select>
        </div>
        <div class="filter-group" style="justify-content: flex-end;">
            <label>&nbsp;</label>
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;">
                <i class="ri-search-line"></i> Filter
            </button>
            @if(request()->hasAny(['search', 'bulan', 'tahun']))
                <a href="{{ route('kajor.meninggal.index') }}" class="glass-select" style="background: #6b7280; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
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
                    <th width="12%">NIK</th>
                    <th width="18%">Nama Lengkap</th>
                    <th width="5%">JK</th>
                    <th width="12%">Tgl Meninggal</th>
                    <th width="12%">Tempat</th>
                    <th width="15%">Sebab</th>
                    <th width="12%">Saksi</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataMeninggal as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td><span class="status-badge status-{{ $item->jenis_kelamin }}">{{ $item->jenis_kelamin == 'L' ? 'L' : 'P' }}</span></td>
                    <td>{{ $item->tanggal_meninggal->format('d/m/Y') }}</td>
                    <td>{{ $item->tempat_meninggal ?? '-' }}</td>
                    <td>{{ $item->sebab_meninggal ?? '-' }}</td>
                    <td>{{ $item->nama_saksi ?? '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 0.3rem;">
                            <a href="{{ route('kajor.meninggal.show', $item->id) }}" class="btn-action btn-view" title="Detail">
                                <i class="ri-eye-line"></i>
                            </a>
                            <a href="{{ route('kajor.meninggal.edit', $item->id) }}" class="btn-action btn-edit" title="Edit">
                                <i class="ri-edit-line"></i>
                            </a>
                            <form action="{{ route('kajor.meninggal.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" style="border:none; cursor:pointer;" title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1rem;">
        {{ $dataMeninggal->links() }}
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
                { responsivePriority: 3, targets: 1 },
                { responsivePriority: 1, targets: [2, 8] },
                { responsivePriority: 5, targets: [3, 4] },
                { responsivePriority: 4, targets: [5, 6] },
                { responsivePriority: 2, targets: 7 }
            ],
            paging: false,
            info: false,
            sorting: false,
            language: {
                searchPlaceholder: "Cari data meninggal...",
                search: "",
                emptyTable: "Belum ada data meninggal",
            }
        });
    });
</script>
@endsection
