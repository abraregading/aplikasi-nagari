@extends('petugas.layouts.app')
@section('title', 'Tambah Penghuni')

@section('head')
<style>
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; }
    .form-control { width: 100%; padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid rgba(0,0,0,0.15); font-size: 0.95rem; background: rgba(255,255,255,0.8); transition: all 0.2s; }
    .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,0.15); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
    .btn { padding: 0.7rem 1.5rem; border-radius: 10px; font-size: 0.9rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s; border: none; cursor: pointer; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: #0284c7; }
    .btn-secondary { background: rgba(107,114,128,0.15); color: #4b5563; }
    .btn-secondary:hover { background: rgba(107,114,128,0.25); }
    .alert { padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
    .alert-danger { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #dc2626; }
    .required { color: red; }
    .info-box { background: rgba(14,165,233,0.1); border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; }
    .info-box h4 { margin: 0 0 0.5rem 0; font-size: 1rem; color: #0ea5e9; }
    .info-box p { margin: 0; font-size: 0.9rem; color: var(--text-muted); }
    .section-title { font-size: 1.1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: var(--primary); }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .button-group { display: flex; gap: 1rem; margin-top: 1.5rem; }
    .nik-search-box { background: rgba(14,165,233,0.1); border-radius: 8px; padding: 1rem; margin-bottom: 1rem; }
    .nik-search-row { display: flex; gap: 0.5rem; align-items: flex-end; flex-wrap: wrap; }
    .nik-search-row > div:first-child { flex: 1; min-width: 150px; }
    .nik-result { margin-top: 0.75rem; display: none; }
    .nik-result-found { background: rgba(16,185,129,0.15); color: #059669; padding: 0.75rem; border-radius: 8px; font-size: 0.9rem; }
    
    @media(max-width:768px) {
        .form-row, .form-row-3 { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
        .page-header h2 { font-size: 1.1rem; }
        .nik-search-row { flex-direction: column; }
        .nik-search-row > div { width: 100%; }
        .nik-search-row .btn { width: 100%; justify-content: center; }
        .button-group { flex-direction: column; }
        .button-group .btn { width: 100%; justify-content: center; }
    }
    @media(max-width:480px) {
        .glass { padding: 1rem !important; }
        .form-group { margin-bottom: 1rem; }
        .section-title { font-size: 1rem; }
        h4 { font-size: 0.95rem; }
    }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-user-add-line" style="color: var(--primary)"></i> Tambah Penghuni</h2>
    <a href="{{ route('petugas.bisniskos.penghuni.index', $bisnis->id) }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
</div>

<div class="info-box">
    <h4>{{ $bisnis->nama_usaha }}</h4>
    <p>{{ $bisnis->alamat }}</p>
</div>

<div    >
    <div class="glass" style="padding: 1.5rem; border-radius: 16px;">
        @if($errors->any())
        <div class="alert alert-danger">
            <i class="ri-error-warning-line"></i>
            <div>
                <strong>Terjadi kesalahan:</strong>
                <ul style="margin: .5rem 0 0 1rem;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('petugas.bisniskos.penghuni.store', $bisnis->id) }}">
            @csrf

            <h4 class="section-title">Data Penghuni</h4>

            <div class="nik-search-box">
                <div class="nik-search-row">
                    <div>
                        <label style="font-size: 0.85rem; font-weight: 500; margin-bottom: 0.25rem; display: block;">Cari NIK di Database Warga</label>
                        <input type="text" id="search_nik_penghuni" class="form-control" placeholder="Masukkan NIK dan tekan Enter">
                    </div>
                    <button type="button" onclick="searchPenghuni()" class="btn btn-primary">
                        <i class="ri-search-line"></i> Cari
                    </button>
                    <button type="button" onclick="clearPenghuni()" class="btn btn-secondary">
                        Manual
                    </button>
                </div>
                <div id="penghuni_result" class="nik-result">
                    <div class="nik-result-found">
                        <strong>Ditemukan!</strong> <span id="penghuni_nama_text"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" placeholder="Nomor KTP">
                </div>
                <div class="form-group">
                    <label for="jekel">Jenis Kelamin</label>
                    <select name="jekel" id="jekel" class="form-control">
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jekel') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jekel') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="form-row-3">
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                </div>
                <div class="form-group">
                    <label for="pekerjaan">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="asal_desa">Alamat Asal (Desa/Kelurahan)</label>
                <input type="text" name="asal_desa" id="asal_desa" class="form-control" value="{{ old('asal_desa') }}">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="asal_kecamatan">Kecamatan</label>
                    <input type="text" name="asal_kecamatan" id="asal_kecamatan" class="form-control" value="{{ old('asal_kecamatan') }}">
                </div>
                <div class="form-group">
                    <label for="asal_kabupaten">Kabupaten</label>
                    <input type="text" name="asal_kabupaten" id="asal_kabupaten" class="form-control" value="{{ old('asal_kabupaten') }}">
                </div>
            </div>

            <h4 class="section-title">Informasi Kamar</h4>

            <div class="form-row">
                <div class="form-group">
                    <label for="no_kamar">No. Kamar</label>
                    <input type="text" name="no_kamar" id="no_kamar" class="form-control" value="{{ old('no_kamar') }}" placeholder="Contoh: Kamar 01">
                </div>
                <div class="form-group">
                    <label for="harga_sewa">Harga Sewa (Rp)</label>
                    <input type="number" name="harga_sewa" id="harga_sewa" class="form-control" value="{{ old('harga_sewa') }}" min="0">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}">
                </div>
                <div class="form-group">
                    <label for="status">Status <span class="required">*</span></label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="pindah" {{ old('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                        <option value="keluar" {{ old('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="tanggal_keluar">Tanggal Keluar (jika sudah keluar)</label>
                <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" value="{{ old('tanggal_keluar') }}">
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea name="catatan" id="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i> Simpan
                </button>
                <a href="{{ route('petugas.bisniskos.penghuni.index', $bisnis->id) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
function searchPenghuni() {
    const nik = document.getElementById('search_nik_penghuni').value;
    if (!nik) {
        alert('Masukkan NIK terlebih dahulu');
        return;
    }
    
    fetch('{{ route("petugas.bisniskos.searchnik") }}?nik=' + nik)
        .then(response => response.json())
        .then(data => {
            if (data.found) {
                document.getElementById('nama_lengkap').value = data.data.nama_lengkap;
                document.getElementById('nik').value = data.data.nik;
                document.getElementById('jekel').value = data.data.jenis_kelamin === 'Laki-laki' ? 'L' : 'P';
                document.getElementById('tempat_lahir').value = data.data.tempat_lahir || '';
                document.getElementById('tanggal_lahir').value = data.data.tanggal_lahir || '';
                document.getElementById('pekerjaan').value = data.data.pekerjaan || '';
                
                document.getElementById('penghuni_result').style.display = 'block';
                document.getElementById('penghuni_nama_text').textContent = data.data.nama_lengkap + ' (NIK: ' + data.data.nik + ')';
            } else {
                alert('NIK tidak ditemukan di database. Silakan input manual.');
                document.getElementById('penghuni_result').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat pencarian');
        });
}

function clearPenghuni() {
    document.getElementById('search_nik_penghuni').value = '';
    document.getElementById('penghuni_result').style.display = 'none';
}

document.getElementById('search_nik_penghuni').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchPenghuni();
    }
});
</script>
@endsection