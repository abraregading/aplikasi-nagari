{{-- Form partial khusus: Surat Keterangan Penghasilan --}}
{{-- Field-field ini akan tersimpan di riwayat_surat.data_surat (JSON) --}}

<div class="form-section">
    <div class="form-section-title">
        <i class="ri-user-star-line"></i> Data Siswa / Mahasiswa
    </div>

    <div class="form-row">
        <div class="form-group">
            <label><i class="ri-user-line"></i> Nama Siswa / Mahasiswa <span class="required">*</span></label>
            <input type="text" name="dynamic[nama_siswa]" class="form-control auto-fill-target"
                   placeholder="Nama lengkap siswa/mahasiswa"
                   value="{{ old('dynamic.nama_siswa', $dataSurat['nama_siswa'] ?? '') }}" required
                   data-autofill-from="nama_lengkap">
        </div>
        <div class="form-group">
            <label><i class="ri-map-pin-line"></i> Tempat Lahir</label>
            <input type="text" name="dynamic[tempat_lahir]" class="form-control auto-fill-target"
                   placeholder="Otomatis dari NIK pemohon"
                   value="{{ old('dynamic.tempat_lahir', $dataSurat['tempat_lahir'] ?? '') }}"
                   data-autofill-from="tempat_lahir">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label><i class="ri-calendar-line"></i> Tanggal Lahir</label>
            <input type="date" name="dynamic[tanggal_lahir]" class="form-control auto-fill-target"
                   value="{{ old('dynamic.tanggal_lahir', $dataSurat['tanggal_lahir'] ?? '') }}"
                   data-autofill-from="tanggal_lahir">
        </div>
        <div class="form-group">
            <label><i class="ri-home-4-line"></i> Alamat Rumah</label>
            <input type="text" name="dynamic[alamat_rumah]" class="form-control auto-fill-target"
                   placeholder="Otomatis dari NIK pemohon"
                   value="{{ old('dynamic.alamat_rumah', $dataSurat['alamat_rumah'] ?? '') }}"
                   data-autofill-from="alamat">
        </div>
    </div>
</div>

<div class="form-section">
    <div class="form-section-title">
        <i class="ri-school-line"></i> Data Universitas / Sekolah
    </div>

    <div class="form-row">
        <div class="form-group">
            <label><i class="ri-building-2-line"></i> Nama Universitas / Sekolah <span class="required">*</span></label>
            <input type="text" name="dynamic[nama_universitas]" class="form-control"
                   placeholder="Nama universitas atau sekolah"
                   value="{{ old('dynamic.nama_universitas', $dataSurat['nama_universitas'] ?? '') }}" required>
        </div>
        <div class="form-group">
            <label><i class="ri-map-pin-2-line"></i> Alamat Universitas / Sekolah <span class="required">*</span></label>
            <input type="text" name="dynamic[alamat_universitas]" class="form-control"
                   placeholder="Alamat lengkap universitas/sekolah"
                   value="{{ old('dynamic.alamat_universitas', $dataSurat['alamat_universitas'] ?? '') }}" required>
        </div>
    </div>
</div>

<div class="form-section">
    <div class="form-section-title">
        <i class="ri-parent-line"></i> Data Orang Tua
    </div>

    <div class="form-row">
        <div class="form-group">
            <label><i class="ri-user-line"></i> Nama Ayah <span class="required">*</span></label>
            <input type="text" name="dynamic[nama_ayah]" class="form-control"
                   placeholder="Nama lengkap ayah"
                   value="{{ old('dynamic.nama_ayah', $dataSurat['nama_ayah'] ?? '') }}" required>
        </div>
        <div class="form-group">
            <label><i class="ri-user-line"></i> Nama Ibu <span class="required">*</span></label>
            <input type="text" name="dynamic[nama_ibu]" class="form-control"
                   placeholder="Nama lengkap ibu"
                   value="{{ old('dynamic.nama_ibu', $dataSurat['nama_ibu'] ?? '') }}" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label><i class="ri-briefcase-line"></i> Pekerjaan Orang Tua <span class="required">*</span></label>
            <input type="text" name="dynamic[pekerjaan_ortu]" class="form-control"
                   placeholder="Pekerjaan ayah/orang tua"
                   value="{{ old('dynamic.pekerjaan_ortu', $dataSurat['pekerjaan_ortu'] ?? '') }}" required>
        </div>
        <div class="form-group">
            <label><i class="ri-money-dollar-circle-line"></i> Penghasilan Dari (Rp) <span class="required">*</span></label>
            <input type="number" name="dynamic[penghasilan_dari]" class="form-control"
                   placeholder="Contoh: 1000000"
                   value="{{ old('dynamic.penghasilan_dari', $dataSurat['penghasilan_dari'] ?? '') }}" required
                   min="0" step="1000">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label><i class="ri-money-dollar-circle-line"></i> Penghasilan Sampai (Rp) <span class="required">*</span></label>
            <input type="number" name="dynamic[penghasilan_sampai]" class="form-control"
                   placeholder="Contoh: 3000000"
                   value="{{ old('dynamic.penghasilan_sampai', $dataSurat['penghasilan_sampai'] ?? '') }}" required
                   min="0" step="1000">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label><i class="ri-group-line"></i> Jumlah Tanggungan Anak <span class="required">*</span></label>
            <input type="number" name="dynamic[jumlah_tanggungan]" class="form-control"
                   placeholder="Jumlah anak yang ditanggung"
                   value="{{ old('dynamic.jumlah_tanggungan', $dataSurat['jumlah_tanggungan'] ?? '') }}" required
                   min="0">
        </div>
        <div class="form-group">
            {{-- Spacer --}}
        </div>
    </div>
</div>
