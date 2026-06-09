@extends('admin.layouts.app')

@section('title', 'Dashboard Data Layanan Surat')


@section('head')
<!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection
@section('konten')
<h2 style="margin-bottom: 2rem;">Data Layanan Surat</h2>

  <div class="glass" style="padding: 2rem; border-radius: 16px;">
      <h3 style="margin-bottom: 1.5rem; color: var(--primary);">Layanan Surat</h3>
      <div class="table-overlay">
          <table id="example" class="display" style="width:100%">
              <thead>
                  <tr>
                      <th width="15%">TANGGAL</th>
                      <th width="25%">PEMOHON</th>
                      <th width="20%">JENIS SURAT</th>
                      <th width="15%">STATUS</th>
                      <th width="25%">PEMBUAT</th>                  
                    </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011/04/25</td>
                  </tr>
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