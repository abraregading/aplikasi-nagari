@extends('admin.layouts.app')

@section('title', 'Dashboard Daftar Berita')


@section('head')
<!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection
@section('konten')
<h2 style="margin-bottom: 2rem;">Data Berita</h2>

  <div class="glass" style="padding: 2rem; border-radius: 16px;">
      <a href="{{ route('daftar-berita.create') }}" style="background:var(--primary); color:white; border:none; padding:0.8rem 1.5rem; border-radius:8px; cursor:pointer;">Tambah Berita</a><br><br><br>
      <div class="table-overlay">
          <table id="example" class="display" style="width:100%">
              <thead>
                  <tr>
                      <th width="30%">Judul</th>
                      <th width="40%">Isi Berita</th>
                      <th width="15%">Gambar</th>
                      <th width="15%">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($berita as $berita)
                  <tr>
                      <td>{{ $berita->judul_berita }}</td>
                      <td>{{ Str::limit($berita->isi_berita1, 100) }}</td>
                      <td>
                          @if($berita->gambar_berita)
                              <img src="{{ Storage::url($berita->gambar_berita      ) }}" alt="Gambar Berita" style="max-width: 100px; max-height: 100px;">
                          @endif
                      </td>
                      <td>
                          <a href="{{ route('daftar-berita.edit', $berita->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">Edit</a>
                          <form action="{{ route('daftar-berita.destroy', $berita->id) }}" method="POST" style="display: inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem;" onclick="return confirm('Are you sure?')">Delete</button>
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