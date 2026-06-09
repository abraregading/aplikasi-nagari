@extends('petugas.layouts.app')
@section('title', 'Penghuni - ' . $bisnis->nama_usaha)

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
    .btn-sm { padding: .3rem .6rem; font-size: .8rem; }
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
    .badge-aktif { background: rgba(16,185,129,.15); color: #059669; }
    .badge-pindah { background: rgba(245,158,11,.15); color: #d97706; }
    .badge-keluar { background: rgba(239,68,68,.15); color: #dc2626; }
    .empty-state { text-align: center; padding: 3rem; color: var(--text-muted); }
    .pagination-wrap { display: flex; justify-content: center; gap: .5rem; margin-top: 1.5rem; }
    .pagination-wrap a, .pagination-wrap span { padding: .5rem .9rem; border-radius: 8px; font-size: .85rem; text-decoration: none; }
    .pagination-wrap a { background: rgba(255,255,255,.6); color: var(--text-main); border: 1px solid rgba(0,0,0,.08); }
    .pagination-wrap a:hover { background: rgba(14,165,233,.1); border-color: var(--primary); }
    .pagination-wrap span { background: var(--primary); color: #fff; }
    @media(max-width:768px) { .search-bar { flex-direction: column; } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <div>
        <h2><i class="ri-user-line" style="color: var(--primary)"></i> Penghuni - {{ $bisnis->nama_usaha }}</h2>
        <small style="color: var(--text-muted);">{{ $bisnis->alamat }}</small>
    </div>
    <div class="actions">
        <a href="{{ route('petugas.bisniskos.show', $bisnis->id) }}" class="btn btn-secondary">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <a href="{{ route('petugas.bisniskos.penghuni.create', $bisnis->id) }}" class="btn btn-primary">
            <i class="ri-add-line"></i> Tambah Penghuni
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert" style="background: rgba(16,185,129,.15); border: 1px solid rgba(16,185,129,.25); color: #059669; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: .5rem;">
    <i class="ri-check-line"></i> {{ session('success') }}
</div>
@endif


<div class="glass">
    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Cari nama, NIK, atau kamar..." value="{{ request('search') }}">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
            <option value="keluar" {{ request('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
        </select>
        <button type="submit"><i class="ri-search-line"></i> Filter</button>
        @if(request()->anyFilled(['search', 'status']))
            <a href="{{ route('petugas.bisniskos.penghuni.index', $bisnis->id) }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table id="example" class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NIK</th>
                    <th>JK</th>
                    <th>No. Kamar</th>
                    <th>Harga Sewa</th>
                    <th>Tgl Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penghunis as $index => $p)
                <tr>
                    <td>{{ $penghunis->firstItem() + $index }}</td>
                    <td style="font-weight: 500;">{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->nik ?? '-' }}</td>
                    <td>{{ $p->jekel == 'L' ? 'L' : 'P' }}</td>
                    <td>{{ $p->no_kamar ?? '-' }}</td>
                    <td>Rp {{ $p->harga_sewa ? number_format($p->harga_sewa, 0, ',', '.') : '-' }}</td>
                    <td>{{ $p->tanggal_masuk ? $p->tanggal_masuk->format('d/m/Y') : '-' }}</td>
                    <td>
                        @if($p->status == 'aktif')
                            <span class="badge badge-aktif">Aktif</span>
                        @elseif($p->status == 'pindah')
                            <span class="badge badge-pindah">Pindah</span>
                        @else
                            <span class="badge badge-keluar">Keluar</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: .3rem;">
                            <a href="{{ route('petugas.bisniskos.penghuni.edit', [$bisnis->id, $p->id]) }}" class="btn btn-sm btn-info" title="Edit">
                                <i class="ri-edit-line"></i>
                            </a>
                            <form action="{{ route('petugas.bisniskos.penghuni.destroy', [$bisnis->id, $p->id]) }}" method="POST" style="display: inline;">
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
                    <td colspan="9" class="empty-state">
                        <i class="ri-user-line" style="font-size: 2rem; display: block; margin-bottom: .5rem;"></i>
                        <p>Belum ada penghuni</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">{{ $penghunis->links() }}</div>
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