<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Usaha {{ $bisnis->nama_usaha }} - {{ config('app.name', 'Si YanDuk') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background: #fff; color: #333; }

        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .header h1 { font-size: 22px; margin-bottom: 5px; text-transform: uppercase; }
        .header h2 { font-size: 16px; font-weight: normal; color: #666; }
        .header .jorong { font-size: 14px; color: #333; margin-top: 5px; }

        .info-section { margin-bottom: 25px; }
        .info-section h3 { font-size: 14px; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; background: #f5f5f5; padding: 8px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .info-item { display: flex; font-size: 12px; }
        .info-label { font-weight: 600; width: 140px; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 11px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background-color: #f0f0f0; font-weight: 600; font-size: 10px; }

        .badge { padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .badge-aktif { background: #d1fae5; color: #065f46; }
        .badge-nonaktif { background: #e5e7eb; color: #374151; }
        .badge-pindah { background: #fef3c7; color: #92400e; }
        .badge-keluar { background: #fee2e2; color: #991b1b; }

        .section-title { font-size: 14px; font-weight: 600; margin: 20px 0 10px 0; padding: 8px; background: #f9fafb; border-left: 3px solid #333; }

        .footer { margin-top: 30px; text-align: right; font-size: 11px; color: #666; }
        .footer p { margin-bottom: 3px; }

        .no-print { margin-top: 20px; text-align: center; }
        .no-print button { padding: 10px 20px; margin: 0 5px; cursor: pointer; border: none; border-radius: 5px; font-size: 12px; }
        .btn-print { background: #333; color: #fff; }

        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Data Usaha Kos & Kontrakan</h1>
        <h2>{{ config('app.name', 'Si YanDuk') }} - Nagari {{ $profil['nama_nagari'] ?? 'Nagari' }}</h2>
        <div class="jorong">Jorong: <strong>{{ $jorongName }}</strong></div>
    </div>

    <div class="info-section">
        <h3>A. Data Usaha</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama Usaha:</span>
                <span>{{ $bisnis->nama_usaha }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jenis Usaha:</span>
                <span>
                    @switch($bisnis->jenis_usaha)
                        @case('kos') Kos @break
                        @case('kontrakan') Kontrakan @break
                        @case('rumah_petak') Rumah Petak @break
                        @default {{ $bisnis->jenis_usaha }}
                    @endswitch
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Status:</span>
                <span>{{ $bisnis->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jumlah Kamar:</span>
                <span>{{ $bisnis->jumlah_kamar ?? '-' }} kamar</span>
            </div>
            <div class="info-item" style="grid-column: span 2;">
                <span class="info-label">Alamat:</span>
                <span>{{ $bisnis->alamat }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>B. Data Pemilik</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama Pemilik:</span>
                <span>{{ $bisnis->pemilik_nama }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">NIK:</span>
                <span>{{ $bisnis->pemilik_nik ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">No. Telepon:</span>
                <span>{{ $bisnis->pemilik_telepon ?? '-' }}</span>
            </div>
        </div>
    </div>

    @if($bisnis->catatan)
    <div class="info-section">
        <h3>C. Catatan</h3>
        <p style="font-size: 12px;">{{ $bisnis->catatan }}</p>
    </div>
    @endif

    <div class="section-title">D. Data Penghuni</div>
    @if($bisnis->penghunis->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 120px;">Nama Lengkap</th>
                <th style="width: 80px;">NIK</th>
                <th style="width: 40px;">JK</th>
                <th style="width: 60px;">No. Kamar</th>
                <th style="width: 70px;">Tgl Masuk</th>
                <th style="width: 70px;">Tgl Keluar</th>
                <th>Pekerjaan</th>
                <th style="width: 60px;">Asal</th>
                <th style="width: 50px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bisnis->penghunis as $index => $penghuni)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $penghuni->nama_lengkap }}</td>
                <td>{{ $penghuni->nik ?? '-' }}</td>
                <td>{{ $penghuni->jekel == 'L' ? 'L' : 'P' }}</td>
                <td>{{ $penghuni->no_kamar ?? '-' }}</td>
                <td>{{ $penghuni->tanggal_masuk ? $penghuni->tanggal_masuk->format('d/m/Y') : '-' }}</td>
                <td>{{ $penghuni->tanggal_keluar ? $penghuni->tanggal_keluar->format('d/m/Y') : '-' }}</td>
                <td>{{ $penghuni->pekerjaan ?? '-' }}</td>
                <td>{{ $penghuni->asal_desa ?? '-' }}</td>
                <td>
                    <span class="badge badge-{{ $penghuni->status }}">
                        @switch($penghuni->status)
                            @case('aktif') Aktif @break
                            @case('pindah') Pindah @break
                            @case('keluar') Keluar @break
                            @default {{ $penghuni->status }}
                        @endswitch
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p style="font-size: 12px; color: #666; font-style: italic;">Tidak ada data penghuni.</p>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        <p>{{ config('app.name', 'Si YanDuk') }} - Jorong {{ $jorongName }}</p>
    </div>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">Print / Cetak</button>
        <button class="btn-print" onclick="window.close()">Tutup</button>
    </div>
</body>
</html>