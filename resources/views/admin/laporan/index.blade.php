@extends('admin.layouts.app')

@section('title', 'Manajemen Laporan Masyarakat')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('konten')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Manajemen Laporan Masyarakat</h2>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('laporan.index', ['status' => 'pending']) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.5rem 1rem; text-decoration: none;">
            <i class="ri-eye-line"></i> Pending ({{ \App\Models\Laporan::where('status', 'pending')->count() }})
        </a>
        <a href="{{ route('laporan.index', ['status' => 'diproses']) }}" class="glass-select" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.25); padding: 0.5rem 1rem; text-decoration: none;">
            <i class="ri-loader-4-line"></i> Diproses
        </a>
        <a href="{{ route('laporan.index', ['status' => 'selesai']) }}" class="glass-select" style="background: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.25); padding: 0.5rem 1rem; text-decoration: none;">
            <i class="ri-checkbox-circle-line"></i> Selesai
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success" style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.25); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
    <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-error" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.25); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
    <i class="ri-error-warning-line"></i> {{ session('error') }}
</div>
@endif

<div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 2rem;">
    <form method="GET" action="{{ route('laporan.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" placeholder="Cari nama atau isi laporan..." value="{{ request('search') }}" style="padding: 0.5rem 1rem; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white; min-width: 200px;">
        <select name="kategori" style="padding: 0.5rem 1rem; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: white;">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
            @endforeach
        </select>
        <button type="submit" style="padding: 0.5rem 1rem; background: var(--primary); border: none; border-radius: 8px; color: white; cursor: pointer;">
            <i class="ri-search-line"></i> Filter
        </button>
        <a href="{{ route('laporan.index') }}" style="padding: 0.5rem 1rem; background: rgba(255,255,255,0.1); border: none; border-radius: 8px; color: white; text-decoration: none;">
            Reset
        </a>
    </form>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <form id="bulkForm" method="POST" action="{{ route('laporan.bulkAction') }}">
        @csrf
        <input type="hidden" name="action" id="bulkActionInput" value="">
        <div style="margin-bottom: 1rem; display: flex; gap: 0.5rem;">
            <button type="button" onclick="submitBulkAction('diproses')" class="glass-select" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.25); padding: 0.5rem 1rem; cursor: pointer;">
                <i class="ri-loader-4-line"></i> Tandai Diproses
            </button>
            <button type="button" onclick="submitBulkAction('selesai')" class="glass-select" style="background: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.25); padding: 0.5rem 1rem; cursor: pointer;">
                <i class="ri-checkbox-circle-line"></i> Tandai Selesai
            </button>
            <button type="button" onclick="submitBulkAction('delete')" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.5rem 1rem; cursor: pointer;">
                <i class="ri-delete-bin-line"></i> Hapus Terpilih
            </button>
        </div>

        <div class="table-overlay">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th width="30px"><input type="checkbox" id="selectAll"></th>
                        <th width="15%">Nama</th>
                        <th width="15%">Kontak</th>
                        <th width="15%">Kategori</th>
                        <th width="25%">Isi Laporan</th>
                        <th width="10%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                    <tr>
                        <td><input type="checkbox" name="laporan_ids[]" value="{{ $laporan->id }}" class="laporan-checkbox"></td>
                        <td>
                            <strong>{{ $laporan->nama }}</strong>
                        </td>
                        <td>
                            <small>
                                <i class="ri-phone-line"></i> {{ $laporan->no_hp }}<br>
                                @if($laporan->email)
                                    <i class="ri-mail-line"></i> {{ $laporan->email }}
                                @endif
                            </small>
                        </td>
                        <td>
                            <span style="display: block; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $laporan->kategori }}</span>
                        </td>
                        <td>
                            <span style="display: block; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Str::limit($laporan->isi_laporan, 80) }}</span>
                        </td>
                        <td>
                            @if($laporan->status === 'pending')
                                <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">Pending</span>
                            @elseif($laporan->status === 'diproses')
                                <span style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">Diproses</span>
                            @elseif($laporan->status === 'selesai')
                                <span style="background: rgba(34, 197, 94, 0.15); color: #22c55e; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">Selesai</span>
                            @else
                                <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('laporan.show', $laporan->id) }}" class="glass-select" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.25); padding: 0.3rem 0.6rem; font-size: 0.8rem; text-decoration: none;">
                                <i class="ri-eye-line"></i>
                            </a>
                            <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.3rem 0.6rem; font-size: 0.8rem; cursor: pointer;" onclick="return confirm('Hapus laporan ini?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: #888;">
                            <i class="ri-inbox-2-line" style="font-size: 3rem;"></i><br>
                            Belum ada laporan masuk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1rem;">
            {{ $laporans->withQueryString()->links() }}
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            paging: false,
            order: [[6, 'desc']]
        });

        $('#selectAll').on('click', function() {
            $('.laporan-checkbox').prop('checked', this.checked);
        });
    });

    function submitBulkAction(action) {
        const checked = document.querySelectorAll('.laporan-checkbox:checked');
        if (checked.length === 0) {
            alert('Pilih laporan terlebih dahulu.');
            return;
        }
        
        if (action === 'delete' && !confirm('Hapus laporan yang terpilih?')) {
            return;
        }
        
        document.getElementById('bulkActionInput').value = action;
        document.getElementById('bulkForm').submit();
    }
</script>
@endsection