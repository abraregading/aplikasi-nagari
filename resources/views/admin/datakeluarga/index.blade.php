@extends('admin.layouts.app')

@section('title', 'Dashboard Data Keluarga Nagari')


@section('head')
<!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection
@section('konten')
<h2 style="margin-bottom: 2rem;">Data Keluarga</h2>

    {{-- Flash Messages --}}
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
      <a href="{{ route('data-keluarga.create') }}" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
          <i class="ri-add-line"></i> Tambah Data Keluarga
      </a><br><br><br>

      <div class="table-overlay">
          <table id="example" class="display" style="width:100%">
              <thead>
                  <tr>
                      <th width="5%">No</th>
                      <th width="15%">NO KK</th>
                      <th width="15%">NIK KEPALA KELUARGA</th>
                      <th width="25%">ALAMAT</th>
                      <th width="15%">KEJORONGAN</th>
                      <th width="10%">STATUS</th>
                      <th width="15%">AKSI</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($keluargas as $index => $keluarga)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $keluarga->no_kk }}</td>
                      <td>{{ $keluarga->kepala_keluarga_nik }}</td>
                      <td>{{ $keluarga->alamat }}</td>
                      <td>{{ $keluarga->jorong }}</td>
                      <td>
                          @if($keluarga->status == 'aktif')
                              <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">Aktif</span>
                          @elseif($keluarga->status == 'pindah')
                              <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">Pindah</span>
                          @else
                              <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">Non-Aktif</span>
                          @endif
                      </td>
                      <td>
                          <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                              <a href="{{ route('data-keluarga.show', $keluarga->id) }}" class="glass-select" style="background: rgba(99, 102, 241, 0.15); color: #6366f1; border: 1px solid rgba(99, 102, 241, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                  <i class="ri-eye-line"></i> Detail
                              </a>
                              <a href="{{ route('data-keluarga.edit', $keluarga->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                  <i class="ri-edit-line"></i> Edit
                              </a>
                              <form action="{{ route('data-keluarga.destroy', $keluarga->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data keluarga ini?')">
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
                    searchPlaceholder: "Cari data keluarga...",
                    search: "",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    emptyTable: "Belum ada data keluarga",
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