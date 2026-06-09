@php
    $heroImage = '';
    if (!empty($profilnagari['hero_image_url'])) {
        $heroImage = $profilnagari['hero_image_url'];
    } elseif (!empty($profilnagari['hero_image'])) {
        $heroImage = asset($profilnagari['hero_image']);
    } else {
        $heroImage = asset('site/assets/hero.png');
    }
@endphp

<header id="home" class="hero">
    <img src="{{ $heroImage }}" alt="Pemandangan Desa" class="hero-bg">
    <div class="hero-content glass">
        <h1>Website Resmi <br>{{ $profilnagari['bentuk_pemerintahan'] ?? 'Desa' }} {{ $profilnagari['nama_pemerintahan'] ?? 'Desa Digital' }}</h1>
        <p>Mewujudkan Masyarakat Mandiri, Modern, dan Berbudaya Menuju Masa Depan Gemilang.</p>
        <a href="{{ url('/login') }}" class="btn">Sistem Informasi</a>
    </div>
</header>