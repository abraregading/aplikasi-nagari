@extends('petugas.layouts.app')
@section('title', 'Edit Kartu Keluarga')

@section('head')
<style>
    .page-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }
    .form-section { margin-bottom: 1.5rem; }
    .form-section h3 { font-size: 1rem; margin-bottom: 1rem; color: var(--primary); }
    .form-grid { display: grid; gap: 1rem; }
    .form-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
    .form-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }
    @media(max-width: 768px) { .form-grid.cols-2, .form-grid.cols-3 { grid-template-columns: 1fr; } }
    .form-group { display: flex; flex-direction: column; gap: .4rem; }
    .form-group label { font-size: .9rem; font-weight: 500; color: var(--text-muted); }
    .form-group label .required { color: #dc2626; }

    /* Form inputs - light theme compatible */
    .form-input {
        padding: .7rem 1rem;
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,.12);
        background: rgba(255,255,255,.7);
        color: var(--text-main);
        font-size: .95rem;
        font-family: inherit;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,.12); }
    .form-input::placeholder { color: var(--text-muted); }
    select.form-input { cursor: pointer; }
    textarea.form-input { resize: vertical; min-height: 80px; }

    /* Buttons */
    .btn { padding: .8rem 1.5rem; border-radius: 10px; font-weight: 600; font-size: .9rem; text-decoration: none; display: inline-flex; align-items: center; gap: .5rem; transition: all .2s; cursor: pointer; border: none; font-family: inherit; }
    .btn-success { background: #10b981; color: #fff; }
    .btn-success:hover { background: #059669; }
    .btn-secondary { background: transparent; color: var(--text-main); border: 1px solid rgba(0,0,0,.15); }
    .btn-secondary:hover { background: rgba(0,0,0,.03); }
    .btn-group { display: flex; gap: 1rem; margin-top: 1.5rem; }

    /* Alerts */
    .alert { padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; }
    .alert-error { background: rgba(239,68,68,.08); border: 1px solid rgba(239,68,68,.2); color: #dc2626; }
    .alert ul { margin: .5rem 0 0 1.5rem; }

    /* Info box */
    .info-box {
        padding: 1rem;
        border-radius: 10px;
        background: rgba(14,165,233,.08);
        border: 1px solid rgba(14,165,233,.15);
        margin-bottom: 1rem;
        font-size: .85rem;
        color: #0369a1;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    /* Anggota table - light theme */
    .family-table-wrap {
        overflow-x: auto;
        margin-top: 1rem;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,.08);
    }
    .family-table { width: 100%; border-collapse: collapse; font-size: .85rem; }
    .family-table th {
        background: rgba(14,165,233,.08);
        padding: .75rem .5rem;
        text-align: left;
        color: #0369a1;
        font-weight: 600;
        white-space: nowrap;
        border-bottom: 2px solid rgba(14,165,233,.12);
    }
    .family-table td {
        padding: .6rem .5rem;
        border-bottom: 1px solid rgba(0,0,0,.04);
    }
    .family-table tr:hover td { background: rgba(14,165,233,.03); }
    .family-table input, .family-table select {
        width: 100%;
        padding: .4rem .5rem;
        border-radius: 6px;
        border: 1px solid rgba(0,0,0,.1);
        background: rgba(255,255,255,.8);
        color: var(--text-main);
        font-size: .82rem;
        min-width: 90px;
        font-family: inherit;
    }
    .family-table input:focus, .family-table select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(14,165,233,.1);
    }
    .family-table input[readonly] {
        background: rgba(0,0,0,.03);
        color: var(--text-muted);
    }
    .btn-add-member {
        margin-top: 1rem;
        background: rgba(16,185,129,.1);
        color: #059669;
        border: 1px dashed rgba(16,185,129,.3);
    }
    .btn-add-member:hover {
        background: rgba(16,185,129,.2);
    }
    .btn-delete-member {
        background: rgba(239,68,68,.1);
        color: #dc2626;
        border: none;
        padding: .3rem .5rem;
        border-radius: 6px;
        cursor: pointer;
    }
    .btn-delete-member:hover {
        background: rgba(239,68,68,.2);
    }
</style>
@endsection

@section('konten')
<div class="page-header">
    <a href="{{ route('petugas.pendataankeluarga.index') }}" class="glass-select" style="background: transparent; border: 1px solid var(--text-muted); padding: .5rem 1rem; color: var(--text-main); text-decoration: none;">
        <i class="ri-arrow-left-line"></i>
    </a>
    <h2>Edit Data Kartu Keluarga</h2>
</div>

@if($errors->any())
<div class="alert alert-error">
    <i class="ri-error-warning-line"></i> Terdapat kesalahan:
    <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif
@if(session('error'))
<div class="alert alert-error"><i class="ri-error-warning-line"></i> {{ session('error') }}</div>
@endif

<form action="{{ route('petugas.pendataankeluarga.update', $keluarga->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- KK Info Section --}}
    <div class="glass" style="padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
        <div class="form-section">
            <h3><i class="ri-home-line"></i> Data Kartu Keluarga</h3>
            <div class="info-box">
                <i class="ri-information-line"></i> Data di bawah ini diambil dari database. Perbarui sesuai kondisi terkini lalu simpan.
            </div>
            <div class="form-grid cols-2">
                <div class="form-group">
                    <label>No. KK <span class="required">*</span></label>
                    <input type="text" name="no_kk" class="form-input" value="{{ old('no_kk', $keluarga->no_kk) }}" maxlength="16" required>
                </div>
                <div class="form-group">
                    <label>NIK Kepala Keluarga</label>
                    <input type="text" name="kepala_keluarga_nik" class="form-input" value="{{ old('kepala_keluarga_nik', $keluarga->kepala_keluarga_nik) }}" maxlength="20">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Alamat <span class="required">*</span></label>
                    <textarea name="alamat" class="form-input" required>{{ old('alamat', $keluarga->alamat) }}</textarea>
                </div>
            </div>
            <div class="form-grid cols-3" style="margin-top: 1rem;">
                <div class="form-group">
                    <label>Jorong</label>
                    <input type="text" name="jorong" class="form-input" value="{{ old('jorong', $keluarga->jorong) }}" maxlength="50">
                </div>
                <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" name="kode_pos" class="form-input" value="{{ old('kode_pos', $keluarga->kode_pos) }}" maxlength="10">
                </div>
                <div class="form-group">
                    <label>Desa/Kelurahan</label>
                    <input type="text" name="desa_kelurahan" class="form-input" value="{{ old('desa_kelurahan', $keluarga->desa_kelurahan) }}">
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-input" value="{{ old('kecamatan', $keluarga->kecamatan) }}">
                </div>
                <div class="form-group">
                    <label>Kabupaten/Kota</label>
                    <input type="text" name="kabupaten_kota" class="form-input" value="{{ old('kabupaten_kota', $keluarga->kabupaten_kota) }}">
                </div>
                <div class="form-group">
                    <label>Provinsi</label>
                    <input type="text" name="provinsi" class="form-input" value="{{ old('provinsi', $keluarga->provinsi) }}">
                </div>
                <div class="form-group">
                    <label>Jumlah Anggota</label>
                    <input type="number" name="jumlah_anggota" class="form-input" value="{{ old('jumlah_anggota', $keluarga->jumlah_anggota) }}" min="0">
                </div>
                <div class="form-group">
                    <label>Status <span class="required">*</span></label>
                    <select name="status" class="form-input" required>
                        <option value="aktif" {{ old('status', $keluarga->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="pindah" {{ old('status', $keluarga->status) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                        <option value="non-aktif" {{ old('status', $keluarga->status) == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Anggota Keluarga Section --}}
    @if($anggota->count() > 0)
    <div class="glass" style="padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
        <div class="form-section" style="margin-bottom: 0;">
            <h3><i class="ri-group-line"></i> Data Anggota Keluarga ({{ $anggota->count() }})</h3>
            <div class="info-box">
                <i class="ri-information-line"></i> Perbarui data setiap anggota keluarga. Data akan disimpan ke tabel penduduk.
            </div>
            <div class="family-table-wrap">
                <table class="family-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Tempat Lahir</th>
                            <th>Tgl Lahir</th>
                            <th>JK</th>
                            <th>Agama</th>
                            <th>Status Kawin</th>
                            <th>Hub. Keluarga</th>
                            <th>Pekerjaan</th>
                            <th>Pendidikan</th>
                            <th>Status Hidup</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggota as $i => $a)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <input type="text" name="anggota[{{ $i }}][nik]" value="{{ $a->nik }}" readonly style="min-width: 140px;">
                            </td>
                            <td><input type="text" name="anggota[{{ $i }}][nama_lengkap]" value="{{ $a->nama_lengkap }}" style="min-width: 140px;"></td>
                            <td><input type="text" name="anggota[{{ $i }}][tempat_lahir]" value="{{ $a->tempat_lahir }}" style="min-width: 100px;"></td>
                            <td><input type="date" name="anggota[{{ $i }}][tanggal_lahir]" value="{{ $a->tanggal_lahir ? $a->tanggal_lahir->format('Y-m-d') : '' }}" style="min-width: 130px;"></td>
                            <td>
                                <select name="anggota[{{ $i }}][jenis_kelamin]" style="min-width: 60px;">
                                    <option value="L" {{ $a->jenis_kelamin == 'L' ? 'selected' : '' }}>L</option>
                                    <option value="P" {{ $a->jenis_kelamin == 'P' ? 'selected' : '' }}>P</option>
                                </select>
                            </td>
                            <td>
                                <select name="anggota[{{ $i }}][agama]">
                                    <option value="">-</option>
                                    @foreach($agama as $item)
                                    <option value="{{ $item->agama }}" {{ $a->agama == $item->agama ? 'selected' : '' }}>{{ $item->agama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="anggota[{{ $i }}][status_perkawinan]">
                                    <option value="">-</option>
                                    @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $sk)
                                    <option value="{{ $sk }}" {{ $a->status_perkawinan == $sk ? 'selected' : '' }}>{{ $sk }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="anggota[{{ $i }}][hubungan_keluarga]">
                                    <option value="">-</option>
                                    @foreach(['Kepala Keluarga','Istri','Anak','Orang Tua','Mertua','Cucu','Lainnya'] as $hk)
                                    <option value="{{ $hk }}" {{ $a->hubungan_keluarga == $hk ? 'selected' : '' }}>{{ $hk }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" name="anggota[{{ $i }}][pekerjaan]" value="{{ $a->pekerjaan }}" style="min-width: 100px;"></td>
                            <td>
                                <select name="anggota[{{ $i }}][pendidikan_terakhir]">
                                    <option value="">-</option>
                                    @foreach(['Tidak/Belum Sekolah','SD/Sederajat','SMP/Sederajat','SMA/Sederajat','D1/D2/D3','S1','S2','S3'] as $pd)
                                    <option value="{{ $pd }}" {{ $a->pendidikan_terakhir == $pd ? 'selected' : '' }}>{{ $pd }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="anggota[{{ $i }}][status_hidup]">
                                    <option value="hidup" {{ ($a->status_hidup ?? 'hidup') == 'hidup' ? 'selected' : '' }}>Hidup</option>
                                    <option value="meninggal" {{ $a->status_hidup == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                                    <option value="pindah" {{ $a->status_hidup == 'pindah' ? 'selected' : '' }}>Pindah</option>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn-delete-member" onclick="deleteRow(this)" title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-add-member" onclick="addNewMember()">
                <i class="ri-add-line"></i> Tambah Anggota Keluarga
            </button>
        </div>
    </div>
    @else
    <div class="glass" style="padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
        <div class="form-section" style="margin-bottom: 0;">
            <h3><i class="ri-group-line"></i> Data Anggota Keluarga (0)</h3>
            <div class="info-box">
                <i class="ri-information-line"></i> Tambahkan anggota keluarga dengan klik tombol di bawah.
            </div>
            <div class="family-table-wrap">
                <table class="family-table" id="empty-family-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Tempat Lahir</th>
                            <th>Tgl Lahir</th>
                            <th>JK</th>
                            <th>Agama</th>
                            <th>Status Kawin</th>
                            <th>Hub. Keluarga</th>
                            <th>Pekerjaan</th>
                            <th>Pendidikan</th>
                            <th>Status Hidup</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <button type="button" class="btn btn-add-member" onclick="addNewMemberEmpty()">
                <i class="ri-add-line"></i> Tambah Anggota Keluarga
            </button>
        </div>
    </div>
    @endif

    <div class="btn-group">
        <button type="submit" class="btn btn-success"><i class="ri-save-line"></i> Simpan Perubahan</button>
        <a href="{{ route('petugas.pendataankeluarga.index') }}" class="btn btn-secondary"><i class="ri-close-line"></i> Batal</a>
    </div>
</form>

<script>
let memberIndex = {{ $anggota->count() }};

function getMemberFields(index) {
    return `
        <td>${index + 1}</td>
        <td><input type="text" name="anggota[${index}][nik]" placeholder="NIK Baru" style="min-width: 140px;"></td>
        <td><input type="text" name="anggota[${index}][nama_lengkap]" placeholder="Nama" style="min-width: 140px;"></td>
        <td><input type="text" name="anggota[${index}][tempat_lahir]" placeholder="Tempat" style="min-width: 100px;"></td>
        <td><input type="date" name="anggota[${index}][tanggal_lahir]" style="min-width: 130px;"></td>
        <td>
            <select name="anggota[${index}][jenis_kelamin]" style="min-width: 60px;">
                <option value="L">L</option>
                <option value="P">P</option>
            </select>
        </td>
        <td>
            <select name="anggota[${index}][agama]">
                <option value="">-</option>
                @foreach(['Islam','Kristen','Katholik','Hindu','Budha','Konghucu'] as $ag)
                <option value="{{ $ag }}">{{ $ag }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="anggota[${index}][status_perkawinan]">
                <option value="">-</option>
                @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $sk)
                <option value="{{ $sk }}">{{ $sk }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="anggota[${index}][hubungan_keluarga]">
                <option value="">-</option>
                @foreach(['Kepala Keluarga','Istri','Anak','Orang Tua','Mertua','Cucu','Lainnya'] as $hk)
                <option value="{{ $hk }}">{{ $hk }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="text" name="anggota[${index}][pekerjaan]" placeholder="Pekerjaan" style="min-width: 100px;"></td>
        <td>
            <select name="anggota[${index}][pendidikan_terakhir]">
                <option value="">-</option>
                @foreach(['Tidak/Belum Sekolah','SD/Sederajat','SMP/Sederajat','SMA/Sederajat','D1/D2/D3','S1','S2','S3'] as $pd)
                <option value="{{ $pd }}">{{ $pd }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="anggota[${index}][status_hidup]">
                <option value="hidup">Hidup</option>
                <option value="meninggal">Meninggal</option>
                <option value="pindah">Pindah</option>
            </select>
        </td>
        <td>
            <button type="button" class="btn-delete-member" onclick="deleteRow(this)" title="Hapus">
                <i class="ri-delete-bin-line"></i>
            </button>
        </td>
    `;
}

function addNewMember() {
    const tbody = document.querySelector('.family-table tbody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = getMemberFields(memberIndex);
    tbody.appendChild(newRow);
    memberIndex++;
    updateRowNumbers();
}

function addNewMemberEmpty() {
    const table = document.getElementById('empty-family-table');
    const tbody = table.querySelector('tbody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = getMemberFields(memberIndex);
    tbody.appendChild(newRow);
    memberIndex++;
    updateRowNumbersEmpty();
}

function deleteRow(btn) {
    const row = btn.closest('tr');
    const nik = row.querySelector('input[name$="[nik]"]').value;
    if (nik && !confirm('Anggota dengan NIK ' + nik + ' akan dihapus dari database. Lanjutkan?')) {
        return;
    }
    row.remove();
    const table = document.getElementById('empty-family-table');
    if (table && table.contains(row)) {
        updateRowNumbersEmpty();
    } else {
        updateRowNumbers();
    }
}

function updateRowNumbers() {
    const rows = document.querySelectorAll('.family-table:not(#empty-family-table) tbody tr');
    rows.forEach((row, index) => {
        row.querySelector('td:first-child').textContent = index + 1;
        const inputs = row.querySelectorAll('input, select');
        inputs.forEach(input => {
            const name = input.name.replace(/\[\d+\]/, `[${index}]`);
            input.name = name;
        });
    });
    memberIndex = Math.max(memberIndex, rows.length);
}

function updateRowNumbersEmpty() {
    const table = document.getElementById('empty-family-table');
    if (!table) return;
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        row.querySelector('td:first-child').textContent = index + 1;
        const inputs = row.querySelectorAll('input, select');
        inputs.forEach(input => {
            const name = input.name.replace(/\[\d+\]/, `[${index}]`);
            input.name = name;
        });
    });
    memberIndex = Math.max(memberIndex, rows.length);
}
</script>
@endsection
