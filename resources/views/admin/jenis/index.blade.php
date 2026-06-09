@extends('admin.layouts.app')

@section('title', 'Dashboard Data Jenis Layanan Surat')

@section('head')
<!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('konten')
<h2 style="margin-bottom: 2rem;">Data Jenis Layanan Surat</h2>

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
      <a href="{{ route('jenis-surat.create') }}" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
          <i class="ri-add-line"></i> Tambah Jenis Layanan
      </a><br><br><br>

      <div class="table-overlay">
          <table id="example" class="display" style="width:100%">
              <thead>
                  <tr>
                      <th width="5%">No</th>
                      <th width="15%">Nama Layanan</th>
                      <th width="8%">Kode</th>
                      <th width="12%">Deskripsi</th>
                      <th width="10%">Persyaratan</th>
                      <th width="8%">Cetak</th>
                      <th width="22%">Template Surat</th>
                      <th width="20%">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($jenisSurat as $index => $surat)
                  <tr>
                      <td>{{ $index + 1 }}</td>
                      <td style="font-weight: 600;">{{ $surat->nama_layanan }}</td>
                      <td><code>{{ $surat->kode_surat ?? '-' }}</code></td>
                      <td>{{ Str::limit($surat->deskripsi, 30) ?? '-' }}</td>
                      <td>{{ Str::limit($surat->persyaratan, 30) ?? '-' }}</td>
                      <td>
                          @if($surat->template_file)
                              <code style="background: rgba(99, 102, 241, 0.1); color: #818cf8; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">{{ $surat->template_file }}</code>
                          @else
                              <span style="color: var(--text-muted); font-size: 0.8rem;">Default</span>
                          @endif
                      </td>
                      <td>
                          @if($surat->templateSurat)
                              <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.3rem;">
                                  <i class="ri-file-text-line"></i> {{ $surat->templateSurat->nama_template }}
                              </span>
                          @else
                              <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.3rem;">
                                  <i class="ri-alert-line"></i> Belum dipilih
                              </span>
                          @endif
                      </td>
                      <td>
                          <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                              <a href="{{ route('jenis-surat.edit', $surat->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                  <i class="ri-edit-line"></i> Edit
                              </a>
                              <form action="{{ route('jenis-surat.destroy', $surat->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis layanan ini?')">
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
                    searchPlaceholder: "Cari jenis layanan...",
                    search: "",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    emptyTable: "Belum ada jenis layanan surat",
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