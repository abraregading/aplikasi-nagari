@extends('warga.layouts.app')

@section('title', 'Entry Surat Baru - ' . $jenisSurat->nama_layanan)

@section('head')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
    }
    .page-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--bg-glass);
        border: var(--border-glass);
        color: var(--text-muted);
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s;
        font-family: 'Outfit', sans-serif;
    }
    .btn-back:hover {
        color: var(--primary);
        transform: translateX(-3px);
    }
    .form-card {
        border-radius: 16px;
        padding: 2rem;
    }
    .form-section {
        margin-bottom: 2rem;
    }
    .form-section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(14, 165, 233, 0.15);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .form-row.full {
        grid-template-columns: 1fr;
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    .form-group label {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-main);
        margin-bottom: 0.4rem;
    }
    .form-group label .required {
        color: #ef4444;
    }
    .form-control {
        padding: 0.8rem 1rem;
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,0.1);
        background: rgba(255,255,255,0.8);
        font-size: 0.9rem;
        font-family: 'Outfit', sans-serif;
        color: var(--text-main);
        transition: all 0.3s;
        outline: none;
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
    }
    .form-control:read-only {
        background: rgba(0,0,0,0.03);
        color: var(--text-muted);
    }
    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }
    select.form-control {
        cursor: pointer;
    }

    /* NIK Search */
    .nik-search-wrapper {
        position: relative;
    }
    .nik-search-wrapper .search-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        cursor: pointer;
        transition: 0.3s;
    }
    .nik-search-wrapper .search-icon:hover {
        color: var(--primary);
    }
    .nik-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        max-height: 250px;
        overflow-y: auto;
        z-index: 50;
        display: none;
        border: 1px solid rgba(0,0,0,0.08);
    }
    .nik-dropdown.show {
        display: block;
    }
    .nik-dropdown-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: 0.2s;
        border-bottom: 1px solid rgba(0,0,0,0.04);
    }
    .nik-dropdown-item:last-child {
        border-bottom: none;
    }
    .nik-dropdown-item:hover {
        background: rgba(14, 165, 233, 0.08);
    }
    .nik-dropdown-item .nik-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-main);
    }
    .nik-dropdown-item .nik-number {
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    .nik-loading {
        padding: 1rem;
        text-align: center;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    /* Penduduk Info Card */
    .penduduk-info {
        background: linear-gradient(135deg, rgba(14,165,233,0.05), rgba(99,102,241,0.05));
        border-radius: 12px;
        padding: 1.25rem;
        margin-top: 0.75rem;
        border: 1px dashed rgba(14, 165, 233, 0.3);
        display: none;
    }
    .penduduk-info.show {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .penduduk-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 0.75rem;
    }
    .penduduk-info-item {
        font-size: 0.85rem;
    }
    .penduduk-info-item .label {
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .penduduk-info-item .value {
        font-weight: 600;
        color: var(--text-main);
        margin-top: 2px;
    }

    /* Buttons */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(0,0,0,0.06);
        margin-top: 1rem;
    }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        font-family: 'Outfit', sans-serif;
        transition: all 0.3s;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
    }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(0,0,0,0.04);
        color: var(--text-muted);
        border: 1px solid rgba(0,0,0,0.08);
        padding: 0.75rem 2rem;
        border-radius: 10px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        font-family: 'Outfit', sans-serif;
        transition: all 0.3s;
    }
    .btn-cancel:hover {
        background: rgba(0,0,0,0.08);
        color: var(--text-main);
    }

    /* Alert */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column; }
        .form-actions .btn-submit,
        .form-actions .btn-cancel { width: 100%; justify-content: center; }
        .nik-search-wrapper .nik-dropdown { max-height: 200px; }
        #pendudukInfo .penduduk-info-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('konten')

<div class="page-header">
    <div>
        <h2><i class="ri-file-edit-line" style="color: var(--primary); margin-right: 8px;"></i>Entry Surat Baru</h2>
        <p>Jenis Surat: <strong>{{ $jenisSurat->nama_layanan }}</strong></p>
    </div>
    <a href="{{ route('buatsuratwarga.index') }}" class="btn-back">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <i class="ri-error-warning-line"></i>
    <div>
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
</div>
@endif

<form action="{{ route('buatsuratwarga.store') }}" method="POST">
    @csrf

    <input type="hidden" name="jenis_surat" value="{{ $jenisSurat->nama_layanan }}">

    <div class="form-card glass">
        <!-- Section: Data Pemohon -->
        <div class="form-section">
            <div class="form-section-title">
                <i class="ri-user-search-line"></i> Data Pemohon
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label>NIK Pemohon <span class="required">*</span></label>
                    <div class="nik-search-wrapper">
                        <input type="text" name="nik_pemohon" id="nikInput" class="form-control" 
                               placeholder="Ketik NIK untuk mencari data penduduk..." 
                               value="{{ old('nik_pemohon', $userNik) }}" autocomplete="off" required>
                        <i class="ri-search-line search-icon" id="nikSearchBtn"></i>
                        <div class="nik-dropdown" id="nikDropdown"></div>
                    </div>
                </div>
            </div>

            <!-- Penduduk Info Preview -->
            <div class="penduduk-info" id="pendudukInfo">
                <div class="penduduk-info-grid">
                    <div class="penduduk-info-item">
                        <div class="label">Nama Lengkap</div>
                        <div class="value" id="infoNama">-</div>
                    </div>
                    <div class="penduduk-info-item">
                        <div class="label">Tempat / Tgl Lahir</div>
                        <div class="value" id="infoTTL">-</div>
                    </div>
                    <div class="penduduk-info-item">
                        <div class="label">Jenis Kelamin</div>
                        <div class="value" id="infoJK">-</div>
                    </div>
                    <div class="penduduk-info-item">
                        <div class="label">Agama</div>
                        <div class="value" id="infoAgama">-</div>
                    </div>
                    <div class="penduduk-info-item">
                        <div class="label">Status Perkawinan</div>
                        <div class="value" id="infoStatus">-</div>
                    </div>
                    <div class="penduduk-info-item">
                        <div class="label">Pekerjaan</div>
                        <div class="value" id="infoPekerjaan">-</div>
                    </div>
                    <div class="penduduk-info-item" style="grid-column: 1 / -1;">
                        <div class="label">Alamat</div>
                        <div class="value" id="infoAlamat">-</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: Detail Surat -->
        <div class="form-section">
            <div class="form-section-title">
                <i class="ri-file-text-line"></i> Detail Surat
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Jenis Surat</label>
                    <select name="jenis_surat_select" class="form-control" id="jenisSelect" disabled>
                        @foreach($allJenis as $j)
                            <option value="{{ $j->nama_layanan }}" {{ $j->id == $jenisSurat->id ? 'selected' : '' }}>{{ $j->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nomor Surat</label>
                    <input type="text" name="nomor_surat" class="form-control" placeholder="Kosongkan jika auto-generate" value="{{ old('nomor_surat') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Jorong</label>
                    <input type="text" name="jorong" class="form-control" placeholder="Masukkan nama jorong" value="{{ old('jorong') }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Pengantar</label>
                    <input type="date" name="tanggal_pengantar" class="form-control" value="{{ old('tanggal_pengantar', date('Y-m-d')) }}">
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label>Nama Jalan / Alamat Detail</label>
                    <input type="text" name="nama_jalan" class="form-control" placeholder="Masukkan nama jalan" value="{{ old('nama_jalan') }}">
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label>Penandatangan Surat</label>
                    <select name="penandatangan_id" class="form-control">
                        <option value="">-- Pilih Penandatangan --</option>
                        @foreach($penandatanganList as $pt)
                            <option value="{{ $pt->id }}" {{ old('penandatangan_id', $defaultPenandatangan->id ?? '') == $pt->id ? 'selected' : '' }}>
                                {{ $pt->nama }} — {{ $pt->jabatan }}{{ $pt->is_default ? ' ★ Default' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        @if(!empty($formFields))
        @php $hasNikSearch = collect($formFields)->contains('type', 'nik_search'); @endphp
        <!-- Section: Data Khusus {{ $jenisSurat->nama_layanan }} -->
        <div class="form-section">
            <div class="form-section-title">
                <i class="ri-file-edit-line"></i> Data {{ $jenisSurat->nama_layanan }}
            </div>
            @foreach($formFields as $field)
            <div class="form-row {{ in_array($field['type'] ?? 'text', ['textarea']) ? 'full' : '' }}">
                <div class="form-group">
                    <label>{{ $field['label'] ?? $field['name'] ?? '' }} @if(!empty($field['required']))<span class="required">*</span>@endif</label>

                    @if(($field['type'] ?? 'text') === 'nik_search')
                        <div class="nik-search-wrapper">
                            <input type="text" name="dynamic[{{ $field['name'] ?? '' }}]" class="form-control nik-search-field"
                                   placeholder="Ketik NIK untuk mencari..."
                                   value="{{ old('dynamic.' . ($field['name'] ?? '')) }}" autocomplete="off"
                                   data-field="{{ $field['name'] ?? '' }}"
                                   data-autofill='{{ json_encode($field['auto_fill'] ?? new stdClass()) }}'
                                   {{ !empty($field['required']) ? 'required' : '' }}>
                            <i class="ri-search-line search-icon"></i>
                            <div class="nik-dropdown" style="display:none;"></div>
                        </div>
                    @elseif(($field['type'] ?? 'text') === 'textarea')
                        <textarea name="dynamic[{{ $field['name'] ?? '' }}]" class="form-control" placeholder="{{ $field['label'] ?? '' }}" {{ !empty($field['required']) ? 'required' : '' }}>{{ old('dynamic.' . ($field['name'] ?? '')) }}</textarea>
                    @elseif(($field['type'] ?? 'text') === 'number')
                        <input type="number" name="dynamic[{{ $field['name'] ?? '' }}]" class="form-control" placeholder="{{ $field['label'] ?? '' }}" value="{{ old('dynamic.' . ($field['name'] ?? '')) }}" {{ !empty($field['required']) ? 'required' : '' }}>
                    @elseif(($field['type'] ?? 'text') === 'date')
                        <input type="date" name="dynamic[{{ $field['name'] ?? '' }}]" class="form-control" value="{{ old('dynamic.' . ($field['name'] ?? '')) }}" {{ !empty($field['required']) ? 'required' : '' }}>
                    @else
                        <input type="text" name="dynamic[{{ $field['name'] ?? '' }}]" class="form-control auto-fill-target" placeholder="{{ $field['label'] ?? '' }}" value="{{ old('dynamic.' . ($field['name'] ?? '')) }}" {{ !empty($field['required']) ? 'required' : '' }}>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(empty($formFields))
        <!-- Section: Keterangan -->
        <div class="form-section">
            <div class="form-section-title">
                <i class="ri-information-line"></i> Keterangan & Keperluan
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label>Keterangan <span class="required">*</span></label>
                    <textarea name="keterangan" class="form-control" placeholder="Contoh: Miskin, Tidak Mampu, Berkelakuan Baik, dll." required>{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label>Pernyataan / Keperluan</label>
                    <textarea name="pernyataan" class="form-control" placeholder="Contoh: persyaratan pengurusan bantuan sosial">{{ old('pernyataan') }}</textarea>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="form-actions">
            <a href="{{ route('buatsurat.index') }}" class="btn-cancel">
                <i class="ri-close-line"></i> Batal
            </a>
            <button type="submit" class="btn-submit">
                <i class="ri-save-line"></i> Simpan & Ajukan
            </button>
        </div>
    </div>
</form>

@endsection

@section('script')
<script>
    // ===== NIK Search Helper =====
    const SEARCH_URL = '{{ route('buatsuratwarga.cari-penduduk') }}';
    let searchTimeouts = {};

    function initNikSearch(inputEl) {
        const wrapper = inputEl.closest('.nik-search-wrapper');
        const dropdown = wrapper.querySelector('.nik-dropdown');
        const fieldName = inputEl.dataset.field;
        let autoFillMap = {};
        try { autoFillMap = JSON.parse(inputEl.dataset.autofill || '{}'); } catch(e) {}

        inputEl.addEventListener('input', function() {
            clearTimeout(searchTimeouts[fieldName]);
            const nik = this.value.trim();
            if (nik.length < 3) { dropdown.style.display = 'none'; return; }

            dropdown.innerHTML = '<div class="nik-loading">Mencari...</div>';
            dropdown.style.display = 'block';

            searchTimeouts[fieldName] = setTimeout(() => {
                fetch(`${SEARCH_URL}?nik=${encodeURIComponent(nik)}`)
                    .then(r => r.json())
                    .then(data => {
                        if (data.length === 0) {
                            dropdown.innerHTML = '<div class="nik-loading">Tidak ditemukan</div>';
                            return;
                        }
                        dropdown.innerHTML = data.map(p =>
                            `<div class="nik-dropdown-item" data-penduduk='${encodeURIComponent(JSON.stringify(p))}'>
                                <div class="nik-name">${p.nama_lengkap || '-'}</div>
                                <div class="nik-number">NIK: ${p.nik}</div>
                            </div>`
                        ).join('');
                        dropdown.querySelectorAll('.nik-dropdown-item').forEach(item => {
                            item.addEventListener('click', function() {
                                const p = JSON.parse(decodeURIComponent(this.dataset.penduduk));
                                inputEl.value = p.nik;
                                dropdown.style.display = 'none';
                                Object.keys(autoFillMap).forEach(targetField => {
                                    const pendudukCol = autoFillMap[targetField];
                                    const targetInput = document.querySelector(`input[name="dynamic[${targetField}]"], textarea[name="dynamic[${targetField}]"]`);
                                    if (targetInput && p[pendudukCol] !== undefined) {
                                        targetInput.value = p[pendudukCol];
                                    }
                                });
                            });
                        });
                    })
                    .catch(() => { dropdown.innerHTML = '<div class="nik-loading">Error</div>'; });
            }, 400);
        });

        inputEl.addEventListener('focus', function() {
            if (this.value.trim().length >= 3) dropdown.style.display = 'block';
        });
    }

    // Init pemohon NIK search (existing)
    document.addEventListener('DOMContentLoaded', function() {
        const pemohonInput = document.getElementById('nikInput');
        if (pemohonInput) {
            const pemohonDropdown = document.getElementById('nikDropdown');
            const pendudukInfo = document.getElementById('pendudukInfo');
            let timeout;

            pemohonInput.addEventListener('input', function() {
                clearTimeout(timeout);
                const nik = this.value.trim();
                if (nik.length < 3) { pemohonDropdown.classList.remove('show'); return; }

                pemohonDropdown.innerHTML = '<div class="nik-loading">Mencari...</div>';
                pemohonDropdown.classList.add('show');

                timeout = setTimeout(() => {
                    fetch(`${SEARCH_URL}?nik=${encodeURIComponent(nik)}`)
                        .then(r => r.json())
                        .then(data => {
                            if (data.length === 0) {
                                pemohonDropdown.innerHTML = '<div class="nik-loading">Tidak ditemukan</div>';
                                return;
                            }
                            pemohonDropdown.innerHTML = data.map(p =>
                                `<div class="nik-dropdown-item" data-penduduk='${encodeURIComponent(JSON.stringify(p))}'>
                                    <div class="nik-name">${p.nama_lengkap || '-'}</div>
                                    <div class="nik-number">NIK: ${p.nik}</div>
                                </div>`
                            ).join('');
                            pemohonDropdown.querySelectorAll('.nik-dropdown-item').forEach(item => {
                                item.addEventListener('click', function() {
                                    const p = JSON.parse(decodeURIComponent(this.dataset.penduduk));
                                    pemohonInput.value = p.nik;
                                    pemohonDropdown.classList.remove('show');
                                    document.getElementById('infoNama').textContent = p.nama_lengkap || '-';
                                    document.getElementById('infoTTL').textContent = (p.tempat_lahir || '-') + ', ' + (p.tanggal_lahir || '-');
                                    document.getElementById('infoJK').textContent = p.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
                                    document.getElementById('infoAgama').textContent = p.agama || '-';
                                    document.getElementById('infoStatus').textContent = p.status_perkawinan || '-';
                                    document.getElementById('infoPekerjaan').textContent = p.pekerjaan || '-';
                                    document.getElementById('infoAlamat').textContent = p.alamat || '-';
                                    pendudukInfo.classList.add('show');
                                });
                            });
                        })
                        .catch(() => { pemohonDropdown.innerHTML = '<div class="nik-loading">Gagal</div>'; });
                }, 400);
            });

            document.addEventListener('click', function(e) {
                if (!pemohonInput.contains(e.target) && !pemohonDropdown.contains(e.target)) {
                    pemohonDropdown.classList.remove('show');
                }
            });

            if (pemohonInput.value.trim().length >= 3) pemohonInput.dispatchEvent(new Event('input'));
        }

        // Init dynamic nik_search fields
        document.querySelectorAll('.nik-search-field').forEach(initNikSearch);
    });
</script>
@endsection
