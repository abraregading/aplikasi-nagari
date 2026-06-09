<!-- Stats Section -->
    <div class="stats container">
        <div class="stat-card">
            <div class="stat-number">2.5k</div>
            <div class="stat-label">Penduduk</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">450</div>
            <div class="stat-label">Kepala Keluarga</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">12km²</div>
            <div class="stat-label">Luas Wilayah</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">8</div>
            <div class="stat-label">Dusun</div>
        </div>
    </div>

    <!-- About Section -->
    <section id="about">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Tentang Kami</span>
                <h2>Mengenal Desa Digital</h2>
            </div>
            <div style="display: flex; gap: 3rem; flex-wrap: wrap; align-items: center; justify-content: center;">
                <div style="flex: 1; min-width: 300px;">
                    <p style="margin-bottom: 1.5rem; font-size: 1.1rem; color: #555;">
                        Desa Digital adalah desa percontohan yang mengintegrasikan teknologi informasi dalam pelayanan publik dan pemberdayaan masyarakat, tanpa meninggalkan kearifan lokal yang luhur.
                    </p>
                    <p style="margin-bottom: 1.5rem; font-size: 1.1rem; color: #555;">
                        Kami berkomitmen untuk memberikan pelayanan yang transparan, akuntabel, dan efisien bagi seluruh warga desa. Alam yang asri dan masyarakat yang guyub rukun menjadi modal utama kami.
                    </p>
                    <ul style="list-style: none; margin-top: 1rem;">
                        <li style="margin-bottom: 0.5rem;"><i class="fa-solid fa-check-circle" style="color: var(--primary-color); margin-right: 10px;"></i> Pelayanan Administrasi Cepat</li>
                        <li style="margin-bottom: 0.5rem;"><i class="fa-solid fa-check-circle" style="color: var(--primary-color); margin-right: 10px;"></i> Pemberdayaan ekonomi UMKM</li>
                        <li style="margin-bottom: 0.5rem;"><i class="fa-solid fa-check-circle" style="color: var(--primary-color); margin-right: 10px;"></i> Infrastruktur Merata</li>
                    </ul>
                </div>
                <div style="flex: 1; min-width: 300px;">
                    <img src="assets/farming.png" alt="Pertanian Modern" style="border-radius: 20px; box-shadow: var(--shadow-lg);">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" style="background-color: #f0f7f4;">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Layanan Publik</span>
                <h2>Melayani Sepenuh Hati</h2>
            </div>
            
            <div class="services-grid">
                <div class="service-card">
                    <i class="fa-solid fa-file-contract service-icon"></i>
                    <h3>Administrasi Kependudukan</h3>
                    <p>Pembuatan KK, KTP, dan Akta Kelahiran kini lebih mudah dan cepat melalui loket terpadu.</p>
                    <a href="layanan-kependudukan.html" class="service-link">Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="service-card">
                    <i class="fa-solid fa-store service-icon"></i>
                    <h3>Pasar Desa & UMKM</h3>
                    <p>Pusat informasi produk unggulan desa dan pendampingan usaha kecil menengah.</p>
                    <a href="layanan-umkm.html" class="service-link">Lihat Produk <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="service-card">
                    <i class="fa-solid fa-shield-heart service-icon"></i>
                    <h3>Kesehatan & Posyandu</h3>
                    <p>Jadwal layanan kesehatan, posyandu balita & lansia, serta ambulans desa siaga 24 jam.</p>
                    <a href="layanan-kesehatan.html" class="service-link">Jadwal Layanan <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="service-card">
                    <i class="fa-solid fa-envelope-open-text service-icon"></i>
                    <h3>Pengaduan Masyarakat</h3>
                    <p>Saluran aspirasi dan pengaduan warga untuk pembangunan desa yang lebih baik.</p>
                    <a href="layanan-pengaduan.html" class="service-link">Buat Laporan <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Galeri</span>
                <h2>Potret Desa Kami</h2>
            </div>
            <div class="gallery-grid">
                <!-- Using inline styles for specific bg images as simple implementation -->
                <div class="gallery-item">
                    <img src="{{asset('site')}}/assets/hero.png" class="gallery-img" alt="Pemandangan Alam">
                    <div class="gallery-overlay">
                        <h4>Pesona Alam</h4>
                        <p>Keindahan lanskap desa di pagi hari</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="{{asset('site')}}/assets/community.png" class="gallery-img" alt="Kegiatan Warga">
                    <div class="gallery-overlay">
                        <h4>Musyawarah Desa</h4>
                        <p>Kegiatan rutin rembug warga di Balai Desa</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="{{asset('site')}}/assets/farming.png" class="gallery-img" alt="Pertanian">
                    <div class="gallery-overlay">
                        <h4>Pertanian Modern</h4>
                        <p>Inovasi tani untuk ketahanan pangan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>