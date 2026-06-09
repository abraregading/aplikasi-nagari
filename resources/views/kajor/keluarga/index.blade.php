@extends('kajor.layouts.app')

@section('title', 'Data Keluarga - Jorong ' . $jorongName)

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
    .status-aktif { background: rgba(16, 185, 129, 0.2); color: #10b981; }
    .status-pindah { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
    .status-non-aktif { background: rgba(107, 114, 128, 0.2); color: #6b7280; }

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
    <h2 style="margin-bottom: 0.5rem;">Data Keluarga</h2>
    <p style="color: #999;">Jorong: <strong>{{ $jorongName }}</strong></p>
</div>

    <div class="glass" style="padding: 2rem; border-radius: 16px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem;">
            <h3 style="margin: 0; color: var(--primary);">Daftar Keluarga</h3>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <form action="{{ route('kajor.keluarga.sync') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="glass-select" style="background: rgba(16, 185, 129, 0.2); color: #10b981; border: none; padding: 0.6rem 1.2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i class="ri-refresh-line"></i> Sync Jumlah
                    </button>
                </form>
                <a href="{{ route('kajor.keluarga.create') }}" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.6rem 1.2rem; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="ri-add-line"></i> Tambah KK
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="ri-check-line"></i> {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="filter-section">
        <div class="filter-group">
            <label>Cari No. KK / Alamat</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." style="min-width: 120px; width: 200px; max-width: 100%;">
        </div>
        <div class="filter-group">
            <label>Status</label>
            <select name="status" style="min-width: 100px; width: 120px;">
                <option value="">Semua</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                <option value="non-aktif" {{ request('status') == 'non-aktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="filter-group" style="justify-content: flex-end;">
            <label>&nbsp;</label>
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;">
                <i class="ri-search-line"></i> Filter
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('kajor.keluarga.index') }}" class="glass-select" style="background: #6b7280; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
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
                    <th width="15%">No. KK</th>
                    <th width="20%">Nama Kepala Keluarga</th>
                    <th width="15%">Alamat</th>
                    <th width="12%">Jorong</th>
                    <th width="8%">Anggota</th>
                    <th width="10%">Status</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keluargas as $keluarga)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $keluarga->no_kk }}</td>
                    <td>{{ $keluarga->kepalaKeluarga->nama_lengkap ?? '-' }}</td>
                    <td>{{ $keluarga->alamat }}</td>
                    <td>{{ $keluarga->jorong ?? '-' }}</td>
                    <td>{{ $keluarga->jumlah_anggota }}</td>
                    <td>
                        <span class="status-badge status-{{ $keluarga->status }}">
                            @switch($keluarga->status)
                                @case('aktif') Aktif @break
                                @case('pindah') Pindah @break
                                @case('non-aktif') Nonaktif @break
                                @default {{ $keluarga->status }}
                            @endswitch
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('kajor.keluarga.show', $keluarga->id) }}" class="btn-action btn-view" title="Lihat Detail">
                            <i class="ri-eye-line"></i>
                        </a>
                        <a href="{{ route('kajor.keluarga.edit', $keluarga->id) }}" class="btn-action" style="background: rgba(245, 158, 11, 0.2); color: #f59e0b;" title="Edit">
                            <i class="ri-edit-line"></i>
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
                    { responsivePriority: 5, targets: 0 },
                    { responsivePriority: 3, targets: 1 },
                    { responsivePriority: 1, targets: [2, 7] },
                    { responsivePriority: 4, targets: 3 },
                    { responsivePriority: 6, targets: [4, 5] },
                    { responsivePriority: 2, targets: 6 }
                ],
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