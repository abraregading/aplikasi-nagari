<!DOCTYPE html>
<html lang="en">
  @include('kader.layouts.head')
  <body>
    <div class="dashboard-container">
      <!-- Sidebar Overlay -->
      <div class="sidebar-overlay" onclick="closeSidebar()"></div>

      <!-- Sidebar -->
      @include('kader.layouts.sidebar')

      <!-- Main Content -->
      <main class="main-content">
        <!-- Topbar -->
        @include('kader.layouts.header')

        <!-- Stats Grid -->
        @yield('konten')
        
            <!-- Footer -->
            @include('kader.layouts.footer')
        </main>
    </div>

    <!-- Scripts -->
  @include('kader.layouts.script')
  </body>
</html>
