<!-- About Section -->
<section id="about">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Tentang Kami</span>
            <h2>Mengenal {{ $profilnagari['bentuk_pemerintahan'] ?? 'Desa' }} {{ $profilnagari['nama_pemerintahan'] ?? 'Desa Digital' }}</h2>
        </div>
        <div style="display: flex; gap: 3rem; flex-wrap: wrap; align-items: center; justify-content: center;">
            <div style="flex: 1; min-width: 300px;">
                <p style="margin-bottom: 1.5rem; font-size: 1.1rem; color: #555;">
                    {{ $tentang->isi_1 ?? 'Desa kami adalah sebuah komunitas yang kaya akan budaya dan tradisi, terletak di tengah keindahan alam yang mempesona. Dengan penduduk yang ramah dan gotong royong, kami berkomitmen untuk menjaga warisan budaya sambil terus berkembang menuju masa depan yang lebih baik.' }}
                </p>
                <p style="margin-bottom: 1.5rem; font-size: 1.1rem; color: #555;">
                    {{ $tentang->isi_2 ?? 'Kami berkomitmen untuk memberikan pelayanan yang transparan, akuntabel, dan efisien bagi seluruh warga desa. Alam yang asri dan masyarakat yang guyub rukun menjadi modal utama kami.' }}
                </p>
                <!-- <ul style="list-style: none; margin-top: 1rem;">
                    <li style="margin-bottom: 0.5rem;"><i class="fa-solid fa-check-circle" style="color: var(--primary-color); margin-right: 10px;"></i> Pelayanan Administrasi Cepat</li>
                </ul> -->
            </div>
            <div style="flex: 1; min-width: 300px;">
                @if ($tentang && $tentang->gambar)
                    <img src="{{ Storage::url($tentang->gambar) }}" alt="Pertanian Modern" style="border-radius: 20px; box-shadow: var(--shadow-lg);">
                @else
                    <img src="{{asset('site')}}/assets/farming.png" alt="Pertanian Modern" style="border-radius: 20px; box-shadow: var(--shadow-lg);">
                @endif
            </div>
        </div>
    </div>
</section>
