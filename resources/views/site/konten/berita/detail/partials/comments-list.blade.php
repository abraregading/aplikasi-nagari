<div class="comments-container">
    <h4 style="color: white; margin-bottom: 1.5rem;">
        <i class="ri-chat-3-line"></i> {{ $comments->count() }} Komentar
    </h4>

    @forelse($comments as $comment)
    <div class="comment-item" style="margin-bottom: 1.5rem; padding: 1.5rem; background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 45px; height: 45px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white;">
                    {{ strtoupper(substr($comment->nama, 0, 1)) }}
                </div>
                <div>
                    <strong style="color: white;">{{ $comment->nama }}</strong>
                    @if($comment->user)
                    <span style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.7rem; margin-left: 0.5rem;">
                        {{ ucfirst($comment->user->role) }}
                    </span>
                    @else
                    <span style="background: rgba(255,255,255,0.1); color: #888; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.7rem; margin-left: 0.5rem;">Tamu</span>
                    @endif
                    <br>
                    <small style="color: #888;">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
        
        <div style="padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 8px; margin-bottom: 1rem;">
            <p style="margin: 0; color: #ccc; line-height: 1.6;">{{ $comment->konten }}</p>
        </div>

        <button type="button" onclick="showReplyForm({{ $comment->id }})" 
                style="background: none; border: none; color: var(--primary); cursor: pointer; font-size: 0.9rem; padding: 0.5rem 0;">
            <i class="ri-reply-line"></i> Balas
        </button>

        <div id="reply-form-{{ $comment->id }}" style="display: none; margin-top: 1rem; padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 8px;">
            <p style="margin: 0 0 1rem; color: #888; font-size: 0.9rem;">
                <i class="ri-reply-line"></i> Membalas <strong style="color: var(--primary);">{{ $comment->nama }}</strong>
            </p>
            <form method="POST" action="{{ route('site.komentar.store', $berita->slug) }}">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <div style="margin-bottom: 0.75rem;">
                    <input type="text" name="nama" placeholder="Nama Anda *" required
                           style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; background: rgba(0,0,0,0.3); color: white; font-size: 0.9rem;">
                </div>
                <div style="margin-bottom: 0.75rem;">
                    <input type="email" name="email" placeholder="Email (opsional)"
                           style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; background: rgba(0,0,0,0.3); color: white; font-size: 0.9rem;">
                </div>
                <textarea name="konten" rows="3" placeholder="Tulis balasan Anda... (min. 5 karakter)" required
                          style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; background: rgba(0,0,0,0.3); color: white; font-size: 0.9rem; resize: vertical; margin-bottom: 0.75rem;"></textarea>
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <button type="button" onclick="hideReplyForm({{ $comment->id }})" style="background: rgba(255,255,255,0.1); color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer;">Batal</button>
                    <button type="submit" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer;">Kirim</button>
                </div>
            </form>
        </div>

        @if($comment->approvedReplies->count() > 0)
        <div class="replies" style="margin-top: 1.5rem; margin-left: 2rem; padding-left: 1rem; border-left: 2px solid rgba(255,255,255,0.1);">
            @foreach($comment->approvedReplies as $reply)
            <div class="reply-item" style="margin-bottom: 1rem; padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 8px;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                    <div style="width: 35px; height: 35px; border-radius: 50%; background: #666; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 0.85rem;">
                        {{ strtoupper(substr($reply->nama, 0, 1)) }}
                    </div>
                    <div>
                        <strong style="color: white; font-size: 0.9rem;">{{ $reply->nama }}</strong>
                        <br>
                        <small style="color: #666; font-size: 0.8rem;">{{ $reply->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                <p style="margin: 0; color: #bbb; font-size: 0.95rem; line-height: 1.5;">{{ $reply->konten }}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @empty
    <div style="text-align: center; padding: 3rem; color: #666;">
        <i class="ri-chat-3-line" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></i>
        <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
    </div>
    @endforelse
</div>

<script>
function showReplyForm(commentId) {
    document.getElementById('reply-form-' + commentId).style.display = 'block';
}

function hideReplyForm(commentId) {
    document.getElementById('reply-form-' + commentId).style.display = 'none';
}
</script>