<ul class="nav-links">
    <li><a href="{{ route('site.home') }}" class="{{ request()->routeIs('site.home') ? 'active' : '' }}">Beranda</a></li>
    <li><a href="{{ route('site.pemerintahan') }}" class="{{ request()->routeIs('site.pemerintahan') ? 'active' : '' }}">Pemerintahan</a></li>
    <li><a href="{{ route('site.statistik') }}" class="{{ request()->routeIs('site.statistik') ? 'active' : '' }}">Statistik</a></li>
    <li><a href="{{ route('site.berita') }}" class="{{ request()->routeIs('site.berita') ? 'active' : '' }}">Berita</a></li>
    <li><a href="{{ route('site.profil') }}" class="{{ request()->routeIs('site.profil') ? 'active' : '' }}">Profil</a></li>
    <li><a href="{{ route('site.layanan') }}" class="{{ request()->routeIs('site.layanan') ? 'active' : '' }}">Layanan</a></li>
    <li><a href="{{ route('site.galeri') }}" class="{{ request()->routeIs('site.galeri') ? 'active' : '' }}">Galeri</a></li>
    <li><a href="{{ route('site.kontak') }}" class="{{ request()->routeIs('site.kontak') ? 'active' : '' }}">Kontak</a></li>
    @auth
    <li>
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="nav-link">
                <i class="ri-logout-box-r-line"></i>
                <span>Keluar</span>
            </button>
        </form>
    </li>
    @endauth
</ul>