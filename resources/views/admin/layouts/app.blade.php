<!DOCTYPE html>
<html lang="en">
  @include('admin.layouts.head')
  <body>
    <div class="dashboard-container">
      <!-- Sidebar Overlay -->
      <div class="sidebar-overlay" onclick="closeSidebar()"></div>

      <!-- Sidebar -->
      @include('admin.layouts.sidebar')

      <!-- Main Content -->
      <main class="main-content">
        <!-- Topbar -->
        @include('admin.layouts.header')

        <!-- Stats Grid -->
        @yield('konten')
        
            <!-- Footer -->
            @include('admin.layouts.footer')
        </main>
    </div>

    <!-- Scripts -->
  @include('admin.layouts.script')
  </body>
</html>
