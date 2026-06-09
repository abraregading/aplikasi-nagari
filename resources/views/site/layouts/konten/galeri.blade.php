<!-- Gallery Section -->
<section id="gallery">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Galeri</span>
            <h2>Potret {{ $profilnagari['bentuk_pemerintahan'] ?? 'Desa' }} Kami</h2>
        </div>
        <div class="gallery-grid">
            <!-- Using inline styles for specific bg images as simple implementation -->
             @foreach($galeri as $item)
             
            <div class="gallery-item">
               <a href="{{ route('site.berita.show', ['slug' => $item->slug]) }}">
                    @if ($item && $item->gambar_berita)
                        <img src="{{ Storage::url($item->gambar_berita) }}" alt="Galeri {{ $item->judul_berita }}" class="gallery-img">
                    @else
                        <img src="{{asset('site')}}/assets/hero.png" class="gallery-img" alt="Pemandangan Alam">
                    @endif
               </a>
                <div class="gallery-overlay">
                    <a href="{{ route('site.berita.show', ['slug' => $item->slug]) }}" class="gallery-link">
                        <h4>{{ $item->judul_berita ?? 'Pesona Alam' }}</h4>
                    </a>
                    <p>{{ substr($item->isi_1, 0, 55) ?? 'Keindahan lanskap desa di pagi hari' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>