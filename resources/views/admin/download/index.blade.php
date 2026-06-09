@extends('admin.layouts.app')

@section('title', 'Dashboard Download Data Penduduk')


@section('head')
<!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection
@section('konten')
<h2 style="margin-bottom: 2rem;">Download Data Penduduk</h2>

  <div class="glass" style="padding: 2rem; border-radius: 16px;">
      <h3 style="margin-bottom: 1.5rem; color: var(--primary);">Employee Directory</h3>
      <div class="table-overlay">
          <table id="example" class="display" style="width:100%">
              <thead>
                  <tr>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Office</th>
                      <th>Age</th>
                      <th>Start date</th>
                      <th>Status</th>
                      <th>Salary</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011/04/25</td>
                      <td><span class="status-badge status-success">Active</span></td>
                      <td>$320,800</td>
                  </tr>
                  <tr>
                      <td>Garrett Winters</td>
                      <td>Accountant</td>
                      <td>Tokyo</td>
                      <td>63</td>
                      <td>2011/07/25</td>
                      <td><span class="status-badge status-warning">Pending</span></td>
                      <td>$170,750</td>
                  </tr>
                  <!-- More dummy data -->
                  <tr>
                      <td>Ashton Cox</td>
                      <td>Junior Technical Author</td>
                      <td>San Francisco</td>
                      <td>66</td>
                      <td>2009/01/12</td>
                      <td><span class="status-badge status-success">Active</span></td>
                      <td>$86,000</td>
                  </tr>
                  <tr>
                      <td>Cedric Kelly</td>
                      <td>Senior Javascript Developer</td>
                      <td>Edinburgh</td>
                      <td>22</td>
                      <td>2012/03/29</td>
                      <td><span class="status-badge status-success">Active</span></td>
                      <td>$433,060</td>
                  </tr>
                  <tr>
                      <td>Airi Satou</td>
                      <td>Accountant</td>
                      <td>Tokyo</td>
                      <td>33</td>
                      <td>2008/11/28</td>
                      <td><span class="status-badge status-danger">Inactive</span></td>
                      <td>$162,700</td>
                  </tr>
                    <tr>
                      <td>Brielle Williamson</td>
                      <td>Integration Specialist</td>
                      <td>New York</td>
                      <td>61</td>
                      <td>2012/12/02</td>
                      <td><span class="status-badge status-success">Active</span></td>
                      <td>$372,000</td>
                  </tr>
                    <tr>
                      <td>Herrod Chandler</td>
                      <td>Sales Assistant</td>
                      <td>San Francisco</td>
                      <td>59</td>
                      <td>2012/08/06</td>
                      <td><span class="status-badge status-success">Active</span></td>
                      <td>$137,500</td>
                  </tr>
                    <tr>
                      <td>Rhona Davidson</td>
                      <td>Integration Specialist</td>
                      <td>Tokyo</td>
                      <td>55</td>
                      <td>2010/10/14</td>
                      <td><span class="status-badge status-success">Active</span></td>
                      <td>$327,900</td>
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