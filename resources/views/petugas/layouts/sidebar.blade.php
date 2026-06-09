<aside class="sidebar glass">
    <div class="logo">
        <i class="ri-dashboard-3-line"></i>
        <span>E-Pendataan Kuamang Alai</span>
    </div>

    <ul class="nav-links">
        <li class="nav-item">
            <a href="{{ route('petugas.home') }}" class="nav-link{{ request()->routeIs('petugas.home') ? ' active' : '' }}">
                <i class="ri-layout-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
            <i class="ri-table-line"></i>
            <span>Pendataan</span>
            <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('petugas.bisniskos.index') }}" class="nav-link{{ request()->routeIs('petugas.bisniskos.index') ? ' active' : '' }}" style="font-size:0.9rem;">Pendataan Kontrakan/Kos</a></li>
                <li><a href="{{ route('petugas.pendataankeluarga.index') }}" class="nav-link{{ request()->routeIs('petugas.pendataankeluarga.index') ? ' active' : '' }}" style="font-size:0.9rem;">Pendataan Kartu Keluarga</a></li>
                <li><a href="{{ route('petugas.pendataankeluarga.riwayatsaya') }}" class="nav-link{{ request()->routeIs('petugas.pendataankeluarga.riwayatsaya') ? ' active' : '' }}" style="font-size:0.9rem;">Riwayat Saya</a></li>
            </ul>
        </li>
      
        <li class="nav-item">
            <a href="{{ route('petugas.profil.index') }}" class="nav-link{{ request()->routeIs('petugas.profil.*') ? ' active' : '' }}">
                <i class="ri-folder-user-line"></i>
                <span>Profil Saya</span>
            </a>
        </li>

        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer; width: 100%; text-align: left; font-family: inherit; font-size: inherit; color: inherit; padding: inherit;">
                    <i class="ri-logout-box-r-line"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </li>
    </ul>

    
    </aside>