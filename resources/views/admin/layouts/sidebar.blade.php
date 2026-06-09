<aside class="sidebar glass">
    <div class="logo">
        <i class="ri-dashboard-3-line"></i>
        <span>SI YanDuk</span>
    </div>

    <ul class="nav-links">
        <li class="nav-item">
            <a href="{{ route('admin.home') }}" class="nav-link{{ request()->routeIs('admin.home') ? ' active' : '' }}">
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
                <li><a href="{{ route('jenis-surat.index') }}" class="nav-link {{ request()->routeIs('jenis-surat.index') ? ' active' : '' }}" style="font-size:0.9rem;">Jenis Surat</a></li>
                <li><a href="{{ route('template-surat.index') }}" class="nav-link {{ request()->routeIs('template-surat.index') ? ' active' : '' }}" style="font-size:0.9rem;">Template Surat</a></li>
                <li><a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.index') ? ' active' : '' }}" style="font-size:0.9rem;">Laporan </a></li>
            </ul>
        </li>
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
                <i class="ri-user-line"></i>
                <span>Kependudukan</span>
                <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('data-keluarga.index') }}" class="nav-link{{ request()->routeIs('data-keluarga.*') ? ' active' : '' }}" style="font-size:0.9rem;">Data Keluaraga</a></li>
                <li><a href="{{ route('data-penduduk.index') }}" class="nav-link{{ request()->routeIs('data-penduduk.*') ? ' active' : '' }}" style="font-size:0.9rem;">Data Penduduk</a></li>
                <li><a href="{{ route('admin.riwayatpendataan.index') }}" class="nav-link{{ request()->routeIs('admin.riwayatpendataan.*') ? ' active' : '' }}" style="font-size:0.9rem;">Riwayat Pendataan Keluarga</a></li>
                <li><a href="{{ route('import-data.index') }}" class="nav-link {{ request()->routeIs('import-data.index') ? ' active' : '' }}" style="font-size:0.9rem;">Import Data</a></li>
                <li><a href="{{ route('export-data.index') }}" class="nav-link {{ request()->routeIs('export-data.*') ? ' active' : '' }}" style="font-size:0.9rem;">Export Data</a></li>
            </ul>
        </li>
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
                <i class="ri-file-settings-line"></i>
                <span>Berita</span>
                <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('daftar-berita.index') }}" class="nav-link{{ request()->routeIs('daftar-berita.*') ? ' active' : '' }}" style="font-size:0.9rem;">Daftar Berita</a></li>
                <li><a href="{{ route('kategori-berita.index') }}" class="nav-link{{ request()->routeIs('kategori-berita.*') ? ' active' : '' }}" style="font-size:0.9rem;">Kategori Berita</a></li>
                <li><a href="{{ route('komentar.index') }}" class="nav-link{{ request()->routeIs('komentar.*') ? ' active' : '' }}" style="font-size:0.9rem;">Komentar</a></li>
                <li><a href="{{ route('pengumuman.index') }}" class="nav-link{{ request()->routeIs('pengumuman.*') ? ' active' : '' }}" style="font-size:0.9rem;">Pengumuman</a></li>
            </ul>
        </li>
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
                <i class="ri-file-settings-line"></i>
                <span>Pemerintahan</span>
                <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('perangkat.index') }}" class="nav-link{{ request()->routeIs('perangkat.*') ? ' active' : '' }}" style="font-size:0.9rem;">Perangkat Nagari</a></li>
                <li><a href="{{ route('jabatan.index') }}" class="nav-link{{ request()->routeIs('jabatan.*') ? ' active' : '' }}" style="font-size:0.9rem;">Jabatan</a></li>
                <li><a href="{{ route('staf.index') }}" class="nav-link{{ request()->routeIs('staf.*') ? ' active' : '' }}" style="font-size:0.9rem;">Staf</a></li>
            </ul>
        </li>
         <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
            <i class="ri-table-line"></i>
            <span>Pendataan</span>
            <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('admin.bisniskos.index') }}" class="nav-link{{ request()->routeIs('admin.bisniskos*') ? ' active' : '' }}" style="font-size:0.9rem;">Usaha Kos & Kontrakan</a></li>
                <li><a href="{{ route('admin.petugaspendataan.index') }}" class="nav-link{{ request()->routeIs('admin.petugaspendataan*') ? ' active' : '' }}" style="font-size:0.9rem;">Petugas Pendataan</a></li>
                <li><a href="{{ route('admin.riwayatpendataan.index') }}" class="nav-link{{ request()->routeIs('admin.riwayatpendataan*') ? ' active' : '' }}" style="font-size:0.9rem;">Riwayat Pendataan</a></li>
                <li><a href="{{ route('admin.laporan-meninggal.index') }}" class="nav-link{{ request()->routeIs('admin.laporan-meninggal*') ? ' active' : '' }}" style="font-size:0.9rem;">Laporan Meninggal</a></li>
            </ul>
        </li>
         <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
            <i class="ri-table-line"></i>
            <span>Posyandu</span>
            <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('posyandu.index') }}" class="nav-link{{ request()->routeIs('posyandu.*') ? ' active' : '' }}" style="font-size:0.9rem;">Daftar Posyandu</a></li>
            </ul>
        </li>

        <li class="nav-item has-submenu">
            <a href="#" class="nav-link submenu-toggle">
                <i class="ri-file-settings-line"></i>
                <span>Manajemen</span>
                <i class="ri-arrow-down-s-line dropdown-icon" style="margin-left:auto;"></i>
            </a>
            <ul class="submenu" style="list-style:none; padding-left:1.5rem;">
                <li><a href="{{ route('profil-nagari.index') }}" class="nav-link{{ request()->routeIs('profil-nagari.*') ? ' active' : '' }}" style="font-size:0.9rem;">Profil Nagari</a></li>
                <li><a href="{{ route('tentang.index') }}" class="nav-link{{ request()->routeIs('tentang.*') ? ' active' : '' }}" style="font-size:0.9rem;">Tentang</a></li>
                <li><a href="{{ route('data-user.index')}}" class="nav-link{{ request()->routeIs('data-user.*') ? ' active' : '' }}" style="font-size:0.9rem;">User Management</a></li>
                <li><a href="{{url('user-api')}}" class="nav-link{{ request()->routeIs('user.api.*') ? ' active' : '' }}" style="font-size:0.9rem;">User Management API</a></li>
                <li><a href="{{ route('profil-admin.index') }}" class="nav-link{{ request()->routeIs('profil-admin.*') ? ' active' : '' }}" style="font-size:0.9rem;">Profil Admin</a></li>
                <li><a href="{{ route('penandatangan.index') }}" class="nav-link{{ request()->routeIs('penandatangan.*') ? ' active' : '' }}" style="font-size:0.9rem;">Penandatangan</a></li>
            </ul>
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