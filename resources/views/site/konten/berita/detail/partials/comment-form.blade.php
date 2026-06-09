<section class="comment-section">
    <h3 style="color: var(--primary); margin-bottom: 1.5rem;">
        <i class="ri-chat-3-line"></i> Komentar
    </h3>

    @if(session('comment_success'))
    <div style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.25); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <i class="ri-checkbox-circle-line" style="color: #22c55e;"></i> {{ session('comment_success') }}
    </div>
    @endif

    @if ($errors->any())
    <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.25); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <strong style="color: #ef4444;"><i class="ri-error-warning-line"></i> Gagal mengirim komentar:</strong>
        <ul style="margin: 0.5rem 0 0 1.5rem; color: #fca5a5;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="comment-form-container">
        <form method="POST" action="{{ route('site.komentar.store', $berita->slug) }}">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <input type="text" name="nama" placeholder="Nama Anda *" required
                           value="{{ old('nama') }}"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; background: rgba(0,0,0,0.3); color: white; font-size: 0.95rem;">
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email (opsional)" 
                           value="{{ old('email') }}"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; background: rgba(0,0,0,0.3); color: white; font-size: 0.95rem;">
                </div>
            </div>
            <div style="margin-bottom: 1rem;">
                <textarea name="konten" rows="4" placeholder="Tulis komentar Anda... (min. 5 karakter)" required
                          style="width: 100%; padding: 0.75rem 1rem; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; background: rgba(0,0,0,0.3); color: white; font-size: 0.95rem; resize: vertical;">{{ old('konten') }}</textarea>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <small style="color: #888;"><i class="ri-information-line"></i> Komentar akan diverifikasi sebelum ditampilkan</small>
                <button type="submit" style="background: var(--primary); color: white; border: none; padding: 0.75rem 2rem; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    <i class="ri-send-plane-line"></i> Kirim Komentar
                </button>
            </div>
        </form>
    </div>

    <div class="comments-list" style="margin-top: 2rem;">
        @include('site.konten.berita.detail.partials.comments-list')
    </div>
</section>

<style>
.comment-section { margin-top: 3rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); }
.comment-form-container { background: rgba(255,255,255,0.03); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); }
.comment-form-container input, .comment-form-container textarea { outline: none; }
.comment-form-container input:focus, .comment-form-container textarea:focus { border-color: var(--primary); }
</style>