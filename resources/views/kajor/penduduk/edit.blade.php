@extends('kajor.layouts.app')

@section('title', 'Edit Anggota Keluarga - ' . $penduduk->nama_lengkap)

@section('head')
<style>
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; color: #999; font-size: 0.9rem; font-weight: 500; }
    .form-group label .required { color: #ef4444; margin-left: 2px; }
    .form-actions { margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; }
    .error-text { color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem; display: block; }
    .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }
    .autocomplete-wrapper { position: relative; }
    .autocomplete-list { position: absolute; top: 100%; left: 0; right: 0; background: var(--bg-glass, #1e1e2e); border: 1px solid var(--border-glass, rgba(255,255,255,0.1)); border-radius: 8px; max-height: 200px; overflow-y: auto; z-index: 100; display: none; margin-top: 4px; }
    .autocomplete-list.show { display: block; }
    .autocomplete-item { padding: 0.6rem 1rem; cursor: pointer; font-size: 0.9rem; color: var(--text-main, #fff); transition: background 0.2s; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .autocomplete-item:last-child { border-bottom: none; }
    .autocomplete-item:hover, .autocomplete-item.active { background: rgba(99, 102, 241, 0.2); }
    .autocomplete-item .kk-nik { font-weight: 600; }
    .autocomplete-item .kk-info { font-size: 0.8rem; color: #999; margin-top: 2px; }
    .autocomplete-no-result { padding: 0.8rem 1rem; color: #999; font-size: 0.85rem; font-style: italic; }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('kajor.penduduk.show', $penduduk->id) }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Edit Anggota Keluarga</h2>
</div>

@if ($errors->any())
<div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; font-weight: 600;">
        <i class="ri-error-warning-line"></i> Terdapat kesalahan:
    </div>
    <ul style="margin: 0; padding-left: 1.5rem;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <form action="{{ route('kajor.penduduk.update', $penduduk->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="nik">NIK <span class="required">*</span></label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $penduduk->nik) }}" placeholder="Masukkan NIK (16 digit)" class="glass-select" style="width: 100%;" required maxlength="20">
                @error('nik') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="no_kk_search">Nomor KK <span class="required">*</span></label>
                <div class="autocomplete-wrapper">
                    <input type="text" id="no_kk_search" value="{{ old('no_kk', $penduduk->no_kk) }}" placeholder="Ketik No. KK" class="glass-select" style="width: 100%;" autocomplete="off" required>
                    <input type="hidden" id="no_kk" name="no_kk" value="{{ old('no_kk', $penduduk->no_kk) }}" required>
                    <div id="kk-autocomplete-list" class="autocomplete-list"></div>
                </div>
                @error('no_kk') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}" placeholder="Masukkan nama lengkap" class="glass-select" style="width: 100%;" required maxlength="100">
            @error('nama_lengkap') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" placeholder="Contoh: Padang" class="glass-select" style="width: 100%;" maxlength="50">
                @error('tempat_lahir') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('Y-m-d') : '') }}" class="glass-select" style="width: 100%;">
                @error('tanggal_lahir') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="glass-select" style="width: 100%;" required>
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="agama">Agama</label>
                <select id="agama" name="agama" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih --</option>
                    @php $agamaVal = trim(old('agama', $penduduk->agama) ?? ''); @endphp
                    <option value="ISLAM" {{ $agamaVal == 'ISLAM' ? 'selected' : '' }}>Islam</option>
                    <option value="KRISTEN" {{ $agamaVal == 'KRISTEN' ? 'selected' : '' }}>Kristen</option>
                    <option value="KATOLIK" {{ $agamaVal == 'KATOLIK' ? 'selected' : '' }}>Katolik</option>
                    <option value="HINDU" {{ $agamaVal == 'HINDU' ? 'selected' : '' }}>Hindu</option>
                    <option value="BUDDHA" {{ $agamaVal == 'BUDDHA' ? 'selected' : '' }}>Buddha</option>
                    <option value="KONGHUCU" {{ $agamaVal == 'KONGHUCU' ? 'selected' : '' }}>Konghucu</option>
                </select>
                @error('agama') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="status_perkawinan">Status Perkawinan</label>
                <select id="status_perkawinan" name="status_perkawinan" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih --</option>
                    @php $spVal = trim(old('status_perkawinan', $penduduk->status_perkawinan) ?? ''); @endphp
                    <option value="BELUM KAWIN" {{ $spVal == 'BELUM KAWIN' ? 'selected' : '' }}>BELUM KAWIN</option>
                    <option value="KAWIN" {{ $spVal == 'KAWIN' ? 'selected' : '' }}>KAWIN</option>
                    <option value="KAWIN TERCATAT" {{ $spVal == 'KAWIN TERCATAT' ? 'selected' : '' }}>KAWIN TERCATAT</option>
                    <option value="CERAI HIDUP" {{ $spVal == 'CERAI HIDUP' ? 'selected' : '' }}>CERAI HIDUP</option>
                    <option value="CERAI MATI" {{ $spVal == 'CERAI MATI' ? 'selected' : '' }}>CERAI MATI</option>
                </select>
                @error('status_perkawinan') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="hubungan_keluarga">Hubungan Keluarga</label>
                <select id="hubungan_keluarga" name="hubungan_keluarga" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih --</option>
                    @php $hkVal = trim(old('hubungan_keluarga', $penduduk->hubungan_keluarga) ?? ''); @endphp
                    <option value="KEPALA KELUARGA" {{ $hkVal == 'KEPALA KELUARGA' ? 'selected' : '' }}>KEPALA KELUARGA</option>
                    <option value="ISTERI" {{ $hkVal == 'ISTERI' ? 'selected' : '' }}>ISTERI</option>
                    <option value="ANAK" {{ $hkVal == 'ANAK' ? 'selected' : '' }}>ANAK</option>
                    <option value="MENANTU" {{ $hkVal == 'MENANTU' ? 'selected' : '' }}>MENANTU</option>
                    <option value="CUCU" {{ $hkVal == 'CUCU' ? 'selected' : '' }}>CUCU</option>
                    <option value="ORANG TUA" {{ $hkVal == 'ORANG TUA' ? 'selected' : '' }}>ORANG TUA</option>
                    <option value="MERTUA" {{ $hkVal == 'MERTUA' ? 'selected' : '' }}>MERTUA</option>
                    <option value="FAMILI LAIN" {{ $hkVal == 'FAMILI LAIN' ? 'selected' : '' }}>FAMILI LAIN</option>
                    <option value="Lainnya" {{ $hkVal == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('hubungan_keluarga') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}" placeholder="Contoh: Petani, PNS, Wiraswasta" class="glass-select" style="width: 100%;" maxlength="50">
                @error('pekerjaan') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                <select id="pendidikan_terakhir" name="pendidikan_terakhir" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih --</option>
                    @php $ptVal = trim(old('pendidikan_terakhir', $penduduk->pendidikan_terakhir) ?? ''); @endphp
                    <option value="TIDAK/BLM SEKOLAH" {{ $ptVal == 'TIDAK/BLM SEKOLAH' ? 'selected' : '' }}>TIDAK/BLM SEKOLAH</option>
                    <option value="TAMAT SD/SEDERAJAT" {{ $ptVal == 'TAMAT SD/SEDERAJAT' ? 'selected' : '' }}>TAMAT SD/SEDERAJAT</option>
                    <option value="SLTP/SEDERAJAT" {{ $ptVal == 'SLTP/SEDERAJAT' ? 'selected' : '' }}>SLTP/SEDERAJAT</option>
                    <option value="SLTA/SEDERAJAT" {{ $ptVal == 'SLTA/SEDERAJAT' ? 'selected' : '' }}>SLTA/SEDERAJAT</option>
                    <option value="D1/D2/D3" {{ $ptVal == 'D1/D2/D3' ? 'selected' : '' }}>D1/D2/D3</option>
                    <option value="S1" {{ $ptVal == 'S1' ? 'selected' : '' }}>S1</option>
                    <option value="S2" {{ $ptVal == 'S2' ? 'selected' : '' }}>S2</option>
                    <option value="S3" {{ $ptVal == 'S3' ? 'selected' : '' }}>S3</option>
                </select>
                @error('pendidikan_terakhir') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" class="glass-select" style="width: 100%; min-height: 80px;">{{ old('alamat', $penduduk->keluarga->alamat ?? $penduduk->alamat) }}</textarea>
            @error('alamat') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="status_hidup">Status Hidup <span class="required">*</span></label>
            <select id="status_hidup" name="status_hidup" class="glass-select" style="width: 100%;" required>
                <option value="hidup" {{ old('status_hidup', $penduduk->status_hidup) == 'hidup' ? 'selected' : '' }}>Hidup</option>
                <option value="meninggal" {{ old('status_hidup', $penduduk->status_hidup) == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                <option value="pindah" {{ old('status_hidup', $penduduk->status_hidup) == 'pindah' ? 'selected' : '' }}>Pindah</option>
            </select>
            @error('status_hidup') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Update
            </button>
            <a href="{{ route('kajor.penduduk.show', $penduduk->id) }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    const kkData = [
        @foreach($keluargas as $keluarga)
        { no_kk: "{{ $keluarga->no_kk }}", nik: "{{ $keluarga->kepala_keluarga_nik }}", alamat: "{{ Str::limit($keluarga->alamat, 40) }}" },
        @endforeach
    ];

    const searchInput = document.getElementById('no_kk_search');
    const hiddenInput = document.getElementById('no_kk');
    const listEl = document.getElementById('kk-autocomplete-list');
    let activeIdx = -1;

    function renderList(filtered) {
        listEl.innerHTML = '';
        activeIdx = -1;
        if (filtered.length === 0) {
            listEl.innerHTML = '<div class="autocomplete-no-result">Tidak ada data KK yang cocok</div>';
            listEl.classList.add('show');
            return;
        }
        filtered.forEach((item, idx) => {
            const div = document.createElement('div');
            div.className = 'autocomplete-item';
            div.dataset.value = item.no_kk;
            div.innerHTML = `<div class="kk-nik">${item.no_kk}</div><div class="kk-info">NIK Kepala: ${item.nik} &bull; ${item.alamat}</div>`;
            div.addEventListener('click', () => selectItem(item));
            listEl.appendChild(div);
        });
        listEl.classList.add('show');
    }

    function selectItem(item) {
        searchInput.value = item.no_kk;
        hiddenInput.value = item.no_kk;
        listEl.classList.remove('show');
    }

    searchInput.addEventListener('input', function() {
        const val = this.value.trim().toLowerCase();
        hiddenInput.value = this.value.trim();
        if (val.length === 0) { listEl.classList.remove('show'); return; }
        const filtered = kkData.filter(k => k.no_kk.toLowerCase().includes(val) || k.nik.toLowerCase().includes(val));
        renderList(filtered);
    });

    searchInput.addEventListener('focus', function() {
        const val = this.value.trim().toLowerCase();
        if (val.length > 0) {
            const filtered = kkData.filter(k => k.no_kk.toLowerCase().includes(val) || k.nik.toLowerCase().includes(val));
            renderList(filtered);
        } else {
            renderList(kkData.slice(0, 10));
        }
    });

    searchInput.addEventListener('keydown', function(e) {
        const items = listEl.querySelectorAll('.autocomplete-item');
        if (e.key === 'ArrowDown') { e.preventDefault(); activeIdx = Math.min(activeIdx + 1, items.length - 1); items.forEach((el, i) => el.classList.toggle('active', i === activeIdx)); if (items[activeIdx]) items[activeIdx].scrollIntoView({ block: 'nearest' }); }
        else if (e.key === 'ArrowUp') { e.preventDefault(); activeIdx = Math.max(activeIdx - 1, 0); items.forEach((el, i) => el.classList.toggle('active', i === activeIdx)); if (items[activeIdx]) items[activeIdx].scrollIntoView({ block: 'nearest' }); }
        else if (e.key === 'Enter' && activeIdx >= 0 && items[activeIdx]) { e.preventDefault(); const val = items[activeIdx].dataset.value; const item = kkData.find(k => k.no_kk === val); if (item) selectItem(item); }
        else if (e.key === 'Escape') { listEl.classList.remove('show'); }
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !listEl.contains(e.target)) { listEl.classList.remove('show'); }
    });
</script>
@endsection
