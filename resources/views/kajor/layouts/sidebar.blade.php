<aside class="sidebar glass">
    <div class="logo">
        <i class="ri-dashboard-3-line"></i>
        <span>E-Jorong Kuamang Alai</span>
    </div>

    <ul class="nav-links">
        <li class="nav-item">
            <a href="{{ route('kajor.home') }}" class="nav-link{{ request()->routeIs('kajor.home') ? ' active' : '' }}">
                <i class="ri-layout-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
                <i class="ri-user-line"></i>
                <span>Kependudukan</span>
                <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('kajor.keluarga.index') }}" class="nav-link{{ request()->routeIs('kajor.keluarga*') ? ' active' : '' }}" style="font-size:0.9rem;">Data Keluarga</a></li>
                <li><a href="{{ route('kajor.penduduk.index') }}" class="nav-link{{ request()->routeIs('kajor.penduduk*') ? ' active' : '' }}" style="font-size:0.9rem;">Data Penduduk</a></li>
                <li><a href="{{ route('kajor.meninggal.index') }}" class="nav-link{{ request()->routeIs('kajor.meninggal*') ? ' active' : '' }}" style="font-size:0.9rem;">Data Meninggal</a></li>
                <li><a href="{{ route('kajor.laporan-meninggal.index') }}" class="nav-link{{ request()->routeIs('kajor.laporan-meninggal*') ? ' active' : '' }}" style="font-size:0.9rem;">Laporan Meninggal</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('kajor.bisniskos.index') }}" class="nav-link{{ request()->routeIs('kajor.bisniskos*') ? ' active' : '' }}">
                <i class="ri-home-4-line"></i>
                <span>Usaha Kos & Kontrakan</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('kajor.scanner') }}" class="nav-link{{ request()->routeIs('kajor.scanner*') ? ' active' : '' }}">
                <i class="ri-qr-scan-line"></i>
                <span>Scan QR Code</span>
            </a>
        </li>
      
        <li class="nav-item">
            <a href="{{ route('kajor.profil.index') }}" class="nav-link{{ request()->routeIs('kajor.profil.*') ? ' active' : '' }}">
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