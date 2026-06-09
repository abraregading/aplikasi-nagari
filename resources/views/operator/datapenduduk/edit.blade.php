@extends('operator.layouts.app')

@section('title', 'Edit Data Penduduk - Operator')

@section('head')
<style>
    .page-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
        border-radius: 16px;
        border: 1px solid rgba(99, 102, 241, 0.2);
    }
    .page-header h2 {
        margin: 0;
        color: var(--primary);
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .page-header h2 i {
        font-size: 1.75rem;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.6rem 1.2rem;
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.2);
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-back:hover {
        background: #6b7280;
        color: white;
    }
    .form-section {
        margin-bottom: 2rem;
    }
    .section-title {
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--primary);
        margin-bottom: 1.25rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem; }
    .form-group { margin-bottom: 0; }
    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 0.5rem;
        color: #6b7280;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .form-group label i {
        color: var(--primary);
        font-size: 1rem;
    }
    .form-group label .required { color: #ef4444; }
    .glass-input, .glass-select, .glass-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(255,255,255,0.5);
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 10px;
        font-size: 0.95rem;
        color: #1f2937;
        transition: all 0.2s ease;
    }
    .glass-input:focus, .glass-select:focus, .glass-textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
    }
    .glass-input::placeholder, .glass-textarea::placeholder {
        color: #9ca3af;
    }
    .glass-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1.25rem;
        padding-right: 2.5rem;
    }
    .error-text {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .error-text i { font-size: 0.9rem; }
    .form-actions {
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(0,0,0,0.08);
    }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 2rem;
        background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
    }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.5rem;
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.2);
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-cancel:hover {
        background: #6b7280;
        color: white;
    }
    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }
    .alert-error .alert-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #ef4444;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .alert-error ul {
        margin: 0;
        padding-left: 1.5rem;
        color: #ef4444;
    }
    .autocomplete-wrapper { position: relative; }
    .autocomplete-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 10px;
        max-height: 220px;
        overflow-y: auto;
        z-index: 100;
        display: none;
        margin-top: 4px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    .autocomplete-list.show { display: block; }
    .autocomplete-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        font-size: 0.9rem;
        color: #1f2937;
        transition: background 0.2s;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .autocomplete-item:last-child { border-bottom: none; }
    .autocomplete-item:hover, .autocomplete-item.active { background: rgba(99, 102, 241, 0.1); }
    .autocomplete-item .kk-nik { font-weight: 600; color: var(--primary); }
    .autocomplete-item .kk-info { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
    .autocomplete-no-result { padding: 0.8rem 1rem; color: #9ca3af; font-size: 0.85rem; font-style: italic; }
    textarea.glass-input { min-height: 100px; resize: vertical; }
    .input-icon { position: relative; }
    .input-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    .input-icon input { padding-left: 2.5rem; }
</style>
@endsection

@section('konten')
<div class="page-header">
    <a href="{{ route('data-penduduk-operator.show', $penduduk->id) }}" class="btn-back">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2><i class="ri-edit-circle-line"></i> Edit Data Penduduk</h2>
</div>

@if ($errors->any())
<div class="alert-error">
    <div class="alert-title">
        <i class="ri-error-warning-line"></i> Terdapat kesalahan:
    </div>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <form action="{{ route('data-penduduk-operator.update', $penduduk->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-section">
            <div class="section-title"><i class="ri-user-line"></i> Data Identitas</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="nik"><i class="ri-id-card-line"></i> NIK <span class="required">*</span></label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik', $penduduk->nik) }}" class="glass-input" placeholder="Masukkan NIK 16 digit" required maxlength="20">
                    @error('nik') <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="no_kk_search"><i class="ri-family-line"></i> Nomor KK <span class="required">*</span></label>
                    <div class="autocomplete-wrapper">
                        <input type="text" id="no_kk_search" value="{{ old('no_kk', $penduduk->no_kk) }}" placeholder="Ketik No. KK untuk mencari..." class="glass-input" autocomplete="off" required>
                        <input type="hidden" id="no_kk" name="no_kk" value="{{ old('no_kk', $penduduk->no_kk) }}" required>
                        <div id="kk-autocomplete-list" class="autocomplete-list"></div>
                    </div>
                    @error('no_kk') <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="nama_lengkap"><i class="ri-user-settings-line"></i> Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}" class="glass-input" placeholder="Masukkan nama lengkap" required maxlength="100">
                @error('nama_lengkap') <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-section">
            <div class="section-title"><i class="ri-calendar-event-line"></i> Data Kelahiran</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="tempat_lahir"><i class="ri-map-pin-line"></i> Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" class="glass-input" placeholder="Contoh: Padang" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir"><i class="ri-calendar-line"></i> Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('Y-m-d') : '') }}" class="glass-input">
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title"><i class="ri-gender-line"></i> Data Pribadi</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="jenis_kelamin"><i class="ri-men-line"></i> Jenis Kelamin <span class="required">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="glass-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="agama"><i class="ri-book-mark-line"></i> Agama</label>
                    <select id="agama" name="agama" class="glass-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $a)
                            <option value="{{ $a }}" {{ old('agama', $penduduk->agama) == $a ? 'selected' : '' }}>{{ $a }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="status_perkawinan"><i class="ri-heart-line"></i> Status Perkawinan</label>
                    <select id="status_perkawinan" name="status_perkawinan" class="glass-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $s)
                            <option value="{{ $s }}" {{ old('status_perkawinan', $penduduk->status_perkawinan) == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="hubungan_keluarga"><i class="ri-group-line"></i> Hubungan Keluarga</label>
                    <select id="hubungan_keluarga" name="hubungan_keluarga" class="glass-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Kepala Keluarga','Istri','Anak','Menantu','Cucu','Orang Tua','Mertua','Famili Lain','Lainnya'] as $h)
                            <option value="{{ $h }}" {{ old('hubungan_keluarga', $penduduk->hubungan_keluarga) == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title"><i class="ri-briefcase-line"></i> Data Pendidikan & Pekerjaan</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="pekerjaan"><i class="ri-building-line"></i> Pekerjaan</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}" class="glass-input" placeholder="Contoh: Petani, Guru, dll" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="pendidikan_terakhir"><i class="ri-graduation-cap-line"></i> Pendidikan Terakhir</label>
                    <select id="pendidikan_terakhir" name="pendidikan_terakhir" class="glass-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Tidak/Belum Sekolah','SD/Sederajat','SMP/Sederajat','SMA/Sederajat','D1/D2/D3','S1','S2','S3'] as $p)
                            <option value="{{ $p }}" {{ old('pendidikan_terakhir', $penduduk->pendidikan_terakhir) == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title"><i class="ri-home-line"></i> Alamat & Status</div>
            <div class="form-group">
                <label for="alamat"><i class="ri-map-2-line"></i> Alamat</label>
                <textarea id="alamat" name="alamat" class="glass-input" placeholder="Masukkan alamat lengkap...">{{ old('alamat', $penduduk->alamat) }}</textarea>
            </div>
            <div class="form-group">
                <label for="status_hidup"><i class="ri-heart-2-line"></i> Status Hidup <span class="required">*</span></label>
                <select id="status_hidup" name="status_hidup" class="glass-select" required>
                    <option value="hidup" {{ old('status_hidup', $penduduk->status_hidup) == 'hidup' ? 'selected' : '' }}>Hidup</option>
                    <option value="meninggal" {{ old('status_hidup', $penduduk->status_hidup) == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                    <option value="pindah" {{ old('status_hidup', $penduduk->status_hidup) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="ri-save-line"></i> Simpan Perubahan
            </button>
            <a href="{{ route('data-penduduk-operator.show', $penduduk->id) }}" class="btn-cancel">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
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
        filtered.forEach((item) => {
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
