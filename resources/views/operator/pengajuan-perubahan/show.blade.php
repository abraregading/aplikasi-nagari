@extends('operator.layouts.app')

@section('title', 'Detail Pengajuan Perubahan')

@section('head')
<style>
    .page-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
    .page-header h2 { margin: 0; font-size: 1.4rem; }

    .detail-section { margin-bottom: 1.5rem; }
    .detail-section h3 { font-size: 1rem; margin-bottom: 1rem; color: var(--primary); display: flex; align-items: center; gap: .5rem; }

    .diff-table { width: 100%; border-collapse: separate; border-spacing: 0; border-radius: 12px; overflow: hidden; font-size: .9rem; }
    .diff-table th { text-align: left; padding: .75rem 1rem; background: rgba(0,0,0,.03); color: var(--text-muted); font-size: .8rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
    .diff-table td { padding: .75rem 1rem; border-bottom: 1px solid rgba(0,0,0,.04); vertical-align: middle; }
    .diff-table tr:last-child td { border-bottom: none; }
    .diff-table .field-label { font-weight: 500; color: var(--text-main); width: 30%; }
    .diff-table .current-value { color: var(--text-muted); }
    .diff-table .proposed-value { font-weight: 600; color: #059669; }
    .diff-table .unchanged { color: var(--text-muted); }

    .status-badge { display: inline-block; padding: .3rem .8rem; border-radius: 20px; font-size: .8rem; font-weight: 600; }
    .status-pending { background: rgba(245,158,11,.15); color: #d97706; }
    .status-approved { background: rgba(16,185,129,.15); color: #059669; }
    .status-rejected { background: rgba(239,68,68,.15); color: #dc2626; }

    .info-card {
        background: rgba(14,165,233,.06); border: 1px solid rgba(14,165,233,.2);
        border-radius: 12px; padding: 1.25rem; display: flex; gap: 1.5rem;
        align-items: center; flex-wrap: wrap; margin-bottom: 1.5rem;
    }
    .info-card .avatar { width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.2rem; }
    .info-card .info h4 { margin: 0; font-size: 1rem; }
    .info-card .info p { margin: .2rem 0; font-size: .85rem; color: var(--text-muted); }

    .alasan-box {
        background: rgba(245,158,11,.06); border: 1px solid rgba(245,158,11,.2);
        border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem;
    }
    .alasan-box .label { font-size: .8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: .3rem; }
    .alasan-box .content { font-size: .9rem; line-height: 1.6; }

    .btn {
        padding: .6rem 1.2rem; border-radius: 10px; font-weight: 600; font-size: .9rem;
        text-decoration: none; display: inline-flex; align-items: center; gap: .4rem;
        transition: all .2s; cursor: pointer; border: none; font-family: inherit;
    }
    .btn-approve { background: rgba(16,185,129,.15); color: #059669; border: 1px solid rgba(16,185,129,.25); }
    .btn-approve:hover { background: rgba(16,185,129,.25); }
    .btn-reject { background: rgba(239,68,68,.1); color: #dc2626; border: 1px solid rgba(239,68,68,.2); }
    .btn-reject:hover { background: rgba(239,68,68,.2); }
    .btn-secondary { background: transparent; color: var(--text-main); border: 1px solid rgba(0,0,0,.15); }
    .btn-secondary:hover { background: rgba(0,0,0,.03); }
    .btn-group { display: flex; gap: .75rem; margin-top: 1.5rem; flex-wrap: wrap; }

    .form-control {
        width: 100%; padding: .7rem 1rem; border-radius: 10px;
        border: 1px solid rgba(0,0,0,.1); background: rgba(255,255,255,.8);
        font-size: .9rem; font-family: inherit; color: var(--text-main);
        outline: none; transition: all .3s; box-sizing: border-box;
    }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14,165,233,.15); }
    textarea.form-control { resize: vertical; min-height: 60px; }

    .catatan-display {
        background: rgba(0,0,0,.03); border-radius: 10px;
        padding: 1rem; margin-top: 1rem;
        font-size: .9rem; line-height: 1.6;
    }
    .catatan-display .label { font-size: .8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: .3rem; }

    @media(max-width: 768px) { .info-card { flex-direction: column; align-items: flex-start; } .btn-group { flex-direction: column; } }
</style>
@endsection

@section('konten')
<div class="page-header">
    <a href="{{ route('operator.pengajuan-perubahan.index') }}" class="btn btn-secondary" style="padding:.5rem 1rem;">
        <i class="ri-arrow-left-line"></i>
    </a>
    <h2>Detail Pengajuan Perubahan</h2>
</div>

<div class="info-card">
    <div class="avatar">{{ strtoupper(substr($pengajuan->user->name ?? '?', 0, 1)) }}</div>
    <div class="info">
        <h4>{{ $pengajuan->user->name ?? '-' }}</h4>
        <p><i class="ri-fingerprint-line"></i> NIK: {{ $pengajuan->penduduk->nik ?? '-' }}</p>
        <p><i class="ri-calendar-line"></i> Diajukan: {{ $pengajuan->created_at->format('d/m/Y H:i') }}</p>
        <p>
            Status: <span class="status-badge status-{{ $pengajuan->status }}">{{ ucfirst($pengajuan->status) }}</span>
        </p>
    </div>
</div>

<div class="glass" style="padding:1.5rem;border-radius:16px;margin-bottom:1.5rem;">
    <div class="detail-section">
        <h3><i class="ri-file-diff-line"></i> Perubahan Data</h3>
        @php
            $allowedFields = ['nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'agama', 'pekerjaan', 'pendidikan_terakhir', 'alamat'];
            $labels = [
                'nama_lengkap' => 'Nama Lengkap',
                'tempat_lahir' => 'Tempat Lahir',
                'tanggal_lahir' => 'Tanggal Lahir',
                'agama' => 'Agama',
                'pekerjaan' => 'Pekerjaan',
                'pendidikan_terakhir' => 'Pendidikan Terakhir',
                'alamat' => 'Alamat',
            ];
            $dataBaru = $pengajuan->data_baru ?? [];
        @endphp
        <table class="diff-table">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Data Saat Ini</th>
                    <th>Data Diajukan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allowedFields as $field)
                @php
                    $current = $pengajuan->penduduk->$field ?? '-';
                    $proposed = $dataBaru[$field] ?? '-';
                    if ($field === 'tanggal_lahir' && $current instanceof \Carbon\Carbon) {
                        $current = $current->format('d/m/Y');
                    }
                    if ($field === 'tanggal_lahir' && $proposed && $proposed !== '-') {
                        $proposed = \Carbon\Carbon::parse($proposed)->format('d/m/Y');
                    }
                    $changed = $current != $proposed;
                @endphp
                <tr>
                    <td class="field-label">{{ $labels[$field] ?? $field }}</td>
                    <td class="current-value">{{ $current ?: '-' }}</td>
                    <td class="{{ $changed ? 'proposed-value' : 'unchanged' }}">
                        {{ $proposed ?: '-' }}
                        @if(!$changed) <span style="font-size:.75rem;">(tidak berubah)</span> @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if($pengajuan->alasan)
<div class="alasan-box">
    <div class="label">Alasan Perubahan</div>
    <div class="content">{{ $pengajuan->alasan }}</div>
</div>
@endif

@if($pengajuan->catatan && $pengajuan->status !== 'pending')
<div class="glass" style="padding:1.5rem;border-radius:16px;margin-bottom:1.5rem;">
    <div class="catatan-display">
        <div class="label">Catatan Operator</div>
        <div>{{ $pengajuan->catatan }}</div>
    </div>
</div>
@endif

@if($pengajuan->status === 'pending')
<div class="glass" style="padding:1.5rem;border-radius:16px;margin-bottom:1.5rem;">
    <h3 style="font-size:1rem;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;">
        <i class="ri-check-double-line" style="color:var(--primary)"></i> Tindakan
    </h3>

    <div class="btn-group">
        <form action="{{ route('operator.pengajuan-perubahan.approve', $pengajuan->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Setujui perubahan data ini? Data penduduk akan diperbarui.');">
            @csrf
            <button type="submit" class="btn btn-approve"><i class="ri-check-line"></i> Setujui & Perbarui Data</button>
        </form>
        <button type="button" class="btn btn-reject" onclick="document.getElementById('rejectForm').style.display='block';this.style.display='none';">
            <i class="ri-close-line"></i> Tolak
        </button>
    </div>

    <div id="rejectForm" style="display:none;margin-top:1.5rem;">
        <form action="{{ route('operator.pengajuan-perubahan.reject', $pengajuan->id) }}" method="POST" onsubmit="return confirm('Tolak pengajuan perubahan ini?');">
            @csrf
            <div class="form-group">
                <label style="display:block;font-size:.85rem;font-weight:500;margin-bottom:.3rem;">Catatan (opsional)</label>
                <textarea name="catatan" class="form-control" placeholder="Alasan penolakan..."></textarea>
            </div>
            <div style="display:flex;gap:.5rem;margin-top:.75rem;">
                <button type="submit" class="btn btn-reject"><i class="ri-close-line"></i> Ya, Tolak</button>
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('rejectForm').style.display='none';document.querySelector('.btn-reject').style.display='inline-flex';">Batal</button>
            </div>
        </form>
    </div>
</div>
@endif

<div>
    <a href="{{ route('operator.pengajuan-perubahan.index') }}" class="btn btn-secondary"><i class="ri-arrow-left-line"></i> Kembali ke Daftar</a>
</div>
@endsection
