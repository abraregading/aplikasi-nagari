<section class="container" style="padding-top: 0;">
    <div class="glass" style="padding: 3rem; border-radius: 20px; background: white; margin-top: -5rem; max-width: 800px; margin-left: auto; margin-right: auto;">
        
        <p style="text-align: center; margin-bottom: 2rem; color: #666;">
            Silahkan sampaikan aspirasi, keluhan, atau saran Anda untuk kemajuan <br> Desa Digital di {{ $profilnagari['bentuk_pemerintahan'] ?? 'Desa' }} {{ $profilnagari['nama_pemerintahan'] ?? 'Digital' }}. <br>Identitas Anda akan kami jaga kerahasiaannya jika diperlukan.
        </p>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 10px; margin-bottom: 1rem; text-align: center;">
                {{ session('success') }}
            </div>
            @endif

        <form action="{{ route('site.laporan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-input" placeholder="Masukkan nama Anda" required value="{{ old('nama') }}">
                @error('nama') <span style="color: red; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nomor WhatsApp / Telepon</label>
                <input type="tel" name="no_hp" class="form-input" placeholder="Contoh: 08123456789" required value="{{ old('no_hp') }}">
                @error('no_hp') <span style="color: red; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email (opsional)</label>
                <input type="email" name="email" class="form-input" placeholder="Contoh: email@email.com" value="{{ old('email') }}">
                @error('email') <span style="color: red; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-input" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Infrastruktur (Jalan/Jembatan)" {{ old('kategori') == 'Infrastruktur (Jalan/Jembatan)' ? 'selected' : '' }}>Infrastruktur (Jalan/Jembatan)</option>
                    <option value="Pelayanan Publik" {{ old('kategori') == 'Pelayanan Publik' ? 'selected' : '' }}>Pelayanan Publik</option>
                    <option value="Keamanan & Ketertiban" {{ old('kategori') == 'Keamanan & Ketertiban' ? 'selected' : '' }}>Keamanan & Ketertiban</option>
                    <option value="Usulan Pembangunan" {{ old('kategori') == 'Usulan Pembangunan' ? 'selected' : '' }}>Usulan Pembangunan</option>
                    <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori') <span style="color: red; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Isi Laporan</label>
                <textarea name="isi_laporan" class="form-textarea" placeholder="Jelaskan secara detail..." required>{{ old('isi_laporan') }}</textarea>
                @error('isi_laporan') <span style="color: red; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn" style="width: 100%; border: none; cursor: pointer;">Kirim Laporan</button>
        </form>

    </div>
</section>

