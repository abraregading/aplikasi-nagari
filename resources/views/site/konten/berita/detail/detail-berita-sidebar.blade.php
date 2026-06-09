<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-widget">
        <h3 class="sidebar-title">Cari Berita</h3>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Kata kunci...">
            <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>

    <div class="sidebar-widget">
        <h3 class="sidebar-title">Berita Terbaru</h3>
        @php
        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        @endphp
        @foreach($berita_side as $berita)
        <div class="recent-post">
            <a href="{{ route('site.berita.show', ['slug' => $berita->slug]) }}">
                @if ($berita && $berita->gambar_berita)
                <img src="{{ Storage::url($berita->gambar_berita) }}" alt="Gambar Berita {{ $berita->judul_berita }}" class="recent-post-img">  
                @else
                    <img src="{{asset('site')}}/assets/news/gotong.png" alt="Gotong Royong">
                @endif
            </a>
            <div>
                <a href="{{ route('site.berita.show', ['slug' => $berita->slug]) }}"><h4>{{ substr($berita->judul_berita, 0, 40) }}...</h4></a>
                @php $namaBulan = $bulan[$berita->created_at->month]; @endphp
                <span>{{ $berita->created_at->day }} {{ $namaBulan }} {{ $berita->created_at->year }}</span>
            </div>
        </div>
        @endforeach
    </div>

    <div class="sidebar-widget">
        <h3 class="sidebar-title">Kategori</h3>
        <ul style="list-style: none;">
            @foreach($kategoriBerita as $kategori)
            <li style="margin-bottom: 0.8rem;"><a href="#" style="display: flex; justify-content: space-between; color: #555;">{{ $kategori->kategori_berita }} <span>({{ $kategori->berita->count() }})</span></a></li>
            @endforeach
        </ul>
    </div>
</aside>
