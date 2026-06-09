<!DOCTYPE html>
<html lang="en">
  @include('operator.layouts.head')
  <body>
    <div class="dashboard-container">
      <!-- Sidebar Overlay -->
      <div class="sidebar-overlay" onclick="closeSidebar()"></div>

      <!-- Sidebar -->
      @include('operator.layouts.sidebar')

      <!-- Main Content -->
      <main class="main-content">
        <!-- Topbar -->
        @include('operator.layouts.header')

        <!-- Stats Grid -->
        @yield('konten')
        
            <!-- Footer -->
            @include('operator.layouts.footer')
        </main>
    </div>

    <!-- Scripts -->
  @include('operator.layouts.script')
  </body>
</html>
