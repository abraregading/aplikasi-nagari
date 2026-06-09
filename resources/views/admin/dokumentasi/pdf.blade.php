<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #6366f1;
        }
        .header h1 {
            font-size: 22px;
            color: #6366f1;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }
        .meta {
            text-align: right;
            font-size: 10px;
            color: #888;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            background: #6366f1;
            color: white;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
            page-break-after: avoid;
        }
        .role-card {
            border: 1px solid #ddd;
            margin-bottom: 12px;
            page-break-inside: avoid;
        }
        .role-header {
            background: #f5f5f5;
            padding: 8px 12px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .role-name {
            font-weight: bold;
            font-size: 12px;
            color: #333;
        }
        .role-route {
            font-size: 10px;
            color: #6366f1;
            background: #eef2ff;
            padding: 2px 8px;
            border-radius: 3px;
        }
        .role-body {
            padding: 10px 12px;
        }
        .role-desc {
            font-size: 10px;
            color: #666;
            margin-bottom: 8px;
            font-style: italic;
        }
        .role-middleware {
            font-size: 9px;
            color: #888;
            margin-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        th {
            background: #f8f8f8;
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-weight: bold;
        }
        td {
            border: 1px solid #ddd;
            padding: 5px 6px;
            vertical-align: top;
        }
        td:first-child {
            font-weight: bold;
            width: 25%;
            color: #444;
        }
        .feature-list {
            margin: 0;
            padding-left: 15px;
        }
        .feature-list li {
            margin-bottom: 2px;
        }
        .role-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-admin { background: #dc2626; color: white; }
        .badge-operator { background: #2563eb; color: white; }
        .badge-petugas { background: #059669; color: white; }
        .badge-warga { background: #7c3aed; color: white; }
        .badge-kajor { background: #ea580c; color: white; }
        .badge-public { background: #6b7280; color: white; }
        
        .footer {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 9px;
            color: #888;
        }
        
        .comparison-table th {
            background: #6366f1;
            color: white;
        }
        
        .comparison-table td {
            text-align: center;
        }
        .comparison-table td:first-child {
            text-align: left;
        }
        
        .check { color: #059669; }
        .cross { color: #dc2626; }
        
        @page {
            margin: 20mm;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $data['title'] }}</h1>
        <h2>{{ $data['subtitle'] }}</h2>
    </div>
    
    <div class="meta">
        Generated: {{ $data['generated'] }}
    </div>

    <div class="section">
        <div class="section-title">DAFTAR ROLE PENGGUNA</div>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Role</th>
                    <th>Route</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['roles'] as $index => $role)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <span class="role-badge badge-{{ $role['slug'] }}">
                            {{ $role['name'] }}
                        </span>
                    </td>
                    <td>{{ $role['route'] }}</td>
                    <td>{{ $role['deskripsi'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach($data['roles'] as $role)
    <div class="section">
        <div class="section-title">{{ $role['name'].' - DETAIL FITUR' }}</div>
        
        <div class="role-card">
            <div class="role-header">
                <span class="role-name">{{ $role['name'] }}</span>
                <span class="role-route">{{ $role['route'] }}</span>
            </div>
            <div class="role-body">
                <div class="role-desc">{{ $role['deskripsi'] }}</div>
                <div class="role-middleware">Middleware: {{ $role['middleware'] }}</div>
                
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Fitur</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($role['fitur'] as $index => $fitur)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $fitur['nama'] }}</td>
                            <td>{{ $fitur['deskripsi'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach

    <div class="section">
        <div class="section-title">TABEL PERBANDINGAN AKSES FITUR</div>
        
        <table class="comparison-table">
            <thead>
                <tr>
                    <th>Fitur</th>
                    <th>Admin</th>
                    <th>Operator</th>
                    <th>Petugas</th>
                    <th>Warga</th>
                    <th>Kajor</th>
                    <th>Public</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Dashboard</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                </tr>
                <tr>
                    <td>CRUD Penduduk</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td>Read</td>
                    <td class="cross">✗</td>
                    <td>Read</td>
                    <td class="cross">✗</td>
                </tr>
                <tr>
                    <td>CRUD Keluarga</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                    <td>Read</td>
                    <td class="cross">✗</td>
                </tr>
                <tr>
                    <td>Buat Surat</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                </tr>
                <tr>
                    <td>Proses Surat</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                    <td>Read</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                </tr>
                <tr>
                    <td>Import/Export</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                </tr>
                <tr>
                    <td>Moderasi Konten</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                </tr>
                <tr>
                    <td>Manajemen User</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                </tr>
                <tr>
                    <td>View Bisnis Kos</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                </tr>
                <tr>
                    <td>CRUD Bisnis Kos</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                    <td>Read</td>
                    <td class="cross">✗</td>
                </tr>
                <tr>
                    <td>Ganti Password</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="check">✓</td>
                    <td class="cross">✗</td>
                </tr>
                <tr>
                    <td>Akses Website</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="check">✓</td>
                </tr>
                <tr>
                    <td>Komentar Berita</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="cross">✗</td>
                    <td class="check">✓</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh SIYanDuk App</p>
        <p>© 2026 Nagari Kuamangalai - Sistem Informasi Layanan Administrasi Kependudukan</p>
    </div>
</body>
</html>