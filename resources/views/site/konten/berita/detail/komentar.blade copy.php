<h3 class="comments-title"><i class="fa-regular fa-comments"></i> 3 Komentar</h3>
        
<ul class="comment-list">
    <li class="comment-item">
        <div class="comment-avatar">
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="comment-content">
            <div class="comment-header">
                <span class="comment-author">Budi Sudarsono</span>
                <span class="comment-date">18 Des 2025, 10:30</span>
            </div>
            <p class="comment-text">Alhamdulillah, transparansi seperti ini yang kita harapkan. Semoga pembangunan jalan di Dusun II segera tuntas sebelum musim hujan.</p>
            <div class="comment-reply">Balas</div>
        </div>
    </li>

    <li class="comment-item">
        <div class="comment-avatar">
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="comment-content">
            <div class="comment-header">
                <span class="comment-author">Siti Aminah</span>
                <span class="comment-date">18 Des 2025, 11:15</span>
            </div>
            <p class="comment-text">Untuk program stunting mohon jadwal posyandu lebih diperbanyak lagi pak. Terima kasih laporannya.</p>
            <div class="comment-reply">Balas</div>
        </div>
    <!-- </li>

        <li class="comment-item" style="margin-left: 4rem;">
        <div class="comment-avatar">
            <i class="fa-solid fa-user-check"></i>
        </div>
        <div class="comment-content">
            <div class="comment-header">
                <span class="comment-author">Admin Desa</span>
                <span class="comment-date">18 Des 2025, 11:45</span>
            </div>
            <p class="comment-text">Terima kasih masukannya Ibu Siti. Akan kami koordinasikan dengan Bidan Desa untuk penambahan jadwal di tahun depan.</p>
            <div class="comment-reply">Balas</div>
        </div>
    </li> -->
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