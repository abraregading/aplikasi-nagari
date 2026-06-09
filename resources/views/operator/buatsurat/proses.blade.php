@extends('operator.layouts.app')

@section('title', 'Proses Permohonan Surat')

@section('head')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .page-header h2 i { color: var(--primary); font-size: 1.75rem; }
    .page-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    /* Status Filter Tabs */
    .status-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .status-tab {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s ease;
        border: 1px solid rgba(0,0,0,0.08);
        background: rgba(255,255,255,0.5);
        color: #6b7280;
    }
    .status-tab:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .status-tab.active {
        background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
        color: white;
        border-color: transparent;
    }
    .status-tab .count {
        background: rgba(255,255,255,0.25);
        padding: 1px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .status-tab:not(.active) .count {
        background: rgba(0,0,0,0.06);
    }

    /* Alert */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .alert-success {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    /* Table Container */
    .table-container {
        border-radius: 16px;
        padding: 0;
        overflow: hidden;
    }
    .table-wrapper {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    thead {
        background: linear-gradient(135deg, rgba(14,165,233,0.08), rgba(99,102,241,0.05));
    }
    thead th {
        padding: 1rem 1.25rem;
        text-align: left;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    tbody tr {
        border-bottom: 1px solid rgba(0,0,0,0.04);
        transition: background 0.2s;
    }
    tbody tr:hover {
        background: rgba(14, 165, 233, 0.03);
    }
    tbody tr:last-child {
        border-bottom: none;
    }
    tbody td {
        padding: 0.9rem 1.25rem;
        font-size: 0.88rem;
        color: var(--text-main);
        vertical-align: middle;
    }
    .td-nama {
        font-weight: 600;
    }
    .td-nik {
        font-family: monospace;
        font-size: 0.82rem;
        color: var(--text-muted);
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-diajukan { background: rgba(245,158,11,0.12); color: #d97706; }
    .status-diproses { background: rgba(14,165,233,0.12); color: #0284c7; }
    .status-selesai  { background: rgba(34,197,94,0.12);  color: #16a34a; }
    .status-ditolak  { background: rgba(239,68,68,0.12);  color: #dc2626; }

    /* Action Buttons */
    .action-btns {
        display: flex;
        gap: 6px;
        flex-wrap: nowrap;
    }
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.9rem;
        text-decoration: none;
    }
    .action-btn:hover {
        transform: translateY(-2px);
    }
    .btn-edit {
        background: rgba(14,165,233,0.12);
        color: #0284c7;
    }
    .btn-edit:hover { background: rgba(14,165,233,0.25); }
    .btn-cetak {
        background: rgba(34,197,94,0.12);
        color: #16a34a;
    }
    .btn-cetak:hover { background: rgba(34,197,94,0.25); }
    .btn-hapus {
        background: rgba(239,68,68,0.12);
        color: #dc2626;
    }
    .btn-hapus:hover { background: rgba(239,68,68,0.25); }

    /* Status Dropdown */
    .status-select-wrapper {
        position: relative;
        display: inline-block;
    }
    .status-select {
        padding: 4px 8px;
        border-radius: 8px;
        border: 1px solid rgba(0,0,0,0.1);
        font-size: 0.78rem;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        background: white;
        outline: none;
        font-weight: 500;
    }
    .status-select:focus {
        border-color: var(--primary);
    }

    /* Empty */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 0.75rem;
        opacity: 0.3;
    }

    .td-date {
        font-size: 0.82rem;
        color: var(--text-muted);
        white-space: nowrap;
    }

    /* Tooltip */
    .action-btn[title] {
        position: relative;
    }

    @media (max-width: 768px) {
        thead th, tbody td {
            padding: 0.7rem 0.8rem;
            font-size: 0.8rem;
        }
    }
</style>
@endsection

@section('konten')

<div class="page-header">
    <div>
        <h2><i class="ri-task-line" style="color: var(--primary); margin-right: 8px;"></i>Proses Permohonan Surat</h2>
        <p>Kelola dan proses semua permohonan surat masuk</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="ri-checkbox-circle-line"></i>
    {{ session('success') }}
</div>
@endif

<!-- Status Filter Tabs -->
<div class="status-tabs">
    <a href="{{ route('buatsurat.proses') }}" class="status-tab {{ !$status ? 'active' : '' }}">
        <i class="ri-list-check"></i> Semua
        <span class="count">{{ $counts['semua'] }}</span>
    </a>
    <a href="{{ route('buatsurat.proses', ['status' => 'diajukan']) }}" class="status-tab {{ $status == 'diajukan' ? 'active' : '' }}">
        <i class="ri-time-line"></i> Diajukan
        <span class="count">{{ $counts['diajukan'] }}</span>
    </a>
    <a href="{{ route('buatsurat.proses', ['status' => 'diproses']) }}" class="status-tab {{ $status == 'diproses' ? 'active' : '' }}">
        <i class="ri-loader-4-line"></i> Diproses
        <span class="count">{{ $counts['diproses'] }}</span>
    </a>
    <a href="{{ route('buatsurat.proses', ['status' => 'selesai']) }}" class="status-tab {{ $status == 'selesai' ? 'active' : '' }}">
        <i class="ri-checkbox-circle-line"></i> Selesai
        <span class="count">{{ $counts['selesai'] }}</span>
    </a>
    <a href="{{ route('buatsurat.proses', ['status' => 'ditolak']) }}" class="status-tab {{ $status == 'ditolak' ? 'active' : '' }}">
        <i class="ri-close-circle-line"></i> Ditolak
        <span class="count">{{ $counts['ditolak'] }}</span>
    </a>
</div>

<!-- Table -->
<div class="table-container glass">
    <div class="table-wrapper">
        @if($suratList->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>NIK / Nama</th>
                    <th>Jenis Surat</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Ubah Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suratList as $index => $surat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="td-date">{{ $surat->tanggal_pengajuan ? $surat->tanggal_pengajuan->format('d/m/Y') : '-' }}</td>
                    <td>
                        <div class="td-nama">{{ $surat->penduduk->nama_lengkap ?? '-' }}</div>
                        <div class="td-nik">{{ $surat->nik_pemohon }}</div>
                    </td>
                    <td>{{ $surat->jenis_surat }}</td>
                    <td>{{ Str::limit($surat->keterangan, 30) }}</td>
                    <td>
                        <span class="status-badge status-{{ $surat->status }}">
                            {{ ucfirst($surat->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('buatsurat.updateStatus', $surat->id) }}" method="POST" class="status-select-wrapper">
                            @csrf
                            @method('PUT')
                            <select name="status" class="status-select" onchange="this.form.submit()">
                                <option value="diajukan" {{ $surat->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="diproses" {{ $surat->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $surat->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $surat->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('buatsurat.edit', $surat->id) }}" class="action-btn btn-edit" title="Edit">
                                <i class="ri-edit-line"></i>
                            </a>
                            <a href="{{ route('buatsurat.cetak', $surat->id) }}" class="action-btn btn-cetak" title="Cetak" target="_blank">
                                <i class="ri-printer-line"></i>
                            </a>
                            <form action="{{ route('buatsurat.destroy', $surat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus surat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-hapus" title="Hapus">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="ri-inbox-line"></i>
            <h3>Belum Ada Permohonan</h3>
            <p>Belum ada permohonan surat{{ $status ? ' dengan status "' . $status . '"' : '' }}.</p>
        </div>
        @endif
    </div>
</div>

@endsection
