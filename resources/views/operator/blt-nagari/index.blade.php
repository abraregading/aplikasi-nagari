@extends('operator.layouts.app')

@section('title', 'Data BLT Nagari')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .badge-tahun {
        background: rgba(99, 102, 241, 0.15);
        color: var(--primary);
    }
</style>
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Data Penerima BLT Nagari</h2>

@if(session('success'))
<div style="background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.25); color: #065f46; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: .85rem; display: flex; align-items: center; gap: .5rem;">
    <i class="ri-check-line"></i> {{ session('success') }}
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 1.5rem;">
    <form method="GET" action="{{ route('operator.blt-nagari.index') }}" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
        <div style="display: flex; flex-direction: column; gap: 0.3rem;">
            <label style="font-size: 0.8rem; color: #999;">Tahun</label>
            <select name="tahun" class="glass-select" style="padding: 0.5rem 1rem; border-radius: 8px;" onchange="this.form.submit()">
                @for($t = now()->year; $t >= now()->year - 5; $t--)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endfor
            </select>
        </div>
        <a href="{{ route('operator.blt-nagari.create') }}?tahun={{ $tahun }}" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
            <i class="ri-add-line"></i> Tambah Penerima
        </a>
        <a href="{{ route('operator.blt-nagari.cetak', ['tahun' => $tahun]) }}" target="_blank" class="glass-select" style="background: #10b981; color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
            <i class="ri-printer-line"></i> Cetak
        </a>
    </form>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <div class="table-overlay">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>No KK</th>
                    <th>Jorong</th>
                    <th>Pekerjaan</th>
                    <th>Jml Anggota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $d->nik }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->no_kk ?? '-' }}</td>
                    <td>{{ $d->alamat_jorong ?? '-' }}</td>
                    <td>{{ $d->pekerjaan ?? '-' }}</td>
                    <td style="text-align: center;">{{ $d->jumlah_anggota_keluarga }}</td>
                    <td>
                        <a href="{{ route('operator.blt-nagari.edit', $d->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                            <i class="ri-edit-line"></i>
                        </a>
                        <form action="{{ route('operator.blt-nagari.destroy', $d->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem;" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: "Search records..."
            }
        });
    });
</script>
@endsection
