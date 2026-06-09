@extends('admin.layouts.app')

@section('title', 'Dashboard Data Penduduk Nagari')


@section('head')
<!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection
@section('konten')
<h2 style="margin-bottom: 2rem;">Data Penduduk</h2>

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

<section class="stats-grid">
  <div class="stat-card glass">
    <div class="stat-info">
      <h3>{{$jmlpenduduk}} Jiwa</h3>
      <p>Jumlah Penduduk</p>
      <div class="stat-trend trend-up">
        <i class="ri-arrow-up-line"></i>
        <span>+12.5%</span>
      </div>
    </div>
  </div>

  <div class="stat-card glass">
    <div class="stat-info">
      <h3>{{$jmllakilaki}} Jiwa</h3>
      <p>Jumlah Laki-laki</p>
      <div class="stat-trend trend-up">
        <i class="ri-arrow-up-line"></i>
        <span>+5.2%</span>
      </div>
    </div>
  </div>

  <div class="stat-card glass">
    <div class="stat-info">
      <h3>{{$jmlperempuan}} Jiwa</h3>
      <p>Jumlah Perempuan</p>
      <div class="stat-trend trend-down">
        <i class="ri-arrow-down-line"></i>
        <span>-2.1%</span>
      </div>
    </div>
  </div>

  <div class="stat-card glass">
    <div class="stat-info">
      <h3>{{$jmlkeluarga}} Keluarga</h3>
      <p>Jumlah Keluarga</p>
      <div class="stat-trend trend-up">
        <i class="ri-arrow-up-line"></i>
        <span>+8.4%</span>
      </div>
    </div>
  </div>
</section>

  <div class="glass" style="padding: 2rem; border-radius: 16px;">
      <a href="{{ route('data-penduduk.create') }}" class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
          <i class="ri-add-line"></i> Tambah Data Penduduk
      </a><br><br><br>

      <div class="table-overlay">
          <table id="example" class="display" style="width:100%">
              <thead>
                  <tr>
                      <th width="5%">No</th>
                      <th width="12%">NIK</th>
                      <th width="18%">NAMA</th>
                      <th width="8%">JK</th>
                      <th width="10%">AGAMA</th>
                      <th width="17%">ALAMAT</th>
                      <th width="10%">STATUS</th>
                      <th width="20%">AKSI</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($penduduks as $index => $penduduk)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $penduduk->nik }}</td>
                      <td style="font-weight: 600;">{{ $penduduk->nama_lengkap }}</td>
                      <td>
                          @if($penduduk->jenis_kelamin == 'L')
                              <span style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem;">L</span>
                          @else
                              <span style="background: rgba(236, 72, 153, 0.15); color: #ec4899; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem;">P</span>
                          @endif
                      </td>
                      <td>{{ $penduduk->agama }}</td>
                      <td>{{ $penduduk->alamat }}</td>
                      <td>
                          @if($penduduk->status_hidup == 'hidup')
                              <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">Hidup</span>
                          @elseif($penduduk->status_hidup == 'meninggal')
                              <span style="background: rgba(107, 114, 128, 0.15); color: #6b7280; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">Meninggal</span>
                          @else
                              <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500;">Pindah</span>
                          @endif
                      </td>
                      <td>
                          <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                              <a href="{{ route('data-penduduk.show', $penduduk->id) }}" class="glass-select" style="background: rgba(99, 102, 241, 0.15); color: #6366f1; border: 1px solid rgba(99, 102, 241, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                  <i class="ri-eye-line"></i> Detail
                              </a>
                              <a href="{{ route('data-penduduk.edit', $penduduk->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                  <i class="ri-edit-line"></i> Edit
                              </a>
                              <form action="{{ route('data-penduduk.destroy', $penduduk->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penduduk ini?')">
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
                    searchPlaceholder: "Cari data penduduk...",
                    search: "",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    emptyTable: "Belum ada data penduduk",
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