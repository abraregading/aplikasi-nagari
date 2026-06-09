<footer class="footer">
    <div class="footer-content">
        <p class="copyright">&copy; {{ date('Y') }} SI YanDuk Admin. All rights reserved.</p>
        <div class="footer-links">
            <a href="#">{{ $profil['bentuk_pemerintahan'] ?? 'Desa' }} {{ $profil['nama_pemerintahan'] ?? 'Desa' }}</a>
            <a href="#">{{ $profil['kabupaten'] ?? 'Pasaman Barat' }}</a>
        </div>
    </div>
</footer>