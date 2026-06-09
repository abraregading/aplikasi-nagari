@extends('admin.layouts.app')

@section('title', 'Tambah Data Penduduk - Admin Desa')

@section('head')
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
    }
    .form-group label .required {
        color: #ef4444;
        margin-left: 2px;
    }
    .form-actions {
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .error-text {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.3rem;
        display: block;
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }
    .kk-input-wrapper {
        position: relative;
    }
    .kk-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--glass);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        max-height: 250px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .kk-dropdown.show {
        display: block;
    }
    .kk-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        transition: background 0.2s;
    }
    .kk-item:hover {
        background: rgba(99, 102, 241, 0.15);
    }
    .kk-item:last-child {
        border-bottom: none;
    }
    .kk-item-no {
        font-weight: 600;
        color: #6366f1;
    }
    .kk-item-info {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.2rem;
    }
    .kk-no-result {
        padding: 1rem;
        text-align: center;
        color: var(--text-muted);
    }
    .btn-new-kk {
        display: inline-block;
        margin-left: 0.5rem;
        padding: 0.3rem 0.8rem;
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border-radius: 6px;
        font-size: 0.8rem;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-new-kk:hover {
        background: rgba(16, 185, 129, 0.25);
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('data-penduduk.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Tambah Data Penduduk</h2>
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
    <form action="{{ route('data-penduduk.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="nik">NIK <span class="required">*</span></label>
                <input type="text" id="nik" name="nik" value="{{ old('nik') }}" placeholder="Masukkan NIK (16 digit)" class="glass-select" style="width: 100%;" required maxlength="20">
                @error('nik')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="no_kk">Nomor KK <span class="required">*</span></label>
                <div class="kk-input-wrapper">
                    <input type="text" 
                           id="no_kk" 
                           name="no_kk" 
                           value="{{ old('no_kk') }}" 
                           placeholder="Ketik No. KK untuk mencari..." 
                           class="glass-select" 
                           style="width: 100%;" 
                           required
                           autocomplete="off">
                    <div id="kk-dropdown" class="kk-dropdown"></div>
                </div>
                <a href="{{ route('data-keluarga.create') }}" target="_blank" class="btn-new-kk">
                    <i class="ri-add-line"></i> KK Baru
                </a>
                @error('no_kk')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" class="glass-select" style="width: 100%;" required maxlength="100">
            @error('nama_lengkap')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Padang" class="glass-select" style="width: 100%;" maxlength="50">
                @error('tempat_lahir')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="glass-select" style="width: 100%;">
                @error('tanggal_lahir')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="glass-select" style="width: 100%;" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="agama">Agama</label>
                <select id="agama" name="agama" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih Agama --</option>
                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                </select>
                @error('agama')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="status_perkawinan">Status Perkawinan</label>
                <select id="status_perkawinan" name="status_perkawinan" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih Status --</option>
                    <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                    <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                    <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                    <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                </select>
                @error('status_perkawinan')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="hubungan_keluarga">Hubungan Keluarga</label>
                <select id="hubungan_keluarga" name="hubungan_keluarga" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih Hubungan --</option>
                    <option value="Kepala Keluarga" {{ old('hubungan_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                    <option value="Istri" {{ old('hubungan_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                    <option value="Anak" {{ old('hubungan_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                    <option value="Menantu" {{ old('hubungan_keluarga') == 'Menantu' ? 'selected' : '' }}>Menantu</option>
                    <option value="Cucu" {{ old('hubungan_keluarga') == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                    <option value="Orang Tua" {{ old('hubungan_keluarga') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="Mertua" {{ old('hubungan_keluarga') == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                    <option value="Famili Lain" {{ old('hubungan_keluarga') == 'Famili Lain' ? 'selected' : '' }}>Famili Lain</option>
                    <option value="Lainnya" {{ old('hubungan_keluarga') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('hubungan_keluarga')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Contoh: Petani, PNS, Wiraswasta" class="glass-select" style="width: 100%;" maxlength="50">
                @error('pekerjaan')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                <select id="pendidikan_terakhir" name="pendidikan_terakhir" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih Pendidikan --</option>
                    <option value="Tidak/Belum Sekolah" {{ old('pendidikan_terakhir') == 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                    <option value="SD/Sederajat" {{ old('pendidikan_terakhir') == 'SD/Sederajat' ? 'selected' : '' }}>SD/Sederajat</option>
                    <option value="SMP/Sederajat" {{ old('pendidikan_terakhir') == 'SMP/Sederajat' ? 'selected' : '' }}>SMP/Sederajat</option>
                    <option value="SMA/Sederajat" {{ old('pendidikan_terakhir') == 'SMA/Sederajat' ? 'selected' : '' }}>SMA/Sederajat</option>
                    <option value="D1/D2/D3" {{ old('pendidikan_terakhir') == 'D1/D2/D3' ? 'selected' : '' }}>D1/D2/D3</option>
                    <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                    <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                    <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                </select>
                @error('pendidikan_terakhir')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" class="glass-select" style="width: 100%; min-height: 80px;">{{ old('alamat') }}</textarea>
            @error('alamat')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="status_hidup">Status Hidup <span class="required">*</span></label>
            <select id="status_hidup" name="status_hidup" class="glass-select" style="width: 100%;" required>
                <option value="hidup" {{ old('status_hidup') == 'hidup' ? 'selected' : '' }}>Hidup</option>
                <option value="meninggal" {{ old('status_hidup') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                <option value="pindah" {{ old('status_hidup') == 'pindah' ? 'selected' : '' }}>Pindah</option>
            </select>
            @error('status_hidup')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Simpan
            </button>
            <a href="{{ route('data-penduduk.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function() {
    let timeout = null;
    const $input = $('#no_kk');
    const $dropdown = $('#kk-dropdown');
    
    $input.on('input', function() {
        const query = $(this).val();
        
        clearTimeout(timeout);
        
        if (query.length < 2) {
            $dropdown.removeClass('show').html('');
            return;
        }
        
        timeout = setTimeout(function() {
            $.ajax({
                url: '{{ route("data-penduduk.cariKk") }}',
                type: 'GET',
                data: { q: query },
                success: function(data) {
                    if (data.length > 0) {
                        let html = '';
                        data.forEach(function(item) {
                            html += `
                                <div class="kk-item" data-no-kk="${item.no_kk}">
                                    <div class="kk-item-no">${item.no_kk}</div>
                                    <div class="kk-item-info">
                                        Kepala: ${item.kepala_keluarga_nik || '-'} | 
                                        Alamat: ${item.alamat || '-'} | 
                                        RT/RW: ${item.rt || '-'}/${item.rw || '-'}
                                    </div>
                                </div>
                            `;
                        });
                        $dropdown.html(html).addClass('show');
                    } else {
                        $dropdown.html('<div class="kk-no-result">No. KK tidak ditemukan</div>').addClass('show');
                    }
                },
                error: function() {
                    $dropdown.removeClass('show');
                }
            });
        }, 300);
    });
    
    $dropdown.on('click', '.kk-item', function() {
        const noKk = $(this).data('no-kk');
        $input.val(noKk);
        $dropdown.removeClass('show');
    });
    
    $(document).click(function(e) {
        if (!$input.is(e.target) && !$dropdown.is(e.target) && !$dropdown.has(e.target).length) {
            $dropdown.removeClass('show');
        }
    });
});
</script>
@endsection
