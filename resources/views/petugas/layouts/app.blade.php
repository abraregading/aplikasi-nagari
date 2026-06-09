<!DOCTYPE html>
<html lang="en">
  @include('petugas.layouts.head')
  <body>
    <div class="dashboard-container">
      <!-- Sidebar Overlay -->
      <div class="sidebar-overlay" onclick="closeSidebar()"></div>

      <!-- Sidebar -->
      @include('petugas.layouts.sidebar')

      <!-- Main Content -->
      <main class="main-content">
        <!-- Topbar -->
        @include('petugas.layouts.header')

        <!-- Stats Grid -->
        @yield('konten')
        
            <!-- Footer -->
            @include('petugas.layouts.footer')
        </main>
    </div>

    <!-- Scripts -->
  @include('petugas.layouts.script')
  </body>
</html>
