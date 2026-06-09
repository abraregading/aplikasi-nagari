@extends('operator.layouts.app')

@section('title', 'Tambah Penerima BLT Nagari')

@section('head')
<style>
    .form-section-title {
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
        color: var(--primary);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding-bottom: 0.5rem;
    }
</style>
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Tambah Penerima BLT Nagari</h2>

@if($errors->any())
<div style="background: #fee; border: 1px solid #fcc; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
    <strong style="color: #c00;">Terjadi kesalahan:</strong>
    <ul style="margin: 0.5rem 0 0 1rem; color: #c00;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <h3 class="form-section-title">Cari Penduduk</h3>
    <div style="margin-bottom: 1.5rem;">
        <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Cari NIK / Nama Penduduk</label>
        <div style="display: flex; gap: 0.5rem;">
            <input type="text" id="searchNik" class="glass-select" style="width: 300px;" placeholder="Masukkan NIK atau Nama...">
            <button type="button" id="btnSearch" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 8px; cursor: pointer;">
                <i class="ri-search-line"></i> Cari
            </button>
        </div>
        <div id="searchResults" style="margin-top: 0.5rem;"></div>
    </div>

    <h3 class="form-section-title">Data Penerima</h3>
    <form method="POST" action="{{ route('operator.blt-nagari.store') }}">
        @csrf
        <input type="hidden" name="tahun" value="{{ $tahun }}">
        <input type="hidden" name="penduduk_id" id="penduduk_id" value="{{ old('penduduk_id') }}">

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">NIK <span style="color:#ef4444;">*</span></label>
            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="glass-select" style="width:100%;" required readonly>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Nama Lengkap <span style="color:#ef4444;">*</span></label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="glass-select" style="width:100%;" required readonly>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">No KK</label>
            <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk') }}" class="glass-select" style="width:100%;" readonly>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" class="glass-select" style="width:100%;" readonly>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="glass-select" style="width:100%;" readonly>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Alamat (Jalan)</label>
            <textarea name="alamat_jalan" id="alamat_jalan" class="glass-select" rows="2" style="width:100%; height:auto;" readonly>{{ old('alamat_jalan') }}</textarea>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Jorong</label>
            <input type="text" name="alamat_jorong" id="alamat_jorong" value="{{ old('alamat_jorong') }}" class="glass-select" style="width:100%;" readonly>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Pekerjaan</label>
            <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}" class="glass-select" style="width:100%;" readonly>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Jumlah Anggota Keluarga</label>
            <input type="number" name="jumlah_anggota_keluarga" id="jumlah_anggota_keluarga" value="{{ old('jumlah_anggota_keluarga', 0) }}" class="glass-select" style="width:200px;" readonly>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <a href="{{ route('operator.blt-nagari.index') }}" class="glass-select" style="padding: 0.8rem 1.5rem; text-decoration:none; display:inline-flex; align-items:center; gap:.5rem; margin-right: 0.5rem;">
                <i class="ri-arrow-left-line"></i> Batal
            </a>
            <button type="submit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; display:inline-flex; align-items:center; gap:.5rem; cursor:pointer;">
                <i class="ri-save-line"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    var searchUrl = '{{ route("operator.blt-nagari.getPenduduk") }}';

    document.getElementById('btnSearch').addEventListener('click', function() {
        var query = document.getElementById('searchNik').value.trim();
        if (query.length < 3) {
            alert('Masukkan minimal 3 karakter');
            return;
        }
        fetch(searchUrl + '?q=' + encodeURIComponent(query))
            .then(function(res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(function(data) {
                var container = document.getElementById('searchResults');
                if (!data || data.length === 0) {
                    container.innerHTML = '<div style="color:#ef4444; padding:0.5rem 0;">Data tidak ditemukan</div>';
                    return;
                }
                var html = '<table style="width:100%; border-collapse:collapse; font-size:0.85rem;">';
                html += '<tr style="background:rgba(99,102,241,0.1);"><th style="padding:0.5rem; text-align:left;">NIK</th><th style="padding:0.5rem; text-align:left;">Nama</th><th style="padding:0.5rem; text-align:left;">No KK</th><th style="padding:0.5rem;">Aksi</th></tr>';
                data.forEach(function(p) {
                    html += '<tr style="border-bottom:1px solid rgba(255,255,255,0.05);">';
                    html += '<td style="padding:0.5rem;">' + (p.nik || '-') + '</td>';
                    html += '<td style="padding:0.5rem;">' + (p.nama_lengkap || '-') + '</td>';
                    html += '<td style="padding:0.5rem;">' + (p.no_kk || '-') + '</td>';
                    html += '<td style="padding:0.5rem; text-align:center;"><button type="button" class="glass-select" style="background:var(--primary); color:white; border:none; padding:0.3rem 0.8rem; border-radius:6px; cursor:pointer; font-size:0.8rem;" onclick="pilihPenduduk(' + p.id + ')">Pilih</button></td>';
                    html += '</tr>';
                });
                html += '</table>';
                container.innerHTML = html;
            })
            .catch(function(err) {
                document.getElementById('searchResults').innerHTML = '<div style="color:#ef4444; padding:0.5rem 0;">Error: ' + err.message + '</div>';
            });
    });

    function pilihPenduduk(id) {
        fetch(searchUrl + '?id=' + id)
            .then(function(res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(function(p) {
                document.getElementById('penduduk_id').value = p.id;
                document.getElementById('nik').value = p.nik || '';
                document.getElementById('nama').value = p.nama_lengkap || '';
                document.getElementById('no_kk').value = p.no_kk || '';
                document.getElementById('tempat_lahir').value = p.tempat_lahir || '';
                document.getElementById('tanggal_lahir').value = p.tanggal_lahir || '';
                document.getElementById('alamat_jalan').value = p.alamat || '';
                document.getElementById('alamat_jorong').value = p.jorong || '';
                document.getElementById('pekerjaan').value = p.pekerjaan || '';
                document.getElementById('jumlah_anggota_keluarga').value = p.jumlah_anggota_keluarga || 0;
                document.getElementById('searchResults').innerHTML = '<div style="color:#10b981; padding:0.5rem 0;"><i class="ri-check-line"></i> Data penduduk terpilih: <strong>' + (p.nama_lengkap || '') + '</strong></div>';
            })
            .catch(function(err) {
                document.getElementById('searchResults').innerHTML = '<div style="color:#ef4444; padding:0.5rem 0;">Error: ' + err.message + '</div>';
            });
    }
</script>
@endsection
