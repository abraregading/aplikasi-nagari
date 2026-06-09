@extends('kajor.layouts.app')

@section('title', 'Tambah Data Meninggal - ' . $jorongName)

@section('head')
<style>
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem; font-weight: 500; }
    .form-group label .required { color: #ef4444; margin-left: 2px; }
    .form-actions { margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; }
    .error-text { color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem; display: block; }
    .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('kajor.meninggal.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Tambah Data Meninggal</h2>
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
    <form action="{{ route('kajor.meninggal.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nik">Cari Penduduk <span class="required">*</span></label>
            <div style="display: flex; gap: 0.5rem;">
                <input type="text" id="nik_search" placeholder="Ketik NIK penduduk..." class="glass-select" style="width: 100%; max-width: 300px;" autocomplete="off">
                <button type="button" id="btn-cari" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;">
                    <i class="ri-search-line"></i> Cari
                </button>
            </div>
            <input type="hidden" id="penduduk_id" name="penduduk_id">
            <div id="hasil-cari" style="margin-top: 0.5rem;"></div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nik">NIK <span class="required">*</span></label>
                <input type="text" id="nik" name="nik" value="{{ old('nik') }}" placeholder="NIK" class="glass-select" style="width: 100%;" required maxlength="20">
                @error('nik') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap" class="glass-select" style="width: 100%;" required maxlength="100">
                @error('nama_lengkap') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="glass-select" style="width: 100%;" required>
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="glass-select" style="width: 100%;">
                @error('tanggal_lahir') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="no_kk">No. KK</label>
            <input type="text" id="no_kk" name="no_kk" value="{{ old('no_kk') }}" placeholder="Nomor Kartu Keluarga" class="glass-select" style="width: 100%;" maxlength="20">
            @error('no_kk') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tanggal_meninggal">Tanggal Meninggal <span class="required">*</span></label>
                <input type="date" id="tanggal_meninggal" name="tanggal_meninggal" value="{{ old('tanggal_meninggal') }}" class="glass-select" style="width: 100%;" required>
                @error('tanggal_meninggal') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="waktu_meninggal">Waktu Meninggal</label>
                <input type="time" id="waktu_meninggal" name="waktu_meninggal" value="{{ old('waktu_meninggal') }}" class="glass-select" style="width: 100%;">
                @error('waktu_meninggal') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tempat_meninggal">Tempat Meninggal</label>
                <input type="text" id="tempat_meninggal" name="tempat_meninggal" value="{{ old('tempat_meninggal') }}" placeholder="Contoh: Rumah, RSUD, dll" class="glass-select" style="width: 100%;" maxlength="100">
                @error('tempat_meninggal') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="sebab_meninggal">Sebab Meninggal</label>
                <input type="text" id="sebab_meninggal" name="sebab_meninggal" value="{{ old('sebab_meninggal') }}" placeholder="Penyebab kematian" class="glass-select" style="width: 100%;" maxlength="200">
                @error('sebab_meninggal') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="status_hubungan">Status Hubungan dalam KK</label>
                <select id="status_hubungan" name="status_hubungan" class="glass-select" style="width: 100%;">
                    <option value="">-- Pilih Hubungan --</option>
                    <option value="Kepala Keluarga" {{ old('status_hubungan') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                    <option value="Istri" {{ old('status_hubungan') == 'Istri' ? 'selected' : '' }}>Istri</option>
                    <option value="Anak" {{ old('status_hubungan') == 'Anak' ? 'selected' : '' }}>Anak</option>
                    <option value="Menantu" {{ old('status_hubungan') == 'Menantu' ? 'selected' : '' }}>Menantu</option>
                    <option value="Cucu" {{ old('status_hubungan') == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                    <option value="Orang Tua" {{ old('status_hubungan') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                    <option value="Mertua" {{ old('status_hubungan') == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                    <option value="Famili Lain" {{ old('status_hubungan') == 'Famili Lain' ? 'selected' : '' }}>Famili Lain</option>
                    <option value="Lainnya" {{ old('status_hubungan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('status_hubungan') <span class="error-text">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="no_hp_saksi">No. HP Saksi</label>
                <input type="text" id="no_hp_saksi" name="no_hp_saksi" value="{{ old('no_hp_saksi') }}" placeholder="Nomor HP saksi" class="glass-select" style="width: 100%;" maxlength="20">
                @error('no_hp_saksi') <span class="error-text">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="nama_saksi">Nama Saksi</label>
            <input type="text" id="nama_saksi" name="nama_saksi" value="{{ old('nama_saksi', $authUser->name) }}" placeholder="Nama saksi" class="glass-select" style="width: 100%;" maxlength="100">
            @error('nama_saksi') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea id="keterangan" name="keterangan" placeholder="Keterangan tambahan..." class="glass-select" style="width: 100%; min-height: 80px;">{{ old('keterangan') }}</textarea>
            @error('keterangan') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-save-line"></i> Simpan
            </button>
            <a href="{{ route('kajor.meninggal.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="ri-close-line"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    $('#btn-cari').on('click', function() {
        const nik = $('#nik_search').val();
        if (nik.length < 5) {
            $('#hasil-cari').html('<span style="color:#ef4444;font-size:0.85rem;">Masukkan minimal 5 digit NIK</span>');
            return;
        }

        $.ajax({
            url: '{{ route("kajor.meninggal.getPenduduk") }}',
            type: 'GET',
            data: { nik: nik },
            success: function(res) {
                if (res.found) {
                    const d = res.data;
                    $('#penduduk_id').val(d.id);
                    $('#nik').val(d.nik);
                    $('#nama_lengkap').val(d.nama_lengkap);
                    $('#jenis_kelamin').val(d.jenis_kelamin);
                    $('#tanggal_lahir').val(d.tanggal_lahir);
                    $('#no_kk').val(d.no_kk);
                    if (d.status_hubungan) {
                        $('#status_hubungan').val(d.status_hubungan);
                    }
                    $('#hasil-cari').html('<span style="color:#10b981;font-size:0.85rem;"><i class="ri-check-line"></i> Data ditemukan! Form telah diisi otomatis.</span>');
                } else {
                    $('#penduduk_id').val('');
                    $('#hasil-cari').html('<span style="color:#f59e0b;font-size:0.85rem;"><i class="ri-information-line"></i> Data tidak ditemukan. Silakan isi manual.</span>');
                }
            },
            error: function() {
                $('#hasil-cari').html('<span style="color:#ef4444;font-size:0.85rem;">Terjadi kesalahan saat mencari data.</span>');
            }
        });
    });

    $('#nik_search').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#btn-cari').click();
        }
    });
</script>
@endsection
