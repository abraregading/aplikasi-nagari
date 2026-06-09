<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            text-align: center;
            padding: 3rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            backdrop-filter: blur(20px);
            max-width: 500px;
        }
        .icon { font-size: 5rem; color: #ef4444; margin-bottom: 1rem; }
        h1 { font-size: 4rem; font-weight: 700; color: #ef4444; }
        h2 { font-size: 1.3rem; margin-top: 0.5rem; font-weight: 500; color: #94a3b8; }
        p { margin-top: 1rem; color: #64748b; font-size: 0.95rem; line-height: 1.6; }
        .btn {
            display: inline-block;
            margin-top: 2rem;
            padding: 0.8rem 2rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(99,102,241,0.3); }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon"><i class="ri-shield-keyhole-line"></i></div>
        <h1>403</h1>
        <h2>Akses Ditolak</h2>
        <p>Anda tidak memiliki izin untuk mengakses halaman ini. Silakan kembali ke dashboard atau hubungi administrator.</p>
        <a href="{{ url('/') }}" class="btn"><i class="ri-arrow-left-line"></i> Kembali ke Beranda</a>
    </div>
</body>
</html>
