@extends('operator.layouts.app')

@section('title', 'Tambah Data Penduduk')

@section('head')
<style>
    .page-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
    .page-header a { color: var(--text-main); text-decoration: none; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .form-section { margin-bottom: 1.5rem; }
    .form-section h3 { font-size: 1rem; margin-bottom: 1rem; color: var(--primary); display: flex; align-items: center; gap: 0.5rem; }
    .form-grid { display: grid; gap: 1rem; }
    .form-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
    .form-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }
    @media (max-width: 768px) {
        .form-grid.cols-2, .form-grid.cols-3 { grid-template-columns: 1fr; }
    }
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
    .form-group label { font-size: 0.9rem; font-weight: 500; color: var(--text-muted); }
    .form-group label .required { color: #ef4444; }
    .form-input { padding: 0.7rem 1rem; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: var(--text-main); font-size: 0.95rem; }
    .form-input:focus { outline: none; border-color: var(--primary); }
    .form-input::placeholder { color: var(--text-muted); }
    select.form-input { cursor: pointer; }
    textarea.form-input { resize: vertical; min-height: 80px; }
    .btn-group { display: flex; gap: 1rem; margin-top: 1.5rem; }
    .btn { padding: 0.8rem 1.5rem; border-radius: 10px; font-weight: 600; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s; cursor: pointer; border: none; }
    .btn-primary { background: var(--primary); color: white; }
    .btn-primary:hover { background: #4f46e5; }
    .btn-secondary { background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); }
    .btn-secondary:hover { background: rgba(255,255,255,0.1); }
    .btn-success { background: #10b981; color: white; }
    .btn-success:hover { background: #059669; }
    .alert { padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; }
    .alert-error { background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; }
    .alert ul { margin: 0.5rem 0 0 1.5rem; }
    
    .search-keluarga { display: flex; gap: 0.5rem; margin-bottom: 1rem; }
    .search-keluarga input { flex: 1; }
    .search-keluarga button { white-space: nowrap; }
    .keluarga-result { padding: 1rem; border-radius: 10px; margin-bottom: 1rem; display: none; }
    .keluarga-result.show { display: block; }
    .keluarga-result.success { background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); }
    .keluarga-result.error { background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); }
    
    .anggota-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 1rem; margin-bottom: 1rem; }
    .anggota-card h4 { margin: 0 0 0.75rem 0; font-size: 0.95rem; color: var(--primary); display: flex; align-items: center; gap: 0.5rem; }
    .anggota-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem; }
    @media (max-width: 768px) { .anggota-grid { grid-template-columns: repeat(2, 1fr); } }
    .anggota-grid .form-group label { font-size: 0.8rem; }
    .anggota-grid .form-input { padding: 0.5rem 0.75rem; font-size: 0.85rem; }
    
    .tab-buttons { display: flex; gap: 0.5rem; margin-bottom: 1rem; }
    .tab-btn { padding: 0.6rem 1.2rem; border-radius: 8px; font-size: 0.9rem; font-weight: 500; cursor: pointer; border: 1px solid var(--text-muted); background: transparent; color: var(--text-muted); transition: all 0.2s; }
    .tab-btn.active { background: var(--primary); color: white; border-color: var(--primary); }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    
    .select-keluarga-list { max-height: 300px; overflow-y: auto; }
    .select-keluarga-item { display: flex; align-items: center; gap: 1rem; padding: 0.75rem; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; margin-bottom: 0.5rem; cursor: pointer; transition: all 0.2s; }
    .select-keluarga-item:hover { background: rgba(255,255,255,0.1); border-color: var(--primary); }
    .select-keluarga-item.selected { background: rgba(16, 185, 129, 0.15); border-color: #10b981; }
    .kk-info { flex: 1; }
    .kk-info strong { display: block; font-size: 0.95rem; }
    .kk-info small { color: var(--text-muted); font-size: 0.8rem; }
    
    .loading { display: inline-block; width: 1rem; height: 1rem; border: 2px solid rgba(255,255,255,0.3); border-radius: 50%; border-top-color: white; animation: spin 1s linear infinite; margin-left: 0.5rem; }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <a href="{{ route('data-penduduk-operator.index') }}" class="glass-select" style="background: transparent; border: 1px solid var(--text-muted); padding: 0.5rem 1rem;">
        <i class="ri-arrow-left-line"></i>
    </a>
    <h2>Tambah Data Penduduk</h2>
</div>

@if($errors->any())
    <div class="alert alert-error">
        <i class="ri-error-warning-line"></i> Terdapat kesalahan:
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="glass" style="padding: 1.5rem; border-radius: 16px;">
    <form action="{{ route('data-penduduk-operator.store') }}" method="POST" id="formPenduduk">
        @csrf
        
        <div class="form-section">
            <h3><i class="ri-group-line"></i> Pilih Keluarga</h3>
            <div class="tab-buttons">
                <button type="button" class="tab-btn active" onclick="switchTab('existing')">Keluarga yang Sudah Ada</button>
                <button type="button" class="tab-btn" onclick="switchTab('new')">Keluarga Baru</button>
            </div>
            
            <div id="tab-existing" class="tab-content active">
                <div class="search-keluarga">
                    <input type="text" id="searchKk" class="form-input" placeholder="Cari No. KK atau alamat keluarga...">
                    <button type="button" class="btn btn-success" onclick="searchKeluarga()">
                        <i class="ri-search-line"></i> Cari
                    </button>
                </div>
                
                <div id="searchResults" class="select-keluarga-list"></div>
                
                <div id="anggotaKeluargaSection" style="display: none;">
                    <h4 style="margin: 1rem 0 0.75rem 0; font-size: 0.95rem; color: var(--text-main);">
                        <i class="ri-team-line"></i> Anggota Keluarga (Klik untuk edit)
                    </h4>
                    <div id="anggotaKeluargaList"></div>
                    
                    <input type="hidden" name="pilih_dari_keluarga_ada" value="1" id="pilihDariKeluargaAda">
                    <input type="hidden" name="selected_no_kk" id="selectedNoKk">
                </div>
            </div>
            
            <div id="tab-new" class="tab-content">
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">Isi data keluarga baru di bawah ini</p>
            </div>
        </div>

        <div id="formDataPenduduk" class="form-section">
            <h3><i class="ri-id-card-line"></i> Identitas</h3>
            <div class="form-grid cols-2">
                <div class="form-group">
                    <label for="nik">NIK <span class="required">*</span></label>
                    <input type="text" id="nik" name="nik" class="form-input" value="{{ old('nik') }}" placeholder="Masukkan 16 digit NIK" maxlength="16" required>
                </div>
                <div class="form-group">
                    <label for="no_kk">No. KK <span class="required">*</span></label>
                    <input type="text" id="no_kk" name="no_kk" class="form-input" value="{{ old('no_kk') }}" placeholder="Masukkan 16 digit No. KK" maxlength="16" required>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-input" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3><i class="ri-calendar-line"></i> Data Pribadi</h3>
            <div class="form-grid cols-3">
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir <span class="required">*</span></label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-input" value="{{ old('tempat_lahir') }}" placeholder="Tempat lahir" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir <span class="required">*</span></label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir') }}" required>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-input" required>
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="agama">Agama</label>
                    <select id="agama" name="agama" class="form-input">
                        <option value="">Pilih</option>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katholik" {{ old('agama') == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status_perkawinan">Status Perkawinan</label>
                    <select id="status_perkawinan" name="status_perkawinan" class="form-input">
                        <option value="">Pilih</option>
                        <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="hubungan_keluarga">Hubungan Keluarga</label>
                    <select id="hubungan_keluarga" name="hubungan_keluarga" class="form-input">
                        <option value="">Pilih</option>
                        <option value="Kepala Keluarga" {{ old('hubungan_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                        <option value="Istri" {{ old('hubungan_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                        <option value="Anak" {{ old('hubungan_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                        <option value="Orang Tua" {{ old('hubungan_keluarga') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                        <option value="Mertua" {{ old('hubungan_keluarga') == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                        <option value="Cucu" {{ old('hubungan_keluarga') == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                        <option value="Lainnya" {{ old('hubungan_keluarga') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3><i class="ri-briefcase-line"></i> Pekerjaan & Pendidikan</h3>
            <div class="form-grid cols-2">
                <div class="form-group">
                    <label for="pekerjaan">Pekerjaan</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" class="form-input" value="{{ old('pekerjaan') }}" placeholder="Pekerjaan">
                </div>
                <div class="form-group">
                    <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                    <select id="pendidikan_terakhir" name="pendidikan_terakhir" class="form-input">
                        <option value="">Pilih</option>
                        <option value="Tidak/Belum Sekolah" {{ old('pendidikan_terakhir') == 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                        <option value="SD/Sederajat" {{ old('pendidikan_terakhir') == 'SD/Sederajat' ? 'selected' : '' }}>SD/Sederajat</option>
                        <option value="SMP/Sederajat" {{ old('pendidikan_terakhir') == 'SMP/Sederajat' ? 'selected' : '' }}>SMP/Sederajat</option>
                        <option value="SMA/Sederajat" {{ old('pendidikan_terakhir') == 'SMA/Sederajat' ? 'selected' : '' }}>SMA/Sederajat</option>
                        <option value="D1/D2/D3" {{ old('pendidikan_terakhir') == 'D1/D2/D3' ? 'selected' : '' }}>D1/D2/D3</option>
                        <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3><i class="ri-map-pin-line"></i> Alamat & Status</h3>
            <div class="form-grid cols-2">
                <div class="form-group" style="grid-column: span 2;">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-input" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="status_hidup">Status <span class="required">*</span></label>
                    <select id="status_hidup" name="status_hidup" class="form-input" required>
                        <option value="hidup" {{ old('status_hidup') == 'hidup' ? 'selected' : '' }}>Hidup</option>
                        <option value="meninggal" {{ old('status_hidup') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                        <option value="pindah" {{ old('status_hidup') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary" onclick="return prepareSubmit(event)">
                <i class="ri-save-line"></i> Simpan Data
            </button>
            <a href="{{ route('data-penduduk-operator.index') }}" class="btn btn-secondary">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    let selectedKeluarga = null;
    let anggotaKeluargaData = [];

    function switchTab(tab) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        
        if (tab === 'existing') {
            document.querySelector('.tab-btn:first-child').classList.add('active');
            document.getElementById('tab-existing').classList.add('active');
            document.getElementById('formDataPenduduk').style.display = 'none';
        } else {
            document.querySelector('.tab-btn:last-child').classList.add('active');
            document.getElementById('tab-new').classList.add('active');
            document.getElementById('formDataPenduduk').style.display = 'block';
            document.getElementById('anggotaKeluargaSection').style.display = 'none';
            document.getElementById('pilihDariKeluargaAda').value = '';
        }
    }

    async function searchKeluarga() {
        const searchInput = document.getElementById('searchKk').value;
        const resultsDiv = document.getElementById('searchResults');
        
        if (searchInput.length < 2) {
            resultsDiv.innerHTML = '<p style="color: var(--text-muted);">Masukkan minimal 2 karakter untuk mencari</p>';
            return;
        }

        resultsDiv.innerHTML = '<div class="loading"></div> Memuat...';

        try {
            const response = await fetch(`/cari-kk?q=${encodeURIComponent(searchInput)}`);
            const data = await response.json();
            
            if (data.length === 0) {
                resultsDiv.innerHTML = '<p style="color: var(--text-muted);">Keluarga tidak ditemukan</p>';
                return;
            }

            resultsDiv.innerHTML = data.map(k => `
                <div class="select-keluarga-item" onclick="selectKeluarga('${k.no_kk}')" data-kk="${k.no_kk}">
                    <div class="kk-info">
                        <strong>${k.no_kk}</strong>
                        <small>Kepala: ${k.kepala_keluarga || '-'} | RT ${k.rt || '-'} RW ${k.rw || '-'}</small><br>
                        <small>${k.alamat || 'Alamat tidak tersedia'}</small>
                    </div>
                </div>
            `).join('');
        } catch (error) {
            resultsDiv.innerHTML = '<p style="color: #ef4444;">Terjadi kesalahan saat mencari</p>';
        }
    }

    async function selectKeluarga(noKk) {
        document.querySelectorAll('.select-keluarga-item').forEach(item => item.classList.remove('selected'));
        document.querySelector(`[data-kk="${noKk}"]`).classList.add('selected');
        
        document.getElementById('selectedNoKk').value = noKk;
        document.getElementById('no_kk').value = noKk;

        const anggotaSection = document.getElementById('anggotaKeluargaSection');
        const anggotaList = document.getElementById('anggotaKeluargaList');
        
        anggotaSection.style.display = 'block';
        anggotaList.innerHTML = '<div class="loading"></div> Memuat anggota keluarga...';

        try {
            const response = await fetch(`/cari-keluarga?no_kk=${encodeURIComponent(noKk)}`);
            const result = await response.json();
            
            if (!result.found) {
                anggotaList.innerHTML = '<p style="color: var(--text-muted);">Keluarga tidak memiliki anggota</p>';
                return;
            }

            anggotaKeluargaData = result.anggota.map(a => ({
                id: a.id,
                nik: a.nik,
                no_kk: a.no_kk,
                nama_lengkap: a.nama_lengkap,
                tempat_lahir: a.tempat_lahir || '',
                tanggal_lahir: a.tanggal_lahir || '',
                jenis_kelamin: a.jenis_kelamin,
                agama: a.agama || '',
                status_perkawinan: a.status_perkawinan || '',
                hubungan_keluarga: a.hubungan_keluarga || '',
                pekerjaan: a.pekerjaan || '',
                pendidikan_terakhir: a.pendidikan_terakhir || '',
                alamat: a.alamat || '',
                status_hidup: a.status_hidup || 'hidup'
            }));

            renderAnggotaKeluarga();
            
            document.getElementById('formDataPenduduk').style.display = 'none';
            document.getElementById('pilihDariKeluargaAda').value = '1';

        } catch (error) {
            anggotaList.innerHTML = '<p style="color: #ef4444;">Terjadi kesalahan saat memuat anggota keluarga</p>';
        }
    }

    function renderAnggotaKeluarga() {
        const anggotaList = document.getElementById('anggotaKeluargaList');
        
        if (anggotaKeluargaData.length === 0) {
            anggotaList.innerHTML = '<p style="color: var(--text-muted);">Belum ada anggota keluarga</p>';
            return;
        }

        anggotaList.innerHTML = anggotaKeluargaData.map((anggota, index) => `
            <div class="anggota-card">
                <h4>
                    <i class="ri-user-line"></i> 
                    ${anggota.nama_lengkap} 
                    <span style="font-size: 0.8rem; color: var(--text-muted);">(${anggota.hubungan_keluarga || '-'})</span>
                </h4>
                <div class="anggota-grid">
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" class="form-input" value="${anggota.nik}" readonly>
                        <input type="hidden" name="anggota_keluarga[${index}][nik]" value="${anggota.nik}">
                        <input type="hidden" name="anggota_keluarga[${index}][no_kk]" value="${anggota.no_kk}">
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-input" name="anggota_keluarga[${index}][nama_lengkap]" value="${anggota.nama_lengkap}">
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-input" name="anggota_keluarga[${index}][tempat_lahir]" value="${anggota.tempat_lahir}">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-input" name="anggota_keluarga[${index}][tanggal_lahir]" value="${anggota.tanggal_lahir}">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select class="form-input" name="anggota_keluarga[${index}][jenis_kelamin]">
                            <option value="L" ${anggota.jenis_kelamin === 'L' ? 'selected' : ''}>Laki-laki</option>
                            <option value="P" ${anggota.jenis_kelamin === 'P' ? 'selected' : ''}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Agama</label>
                        <select class="form-input" name="anggota_keluarga[${index}][agama]">
                            <option value="">Pilih</option>
                            <option value="Islam" ${anggota.agama === 'Islam' ? 'selected' : ''}>Islam</option>
                            <option value="Kristen" ${anggota.agama === 'Kristen' ? 'selected' : ''}>Kristen</option>
                            <option value="Katholik" ${anggota.agama === 'Katholik' ? 'selected' : ''}>Katholik</option>
                            <option value="Hindu" ${anggota.agama === 'Hindu' ? 'selected' : ''}>Hindu</option>
                            <option value="Budha" ${anggota.agama === 'Budha' ? 'selected' : ''}>Budha</option>
                            <option value="Konghucu" ${anggota.agama === 'Konghucu' ? 'selected' : ''}>Konghucu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status Perkawinan</label>
                        <select class="form-input" name="anggota_keluarga[${index}][status_perkawinan]">
                            <option value="">Pilih</option>
                            <option value="Belum Kawin" ${anggota.status_perkawinan === 'Belum Kawin' ? 'selected' : ''}>Belum Kawin</option>
                            <option value="Kawin" ${anggota.status_perkawinan === 'Kawin' ? 'selected' : ''}>Kawin</option>
                            <option value="Cerai Hidup" ${anggota.status_perkawinan === 'Cerai Hidup' ? 'selected' : ''}>Cerai Hidup</option>
                            <option value="Cerai Mati" ${anggota.status_perkawinan === 'Cerai Mati' ? 'selected' : ''}>Cerai Mati</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Hubungan Keluarga</label>
                        <select class="form-input" name="anggota_keluarga[${index}][hubungan_keluarga]">
                            <option value="">Pilih</option>
                            <option value="Kepala Keluarga" ${anggota.hubungan_keluarga === 'Kepala Keluarga' ? 'selected' : ''}>Kepala Keluarga</option>
                            <option value="Istri" ${anggota.hubungan_keluarga === 'Istri' ? 'selected' : ''}>Istri</option>
                            <option value="Anak" ${anggota.hubungan_keluarga === 'Anak' ? 'selected' : ''}>Anak</option>
                            <option value="Orang Tua" ${anggota.hubungan_keluarga === 'Orang Tua' ? 'selected' : ''}>Orang Tua</option>
                            <option value="Mertua" ${anggota.hubungan_keluarga === 'Mertua' ? 'selected' : ''}>Mertua</option>
                            <option value="Cucu" ${anggota.hubungan_keluarga === 'Cucu' ? 'selected' : ''}>Cucu</option>
                            <option value="Lainnya" ${anggota.hubungan_keluarga === 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <input type="text" class="form-input" name="anggota_keluarga[${index}][pekerjaan]" value="${anggota.pekerjaan}">
                    </div>
                    <div class="form-group">
                        <label>Pendidikan</label>
                        <select class="form-input" name="anggota_keluarga[${index}][pendidikan_terakhir]">
                            <option value="">Pilih</option>
                            <option value="Tidak/Belum Sekolah" ${anggota.pendidikan_terakhir === 'Tidak/Belum Sekolah' ? 'selected' : ''}>Tidak/Belum Sekolah</option>
                            <option value="SD/Sederajat" ${anggota.pendidikan_terakhir === 'SD/Sederajat' ? 'selected' : ''}>SD/Sederajat</option>
                            <option value="SMP/Sederajat" ${anggota.pendidikan_terakhir === 'SMP/Sederajat' ? 'selected' : ''}>SMP/Sederajat</option>
                            <option value="SMA/Sederajat" ${anggota.pendidikan_terakhir === 'SMA/Sederajat' ? 'selected' : ''}>SMA/Sederajat</option>
                            <option value="D1/D2/D3" ${anggota.pendidikan_terakhir === 'D1/D2/D3' ? 'selected' : ''}>D1/D2/D3</option>
                            <option value="S1" ${anggota.pendidikan_terakhir === 'S1' ? 'selected' : ''}>S1</option>
                            <option value="S2" ${anggota.pendidikan_terakhir === 'S2' ? 'selected' : ''}>S2</option>
                            <option value="S3" ${anggota.pendidikan_terakhir === 'S3' ? 'selected' : ''}>S3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-input" name="anggota_keluarga[${index}][alamat]" value="${anggota.alamat}">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-input" name="anggota_keluarga[${index}][status_hidup]">
                            <option value="hidup" ${anggota.status_hidup === 'hidup' ? 'selected' : ''}>Hidup</option>
                            <option value="meninggal" ${anggota.status_hidup === 'meninggal' ? 'selected' : ''}>Meninggal</option>
                            <option value="pindah" ${anggota.status_hidup === 'pindah' ? 'selected' : ''}>Pindah</option>
                        </select>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function prepareSubmit(event) {
        const isFromExisting = document.getElementById('pilihDariKeluargaAda').value === '1';
        
        if (isFromExisting && anggotaKeluargaData.length === 0) {
            alert('Silakan pilih keluarga terlebih dahulu');
            event.preventDefault();
            return false;
        }

        if (!isFromExisting) {
            const nik = document.getElementById('nik').value;
            const no_kk = document.getElementById('no_kk').value;
            const nama_lengkap = document.getElementById('nama_lengkap').value;
            
            if (!nik || !no_kk || !nama_lengkap) {
                alert('Mohon lengkapi data identitas');
                event.preventDefault();
                return false;
            }
        }

        return true;
    }

    document.getElementById('searchKk').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchKeluarga();
        }
    });
</script>
@endsection