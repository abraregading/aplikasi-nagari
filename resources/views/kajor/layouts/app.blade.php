<!DOCTYPE html>
<html lang="en">
  @include('kajor.layouts.head')
  <body>
    <div class="dashboard-container">
      <!-- Sidebar Overlay -->
      <div class="sidebar-overlay" onclick="closeSidebar()"></div>

      <!-- Sidebar -->
      @include('kajor.layouts.sidebar')

      <!-- Main Content -->
      <main class="main-content">
        <!-- Topbar -->
        @include('kajor.layouts.header')

        <!-- Stats Grid -->
        @yield('konten')
        
            <!-- Footer -->
            @include('kajor.layouts.footer')
        </main>
    </div>

    <!-- Scripts -->
  @include('kajor.layouts.script')
  </body>
</html>
