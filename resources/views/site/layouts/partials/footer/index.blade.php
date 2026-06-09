<div class="footer-content">
    <div class="footer-brand">
        <h2>{{ $profilnagari['bentuk_pemerintahan'] ?? 'Desa' }} {{ $profilnagari['nama_pemerintahan'] ?? 'Nagari' }}</h2>
        <p>{{ $profilnagari['kecamatan'] ?? 'Alamat tidak tersedia' }} <br> {{ $profilnagari['kabupaten'] ?? 'Kabupaten tidak tersedia' }}<br>{{ $profilnagari['provinsi'] ?? 'Provinsi tidak tersedia' }} Indonesia</p>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
            <a href="#" style="color: white; font-size: 1.2rem;"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" style="color: white; font-size: 1.2rem;"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" style="color: white; font-size: 1.2rem;"><i class="fa-brands fa-youtube"></i></a>
        </div>
    </div>
    
    <div class="footer-links">
        <h4>Tautan Cepat</h4>
        <ul>
            <li><a href="{{ route('site.home') }}">Beranda</a></li>
            <li><a href="{{ route('site.profil') }}">Profil Desa</a></li>
            <li><a href="{{ route('site.layanan') }}">Layanan</a></li>
            <li><a href="{{ route('site.berita') }}">Berita Desa</a></li>
        </ul>
    </div>
    
        <ul style="list-style: none;">
            <li style="margin-bottom: 1rem;"><i class="fa-solid fa-phone" style="margin-right: 10px;"></i> {{ $profilnagari['no_hp'] ?? 'Telepon tidak tersedia' }}</li>
            <li style="margin-bottom: 1rem;"><i class="fa-solid fa-envelope" style="margin-right: 10px;"></i> {{ $profilnagari['email'] ?? 'Email tidak tersedia' }}</li>
            <li><i class="fa-solid fa-map-marker-alt" style="margin-right: 10px;"></i> {{ $profilnagari['alamat'] ?? 'Alamat tidak tersedia' }}</li>
        </ul>
        </ul>
    </div>

    <div class="footer-map">
        <h4>Lokasi Kami</h4>
        <iframe src="{{ $profilnagari['titikkoordinat'] ?? '#' }}" width="100%" height="200" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>
<div class="copyright">
    <p>&copy; {{date('Y')}} Pemerintah {{ $profilnagari['bentuk_pemerintahan'] ?? 'Desa' }} {{ $profilnagari['nama_pemerintahan'] ?? 'Desa' }}. All Rights Reserved.</p>
</div>