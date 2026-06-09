@extends('petugas.layouts.app')
@section('title', 'Pendataan Kartu Keluarga')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .page-header .actions { display: flex; gap: .75rem; }
    .btn { padding: .6rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: .9rem; text-decoration: none; display: inline-flex; align-items: center; gap: .4rem; transition: all .2s; cursor: pointer; border: none; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #0284c7; }

    /* Search */
    .search-bar { display: flex; gap: .75rem; margin-bottom: 1.5rem; }
    .search-bar input { flex: 1; padding: .7rem 1rem; border-radius: 10px; border: 1px solid rgba(0,0,0,.1); background: rgba(255,255,255,.6); color: var(--text-main); font-size: .9rem; font-family: inherit; }
    .search-bar input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,.15); }
    .search-bar input::placeholder { color: var(--text-muted); }
    .search-bar button { padding: .7rem 1.2rem; border-radius: 10px; background: var(--primary); color: #fff; border: none; cursor: pointer; font-weight: 600; font-family: inherit; font-size: .9rem; display: inline-flex; align-items: center; gap: .3rem; }
    .search-bar button:hover { background: #0284c7; }

    /* Table */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: .75rem; color: var(--text-muted); font-size: .8rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; border-bottom: 2px solid rgba(0,0,0,.08); }
    .data-table td { padding: .85rem .75rem; font-size: .9rem; border-bottom: 1px solid rgba(0,0,0,.05); }
    .data-table tr:hover td { background: rgba(14,165,233,.03); }

    /* Status Badges - scoped to avoid conflict with global .badge */
    .status-badge { padding: .25rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600; display: inline-block; position: static; width: auto; height: auto; background: none; border: none; }
    .status-aktif { background: rgba(16,185,129,.15); color: #059669; }
    .status-pindah { background: rgba(245,158,11,.15); color: #d97706; }
    .status-non-aktif { background: rgba(239,68,68,.15); color: #dc2626; }

    /* Action Buttons */
    .btn-action { padding: .4rem .75rem; border-radius: 8px; font-size: .8rem; text-decoration: none; display: inline-flex; align-items: center; gap: .2rem; transition: all .2s; font-family: inherit; }
    .btn-view { background: rgba(99,102,241,.1); color: #4f46e5; }
    .btn-view:hover { background: rgba(99,102,241,.2); }
    .btn-edit { background: rgba(245,158,11,.1); color: #d97706; }
    .btn-edit:hover { background: rgba(245,158,11,.2); }
    .btn-delete { background: rgba(239,68,68,.1); color: #dc2626; border: none; cursor: pointer; }
    .btn-delete:hover { background: rgba(239,68,68,.2); }

    /* Empty & Alert */
    .empty-state { text-align: center; padding: 3rem; color: var(--text-muted); }
    .alert { padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: .5rem; }
    .alert-success { background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.25); color: #059669; }
    .alert-error { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.25); color: #dc2626; }

    /* Pagination */
    .pagination-wrap { display: flex; justify-content: center; gap: .5rem; margin-top: 1.5rem; }
    .pagination-wrap a, .pagination-wrap span { padding: .5rem .9rem; border-radius: 8px; font-size: .85rem; text-decoration: none; }
    .pagination-wrap a { background: rgba(255,255,255,.6); color: var(--text-main); border: 1px solid rgba(0,0,0,.08); }
    .pagination-wrap a:hover { background: rgba(14,165,233,.1); border-color: var(--primary); }
    .pagination-wrap span { background: var(--primary); color: #fff; }

    @media(max-width:768px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .table-wrapper { overflow-x: auto; }
        .search-bar { flex-direction: column; }
    }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-home-line" style="color: var(--primary)"></i> Pendataan Kartu Keluarga</h2>
    <div class="actions">
        <form action="{{ route('petugas.pendataankeluarga.syncAll') }}" method="POST" style="display: inline;" onsubmit="return confirm('Sync semua data keluarga? Proses ini akan menghubungkan data keluarga dengan anggota keluarganya.');">
            @csrf
            <button type="submit" class="btn" style="background: rgba(16,185,129,.15); color: #059669; border: none; cursor: pointer; font-family: inherit; font-size: .9rem; padding: .6rem 1.2rem; border-radius: 10px; font-weight: 600; display: inline-flex; align-items: center; gap: .4rem;">
                <i class="ri-refresh-line"></i> Sync Data
            </button>
        </form>
        <a href="{{ route('petugas.pendataankeluarga.create') }}" class="btn btn-primary">
            <i class="ri-add-line"></i> Tambah KK
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success"><i class="ri-check-line"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error"><i class="ri-error-warning-line"></i> {{ session('error') }}</div>
@endif

<div class="glass" style="padding: 1.5rem; border-radius: 16px;">
    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Cari No. KK, NIK Kepala Keluarga, atau Alamat..." value="{{ request('search') }}">
        <button type="submit"><i class="ri-search-line"></i> Cari</button>
    </form>

    <div class="table-wrapper">
        <table id="example" class="display" style="width:100%x">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. KK</th>
                    <th>Kepala Keluarga</th>
                    <th>Alamat</th>
                    <th>Jorong</th>
                    <th>Anggota</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keluargas as $kk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 500;">{{ $kk->no_kk }}</td>
                    <td>{{ $kk->kepalaKeluarga?->penduduk?->nama_lengkap ?? $kk->kepala_keluarga_nik ?? '-' }}</td>
                    <td>{{ Str::limit($kk->alamat, 35) }}</td>
                    <td>{{ $kk->jorong ?? '-' }}</td>
                    <td>{{ $kk->penduduks_count }}</td>
                    <td>
                        @if($kk->status == 'aktif')
                            <span class="status-badge status-aktif">Aktif</span>
                        @elseif($kk->status == 'pindah')
                            <span class="status-badge status-pindah">Pindah</span>
                        @else
                            <span class="status-badge status-non-aktif">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: .4rem; align-items: center;">
                            <a href="{{ route('petugas.pendataankeluarga.show', $kk->id) }}" class="btn-action btn-view" title="Detail"><i class="ri-eye-line"></i></a>
                            <a href="{{ route('petugas.pendataankeluarga.edit', $kk->id) }}" class="btn-action btn-edit" title="Edit"><i class="ri-edit-line"></i></a>
                            <form action="{{ route('petugas.pendataankeluarga.destroy', $kk->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin hapus data KK ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus"><i class="ri-delete-bin-line"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-state">
                        <i class="ri-folder-line" style="font-size: 2rem; display: block; margin-bottom: .5rem;"></i>
                        <p>Belum ada data kartu keluarga</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
<!--  -->
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
