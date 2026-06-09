@extends('admin.layouts.app')

@section('title', 'Kelola API User')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Kelola API User</h2>

@if(session('success'))
<div class="alert alert-success" style="margin-bottom: 1rem;">
    {{ session('success') }}
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="color: var(--primary);">Daftar API User</h3>
        <a href="{{ route('api-user.create') }}" class="btn" style="background: var(--primary); color: white; padding: 0.5rem 1.5rem; border-radius: 8px;">
            <i class="ri-add-line"></i> Tambah API User
        </a>
    </div>

    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Nama</th>
                <th width="20%">Email</th>
                <th width="20%">Nama Aplikasi</th>
                <th width="15%">Status</th>
                <th width="15%">Dibuat</th>
                <th width="20%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($apiUsers as $apiUser)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $apiUser->name }}</td>
                <td>{{ $apiUser->email }}</td>
                <td>{{ $apiUser->app_name }}</td>
                <td>
                    @if($apiUser->status === 'aktif')
                    <span class="badge" style="background: #10b981; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Aktif</span>
                    @else
                    <span class="badge" style="background: #ef4444; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Nonaktif</span>
                    @endif
                </td>
                <td>{{ $apiUser->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('api-user.show', $apiUser->id) }}" class="btn btn-sm" style="background: #6366f1; color: white; padding: 0.25rem 0.5rem; border-radius: 4px;" title="Lihat Token">
                        <i class="ri-key-line"></i>
                    </a>
                    <a href="{{ route('api-user.edit', $apiUser->id) }}" class="btn btn-sm" style="background: #f59e0b; color: white; padding: 0.25rem 0.5rem; border-radius: 4px;" title="Edit">
                        <i class="ri-edit-line"></i>
                    </a>
                    <form action="{{ route('api-user.destroy', $apiUser->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm" style="background: #ef4444; color: white; padding: 0.25rem 0.5rem; border-radius: 4px;" title="Hapus" onclick="return confirm('Yakin hapus?')">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
                searchPlaceholder: "Cari..."
            }
        });
    });
</script>
@endsection