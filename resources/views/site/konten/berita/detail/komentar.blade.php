<h3 class="comments-title"><i class="fa-regular fa-comments"></i> {{ $komentarcount }} Komentar</h3>
        
<ul class="comment-list">
    @foreach ($komentar as $komentar)
    <li class="comment-item">
        <div class="comment-avatar">
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="comment-content">
            <div class="comment-header">
                <span class="comment-author">{{ $komentar->nama }}</span>
                <span class="comment-date">{{ \Carbon\Carbon::parse($komentar->created_at)->translatedFormat('d F Y, H:i') }}</span>
            </div>
            <p class="comment-text">{{ $komentar->konten }}</p>
            <!-- <div class="comment-reply">Balas</div> -->
        </div>
    </li>
    @endforeach
</ul>

<div class="comment-form-box">
    <h4>Tulis Komentar</h4>
    <form action="{{ route('site.komentar.store', $berita->slug) }}" method="post" class="comment-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input name="nama" type="text" class="form-input" placeholder="Nama Anda">
        </div>
        <div class="form-group">
            <label class="form-label">Email (Tidak dipublikasikan)</label>
            <input name="email" type="email" class="form-input" placeholder="email@contoh.com">
        </div>
        <div class="form-group">
            <label class="form-label">Komentar</label>
            <textarea name="konten" class="form-textarea" rows="4" placeholder="Tulis tanggapan Anda..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width: auto;">Kirim Komentar</button>
    </form>
</div>