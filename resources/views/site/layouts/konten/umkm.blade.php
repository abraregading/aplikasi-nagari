<section class="container" style="padding-top: 0;">
    <div class="glass" style="padding: 2rem; border-radius: 20px; background: white; margin-top: -5rem;">
        <p style="text-align: center; margin-bottom: 3rem; max-width: 700px; margin-left: auto; margin-right: auto;">
            Dukung perekonomian warga dengan membeli produk lokal. Berikut adalah produk-produk unggulan hasil karya warga Desa Digital.
        </p>

        <div class="gallery-grid">
            <!-- Product 1 -->
            <!-- <div class="service-card" style="text-align: left; padding: 0; overflow: hidden;">
                <div style="height: 200px; background-color: #eee; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-basket-shopping" style="font-size: 3rem; color: #ccc;"></i>
                </div>
                <div style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 0.5rem;">Kerajinan Bambu</h3>
                    <p style="margin-bottom: 1rem; font-size: 0.9rem;">Anyaman bambu berkualitas tinggi untuk dekorasi rumah.</p>
                    <span style="color: var(--primary-color); font-weight: bold;">Rp 50.000 - Rp 250.000</span>
                    <div style="margin-top: 1rem;">
                        <a href="https://wa.me/" target="_blank" class="service-link"><i class="fa-brands fa-whatsapp"></i> Hubungi Penjual</a>
                    </div>
                </div>
            </div> -->

            <!-- Product 2 -->
            <!-- <div class="service-card" style="text-align: left; padding: 0; overflow: hidden;">
                <div style="height: 200px; background-color: #eee; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-cookie-bite" style="font-size: 3rem; color: #ccc;"></i>
                </div>
                <div style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 0.5rem;">Keripik Singkong</h3>
                    <p style="margin-bottom: 1rem; font-size: 0.9rem;">Camilan renyah aneka rasa, tanpa pengawet.</p>
                    <span style="color: var(--primary-color); font-weight: bold;">Rp 15.000 / pks</span>
                    <div style="margin-top: 1rem;">
                        <a href="https://wa.me/" target="_blank" class="service-link"><i class="fa-brands fa-whatsapp"></i> Hubungi Penjual</a>
                    </div>
                </div>
            </div> -->

            <!-- Product 3 -->
            <!-- <div class="service-card" style="text-align: left; padding: 0; overflow: hidden;">
                    <div style="height: 200px; background-color: #eee; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-shirt" style="font-size: 3rem; color: #ccc;"></i>
                </div>
                <div style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 0.5rem;">Batik Tulis Desa</h3>
                    <p style="margin-bottom: 1rem; font-size: 0.9rem;">Motif khas desa, dibuat dengan teknik tulis tradisional.</p>
                    <span style="color: var(--primary-color); font-weight: bold;">Rp 350.000</span>
                    <div style="margin-top: 1rem;">
                        <a href="https://wa.me/" target="_blank" class="service-link"><i class="fa-brands fa-whatsapp"></i> Hubungi Penjual</a>
                    </div>
                </div>
            </div> -->
        </div>
        
        <div style="margin-top: 4rem; text-align: center; background: #f0f7f4; padding: 2rem; border-radius: 10px;">
            <h3>Anda pelaku UMKM {{date('Y')}} <br>Pemerintah {{ $profilnagari['bentuk_pemerintahan'] ?? 'Desa' }} {{ $profilnagari['nama_pemerintahan'] ?? 'Desa' }}?</h3>
            <p style="margin-bottom: 1rem;">Daftarkan produk Anda untuk ditampilkan di website {{ $profilnagari['bentuk_pemerintahan'] ?? 'Desa' }}.</p>
            <a href="#" class="btn">Akan segera Hadir</a>
        </div>
    </div>
</section>