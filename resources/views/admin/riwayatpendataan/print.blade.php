<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Riwayat Pendataan Keluarga - {{ $petugas->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; }
        
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header h2 { font-size: 18px; font-weight: normal; color: #666; }
        
        .info-section { margin-bottom: 20px; }
        .info-section h3 { font-size: 16px; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .info-item { display: flex; }
        .info-label { font-weight: 600; width: 140px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; font-weight: 600; }
        
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 11px; }
        .badge-create { background-color: #d4edda; color: #155724; }
        .badge-update { background-color: #fff3cd; color: #856404; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
        
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN RIWAYAT PENDATAAN KELUARGA</h1>
        <h2>{{ config('app.name', 'Si YanDuk') }}</h2>
    </div>
    
    <div class="info-section">
        <h3>Informasi Petugas</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama Petugas:</span>
                <span>{{ $petugas->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span>{{ $petugas->email ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Total Update:</span>
                <span>{{ $totalUpdate }}x</span>
            </div>
            <div class="info-item">
                <span class="info-label">Periode:</span>
                <span>{{ $riwayats->first() ? $riwayats->first()->tanggal_update->format('d/m/Y') : '-' }} - {{ $riwayats->last() ? $riwayats->last()->tanggal_update->format('d/m/Y') : '-' }}</span>
            </div>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th style="width: 130px;">Tanggal</th>
                <th style="width: 150px;">No. KK</th>
                <th>Kepala Keluarga</th>
                <th style="width: 80px;">Aksi</th>
                <th>QR Token</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayats as $index => $riwayat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $riwayat->tanggal_update->format('d/m/Y H:i') }}</td>
                <td>{{ $riwayat->no_kk }}</td>
                <td>{{ $riwayat->kepala_keluarga_nama ?? '-' }}</td>
                <td>
                    @if($riwayat->aksi == 'create')
                    <span class="badge badge-create">Dibuat</span>
                    @else
                    <span class="badge badge-update">Diperbarui</span>
                    @endif
                </td>
                <td style="font-family: monospace; font-size: 10px;">{{ $riwayat->qr_token }}</td>
                <td>{{ $riwayat->catatan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>
    
    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Print</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup</button>
    </div>
</body>
</html>