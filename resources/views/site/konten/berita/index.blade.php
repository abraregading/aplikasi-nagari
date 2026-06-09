@extends('site.konten.app')

@section('judul', 'Website ' . ($profilnagari['bentuk_pemerintahan'] ?? 'Desa') . ' ' . ($profilnagari['nama_pemerintahan'] ?? 'Digital'))
@section('sub_judul', 'Berita')

@section('konten1') 


    <header class="page-header" style="background-image: url('{{asset('site')}}/assets/hero.png');">
        <h1>Kabar {{ $profilnagari['bentuk_pemerintahan'] ?? 'Desa' }} Terkini</h1>
    </header>

    <section class="container" style="padding-top: 0;">
        <div class="glass" style="padding: 2rem; border-radius: 20px; background: white; margin-top: -5rem;">
            
            <div class="news-grid">
                @foreach($berita as $item)
                <!-- Article 1 -->
                <article class="news-card">
                     <a href="{{ route('site.berita.show', ['slug' => $item->slug]) }}">
                        @if ($item && $item->gambar_berita)
                         <img src="{{ Storage::url($item->gambar_berita) }}" alt="Transparansi Dana Desa" class="news-img">
                        @else
                            <img src="{{asset('site')}}/assets/news/dana.png" alt="Transparansi Dana Desa" class="news-img">
                        @endif
                     </a>
                    <div class="news-content">
                        <div class="news-date"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</div>
                        <h3 class="news-title">
                            <a href="{{ route('site.berita.show', ['slug' => $item->slug]) }}">
                                 {{ $item->judul_berita }}
                            </a>
                        </h3>
                        <p class="news-excerpt">{{ $item->isi_berita1 }}</p>
                        <a href="{{ route('site.berita.show', ['slug' => $item->slug]) }}" class="news-link">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 3rem; text-align: center;">
                <a href="#" class="btn" style="background: transparent; color: var(--primary-color); border: 1px solid var(--primary-color);">Lebih Banyak Berita</a>
            </div>

        </div>
    </section>

@endsection