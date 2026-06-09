<header class="topbar">
    <button class="mobile-menu-toggle" onclick="toggleSidebar()" aria-label="Toggle Menu">
        <i class="ri-menu-line"></i>
    </button>

    <div class="search-box">
        <i class="ri-search-line"></i>
        <input type="text" placeholder="Pencarian disini..." />
    </div>

    <div class="user-menu">

        <a href="{{ route('kajor.profil.index') }}" class="profile" style="text-decoration: none; color: inherit;">
            <img
            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0ea5e9&color=fff"
            alt="Profile"
            />
            <div class="profile-info">
            <h4>{{ Auth::user()->name }}</h4>
            <p>User Kepala Jorong</p>
            </div>
            <i
            class="ri-arrow-down-s-line"
            style="color: var(--text-muted)"
            ></i>
        </a>
    </div>
</header>