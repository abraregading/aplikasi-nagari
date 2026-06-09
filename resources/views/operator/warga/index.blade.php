@extends('operator.layouts.app')

@section('title', 'Data Warga')

@section('head')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .filter-bar { display: flex; gap: .75rem; margin-bottom: 1.5rem; flex-wrap: wrap; align-items: center; }
    .filter-bar input, .filter-bar select { padding: .5rem 1rem; border-radius: 8px; border: 1px solid rgba(0,0,0,.1); background: rgba(255,255,255,.6); color: var(--text-main); font-size: .9rem; font-family: inherit; }
    .filter-bar input:focus, .filter-bar select:focus { outline: none; border-color: var(--primary); }
    .filter-bar button { padding: .5rem 1.2rem; border-radius: 8px; background: var(--primary); color: #fff; border: none; cursor: pointer; font-weight: 600; font-family: inherit; font-size: .9rem; }
    .filter-bar button:hover { background: #0284c7; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: .75rem; color: var(--text-muted); font-size: .8rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; border-bottom: 2px solid rgba(0,0,0,.08); }
    .data-table td { padding: .85rem .75rem; font-size: .9rem; border-bottom: 1px solid rgba(0,0,0,.05); vertical-align: middle; }
    .data-table tr:hover td { background: rgba(14,165,233,.03); }

    .btn-action { padding: .4rem .75rem; border-radius: 8px; font-size: .8rem; text-decoration: none; display: inline-flex; align-items: center; gap: .2rem; transition: all .2s; font-family: inherit; border: none; cursor: pointer; }
    .btn-view { background: rgba(99,102,241,.1); color: #4f46e5; }
    .btn-view:hover { background: rgba(99,102,241,.2); }
    .btn-approve { background: rgba(16,185,129,.15); color: #059669; }
    .btn-approve:hover { background: rgba(16,185,129,.25); }
    .btn-reject { background: rgba(239,68,68,.1); color: #dc2626; }
    .btn-reject:hover { background: rgba(239,68,68,.2); }

    .badge { display: inline-block; padding: .25rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600; }
    .badge-pending { background: rgba(245,158,11,.15); color: #d97706; }
    .badge-approved { background: rgba(16,185,129,.15); color: #059669; }
    .badge-rejected { background: rgba(239,68,68,.15); color: #dc2626; }

    .photo-thumb { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb; }
    .photo-placeholder { width: 40px; height: 40px; border-radius: 50%; background: #e5e7eb; display: inline-flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 1rem; }

    .empty-state { text-align: center; padding: 3rem; color: var(--text-muted); }
    .alert { padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: .5rem; }
    .alert-success { background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.25); color: #059669; }
    .alert-error { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.25); color: #dc2626; }

    @media(max-width:768px) { .table-wrapper { overflow-x: auto; } .filter-bar { flex-direction: column; align-items: stretch; } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-user-star-line" style="color: var(--primary)"></i> Data Warga</h2>
</div>

@if(session('success'))
<div class="alert alert-success"><i class="ri-check-line"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error"><i class="ri-error-warning-line"></i> {{ session('error') }}</div>
@endif

<div class="glass" style="padding: 1.5rem; border-radius: 16px;">
    <form method="GET" class="filter-bar">
        <input type="text" name="search" placeholder="Cari nama, username, NIK..." value="{{ request('search') }}">
        <select name="status">
            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <button type="submit"><i class="ri-search-line"></i> Filter</button>
    </form>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Username / NIK</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wargas as $w)
                <tr>
                    <td>
                        @if($w->photo)
                            <img src="{{ asset('storage/photos/' . $w->photo) }}" alt="foto" class="photo-thumb">
                        @else
                            <span class="photo-placeholder"><i class="ri-user-line"></i></span>
                        @endif
                    </td>
                    <td style="font-weight: 500;">{{ $w->name }}</td>
                    <td>{{ $w->nik ?? $w->username }}</td>
                    <td>{{ $w->email ?? '-' }}</td>
                    <td>
                        @if($w->status == 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($w->status == 'approved')
                            <span class="badge badge-approved">Disetujui</span>
                        @else
                            <span class="badge badge-rejected">Ditolak</span>
                        @endif
                    </td>
                    <td>{{ $w->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div style="display: flex; gap: .4rem; align-items: center;">
                            <a href="{{ route('operator.warga.show', $w->id) }}" class="btn-action btn-view" title="Detail"><i class="ri-eye-line"></i></a>
                            @if($w->status == 'pending')
                                <form action="{{ route('operator.warga.approve', $w->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Setujui akun {{ $w->name }}?')">
                                    @csrf
                                    <button type="submit" class="btn-action btn-approve" title="Setujui"><i class="ri-check-line"></i></button>
                                </form>
                                <form action="{{ route('operator.warga.reject', $w->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tolak akun {{ $w->name }}?')">
                                    @csrf
                                    <button type="submit" class="btn-action btn-reject" title="Tolak"><i class="ri-close-line"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <i class="ri-user-line" style="font-size: 2rem; display: block; margin-bottom: .5rem;"></i>
                        <p>Belum ada data warga</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap" style="display:flex;justify-content:center;gap:.5rem;margin-top:1.5rem;">
        {{ $wargas->links() }}
    </div>
</div>
@endsection
