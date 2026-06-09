@extends('admin.layouts.app')

@section('title', 'Komentar Pending')

@section('konten')
<h2 style="margin-bottom: 2rem;">Komentar Menunggu Persetujuan</h2>

@if(session('success'))
<div class="alert" style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.25); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
    <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <form id="bulkForm" method="POST" action="{{ route('komentar.bulkAction') }}">
        @csrf
        <input type="hidden" name="action" id="bulkActionInput" value="">
        <div style="margin-bottom: 1rem; display: flex; gap: 0.5rem; align-items: center;">
            <input type="checkbox" id="selectAll">
            <label for="selectAll" style="margin-right: 1rem; color: #888;">Pilih Semua</label>
            <button type="button" onclick="submitBulkAction('approve')" class="glass-select" style="background: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.25); padding: 0.5rem 1rem; cursor: pointer;">
                <i class="ri-checkbox-circle-line"></i> Setujui Terpilih
            </button>
            <button type="button" onclick="submitBulkAction('reject')" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.5rem 1rem; cursor: pointer;">
                <i class="ri-close-circle-line"></i> Tolak Terpilih
            </button>
        </div>

        <div style="display: grid; gap: 1rem;">
            @forelse($comments as $comment)
            <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <input type="checkbox" name="comment_ids[]" value="{{ $comment->id }}" class="comment-checkbox">
                        <div>
                            <strong style="font-size: 1.1rem;">{{ $comment->nama }}</strong>
                            @if($comment->user)
                                <span style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; padding: 0.1rem 0.5rem; border-radius: 4px; font-size: 0.75rem; margin-left: 0.5rem;">{{ $comment->user->role }}</span>
                            @else
                                <span style="background: rgba(255,255,255,0.1); color: #888; padding: 0.1rem 0.5rem; border-radius: 4px; font-size: 0.75rem; margin-left: 0.5rem;">Tamu</span>
                            @endif
                            @if($comment->parent_id)
                                <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 0.1rem 0.5rem; border-radius: 4px; font-size: 0.75rem; margin-left: 0.5rem;"><i class="ri-reply-line"></i> Balasan</span>
                            @endif
                        </div>
                    </div>
                    <small style="color: #888;">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
                
                <div style="margin-bottom: 1rem; padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 8px;">
                    {{ $comment->konten }}
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{ route('site.berita.show', $comment->berita->slug) }}" target="_blank" style="color: var(--primary); text-decoration: none; font-size: 0.9rem;">
                        <i class="ri-file-text-line"></i> {{ Str::limit($comment->berita->judul_berita ?? '-', 50) }}
                    </a>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('komentar.action', ['komentar' => $comment->id, 'action' => 'approve']) }}" class="glass-select" style="background: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.25); padding: 0.4rem 1rem; text-decoration: none; border-radius: 6px;">
                            <i class="ri-check-line"></i> Setujui
                        </a>
                        <a href="{{ route('komentar.action', ['komentar' => $comment->id, 'action' => 'reject']) }}" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.4rem 1rem; text-decoration: none; border-radius: 6px;">
                            <i class="ri-close-line"></i> Tolak
                        </a>
                        <a href="{{ route('komentar.show', $comment->id) }}" class="glass-select" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.25); padding: 0.4rem 1rem; text-decoration: none; border-radius: 6px;">
                            <i class="ri-eye-line"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 3rem; color: #888;">
                <i class="ri-inbox-line" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></i>
                Tidak ada komentar yang menunggu persetujuan
            </div>
            @endforelse
        </div>

        <div style="margin-top: 2rem;">
            {{ $comments->links() }}
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    document.getElementById('selectAll').addEventListener('click', function() {
        document.querySelectorAll('.comment-checkbox').forEach(cb => cb.checked = this.checked);
    });
    function submitBulkAction(action) {
        document.getElementById('bulkActionInput').value = action;
        document.getElementById('bulkForm').submit();
    }
</script>
@endsection