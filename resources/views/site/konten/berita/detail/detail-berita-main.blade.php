
<main class="article-content">
    <p class="lead" style="font-size: 1.2rem; font-weight: 500; margin-bottom: 2rem;">
        {{ $berita->isi_berita1 }}
    </p>
    @if ($berita->gambar_berita)
        <img src="{{ Storage::url($berita->gambar_berita) }}" alt="Gambar Berita {{ $berita->judul_berita }}" style="width: 80%; border-radius: 15px; margin-bottom: 2rem; box-shadow: var(--shadow-sm);">
    @else
        <img src="{{asset('site')}}/assets/news/dana.png" alt="Infografis Dana Desa" style="width: 100%; border-radius: 15px; margin-bottom: 2rem; box-shadow: var(--shadow-sm);">
    @endif

    {{ $berita->isi_berita2 }}

    <div style="background: #f0f7f4; padding: 1.5rem; border-left: 4px solid var(--primary-color); margin: 2rem 0;">
        <p style="margin-bottom: 0;"><strong>Catatan:</strong> {{ $berita->quote }}</p>
    </div>

    <p>
        {{ $berita->isi_berita3 }}
    <div class="comments-section">
        @include('site.konten.berita.detail.komentar')
    </div>
</main>