@extends('petugas.layouts.app')
@section('title', 'Pendataan Kos & Kontrakan')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .page-header .actions { display: flex; gap: .75rem; }
    .glass { background: rgba(255,255,255,.7); backdrop-filter: blur(10px); border-radius: 16px; padding: 1.5rem; border: 1px solid rgba(255,255,255,.8); }
    .btn { padding: .6rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: .9rem; text-decoration: none; display: inline-flex; align-items: center; gap: .4rem; transition: all .2s; cursor: pointer; border: none; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #0284c7; }
    .btn-secondary { background: rgba(107,114,128,.15); color: #4b5563; }
    .btn-secondary:hover { background: rgba(107,114,128,.25); }
    .btn-info { background: rgba(59,130,246,.15); color: #3b82f6; }
    .btn-info:hover { background: rgba(59,130,246,.25); }
    .btn-danger { background: rgba(239,68,68,.15); color: #dc2626; }
    .btn-danger:hover { background: rgba(239,68,68,.25); }
    .search-bar { display: flex; gap: .75rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .search-bar input, .search-bar select { padding: .7rem 1rem; border-radius: 10px; border: 1px solid rgba(0,0,0,.1); font-size: .9rem; background: rgba(255,255,255,.8); flex: 1; min-width: 150px; }
    .search-bar input:focus, .search-bar select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,.15); }
    .search-bar button { padding: .7rem 1.2rem; border-radius: 10px; background: var(--primary); color: #fff; border: none; cursor: pointer; font-weight: 600; }
    .table-responsive { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: .75rem; color: var(--text-muted); font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; border-bottom: 2px solid rgba(0,0,0,.08); }
    .data-table td { padding: .85rem .75rem; font-size: .9rem; border-bottom: 1px solid rgba(0,0,0,.05); }
    .data-table tr:hover td { background: rgba(14,165,233,.03); }
    .badge { padding: .25rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600; display: inline-block; }
    .badge-kos { background: rgba(14,165,233,.15); color: #0ea5e9; }
    .badge-kontrakan { background: rgba(245,158,11,.15); color: #d97706; }
    .badge-rumah_petak { background: rgba(139,92,246,.15); color: #8b5cf6; }
    .badge-aktif { background: rgba(16,185,129,.15); color: #059669; }
    .badge-nonaktif { background: rgba(239,68,68,.15); color: #dc2626; }
    .empty-state { text-align: center; padding: 3rem; color: var(--text-muted); }
    .pagination-wrap { display: flex; justify-content: center; gap: .5rem; margin-top: 1.5rem; }
    .pagination-wrap a, .pagination-wrap span { padding: .5rem .9rem; border-radius: 8px; font-size: .85rem; text-decoration: none; }
    .pagination-wrap a { background: rgba(255,255,255,.6); color: var(--text-main); border: 1px solid rgba(0,0,0,.08); }
    .pagination-wrap a:hover { background: rgba(14,165,233,.1); border-color: var(--primary); }
    .pagination-wrap span { background: var(--primary); color: #fff; }
    .btn-sm { padding: .3rem .6rem; font-size: .8rem; }
    @media(max-width:768px) { .search-bar { flex-direction: column; } .search-bar > * { width: 100%; } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-home-4-line" style="color: var(--primary)"></i> Pendataan Kos & Kontrakan</h2>
    <div class="actions">
        <a href="{{ route('petugas.bisniskos.create') }}" class="btn btn-primary">
            <i class="ri-add-line"></i> Tambah Usaha
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert" style="background: rgba(16,185,129,.15); border: 1px solid rgba(16,185,129,.25); color: #059669; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: .5rem;">
    <i class="ri-check-line"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert" style="background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.25); color: #dc2626; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: .5rem;">
    <i class="ri-error-warning-line"></i> {{ session('error') }}
</div>
@endif

<div class="glass">
    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Cari nama usaha, alamat, atau pemilik..." value="{{ request('search') }}">
        <select name="jenis_usaha">
            <option value="">Semua Jenis</option>
            <option value="kos" {{ request('jenis_usaha') == 'kos' ? 'selected' : '' }}>Kos</option>
            <option value="kontrakan" {{ request('jenis_usaha') == 'kontrakan' ? 'selected' : '' }}>Kontrakan</option>
            <option value="rumah_petak" {{ request('jenis_usaha') == 'rumah_petak' ? 'selected' : '' }}>Rumah Petak</option>
        </select>
        <select name="status">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <button type="submit"><i class="ri-search-line"></i> Filter</button>
        @if(request()->anyFilled(['search', 'jenis_usaha', 'status']))
            <a href="{{ route('petugas.bisniskos.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table id="example" class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Nama Usaha</th>
                    <th width="15%">Jenis</th>
                    <th width="25%">Alamat</th>
                    <th width="20%">Pemilik</th>
                    <th width="10%">Kamar</th>
                    <th width="10%">Status</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bisnis as $index => $item)
                <tr>
                    <td>{{ $bisnis->firstItem() + $index }}</td>
                    <td style="font-weight: 500;">{{ $item->nama_usaha }}</td>
                    <td>
                        @if($item->jenis_usaha == 'kos')
                            <span class="badge badge-kos">Kos</span>
                        @elseif($item->jenis_usaha == 'kontrakan')
                            <span class="badge badge-kontrakan">Kontrakan</span>
                        @else
                            <span class="badge badge-rumah_petak">Rumah Petak</span>
                        @endif
                    </td>
                    <td>{{ Str::limit($item->alamat, 30) }}</td>
                    <td>{{ $item->pemilik_nama }}</td>
                    <td>{{ $item->jumlah_kamar }}</td>
                    <td>
                        @if($item->status == 'aktif')
                            <span class="badge badge-aktif">Aktif</span>
                        @else
                            <span class="badge badge-nonaktif">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: .3rem; flex-wrap: wrap;">
                            <a href="{{ route('petugas.bisniskos.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="ri-eye-line"></i>
                            </a>
                            <a href="{{ route('petugas.bisniskos.penghuni.index', $item->id) }}" class="btn btn-sm btn-primary" title="Penghuni">
                                <i class="ri-user-line"></i>
                            </a>
                            <a href="{{ route('petugas.bisniskos.edit', $item->id) }}" class="btn btn-sm btn-secondary" title="Edit">
                                <i class="ri-edit-line"></i>
                            </a>
                            <form action="{{ route('petugas.bisniskos.destroy', $item->id) }}" method="POST" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin hapus?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-state">
                        <i class="ri-home-4-line" style="font-size: 2rem; display: block; margin-bottom: .5rem;"></i>
                        <p>Belum ada data kos/kontrakan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $bisnis->links() }}</div>
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
                searchPlaceholder: "Cari usaha...",
                emptyTable: "Tidak ada data usaha"
            },
            paging: false,
            info: false
        });
    });
</script>
@endsection
