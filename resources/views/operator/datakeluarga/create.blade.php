@extends('operator.layouts.app')

@section('title', 'Tambah Data Keluarga - Operator')

@section('head')
<style>
    .page-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .page-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .page-header h2 i { color: var(--primary); }
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
    .btn-back:hover { background: #6b7280; color: white; }
    
    .form-section { margin-bottom: 2rem; }
    .section-title {
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--primary);
        margin-bottom: 1.25rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.25rem;
    }
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
    .form-group label i { color: var(--primary); font-size: 1rem; }
    .form-group label .required { color: #ef4444; }
    .glass-input, .glass-select, .glass-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        background: white;
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
    .glass-input::placeholder, .glass-textarea::placeholder { color: #9ca3af; }
    .glass-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1.25rem;
        padding-right: 2.5rem;
    }
    .error-text { color: #ef4444; font-size: 0.8rem; margin-top: 0.4rem; display: flex; align-items: center; gap: 0.3rem; }
    .error-text i { font-size: 0.9rem; }
    textarea.glass-input { min-height: 100px; resize: vertical; }
    
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
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4); }
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
    .btn-cancel:hover { background: #6b7280; color: white; }
    
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
    .alert-error ul { margin: 0; padding-left: 1.5rem; color: #ef4444; }
</style>
@endsection

@section('konten')
<div class="page-header">
    <a href="{{ route('data-keluarga-operator.index') }}" class="btn-back">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2><i class="ri-family-line"></i> Tambah Data Keluarga</h2>
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
    <form action="{{ route('data-keluarga-operator.store') }}" method="POST">
        @csrf

        <div class="form-section">
            <div class="section-title"><i class="ri-id-card-line"></i> Data Kartu Keluarga</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="no_kk"><i class="ri-number-1"></i> Nomor KK <span class="required">*</span></label>
                    <input type="text" id="no_kk" name="no_kk" value="{{ old('no_kk') }}" placeholder="Masukkan No. KK (16 digit)" class="glass-input" required maxlength="20">
                    @error('no_kk')
                        <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kepala_keluarga_nik"><i class="ri-user-line"></i> NIK Kepala Keluarga</label>
                    <input type="text" id="kepala_keluarga_nik" name="kepala_keluarga_nik" value="{{ old('kepala_keluarga_nik') }}" placeholder="Masukkan NIK Kepala Keluarga" class="glass-input" maxlength="20">
                    @error('kepala_keluarga_nik')
                        <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="alamat"><i class="ri-map-pin-line"></i> Alamat <span class="required">*</span></label>
                <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" class="glass-input" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <div class="section-title"><i class="ri-map-2-line"></i> Data Wilayah</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="jorong"><i class="ri-map-line"></i> Jorong</label>
                    <input type="text" id="jorong" name="jorong" value="{{ old('jorong') }}" placeholder="Contoh: 001" class="glass-input" maxlength="5">
                    @error('jorong')
                        <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="desa_kelurahan"><i class="ri-community-line"></i> Desa/Kelurahan</label>
                    <input type="text" id="desa_kelurahan" name="desa_kelurahan" value="{{ old('desa_kelurahan') }}" placeholder="Masukkan nama desa/kelurahan" class="glass-input" maxlength="50">
                    @error('desa_kelurahan')
                        <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kecamatan"><i class="ri-building-line"></i> Kecamatan</label>
                    <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" placeholder="Masukkan kecamatan" class="glass-input" maxlength="50">
                    @error('kecamatan')
                        <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="kabupaten_kota"><i class="ri-office-line"></i> Kabupaten/Kota</label>
                    <input type="text" id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota') }}" placeholder="Masukkan kabupaten/kota" class="glass-input" maxlength="50">
                    @error('kabupaten_kota')
                        <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="provinsi"><i class="ri-government-line"></i> Provinsi</label>
                    <input type="text" id="provinsi" name="provinsi" value="{{ old('provinsi') }}" placeholder="Masukkan provinsi" class="glass-input" maxlength="50">
                    @error('provinsi')
                        <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kode_pos"><i class="ri-mail-send-line"></i> Kode Pos</label>
                    <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" placeholder="Masukkan kode pos" class="glass-input" maxlength="10">
                    @error('kode_pos')
                        <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jumlah_anggota"><i class="ri-team-line"></i> Jumlah Anggota</label>
                    <input type="number" id="jumlah_anggota" name="jumlah_anggota" value="{{ old('jumlah_anggota') }}" placeholder="0" class="glass-input" min="0">
                    @error('jumlah_anggota')
                        <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span>
                    @enderror
                </div>
            </div>
             <div class="form-section">
            <div class="section-title"><i class="ri-checkbox-multiple-line"></i> Status Keluarga</div>
            <div class="form-group">
                <label for="status"><i class="ri-toggle-line"></i> Status <span class="required">*</span></label>
                <select id="status" name="status" class="glass-select" required>
                    <option value="aktif">Aktif</option>
                    <option value="pindah">Pindah</option>
                    <option value="non-aktif">Non-Aktif</option>
                </select>
                @error('status') <span class="error-text"><i class="ri-alert-line"></i> {{ $message }}</span> @enderror
            </div>
        </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="ri-save-line"></i> Simpan Data
            </button>
            <a href="{{ route('data-keluarga-operator.index') }}" class="btn-cancel">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
@endsection
