<header class="page-header" style="background-image: url('{{asset('site')}}/assets/hero.png');">
        <h1>Struktur Pemerintahan Desa</h1>
</header>

<section class="container" style="padding-top: 0;">
    <div class="glass" style="padding: 3rem; border-radius: 20px; background: white; margin-top: -5rem;">
        
        <p style="text-align: center; margin-bottom: 3rem; color: #666; max-width: 800px; margin-left: auto; margin-right: auto;">
            Mengenal lebih dekat jajaran perangkat desa yang siap melayani masyarakat dengan integritas dan profesionalisme.
        </p>

        
        <!-- Let's retry the structure to be exactly as requested: 
        Kades -> [Sekdes -> Kaurs], [Kasi], [Kasi], [Kasi], [Kadus Group -> Kadus 1, Kadus 2] -->
        
        <div class="tree">
            <ul>
                <li>
                    <div class="org-card">
                        <img src="{{asset('site')}}/assets/staff/kades.png" alt="Kepala Desa">
                        <span class="name">Bapak H. Sutrisno</span>
                        <span class="role">Kepala Desa</span>
                    </div>
                    <ul>
                        <!-- 1. Sekretaris Desa Branch -->
                        <li>
                            <div class="org-card">
                                <div style="width: 70px; height: 70px; background: #eee; border-radius: 50%; margin: 0 auto 0.5rem; display: flex; align-items: center; justify-content: center; border: 2px solid #f0f7f4; color: #ccc;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <span class="name">Ibu Rina Wati</span>
                                <span class="role">Sekretaris Desa</span>
                            </div>
                            <ul>
                                <li>
                                    <div class="org-card">
                                        <span class="name">Siti Aminah</span>
                                        <span class="role">Kaur Keuangan</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="org-card">
                                        <span class="name">Joko Susilo</span>
                                        <span class="role">Kaur Umum</span>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <!-- 2. Kasi Branches (Direct to Kades) -->
                        <li>
                            <div class="org-card">
                                <span class="name">Budi Santoso</span>
                                <span class="role">Kasi Pemerintahan</span>
                            </div>
                        </li>
                        <li>
                            <div class="org-card">
                                <span class="name">Ahmad Fauzi</span>
                                <span class="role">Kasi Pelayanan</span>
                            </div>
                        </li>
                        <li>
                            <div class="org-card">
                                <span class="name">Rudi Hartono</span>
                                <span class="role">Kasi Kesejahteraan</span>
                            </div>
                        </li>

                        <!-- 3. Kwilayahan Branch (Kadus) -->
                            <li>
                            <span class="group-label">Kewilayahan</span>
                            <!-- We can group Kadus under a "Kepala Dusun Coordinator" or just list them. 
                                    To save space let's group them or put them as children of Kades directly. 
                                    Let's put them under a structural node label if possible, or just as children. -->
                            <div class="org-card" style="border-top-color: #999;">
                                <span class="name">Perangkat Wilayah</span>
                                <span class="role">Kepala Dusun</span>
                            </div>
                            <ul>
                                <li>
                                    <div class="org-card">
                                        <span class="name">Pak Bejo</span>
                                        <span class="role">Kadus I</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="org-card">
                                        <span class="name">Pak Yanto</span>
                                        <span class="role">Kadus II</span>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</section>