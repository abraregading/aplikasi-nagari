@extends('kajor.layouts.app')

@section('title', 'Data Usaha Kos & Kontrakan - Jorong ' . $jorongName)

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .jenis-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .jenis-kos { background: rgba(99, 102, 241, 0.2); color: #6366f1; }
    .jenis-kontrakan { background: rgba(16, 185, 129, 0.2); color: #10b981; }
    .jenis-rumah_petak { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .status-aktif { background: rgba(16, 185, 129, 0.2); color: #10b981; }
    .status-nonaktif { background: rgba(107, 114, 128, 0.2); color: #6b7280; }

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
    .btn-print { background: rgba(16, 185, 129, 0.2); color: #10b981; }

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
    <h2 style="margin-bottom: 0.5rem;">Data Usaha Kos & Kontrakan</h2>
    <p style="color: #999;">Jorong: <strong>{{ $jorongName }}</strong></p>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="margin: 0; color: var(--primary);">Daftar Usaha</h3>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="ri-check-line"></i> {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="filter-section">
        <div class="filter-group">
            <label>Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama usaha, alamat, pemilik..." style="min-width: 120px; width: 200px; max-width: 100%;">
        </div>
        <div class="filter-group">
            <label>Jenis Usaha</label>
            <select name="jenis_usaha" style="min-width: 110px; width: 150px;">
                <option value="">Semua</option>
                <option value="kos" {{ request('jenis_usaha') == 'kos' ? 'selected' : '' }}>Kos</option>
                <option value="kontrakan" {{ request('jenis_usaha') == 'kontrakan' ? 'selected' : '' }}>Kontrakan</option>
                <option value="rumah_petak" {{ request('jenis_usaha') == 'rumah_petak' ? 'selected' : '' }}>Rumah Petak</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Status</label>
            <select name="status" style="min-width: 90px; width: 120px;">
                <option value="">Semua</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="filter-group" style="justify-content: flex-end;">
            <label>&nbsp;</label>
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;">
                <i class="ri-search-line"></i> Filter
            </button>
            @if(request()->hasAny(['search', 'jenis_usaha', 'status']))
                <a href="{{ route('kajor.bisniskos.index') }}" class="glass-select" style="background: #6b7280; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                    <i class="ri-refresh-line"></i> Reset
                </a>
            @endif
        </div>
    </form>

    <div class="table-overlay">
        <table id="bisnisTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="18%">Nama Usaha</th>
                    <th width="12%">Jenis</th>
                    <th width="20%">Alamat</th>
                    <th width="15%">Pemilik</th>
                    <th width="8%">Kamar</th>
                    <th width="8%">Penghuni</th>
                    <th width="8%">Status</th>
                    <th width="14%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bisnis as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $item->nama_usaha }}</strong></td>
                    <td>
                        <span class="jenis-badge jenis-{{ $item->jenis_usaha }}">
                            @switch($item->jenis_usaha)
                                @case('kos') Kos @break
                                @case('kontrakan') Kontrakan @break
                                @case('rumah_petak') Rumah Petak @break
                                @default {{ $item->jenis_usaha }}
                            @endswitch
                        </span>
                    </td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->pemilik_nama }}</td>
                    <td>{{ $item->jumlah_kamar ?? '-' }}</td>
                    <td><span style="font-weight: 500; color: var(--primary);">{{ $item->penghunis_count }}</span></td>
                    <td>
                        <span class="status-badge status-{{ $item->status }}">
                            {{ $item->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('kajor.bisniskos.show', $item->id) }}" class="btn-action btn-view" title="Lihat Detail">
                            <i class="ri-eye-line"></i>
                        </a>
                        <a href="{{ route('kajor.bisniskos.print', $item->id) }}" target="_blank" class="btn-action btn-print" title="Print">
                            <i class="ri-printer-line"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1rem; display: flex; justify-content: center;">
        {{ $bisnis->links() }}
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#bisnisTable').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: 'inline'
                }
            },
            columnDefs: [
                { responsivePriority: 6, targets: 0 },
                { responsivePriority: 1, targets: [1, 8] },
                { responsivePriority: 4, targets: [2, 5, 6] },
                { responsivePriority: 5, targets: 3 },
                { responsivePriority: 3, targets: 4 },
                { responsivePriority: 2, targets: 7 }
            ],
            paging: false,
            info: false
        });
    });
</script>
@endsection