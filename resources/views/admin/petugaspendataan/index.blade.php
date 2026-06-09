@extends('admin.layouts.app')

@section('title', 'Petugas Pendataan')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
    .page-header h2 { margin: 0; }
    .glass { background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border-radius: 16px; padding: 1.5rem; border: 1px solid rgba(255,255,255,0.8); }
    .search-bar { display: flex; gap: 0.75rem; margin-bottom: 1.5rem; }
    .search-bar input { flex: 1; padding: 0.7rem 1rem; border-radius: 10px; border: 1px solid rgba(0,0,0,0.1); font-size: 0.9rem; background: rgba(255,255,255,0.8); }
    .search-bar input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,0.15); }
    .search-bar button { padding: 0.7rem 1.2rem; border-radius: 10px; background: var(--primary); color: #fff; border: none; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem; }
    .search-bar button:hover { background: #0284c7; }
    .btn { padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem; transition: all 0.2s; border: none; cursor: pointer; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #0284c7; }
    .btn-secondary { background: rgba(107,114,128,0.15); color: #4b5563; }
    .btn-secondary:hover { background: rgba(107,114,128,0.25); }
    .btn-info { background: rgba(59,130,246,0.15); color: #3b82f6; }
    .btn-info:hover { background: rgba(59,130,246,0.25); }
    .btn-danger { background: rgba(239,68,68,0.15); color: #dc2626; }
    .btn-danger:hover { background: rgba(239,68,68,0.25); }
    .btn-sm { padding: 0.3rem 0.6rem; font-size: 0.8rem; }
    .table-responsive { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: 0.75rem; font-size: 0.75rem; color: var(--text-muted); border-bottom: 2px solid rgba(0,0,0,0.08); text-transform: uppercase; letter-spacing: 0.5px; }
    .data-table td { padding: 0.85rem 0.75rem; font-size: 0.9rem; border-bottom: 1px solid rgba(0,0,0,0.05); }
    .data-table tr:hover td { background: rgba(14,165,233,0.03); }
    .petugas-avatar { width: 36px; height: 36px; border-radius: 50%; background: rgba(14,165,233,0.15); color: #0ea5e9; display: inline-flex; align-items: center; justify-content: center; font-weight: 600; margin-right: 0.5rem; }
    .badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
    .badge-success { background: rgba(16,185,129,0.15); color: #10b981; }
    .badge-danger { background: rgba(239,68,68,0.15); color: #dc2626; }
    .badge-warning { background: rgba(245,158,11,0.15); color: #d97706; }
    .empty-state { text-align: center; padding: 2rem; color: var(--text-muted); }
    .pagination-wrap { display: flex; justify-content: center; gap: 0.5rem; margin-top: 1.5rem; }
    .pagination-wrap a, .pagination-wrap span { padding: 0.5rem 0.9rem; border-radius: 8px; font-size: 0.85rem; text-decoration: none; }
    .pagination-wrap a { background: rgba(255,255,255,0.6); color: var(--text-main); border: 1px solid rgba(0,0,0,0.08); }
    .pagination-wrap a:hover { background: rgba(14,165,233,0.1); border-color: var(--primary); }
    .pagination-wrap span { background: var(--primary); color: #fff; }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-user-add-line" style="color: var(--primary)"></i> Petugas Pendataan</h2>
    <a href="{{ route('admin.petugaspendataan.create') }}" class="btn btn-primary">
        <i class="ri-add-line"></i> Tambah Petugas
    </a>
</div>

@if(session('success'))
<div style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #10b981; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
    <i class="ri-check-line"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #dc2626; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
    <i class="ri-error-warning-line"></i> {{ session('error') }}
</div>
@endif

<div class="glass">
    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Cari nama, email, atau NIK..." value="{{ request('search') }}">
        <button type="submit"><i class="ri-search-line"></i> Cari</button>
        @if(request('search'))
        <a href="{{ route('admin.petugaspendataan.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table id="example" class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Petugas</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>NIK</th>
                    <th>No. Telepon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($petugas as $index => $p)
                <tr>
                    <td>{{ $petugas->firstItem() + $index }}</td>
                    <td>
                        <span class="petugas-avatar">{{ substr($p->name, 0, 1) }}</span>
                        {{ $p->name }}
                    </td>
                    <td>{{ $p->username }}</td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->nik ?? '-' }}</td>
                    <td>{{ $p->no_telepon ?? '-' }}</td>
                    <td>
                        @if($p->status == 'active')
                        <span class="badge badge-success">Aktif</span>
                        @else
                        <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.3rem;">
                            <a href="{{ route('admin.petugaspendataan.show', $p->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="ri-eye-line"></i>
                            </a>
                            <a href="{{ route('admin.petugaspendataan.edit', $p->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                <i class="ri-edit-line"></i>
                            </a>
                            <form action="{{ route('admin.petugaspendataan.destroy', $p->id) }}" method="POST" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin hapus petugas ini?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-state">
                        <i class="ri-user-line" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                        <p>Belum ada petugas pendataan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $petugas->links() }}</div>
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