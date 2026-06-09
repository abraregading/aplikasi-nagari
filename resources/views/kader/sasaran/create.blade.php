@extends('kader.layouts.app')

@section('title', 'Tambah Sasaran Pos Yandu')

@section('head')
<style>
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem; font-weight: 500; }
    .form-group label .required { color: #ef4444; margin-left: 2px; }
    .form-actions { margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; }
    .error-text { color: #ef4444; font-size: 0.8rem; margin-top: 0.3rem; display: block; }

    .step-section {
        background: var(--bg-glass);
        border: 1px solid var(--border-glass);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .step-section .step-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .step-section .step-title .step-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .info-keluarga {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        padding: 1rem;
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        border: 1px solid var(--border-glass);
        margin-bottom: 1rem;
    }
    .info-keluarga .item { }
    .info-keluarga .item .label { font-size: 0.8rem; color: var(--text-muted); }
    .info-keluarga .item .value { font-weight: 600; color: var(--text-main); }

    .anggota-checkbox {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-glass);
        border-radius: 10px;
        margin-bottom: 0.5rem;
        transition: 0.2s;
        cursor: pointer;
    }
    .anggota-checkbox:hover { background: rgba(99, 102, 241, 0.05); border-color: var(--primary); }
    .anggota-checkbox input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--primary); cursor: pointer; }
    .anggota-checkbox .info { flex: 1; }
    .anggota-checkbox .info .nama { font-weight: 600; }
    .anggota-checkbox .info .detail { font-size: 0.85rem; color: var(--text-muted); }

    .anggota-baru-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1rem;
        padding: 1rem;
        background: rgba(255,255,255,0.03);
        border-radius: 12px;
        border: 1px solid var(--border-glass);
        margin-bottom: 0.75rem;
    }
    .anggota-baru-row .baru-number { font-weight: 600; color: var(--primary); font-size: 0.85rem; margin-bottom: 0.5rem; grid-column: 1 / -1; }
    @media (max-width: 768px) { .anggota-baru-row { grid-template-columns: 1fr; } }

    .hidden { display: none; }
    .loading-spinner { display: inline-block; width: 20px; height: 20px; border: 2px solid var(--border-glass); border-top-color: var(--primary); border-radius: 50%; animation: spin 0.6s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 480px) {
        .step-section {
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .step-section .step-title {
            font-size: 0.9rem;
        }
        .info-keluarga {
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            padding: 0.75rem;
        }
        .anggota-checkbox {
            padding: 0.5rem 0.6rem;
            font-size: 0.85rem;
        }
        .anggota-checkbox .info .detail {
            font-size: 0.75rem;
        }
        .form-actions {
            flex-direction: column;
        }
        .form-actions button,
        .form-actions a {
            justify-content: center;
            text-align: center;
            width: 100%;
        }
        #no_kk {
            font-size: 0.85rem;
        }
        .glass-select {
            font-size: 0.85rem;
        }
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
    <a href="{{ route('kader.sasaran.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
    <h2 style="margin: 0;">Tambah Sasaran Baru</h2>
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

<form action="{{ route('kader.sasaran.store') }}" method="POST" id="formSasaran">
    @csrf
    <input type="hidden" name="keluarga_id" id="keluarga_id" value="">

    {{-- Step 1: Cari Keluarga --}}
    <div class="step-section">
        <div class="step-title"><span class="step-num">1</span> Cari Keluarga</div>
        <div class="form-group" style="margin-bottom: 0;">
            <label for="no_kk">Masukkan No. KK atau Nama Ibu/Ayah <span class="required">*</span></label>
            <div style="display: flex; gap: 0.5rem;">
                <input type="text" id="no_kk" name="no_kk" value="{{ old('no_kk') }}" class="glass-select" style="flex: 1;" placeholder="Ketik No. KK (16 digit) atau nama ibu/ayah" required>
                <button type="button" id="btnCariKk" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="ri-search-line"></i> Cari
                </button>
            </div>
            <div id="loadingKk" class="hidden" style="margin-top: 0.5rem;"><span class="loading-spinner"></span> Mencari data...</div>
            <div id="errorKk" class="hidden" style="margin-top: 0.5rem; color: #ef4444; font-size: 0.9rem;"></div>
            <div id="hasilPencarian" class="hidden" style="margin-top: 1rem;"></div>
        </div>
    </div>

    {{-- Step 2: Info Keluarga --}}
    <div id="stepInfoKeluarga" class="step-section hidden">
        <div class="step-title"><span class="step-num">2</span> Informasi Keluarga</div>
        <div id="infoKeluargaContent" class="info-keluarga"></div>
    </div>

    {{-- Step 3: Pilih Anggota --}}
    <div id="stepPilihAnggota" class="step-section hidden">
        <div class="step-title"><span class="step-num">3</span> Pilih Anggota Keluarga</div>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">Centang anggota keluarga yang menjadi sasaran pos yandu:</p>
        <div id="daftarAnggota"></div>
    </div>

    {{-- Step 4: Tambah Anggota Baru --}}
    <div id="stepTambahBaru" class="step-section hidden">
        <div class="step-title"><span class="step-num">4</span> Tambah Anggota Baru (Bayi Baru Lahir)</div>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">Isi data jika ada anggota keluarga baru (misal: bayi baru lahir) yang belum terdaftar di data penduduk.</p>
        <div id="daftarAnggotaBaru"></div>
        <button type="button" id="btnTambahBaru" class="glass-select" style="background: transparent; color: var(--primary); border: 1px dashed var(--primary); padding: 0.6rem 1rem; font-weight: 500; cursor: pointer; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;">
            <i class="ri-add-line"></i> Tambah Anggota Baru
        </button>
    </div>

    {{-- Submit --}}
    <div class="form-actions">
        <button type="submit" id="btnSubmit" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;" disabled>
            <i class="ri-save-line"></i> Simpan Semua Target
        </button>
        <a href="{{ route('kader.sasaran.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="ri-close-line"></i> Batal
        </a>
    </div>
</form>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    let counterBaru = 0;

    $('#btnCariKk').click(function() {
        var noKk = $('#no_kk').val().trim();
        if (!noKk) { alert('Masukkan No. KK terlebih dahulu.'); return; }

        $('#loadingKk').removeClass('hidden');
        $('#errorKk').addClass('hidden');
        $('#stepInfoKeluarga').addClass('hidden');
        $('#stepPilihAnggota').addClass('hidden');
        $('#stepTambahBaru').addClass('hidden');
        $('#btnSubmit').prop('disabled', true);

        $.ajax({
            url: '{{ route("kader.sasaran.cariKk") }}',
            method: 'GET',
            data: { q: noKk },
            dataType: 'json',
            success: function(res) {
                $('#loadingKk').addClass('hidden');
                $('#errorKk').addClass('hidden');
                $('#hasilPencarian').addClass('hidden');

                if (!res.found) {
                    $('#errorKk').text(res.message).removeClass('hidden');
                    return;
                }

                // Banyak hasil (cari berdasarkan nama)
                if (res.multiple) {
                    var html = '<p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.75rem;">Ditemukan ' + res.results.length + ' keluarga. Pilih salah satu:</p>';
                    html += '<div style="display: flex; flex-direction: column; gap: 0.5rem;">';
                    $.each(res.results, function(i, r) {
                        html += '<div class="anggota-checkbox" onclick="pilihKeluarga(' + r.id + ', \'' + r.no_kk + '\')">';
                        html += '<div class="info">';
                        html += '<div class="nama">' + escapeHtml(r.kepala_keluarga || '-') + ' — ' + r.no_kk + '</div>';
                        html += '<div class="detail">Ibu: ' + escapeHtml(r.nama_ibu || '-') + ' &bull; ' + (r.alamat || '-') + ' &bull; ' + (r.jumlah_anggota || '0') + ' anggota</div>';
                        html += '</div></div>';
                    });
                    html += '</div>';
                    $('#hasilPencarian').html(html).removeClass('hidden');
                    return;
                }

                // Satu hasil (cari berdasarkan KK)
                $('#hasilPencarian').addClass('hidden');
                var d = res.data;
                $('#keluarga_id').val(d.id);

                var htmlInfo = '';
                htmlInfo += '<div class="item"><div class="label">Kepala Keluarga</div><div class="value">' + (d.kepala_keluarga || '-') + '</div></div>';
                htmlInfo += '<div class="item"><div class="label">No. KK</div><div class="value">' + d.no_kk + '</div></div>';
                htmlInfo += '<div class="item"><div class="label">Alamat</div><div class="value">' + (d.alamat || '-') + '</div></div>';
                htmlInfo += '<div class="item"><div class="label">RT/RW</div><div class="value">' + (d.rt || '-') + ' / ' + (d.rw || '-') + '</div></div>';
                htmlInfo += '<div class="item"><div class="label">Desa</div><div class="value">' + (d.desa_kelurahan || '-') + '</div></div>';
                htmlInfo += '<div class="item"><div class="label">Kecamatan</div><div class="value">' + (d.kecamatan || '-') + '</div></div>';
                htmlInfo += '<div class="item"><div class="label">Jumlah Anggota</div><div class="value">' + (d.jumlah_anggota || '0') + ' Orang</div></div>';
                $('#infoKeluargaContent').html(htmlInfo);
                $('#stepInfoKeluarga').removeClass('hidden');

                loadAnggota(noKk);
            },
            error: function(xhr) {
                $('#loadingKk').addClass('hidden');
                var msg = 'Terjadi kesalahan saat mencari data.';
                if (xhr.status === 404) msg += ' (Halaman tidak ditemukan)';
                else if (xhr.status === 500) msg += ' (Kesalahan server)';
                else if (xhr.status === 422) msg += ' (Validasi gagal)';
                $('#errorKk').text(msg).removeClass('hidden');
            }
        });
    });

    function loadAnggota(noKk) {
        $.ajax({
            url: '{{ route("kader.sasaran.anggotaByKk") }}',
            method: 'GET',
            data: { no_kk: noKk },
            dataType: 'json',
            success: function(res) {
                if (!res.found || !res.anggota || res.anggota.length === 0) {
                    $('#daftarAnggota').html('<p style="color: var(--text-muted);">Tidak ada anggota keluarga ditemukan.</p>');
                    $('#stepPilihAnggota').removeClass('hidden');
                    $('#stepTambahBaru').removeClass('hidden');
                    return;
                }

                var html = '';
                $.each(res.anggota, function(i, a) {
                    var tgl = a.tanggal_lahir ? new Date(a.tanggal_lahir).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : '-';
                    var jkLabel = a.jenis_kelamin === 'L' ? 'Laki-laki' : (a.jenis_kelamin === 'P' ? 'Perempuan' : '-');
                    html += '<label class="anggota-checkbox">';
                    html += '<input type="checkbox" class="cb-anggota" data-penduduk-id="' + (a.id || '') + '" data-nama="' + escapeHtml(a.nama_lengkap) + '" data-nik="' + (a.nik || '') + '" data-tempat-lahir="' + (a.tempat_lahir || '') + '" data-tanggal-lahir="' + (a.tanggal_lahir || '') + '" data-jk="' + (a.jenis_kelamin || '') + '" data-nama-ibu="' + escapeHtml(a.nama_ibu || '') + '" data-hubungan="' + escapeHtml(a.hubungan_keluarga || '') + '">';
                    html += '<div class="info">';
                    html += '<div class="nama">' + escapeHtml(a.nama_lengkap) + '</div>';
                    html += '<div class="detail">' + jkLabel + ' &bull; ' + tgl + ' &bull; ' + escapeHtml(a.hubungan_keluarga || '-') + '</div>';
                    if (a.nama_ibu) html += '<div class="detail" style="color: var(--primary);">Ibu: ' + escapeHtml(a.nama_ibu) + '</div>';
                    html += '</div></label>';
                });
                $('#daftarAnggota').html(html);
                $('#stepPilihAnggota').removeClass('hidden');
                $('#stepTambahBaru').removeClass('hidden');
                checkSubmitState();
                $('.cb-anggota').change(checkSubmitState);
            },
            error: function() {
                $('#daftarAnggota').html('<p style="color: #ef4444;">Gagal memuat data anggota.</p>');
                $('#stepPilihAnggota').removeClass('hidden');
                $('#stepTambahBaru').removeClass('hidden');
            }
        });
    }

    $('#btnTambahBaru').click(function() {
        var idx = counterBaru++;
        var html = '<div class="anggota-baru-row" id="baru-' + idx + '">';
        html += '<div style="grid-column: 1 / -1; display: flex; justify-content: space-between; align-items: center;">';
        html += '<span class="baru-number">Anggota Baru #' + (idx + 1) + '</span>';
        html += '<button type="button" class="glass-select" style="background: rgba(239,68,68,0.15); color:#ef4444; border:none; padding:0.3rem 0.6rem; font-size:0.8rem; cursor:pointer;" onclick="hapusBaru(' + idx + ')"><i class="ri-close-line"></i></button>';
        html += '</div>';
        html += '<div class="form-group" style="margin-bottom:0;"><label>Nama Lengkap <span class="required">*</span></label><input type="text" name="anggota[' + (100 + idx) + '][nama_lengkap]" class="glass-select" style="width:100%;" placeholder="Nama bayi"></div>';
        html += '<div class="form-group" style="margin-bottom:0;"><label>Tanggal Lahir</label><input type="date" name="anggota[' + (100 + idx) + '][tanggal_lahir]" class="glass-select" style="width:100%;"></div>';
        html += '<div class="form-group" style="margin-bottom:0;"><label>Jenis Kelamin</label><select name="anggota[' + (100 + idx) + '][jenis_kelamin]" class="glass-select" style="width:100%;"><option value="">-- Pilih --</option><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>';
        html += '<div class="form-group" style="margin-bottom:0;"><label>Nama Ibu</label><input type="text" name="anggota[' + (100 + idx) + '][nama_ibu]" class="glass-select" style="width:100%;" placeholder="Nama ibu"></div>';
        html += '<div class="form-group" style="margin-bottom:0;"><label>Nama Ayah</label><input type="text" name="anggota[' + (100 + idx) + '][nama_ayah]" class="glass-select" style="width:100%;" placeholder="Nama ayah"></div>';
        html += '</div>';
        $('#daftarAnggotaBaru').append(html);
        checkSubmitState();
    });

    function hapusBaru(idx) {
        $('#baru-' + idx).remove();
        checkSubmitState();
    }

    function pilihKeluarga(id, noKk) {
        $('#keluarga_id').val(id);
        $('#hasilPencarian').addClass('hidden');

        var htmlInfo = '';
        htmlInfo += '<div class="item"><div class="label">No. KK</div><div class="value">' + noKk + '</div></div>';
        htmlInfo += '<div class="item"><div class="label">Memuat data...</div><div class="value" style="color:var(--text-muted);">Silakan tunggu</div></div>';
        $('#infoKeluargaContent').html(htmlInfo);
        $('#stepInfoKeluarga').removeClass('hidden');

        loadAnggota(noKk);
    }

    function checkSubmitState() {
        var checked = $('.cb-anggota:checked').length > 0;
        var baru = $('#daftarAnggotaBaru').children().length > 0;
        var hasBaruFilled = false;
        $('#daftarAnggotaBaru input[name$="[nama_lengkap]"]').each(function() {
            if ($(this).val().trim() !== '') hasBaruFilled = true;
        });
        $('#btnSubmit').prop('disabled', !(checked || baru > 0));
    }

    $(document).on('change', '#daftarAnggotaBaru input', checkSubmitState);
    $(document).on('change', '#daftarAnggotaBaru select', checkSubmitState);

    function escapeHtml(str) {
        if (!str) return '';
        return $('<span>').text(str).html();
    }

    $('#formSasaran').submit(function(e) {
        var checked = $('.cb-anggota:checked').length > 0;
        var hasBaru = false;
        $('#daftarAnggotaBaru input[name$="[nama_lengkap]"]').each(function() {
            if ($(this).val().trim() !== '') hasBaru = true;
        });
        if (!checked && !hasBaru) {
            e.preventDefault();
            alert('Pilih minimal satu anggota keluarga atau isi data anggota baru.');
            return;
        }

        // Hapus hidden fields lama (jika ada)
        $('.hidden-anggota-data').remove();

        // Tambah hidden fields hanya untuk checkbox yang dicentang
        var idx = 0;
        $('.cb-anggota:checked').each(function() {
            var $cb = $(this);
            var form = $('#formSasaran');
            form.append('<input type="hidden" name="anggota[' + idx + '][penduduk_id]" value="' + $cb.data('penduduk-id') + '" class="hidden-anggota-data">');
            form.append('<input type="hidden" name="anggota[' + idx + '][nama_lengkap]" value="' + $cb.data('nama') + '" class="hidden-anggota-data">');
            form.append('<input type="hidden" name="anggota[' + idx + '][nik]" value="' + ($cb.data('nik') || '') + '" class="hidden-anggota-data">');
            form.append('<input type="hidden" name="anggota[' + idx + '][tempat_lahir]" value="' + ($cb.data('tempat-lahir') || '') + '" class="hidden-anggota-data">');
            form.append('<input type="hidden" name="anggota[' + idx + '][tanggal_lahir]" value="' + ($cb.data('tanggal-lahir') || '') + '" class="hidden-anggota-data">');
            form.append('<input type="hidden" name="anggota[' + idx + '][jenis_kelamin]" value="' + ($cb.data('jk') || '') + '" class="hidden-anggota-data">');
            form.append('<input type="hidden" name="anggota[' + idx + '][nama_ibu]" value="' + ($cb.data('nama-ibu') || '') + '" class="hidden-anggota-data">');
            form.append('<input type="hidden" name="anggota[' + idx + '][hubungan_keluarga]" value="' + ($cb.data('hubungan') || '') + '" class="hidden-anggota-data">');
            idx++;
        });

        // Renum anggota baru agar index lanjutan
        $('#daftarAnggotaBaru .anggota-baru-row').each(function() {
            $(this).find('input, select').each(function() {
                var name = $(this).attr('name');
                if (name) {
                    name = name.replace(/anggota\[\d+\]/, 'anggota[' + idx + ']');
                    $(this).attr('name', name);
                }
            });
            idx++;
        });
    });
</script>
@endsection
