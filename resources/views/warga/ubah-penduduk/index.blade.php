@extends('warga.layouts.app')

@section('title', 'Ubah Data Penduduk')

@section('head')
<style>
    .page-header { margin-bottom: 1.5rem; }
    .page-header h2 { font-size: 1.4rem; margin: 0; }

    .info-card {
        background: rgba(14,165,233,.06);
        border: 1px solid rgba(14,165,233,.2);
        border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem;
        font-size: .85rem; line-height: 1.6;
    }
    .info-card strong { color: var(--primary); }

    .form-section { margin-bottom: 2rem; }
    .form-section h3 { font-size: 1rem; color: var(--primary); margin-bottom: 1rem; display: flex; align-items: center; gap: .5rem; }
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-size: .85rem; font-weight: 500; margin-bottom: .3rem; }
    .form-control {
        width: 100%; padding: .8rem 1rem; border-radius: 10px;
        border: 1px solid rgba(0,0,0,.1); background: rgba(255,255,255,.8);
        font-size: .9rem; font-family: inherit; color: var(--text-main);
        outline: none; transition: all .3s; box-sizing: border-box;
    }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,.15); }
    .form-control.readonly-current {
        background: rgba(0,0,0,.03); color: var(--text-muted);
        border-left: 3px solid #10b981;
    }
    textarea.form-control { resize: vertical; min-height: 80px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-row.full { grid-template-columns: 1fr; }

    .btn {
        padding: .7rem 1.5rem; border-radius: 10px; font-weight: 600; font-size: .9rem;
        border: none; cursor: pointer; font-family: inherit; transition: all .3s;
        display: inline-flex; align-items: center; gap: .5rem;
    }
    .btn-primary { background: var(--primary); color: white; }
    .btn-primary:hover { background: #0284c7; transform: translateY(-1px); }
    .btn-outline { background: transparent; border: 1px solid rgba(0,0,0,.15); color: var(--text-main); }
    .btn-outline:hover { background: rgba(0,0,0,.03); }

    .alert { padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: .9rem; display: flex; align-items: center; gap: .5rem; }
    .alert-success { background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.25); color: #065f46; }
    .alert-error { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.25); color: #991b1b; }
    .alert-pending { background: rgba(245,158,11,.1); border: 1px solid rgba(245,158,11,.25); color: #92400e; }
    .text-red { color: #ef4444; font-size: .8rem; margin-top: .25rem; }
    .text-muted { color: var(--text-muted); font-size: .8rem; }
    .field-hint { font-size: .75rem; color: var(--text-muted); margin-top: .2rem; }
    .status-badge { display: inline-block; padding: .25rem .75rem; border-radius: 20px; font-size: .8rem; font-weight: 600; }
    .status-pending { background: rgba(245,158,11,.15); color: #d97706; }
    .status-approved { background: rgba(16,185,129,.15); color: #059669; }
    .status-rejected { background: rgba(239,68,68,.15); color: #dc2626; }

    @media(max-width: 768px) { .form-row { grid-template-columns: 1fr; } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <h2><i class="ri-edit-box-line" style="color:var(--primary)"></i> Ubah Data Penduduk</h2>
</div>

@if(session('success'))
<div class="alert alert-success"><i class="ri-check-line"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error"><i class="ri-error-warning-line"></i> {{ session('error') }}</div>
@endif

@if($existingPengajuan)
<div class="alert alert-pending">
    <i class="ri-time-line"></i>
    Anda memiliki pengajuan perubahan dengan status <strong>{{ ucfirst($existingPengajuan->status) }}</strong> sejak {{ $existingPengajuan->created_at->format('d/m/Y H:i') }}.
    Silakan tunggu persetujuan Operator Nagari sebelum mengajukan perubahan baru.
</div>
@else

<div class="info-card">
    <i class="ri-information-line"></i>
    Anda dapat mengajukan perubahan data pribadi kependudukan. Perubahan akan diproses setelah mendapat persetujuan dari <strong>Operator Nagari</strong>.
    <br>Field yang bisa diubah: Nama Lengkap, Tempat Lahir, Tanggal Lahir, Agama, Pekerjaan, Pendidikan Terakhir, dan Alamat.
</div>

<form action="{{ route('warga.ubah-penduduk.store') }}" method="POST">
    @csrf

    <div class="glass" style="padding:2rem;border-radius:16px;margin-bottom:1.5rem;">
        <div class="form-section">
            <h3><i class="ri-user-line"></i> Data Saat Ini & Perubahan</h3>
            <p class="text-muted" style="margin-bottom:1rem;">Data saat ini ditampilkan di kolom hijau. Ubah field yang ingin dirubah.</p>

            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control readonly-current" value="{{ $penduduk->nama_lengkap }}" readonly disabled placeholder="Data saat ini">
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}" required>
                    @error('nama_lengkap') <div class="text-red">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" class="form-control readonly-current" value="{{ $penduduk->tempat_lahir ?? '-' }}" readonly disabled>
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}">
                    @error('tempat_lahir') <div class="text-red">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" class="form-control readonly-current" value="{{ $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('Y-m-d') : '' }}" readonly disabled>
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('Y-m-d') : '') }}">
                    @error('tanggal_lahir') <div class="text-red">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Agama</label>
                    <input type="text" class="form-control readonly-current" value="{{ $penduduk->agama ?? '-' }}" readonly disabled>
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <input type="text" name="agama" class="form-control" value="{{ old('agama', $penduduk->agama) }}" placeholder="Islam, Kristen, Hindu, Budha, Katolik">
                    @error('agama') <div class="text-red">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Pekerjaan</label>
                    <input type="text" class="form-control readonly-current" value="{{ $penduduk->pekerjaan ?? '-' }}" readonly disabled>
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}">
                    @error('pekerjaan') <div class="text-red">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Pendidikan Terakhir</label>
                    <input type="text" class="form-control readonly-current" value="{{ $penduduk->pendidikan_terakhir ?? '-' }}" readonly disabled>
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <input type="text" name="pendidikan_terakhir" class="form-control" value="{{ old('pendidikan_terakhir', $penduduk->pendidikan_terakhir) }}" placeholder="SD, SMP, SMA, D3, S1, S2, dll">
                    @error('pendidikan_terakhir') <div class="text-red">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control readonly-current" readonly disabled placeholder="Data saat ini">{{ $penduduk->alamat ?? '-' }}</textarea>
                </div>
            </div>
            <div class="form-row full">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <textarea name="alamat" class="form-control" placeholder="Alamat lengkap">{{ old('alamat', $penduduk->alamat) }}</textarea>
                    @error('alamat') <div class="text-red">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3><i class="ri-question-line"></i> Alasan Perubahan</h3>
            <div class="form-row full">
                <div class="form-group">
                    <label>Alasan <span style="color:#ef4444;">*</span></label>
                    <textarea name="alasan" class="form-control" placeholder="Jelaskan alasan Anda mengajukan perubahan data ini" required>{{ old('alasan') }}</textarea>
                    @error('alasan') <div class="text-red">{{ $message }}</div> @enderror
                    <div class="field-hint">Maksimal 500 karakter</div>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:1rem;justify-content:flex-end;padding-top:1rem;border-top:1px solid rgba(0,0,0,.06);">
            <a href="{{ route('warga.home') }}" class="btn btn-outline"><i class="ri-arrow-left-line"></i> Kembali</a>
            <button type="submit" class="btn btn-primary"><i class="ri-send-plane-line"></i> Ajukan Perubahan</button>
        </div>
    </div>
</form>
@endif
@endsection
