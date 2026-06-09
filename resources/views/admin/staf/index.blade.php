@extends('admin.layouts.app')

@section('title', 'Data Staf - Admin Desa')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Data Staf</h2>

    @if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <i class="ri-checkbox-circle-line" style="font-size: 1.25rem;"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <i class="ri-error-warning-line" style="font-size: 1.25rem;"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

  <div class="glass" style="padding: 2rem; border-radius: 16px;">
      <a href="{{ route('staf.create') }}" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
          <i class="ri-add-line"></i> Tambah Staf
      </a><br><br><br>

      <div class="table-overlay">
          <table id="example" class="display" style="width:100%">
              <thead>
                  <tr>
                      <th width="10%">No</th>
                      <th width="35%">Nama Staf</th>
                      <th width="35%">Jabatan</th>
                      <th width="20%">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($staf as $index => $item)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td style="font-weight: 600;">{{ $item->penduduk->nama_lengkap }}</td>
                      <td style="font-weight: 600;">{{ $item->jabatan->nama_jabatan }}</td>

                      <td>
                          <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                              <a href="{{ route('staf.edit', $item->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                  <i class="ri-edit-line"></i> Edit
                              </a>
                              <form action="{{ route('staf.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus staf ini?')">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem;">
                                      <i class="ri-delete-bin-line"></i> Hapus
                                  </button>
                              </form>
                          </div>
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
                    searchPlaceholder: "Cari staf...",
                    search: "",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    emptyTable: "Belum ada data staf",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>
@endsection
