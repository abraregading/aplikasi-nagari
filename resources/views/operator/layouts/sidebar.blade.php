<aside class="sidebar glass">
    <div class="logo">
        <i class="ri-dashboard-3-line"></i>
        <span>SI YanDuk</span>
    </div>

    <ul class="nav-links">
        <li class="nav-item">
            <a href="{{ route('operator.home') }}" class="nav-link{{ request()->routeIs('operator.home') ? ' active' : '' }}">
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
                <li><a href="{{ route('buatsurat.index') }}" class="nav-link {{ request()->routeIs('buatsurat.index') || request()->routeIs('buatsurat.create') ? ' active' : '' }}" style="font-size:0.9rem;">Buat Surat</a></li>
                <li><a href="{{ route('buatsurat.proses') }}" class="nav-link {{ request()->routeIs('buatsurat.proses') ? ' active' : '' }}" style="font-size:0.9rem;">Proses Permohonan</a></li>
                <li><a href="{{ route('buatsurat.riwayat') }}" class="nav-link {{ request()->routeIs('buatsurat.riwayat') ? ' active' : '' }}" style="font-size:0.9rem;">Riwayat Permohonan</a></li>
            </ul>
        </li>
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
                <i class="ri-user-line"></i>
                <span>Kependudukan</span>
                <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('data-keluarga-operator.index') }}" class="nav-link{{ request()->routeIs('data-keluarga-operator.*') ? ' active' : '' }}" style="font-size:0.9rem;">Data Keluaraga</a></li>
                <li><a href="{{ route('data-penduduk-operator.index') }}" class="nav-link{{ request()->routeIs('data-penduduk-operator.*') ? ' active' : '' }}" style="font-size:0.9rem;">Data Penduduk</a></li>
                <li><a href="{{ route('operator.laporan-meninggal.index') }}" class="nav-link{{ request()->routeIs('operator.laporan-meninggal*') ? ' active' : '' }}" style="font-size:0.9rem;">Laporan Meninggal</a></li>
            </ul>
        </li>
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
                <i class="ri-hand-coin-line"></i>
                <span>Bansos</span>
                <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('operator.blt-nagari.index') }}" class="nav-link {{ request()->routeIs('operator.blt-nagari*') ? ' active' : '' }}" style="font-size:0.9rem;">BLT Nagari</a></li>
            </ul>
        </li>
      
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
                <i class="ri-user-settings-line"></i>
                <span>Manajemen Warga</span>
                <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('operator.warga.index') }}" class="nav-link{{ request()->routeIs('operator.warga.*') && !request()->routeIs('operator.pengajuan-perubahan*') ? ' active' : '' }}" style="font-size:0.9rem;">Data Warga</a></li>
                <li><a href="{{ route('operator.pengajuan-perubahan.index') }}" class="nav-link{{ request()->routeIs('operator.pengajuan-perubahan*') ? ' active' : '' }}" style="font-size:0.9rem;">Pengajuan Perubahan</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="{{ route('operator.pengumuman.index') }}" class="nav-link{{ request()->routeIs('operator.pengumuman*') ? ' active' : '' }}">
                <i class="ri-megaphone-line"></i>
                <span>Pengumuman</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('operator.profil.index') }}" class="nav-link{{ request()->routeIs('operator.profil.*') ? ' active' : '' }}">
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