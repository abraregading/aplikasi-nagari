document.addEventListener("DOMContentLoaded", function () {
  // Mobile Sidebar Toggle
  window.toggleSidebar = function() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    if (sidebar) {
      sidebar.classList.toggle('active');
    }
    if (overlay) {
      overlay.classList.toggle('active');
    }
    // Prevent body scroll when sidebar open
    document.body.style.overflow = sidebar && sidebar.classList.contains('active') ? 'hidden' : '';
  };

  window.closeSidebar = function() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    if (sidebar) sidebar.classList.remove('active');
    if (overlay) overlay.classList.remove('active');
    document.body.style.overflow = '';
  };

  // Close sidebar when clicking outside or on overlay
  document.addEventListener('click', function(e) {
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.mobile-menu-toggle');
    if (sidebar && window.innerWidth <= 768) {
      if (!sidebar.contains(e.target) && toggleBtn && !toggleBtn.contains(e.target)) {
        closeSidebar();
      }
    }
  });

  // Close sidebar on swipe left (touch)
  let touchStartX = 0;
  document.addEventListener('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });

  document.addEventListener('touchend', function(e) {
    const sidebar = document.querySelector('.sidebar');
    if (!sidebar || !sidebar.classList.contains('active')) return;
    const touchEndX = e.changedTouches[0].screenX;
    const diff = touchStartX - touchEndX;
    if (diff > 80) { // swipe left > 80px
      closeSidebar();
    }
  }, { passive: true });

  // Revenue Chart Configuration (safe)
  const chartElem = document.getElementById("revenueChart");
  if (chartElem) {
    const ctx = chartElem.getContext("2d");

    // Create gradient
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, "rgba(14, 165, 233, 0.5)"); // Sky 500
    gradient.addColorStop(1, "rgba(14, 165, 233, 0.05)");

    const revenueChart = new Chart(ctx, {
      type: "line",
      data: {
        labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
        datasets: [
          {
            label: "Revenue",
            data: [1500, 2300, 3200, 2900, 4500, 3800, 5100],
            backgroundColor: gradient,
            borderColor: "#0ea5e9", // Sky 500
            borderWidth: 3,
            pointBackgroundColor: "#ffffff",
            pointBorderColor: "#0ea5e9", // Sky 500
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.4,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            backgroundColor: "rgba(255, 255, 255, 0.9)",
            titleColor: "#0f172a",
            bodyColor: "#0f172a",
            borderColor: "rgba(14, 165, 233, 0.2)",
            borderWidth: 1,
            padding: 10,
            cornerRadius: 8,
            displayColors: false,
          },
        },
        scales: {
          x: {
            grid: {
              color: "rgba(0, 0, 0, 0.05)",
              borderDash: [5, 5],
            },
            ticks: {
              color: "#64748b",
            },
          },
          y: {
            grid: {
              color: "rgba(0, 0, 0, 0.05)",
              borderDash: [5, 5],
            },
            ticks: {
              color: "#64748b",
              callback: function (value) {
                return "$" + value;
              },
            },
          },
        },
      },
    });
  }

  // Sidebar active state toggle logic
  const navLinks = document.querySelectorAll(".nav-link");

  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      // Toggle Submenu
      if (this.classList.contains('submenu-toggle')) {
          e.preventDefault();
          const parentItem = this.closest('.nav-item');
          const submenu = parentItem.querySelector('.submenu');
          
          parentItem.classList.toggle('open');
          
          if (parentItem.classList.contains('open')) {
              submenu.style.display = 'block';
          } else {
              submenu.style.display = 'none';
          }
          return; // Don't trigger active state for toggle itself immediately
      }

      // Normal Link Active State
      if (!this.closest('.submenu')) { // Only main links or leaves
           navLinks.forEach((n) => n.classList.remove("active"));
           this.classList.add("active");
      }
    });
  });
});
