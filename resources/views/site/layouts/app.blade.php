<!DOCTYPE html>
<html lang="id">
@include('site.layouts.partials.head')
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <a href="{{ route('site.home') }}" class="logo">
            <i class="fa-solid fa-leaf"></i>
            <span>{{ $profilnagari['nama_pemerintahan'] ?? 'Desa' }}<span style="color: var(--accent-color);"> Digital </span></span>
        </a>
        <div class="nav-right">
            <div class="nav-overlay"></div>
            @include('site.layouts.partials.navbar')
            <div class="hamburger">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->

    @yield('konten')

    <!-- Footer -->
    <footer id="contact" class="footer">
        @include('site.layouts.partials.footer.index')
    </footer>

    <!-- Bottom Navigation (Mobile) -->
    <nav class="bottom-nav">
        <a href="{{ route('site.home') }}" class="bottom-nav-item {{ request()->routeIs('site.home') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('site.pemerintahan') }}" class="bottom-nav-item {{ request()->routeIs('site.pemerintahan') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            <span>Desa</span>
        </a>
        <a href="{{ route('site.berita') }}" class="bottom-nav-item {{ request()->routeIs('site.berita') ? 'active' : '' }}">
            <i class="fa-regular fa-newspaper"></i>
            <span>Berita</span>
        </a>
        <a href="{{ route('site.layanan') }}" class="bottom-nav-item {{ request()->routeIs('site.layanan') ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group"></i>
            <span>Layanan</span>
        </a>
        <a href="{{ route('site.statistik') }}" class="bottom-nav-item {{ request()->routeIs('site.statistik') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-bar"></i>
            <span>Statistik</span>
        </a>
    </nav>

    @include('site.layouts.partials.script')
</body>
</html>
