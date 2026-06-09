@extends('admin.layouts.app')

@section('title', 'Komentar per Berita')

@section('konten')
<div style="margin-bottom: 2rem;">
    <h2>Komentar untuk: {{ $berita->judul_berita }}</h2>
    <a href="{{ route('komentar.index') }}" style="color: var(--primary); text-decoration: none;">
        <i class="ri-arrow-left-line"></i> Kembali ke daftar komentar
    </a>
</div>

@if(session('success'))
<div class="alert" style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.25); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
    <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    @forelse($comments as $comment)
    <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 1.5rem; margin-bottom: 1rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                    {{ strtoupper(substr($comment->nama, 0, 1)) }}
                </div>
                <div>
                    <strong style="color: white;">{{ $comment->nama }}</strong>
                    <small style="color: #888; display: block;">{{ \Carbon\Carbon::parse($comment->created_at)->translatedFormat('d F Y, H:i') }}</small>
                </div>
            </div>
            <span style="background: rgba(34, 197, 94, 0.15); color: #22c55e; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">Disetujui</span>
        </div>
        <p style="color: #ccc; line-height: 1.6;">{{ $comment->konten }}</p>
        <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
            <a href="{{ route('komentar.show', $comment->id) }}" class="glass-select" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.25); padding: 0.3rem 0.75rem; text-decoration: none; font-size: 0.85rem;">
                <i class="ri-eye-line"></i> Detail
            </a>
            <form action="{{ route('komentar.destroy', $comment->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.3rem 0.75rem; font-size: 0.85rem; cursor: pointer;" onclick="return confirm('Hapus?')">
                    <i class="ri-delete-bin-line"></i> Hapus
                </button>
            </form>
        </div>
    </div>
    @empty
    <div style="text-align: center; padding: 3rem; color: #888;">
        <i class="ri-chat-3-line" style="font-size: 3rem;"></i>
        <p>Belum ada komentar yang disetujui untuk berita ini</p>
    </div>
    @endforelse

    {{ $comments->links() }}
</div>
@endsection