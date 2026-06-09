<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#0ea5e9" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <title>Selamat Datang | Halaman @yield('title')</title>

    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <!-- Remix Icons -->
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('admin')}}/css/style.css" />
    <style>
        @media (max-width: 576px) {
            .glass { padding: 1rem !important; }
            h2 { font-size: 1.25rem; }
            h3 { font-size: 1.1rem; }
        }
    </style>
    @yield('head')
</head>