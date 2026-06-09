@extends('admin.layouts.app')

@section('title', 'Data Pengumuman')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .badge-umum {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
    }
    .badge-khusus {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
    }
    .badge-aktif {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
    }
    .badge-nonaktif {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
    }
</style>
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Data Pengumuman</h2>

@if(session('success'))
<div style="background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.25); color: #065f46; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: .85rem; display: flex; align-items: center; gap: .5rem;">
    <i class="ri-check-line"></i> {{ session('success') }}
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <a href="{{ route('pengumuman.create') }}" style="background:var(--primary); color:white; border:none; padding:0.8rem 1.5rem; border-radius:8px; cursor:pointer; display:inline-flex; align-items:center; gap:.5rem; text-decoration:none;">
        <i class="ri-add-line"></i> Tambah Pengumuman
    </a>
    <br><br>
    <div class="table-overlay">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Tipe</th>
                    <th>Target</th>
                    <th>Status</th>
                    <th>Dibuat Oleh</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengumuman as $p)
                <tr>
                    <td>{{ $p->judul }}</td>
                    <td>
                        <span class="badge badge-{{ $p->tipe }}" style="display:inline-block; padding:.2rem .6rem; border-radius:12px; font-size:.75rem; font-weight:600;">
                            {{ $p->tipe == 'umum' ? 'Umum' : 'Khusus' }}
                        </span>
                    </td>
                    <td>
                        @if($p->tipe == 'khusus' && $p->targetUser)
                            {{ $p->targetUser->name }}
                        @else
                            <span style="color:var(--text-muted);">Semua Warga</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $p->is_active ? 'badge-aktif' : 'badge-nonaktif' }}" style="display:inline-block; padding:.2rem .6rem; border-radius:12px; font-size:.75rem; font-weight:600;">
                            {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>{{ $p->creator ? $p->creator->name : '-' }}</td>
                    <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('pengumuman.edit', $p->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                            <i class="ri-edit-line"></i> Edit
                        </a>
                        <form action="{{ route('pengumuman.destroy', $p->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem;" onclick="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                <i class="ri-delete-bin-line"></i> Hapus
                            </button>
                        </form>
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
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "Search records..."
            }
        });
    });
</script>
@endsection
