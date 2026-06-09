@extends('admin.layouts.app')

@section('title', 'Data User - Admin Desa')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .role-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .role-admin { background: rgba(99, 102, 241, 0.2); color: #6366f1; }
    .role-operator { background: rgba(16, 185, 129, 0.2); color: #10b981; }
    .role-petugas { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
    .role-kader { background: rgba(5, 150, 105, 0.2); color: #059669; }
    .role-kajor { background: rgba(139, 92, 246, 0.2); color: #8b5cf6; }
    .role-warga { background: rgba(107, 114, 128, 0.2); color: #6b7280; }
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
    .jorong-badge {
        background: rgba(139, 92, 246, 0.15);
        color: #7c3aed;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
    }
</style>
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Data User</h2>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="margin: 0; color: var(--primary);">Daftar User</h3>
        <a href="{{ route('data-user.create') }}" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.6rem 1.2rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="ri-add-line"></i> Tambah User
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

    <div class="table-overlay">
        <table id="userTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="18%">Nama</th>
                    <th width="12%">Username</th>
                    <th width="15%">Email</th>
                    <th width="10%">NIK</th>
                    <th width="8%">Role</th>
                    <th width="12%">Wilayah</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datausers as $datauser)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $datauser->name }}</td>
                    <td>{{ $datauser->username }}</td>
                    <td>{{ $datauser->email }}</td>
                    <td>{{ $datauser->nik ?? '-' }}</td>
                    <td>
                        <span class="role-badge role-{{ $datauser->role }}">
                            @switch($datauser->role)
                                @case('admin') Admin @break
                                @case('operator') Operator @break
                                @case('petugas') Petugas @break
                                @case('kader') Kader @break
                                @case('kajor') Kajor @break
                                @case('warga') Warga @break
                                @default {{ $datauser->role }}
                            @endswitch
                        </span>
                    </td>
                    <td>
                        @if($datauser->role === 'kajor' && $datauser->jorong)
                            <span class="jorong-badge">{{ $datauser->jorong }}</span>
                        @elseif($datauser->role === 'kader' && $datauser->posyandu)
                            <span class="jorong-badge" style="background: rgba(5, 150, 105, 0.15); color: #059669;">{{ $datauser->posyandu->nama_posyandu }}</span>
                        @else
                            <span style="color: var(--text-muted);">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('data-user.show', $datauser->id) }}" class="btn-action btn-view" title="Lihat">
                            <i class="ri-eye-line"></i>
                        </a>
                        <a href="{{ route('data-user.edit', $datauser->id) }}" class="btn-action btn-edit" title="Edit">
                            <i class="ri-edit-line"></i>
                        </a>
                        <form action="{{ route('data-user.destroy', $datauser->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete" title="Hapus">
                                <i class="ri-delete-bin-line"></i>
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
        $('#userTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "Cari user...",
                emptyTable: "Tidak ada data user"
            }
        });
    });
</script>
@endsection