@extends('kader.layouts.app')

@section('title', 'Sasaran/Target Pos Yandu')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<style>
    .role-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .status-aktif { background: rgba(16, 185, 129, 0.2); color: #10b981; }
    .status-nonaktif { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
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
    .btn-edit { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
    .btn-delete { background: rgba(239, 68, 68, 0.2); color: #ef4444; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        gap: 1rem;
    }
    @media (max-width: 480px) {
        .page-header {
            flex-direction: column;
            align-items: stretch;
            margin-bottom: 1rem;
        }
        .page-header h2 {
            font-size: 1.2rem;
        }
        .btn-add-sasaran {
            justify-content: center;
            text-align: center;
        }
        .btn-action span {
            display: none;
        }
    }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2 style="margin: 0;">Sasaran / Target Pos Yandu</h2>
    <a href="{{ route('kader.sasaran.create') }}" class="glass-select btn-add-sasaran" style="background: var(--primary); color: white; border: none; padding: 0.6rem 1.2rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
        <i class="ri-add-line"></i> <span>Tambah Sasaran</span>
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

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div class="table-overlay">
        <table id="sasaranTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">NIK</th>
                    <th width="20%">Nama Lengkap</th>
                    <th width="12%">No. KK</th>
                    <th width="12%">Nama Ibu</th>
                    <th width="10%">Tgl Lahir</th>
                    <th width="8%">JK</th>
                    <th width="8%">Status</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sasaran as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nik ?? '-' }}</td>
                    <td style="font-weight: 600;">{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->no_kk }}</td>
                    <td>{{ $item->nama_ibu ?? '-' }}</td>
                    <td>{{ $item->tanggal_lahir ? $item->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->jenis_kelamin ?? '-' }}</td>
                    <td>
                        <span class="role-badge status-{{ $item->status }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td data-priority="1">
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('kader.sasaran.edit', $item->id) }}" class="btn-action btn-edit" title="Edit">
                                <i class="ri-edit-line"></i> <span>Edit</span>
                            </a>
                            <form action="{{ route('kader.sasaran.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sasaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                    <i class="ri-delete-bin-line"></i> <span>Hapus</span>
                                </button>
                            </form>
                        </div>
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
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#sasaranTable').DataTable({
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: [0, 2, 7, 8] },
                { responsivePriority: 2, targets: [4] },
                { responsivePriority: 3, targets: [1, 3] },
                { responsivePriority: 4, targets: [5, 6] }
            ],
            language: {
                searchPlaceholder: "Cari sasaran...",
                search: "",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                emptyTable: "Belum ada data sasaran",
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
