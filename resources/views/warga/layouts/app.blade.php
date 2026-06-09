<!DOCTYPE html>
<html lang="en">
  @include('warga.layouts.head')
  <body>
    <div class="dashboard-container">
      <!-- Sidebar -->
      @include('warga.layouts.sidebar')
      <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

      <!-- Main Content -->
      <main class="main-content">
        <!-- Topbar -->
        @include('warga.layouts.header')

        <!-- Stats Grid -->
        @yield('konten')
        
            <!-- Footer -->
            @include('warga.layouts.footer')
        </main>
    </div>

    <!-- Scripts -->
  @include('warga.layouts.script')
  </body>
</html>
