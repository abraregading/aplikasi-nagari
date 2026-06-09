@extends('admin.layouts.app')

@section('title', 'Detail Komentar')

@section('konten')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2 style="margin-bottom: 0.5rem;">Detail Komentar</h2>
        <a href="{{ route('komentar.index') }}" style="color: var(--primary); text-decoration: none;">
            <i class="ri-arrow-left-line"></i> Kembali ke daftar komentar
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert" style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.25); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
    <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div>
            <h4 style="color: var(--primary); margin-bottom: 1rem;">Informasi Komentar</h4>
            <div style="margin-bottom: 1rem;">
                <label style="color: #888; font-size: 0.85rem;">Nama</label>
                <p style="margin: 0.25rem 0;"><strong>{{ $comment->nama ?? '-' }}</strong></p>
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="color: #888; font-size: 0.85rem;">Email</label>
                <p style="margin: 0.25rem 0;">{{ $comment->email ?? '-' }}</p>
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="color: #888; font-size: 0.85rem;">Status</label>
                <p style="margin: 0.25rem 0;">
                    @if($comment->status === 'pending')
                        <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">Pending</span>
                    @elseif($comment->status === 'approved')
                        <span style="background: rgba(34, 197, 94, 0.15); color: #22c55e; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">Disetujui</span>
                    @else
                        <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">Ditolak</span>
                    @endif
                </p>
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="color: #888; font-size: 0.85rem;">Dibuat</label>
                <p style="margin: 0.25rem 0;">{{ $comment->created_at ? \Carbon\Carbon::parse($comment->created_at)->translatedFormat('d F Y, H:i') : '-' }}</p>
            </div>
            @if($comment->approved_at)
            <div style="margin-bottom: 1rem;">
                <label style="color: #888; font-size: 0.85rem;">Disetujui/Ditolak</label>
                <p style="margin: 0.25rem 0;">{{ \Carbon\Carbon::parse($comment->approved_at)->translatedFormat('d F Y, H:i') }} oleh {{ $comment->approver->name ?? '-' }}</p>
            </div>
            @endif
        </div>
        
        <div>
            <h4 style="color: var(--primary); margin-bottom: 1rem;">Informasi Berita</h4>
            <div style="margin-bottom: 1rem;">
                <label style="color: #888; font-size: 0.85rem;">Judul Berita</label>
                <p style="margin: 0.25rem 0;">
                    @if($comment->berita)
                    <a href="{{ route('site.berita.show', $comment->berita->slug) }}" target="_blank" style="color: var(--primary); text-decoration: none;">
                        {{ $comment->berita->judul_berita }}
                    </a>
                    @else
                    <span style="color: #888;">-</span>
                    @endif
                </p>
            </div>
            @if($comment->user)
            <div style="margin-bottom: 1rem;">
                <label style="color: #888; font-size: 0.85rem;">User</label>
                <p style="margin: 0.25rem 0;">{{ $comment->user->name }} <span style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; padding: 0.1rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">{{ $comment->user->role }}</span></p>
            </div>
            @endif
            @if($comment->parent_id)
            <div style="margin-bottom: 1rem;">
                <label style="color: #888; font-size: 0.85rem;">Balasan untuk</label>
                <p style="margin: 0.25rem 0; color: var(--primary);">
                    <i class="ri-reply-line"></i> Komentar ID #{{ $comment->parent_id }}
                </p>
            </div>
            @endif
        </div>
    </div>

    <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(0,0,0,0.2); border-radius: 12px;">
        <label style="color: #888; font-size: 0.85rem; display: block; margin-bottom: 0.5rem;">Konten Komentar</label>
        <p style="margin: 0; line-height: 1.6;">{{ $comment->konten }}</p>
    </div>

    <div style="margin-top: 2rem; display: flex; gap: 0.5rem; justify-content: flex-end;">
        @if($comment->status === 'pending')
            <a href="{{ route('komentar.action', ['komentar' => $comment->id, 'action' => 'approve']) }}" class="glass-select" style="background: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.25); padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 8px;">
                <i class="ri-check-line"></i> Setujui
            </a>
            <a href="{{ route('komentar.action', ['komentar' => $comment->id, 'action' => 'reject']) }}" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 8px;">
                <i class="ri-close-line"></i> Tolak
            </a>
        @endif
        <form action="/administrator/komentar/{{ $comment->id }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.75rem 1.5rem; cursor: pointer; border-radius: 8px;" onclick="return confirm('Hapus komentar ini?')">
                <i class="ri-delete-bin-line"></i> Hapus
            </button>
        </form>
    </div>
</div>
@endsection