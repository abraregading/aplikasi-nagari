@extends('petugas.layouts.app')
@section('title', 'Tambah Usaha Kos/Kontrakan')

@section('head')
<style>
    .form-container { max-width: 1200px; margin: 0 auto; }
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
    .section-title { font-size: 1.1rem; font-weight: 600; margin: 1.5rem 0 1rem; color: var(--primary); }
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
<div>
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="margin: 0; font-size: 1.4rem;"><i class="ri-home-4-line" style="color: var(--primary)"></i> Tambah Usaha Kos/Kontrakan</h2>
        <a href="{{ route('petugas.bisniskos.index') }}" style="padding: 0.6rem 1.2rem; border-radius: 10px; background: rgba(107,114,128,0.15); color: #4b5563; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; font-weight: 600; font-size: 0.9rem;">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>

    <div class="glass" style="padding: 1.5rem; border-radius: 16px;">
        @if($errors->any())
        <div class="alert alert-danger">
            <i class="ri-error-warning-line"></i>
            <div>
                <strong>Terjadi kesalahan:</strong>
                <ul style="margin: 0.5rem 0 0 1rem;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('petugas.bisniskos.store') }}">
            @csrf

            <h4 style="margin-bottom: 1rem; color: var(--primary);">Informasi Usaha</h4>
            
            <div class="form-group">
                <label for="nama_usaha">Nama Usaha <span class="required">*</span></label>
                <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" value="{{ old('nama_usaha') }}" required placeholder="Contoh: Kos Putri Melati">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="jenis_usaha">Jenis Usaha <span class="required">*</span></label>
                    <select name="jenis_usaha" id="jenis_usaha" class="form-control" required>
                        <option value="">Pilih Jenis</option>
                        <option value="kos" {{ old('jenis_usaha') == 'kos' ? 'selected' : '' }}>Kos</option>
                        <option value="kontrakan" {{ old('jenis_usaha') == 'kontrakan' ? 'selected' : '' }}>Kontrakan</option>
                        <option value="rumah_petak" {{ old('jenis_usaha') == 'rumah_petak' ? 'selected' : '' }}>Rumah Petak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah_kamar">Jumlah Kamar</label>
                    <input type="number" name="jumlah_kamar" id="jumlah_kamar" class="form-control" value="{{ old('jumlah_kamar') }}" min="0" placeholder="Jumlah kamar">
                </div>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat <span class="required">*</span></label>
                <textarea name="alamat" id="alamat" class="form-control" rows="2" required placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="rt">Jorong</label>
                    <input type="text" name="`jorong`" id="`jorong`" class="form-control" value="{{ old('`jorong`') }}" placeholder="Nama Jorong">
                </div>
                <div class="form-group">
                    <label for="desa_kelurahan">Desa/Kelurahan</label>
                    <input type="text" name="desa_kelurahan" id="desa_kelurahan" class="form-control" value="{{ old('desa_kelurahan') }}" placeholder="Desa/Kelurahan">
                </div>
            </div>
            

            <h4 class="section-title">Informasi Pemilik</h4>

            <div class="nik-search-box">
                <div class="nik-search-row">
                    <div>
                        <label style="font-size: 0.85rem; font-weight: 500; margin-bottom: 0.25rem; display: block;">Cari NIK di Database</label>
                        <input type="text" id="search_nik_pemilik" class="form-control" placeholder="Masukkan NIK dan tekan Enter">
                    </div>
                    <button type="button" onclick="searchPemilik()" class="btn btn-primary">
                        <i class="ri-search-line"></i> Cari
                    </button>
                    <button type="button" onclick="clearPemilik()" class="btn btn-secondary">
                        Manual
                    </button>
                </div>
                <div id="pemilik_result" class="nik-result">
                    <div class="nik-result-found">
                        <strong>Ditemukan!</strong> <span id="pemilik_nama_text"></span>
                    </div>
                </div>
            </div>
            <button type="button" onclick="searchPemilik()" style="padding: 0.6rem 1rem; border-radius: 10px; background: var(--primary); color: #fff; border: none; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.9rem;">
                <i class="ri-search-line"></i> Cari
            </button>
            <button type="button" onclick="clearPemilik()" style="padding: 0.6rem 1rem; border-radius: 10px; background: rgba(107,114,128,0.15); color: #4b5563; border: none; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.9rem;">
                Manual
            </button>
                <div id="pemilik_result" style="margin-top: 0.75rem; display: none;">
                    <div style="background: rgba(16,185,129,0.15); color: #059669; padding: 0.75rem; border-radius: 8px; font-size: 0.9rem;">
                        <strong>Ditemukan!</strong> <span id="pemilik_nama_text"></span>
                    </div>
                </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="pemilik_nama">Nama Pemilik <span class="required">*</span></label>
                    <input type="text" name="pemilik_nama" id="pemilik_nama" class="form-control" value="{{ old('pemilik_nama') }}" required>
                </div>
                <div class="form-group">
                    <label for="pemilik_nik">NIK Pemilik</label>
                    <input type="text" name="pemilik_nik" id="pemilik_nik" class="form-control" value="{{ old('pemilik_nik') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="pemilik_telepon">No. Telepon</label>
                    <input type="text" name="pemilik_telepon" id="pemilik_telepon" class="form-control" value="{{ old('pemilik_telepon') }}">
                </div>
                <div class="form-group">
                    <label for="status">Status <span class="required">*</span></label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea name="catatan" id="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i> Simpan
                </button>
                <a href="{{ route('petugas.bisniskos.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
function searchPemilik() {
    const nik = document.getElementById('search_nik_pemilik').value;
    if (!nik) {
        alert('Masukkan NIK terlebih dahulu');
        return;
    }
    
    fetch('{{ route("petugas.bisniskos.searchnik") }}?nik=' + nik)
        .then(response => response.json())
        .then(data => {
            if (data.found) {
                document.getElementById('pemilik_nama').value = data.data.nama_lengkap;
                document.getElementById('pemilik_nik').value = data.data.nik;
                document.getElementById('pemilik_result').style.display = 'block';
                document.getElementById('pemilik_nama_text').textContent = data.data.nama_lengkap + ' (NIK: ' + data.data.nik + ')';
            } else {
                alert('NIK tidak ditemukan di database. Silakan input manual.');
                document.getElementById('pemilik_result').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat pencarian');
        });
}

function clearPemilik() {
    document.getElementById('search_nik_pemilik').value = '';
    document.getElementById('pemilik_result').style.display = 'none';
    document.getElementById('pemilik_nama').value = '';
    document.getElementById('pemilik_nik').value = '';
}

// Enable Enter key to search
document.getElementById('search_nik_pemilik').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchPemilik();
    }
});
</script>
@endsection