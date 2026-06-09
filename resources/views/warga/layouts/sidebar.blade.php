<aside class="sidebar glass">
    <div class="logo">
        <i class="ri-dashboard-3-line"></i>
        <span>E-Warga Kuamang Alai</span>
    </div>

    <ul class="nav-links">
        <li class="nav-item">
            <a href="{{ route('warga.home') }}" class="nav-link{{ request()->routeIs('warga.home') ? ' active' : '' }}">
                <i class="ri-layout-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
            <i class="ri-table-line"></i>
            <span>Layanan Publik</span>
            <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('buatsuratwarga.index') }}" class="nav-link {{ request()->routeIs('buatsuratwarga.index') ? ' active' : '' }}">Buat Surat</a></li>
                <li><a href="{{ route('buatsuratwarga.proses') }}" class="nav-link {{ request()->routeIs('buatsuratwarga.proses') ? ' active' : '' }}">Proses Permohonan</a></li>
                <li><a href="{{ route('buatsuratwarga.riwayat') }}" class="nav-link {{ request()->routeIs('buatsuratwarga.riwayat') ? ' active' : '' }}">Riwayat Permohonan</a></li>
            </ul>
        </li>
      
        <li class="nav-item">
            <a href="{{ route('warga.ubah-penduduk') }}" class="nav-link{{ request()->routeIs('warga.ubah-penduduk*') ? ' active' : '' }}">
                <i class="ri-edit-box-line"></i>
                <span>Ubah Data Penduduk</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('warga.profil') }}" class="nav-link{{ request()->routeIs('warga.profil*') ? ' active' : '' }}">
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