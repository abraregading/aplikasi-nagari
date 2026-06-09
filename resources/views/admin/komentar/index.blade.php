@extends('admin.layouts.app')

@section('title', 'Manajemen Komentar')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('konten')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Manajemen Komentar</h2>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('komentar.index', ['status' => 'pending']) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.5rem 1rem; text-decoration: none;">
            <i class="ri-eye-line"></i> Pending ({{ \App\Models\Comment::where('status', 'pending')->count() }})
        </a>
        <a href="{{ route('komentar.index', ['status' => 'approved']) }}" class="glass-select" style="background: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.25); padding: 0.5rem 1rem; text-decoration: none;">
            <i class="ri-checkbox-circle-line"></i> Disetujui
        </a>
        <a href="{{ route('komentar.index', ['status' => 'rejected']) }}" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.5rem 1rem; text-decoration: none;">
            <i class="ri-close-circle-line"></i> Ditolak
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success" style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.25); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
    <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 2rem;">
    <form method="GET" action="{{ route('komentar.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" placeholder="Cari nama atau konten..." value="{{ request('search') }}" style="padding: 0.5rem 1rem; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; min-width: 200px;">
        <select name="berita_id" style="padding: 0.5rem 1rem; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white;">
            <option value="">Semua Berita</option>
            @foreach($beritas as $berita)
                <option value="{{ $berita->id }}" {{ request('berita_id') == $berita->id ? 'selected' : '' }}>{{ Str::limit($berita->judul_berita, 50) }}</option>
            @endforeach
        </select>
        <button type="submit" style="padding: 0.5rem 1rem; background: var(--primary); border: none; border-radius: 8px; color: white; cursor: pointer;">
            <i class="ri-search-line"></i> Filter
        </button>
        <a href="{{ route('komentar.index') }}" style="padding: 0.5rem 1rem; background: rgba(255,255,255,0.1); border: none; border-radius: 8px; color: white; text-decoration: none;">
            Reset
        </a>
    </form>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <form id="bulkForm" method="POST" action="{{ route('komentar.bulkAction') }}">
        @csrf
        <input type="hidden" name="action" id="bulkActionInput" value="">
        <div style="margin-bottom: 1rem; display: flex; gap: 0.5rem;">
            <button type="button" onclick="submitBulkAction('approve')" class="glass-select" style="background: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.25); padding: 0.5rem 1rem; cursor: pointer;">
                <i class="ri-checkbox-circle-line"></i> Setujui Terpilih
            </button>
            <button type="button" onclick="submitBulkAction('reject')" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.5rem 1rem; cursor: pointer;">
                <i class="ri-close-circle-line"></i> Tolak Terpilih
            </button>
        </div>

        <div class="table-overlay">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th width="30px"><input type="checkbox" id="selectAll"></th>
                        <th width="20%">Nama</th>
                        <th width="30%">Konten</th>
                        <th width="20%">Berita</th>
                        <th width="10%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                    <tr>
                        <td><input type="checkbox" name="comment_ids[]" value="{{ $comment->id }}" class="comment-checkbox"></td>
                        <td>
                            <strong>{{ $comment->nama }}</strong><br>
                            <small style="color: #888;">
                                @if($comment->user)
                                    <i class="ri-user-follow-line"></i> {{ $comment->user->name }}
                                @else
                                    <i class="ri-user-line"></i> Tamu
                                @endif
                            </small>
                        </td>
                        <td>
                            <span style="display: block; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Str::limit($comment->konten, 80) }}</span>
                            @if($comment->parent_id)
                                <small style="color: var(--primary);"><i class="ri-reply-line"></i> Balasan</small>
                            @endif
                        </td>
                        <td><small>{{ Str::limit($comment->berita->judul_berita ?? '-', 40) }}</small></td>
                        <td>
                            @if($comment->status === 'pending')
                                <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">Pending</span>
                            @elseif($comment->status === 'approved')
                                <span style="background: rgba(34, 197, 94, 0.15); color: #22c55e; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">Disetujui</span>
                            @else
                                <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($comment->status === 'pending')
                                <a href="{{ route('komentar.action', ['komentar' => $comment->id, 'action' => 'approve']) }}" class="glass-select" style="background: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.25); padding: 0.3rem 0.6rem; font-size: 0.8rem; text-decoration: none;">
                                    <i class="ri-check-line"></i>
                                </a>
                                <a href="{{ route('komentar.action', ['komentar' => $comment->id, 'action' => 'reject']) }}" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.3rem 0.6rem; font-size: 0.8rem; text-decoration: none;">
                                    <i class="ri-close-line"></i>
                                </a>
                            @endif
                            <a href="{{ route('komentar.show', $comment->id) }}" class="glass-select" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.25); padding: 0.3rem 0.6rem; font-size: 0.8rem; text-decoration: none;">
                                <i class="ri-eye-line"></i>
                            </a>
                            <form action="{{ route('komentar.destroy', $comment->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.3rem 0.6rem; font-size: 0.8rem; cursor: pointer;" onclick="return confirm('Hapus komentar ini?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1rem;">
            {{ $comments->withQueryString()->links() }}
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            paging: false,
            order: [[5, 'desc']]
        });

        $('#selectAll').on('click', function() {
            $('.comment-checkbox').prop('checked', this.checked);
        });
    });

    function submitBulkAction(action) {
        document.getElementById('bulkActionInput').value = action;
        document.getElementById('bulkForm').submit();
    }
</script>
@endsection