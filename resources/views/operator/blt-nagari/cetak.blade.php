<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penerima BLT Nagari {{ $tahun }} - {{ config('app.name', 'Si YanDuk') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; padding: 15px; background: #fff; color: #000; font-size: 11px; }

        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; margin-bottom: 3px; text-transform: uppercase; text-decoration: underline; }
        .header .sub { font-size: 12px; margin-top: 3px; }

        .header-left { text-align: left; margin-top: 10px; margin-bottom: 15px; }
        .header-left .sub { font-size: 12px; margin-top: 2px; }
        .header-left .label { display: inline-block; width: 100px; }

        table { width: 100%; border-collapse: collapse; font-size: 9px; }
        th, td { border: 1px solid #000; padding: 4px 5px; text-align: left; vertical-align: top; }
        th { background-color: #f0f0f0; font-weight: 700; font-size: 8px; text-align: center; }

        .ttd { display: inline-block; width: 50px; }

        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            text-align: center;
            font-size: 11px;
        }
        .signature-box { width: 30%; }
        .signature-box .nama { margin-top: 70px; font-weight: 700; text-decoration: underline; }
        .signature-box .nip { font-size: 10px; margin-top: 2px; }

        .no-print { margin-top: 20px; text-align: center; }
        .no-print button { padding: 10px 20px; margin: 0 5px; cursor: pointer; border: none; border-radius: 5px; font-size: 12px; }
        .btn-print { background: #333; color: #fff; }
        .btn-close { background: #999; color: #fff; }

        .print-info { font-size: 9px; color: #666; margin-top: 10px; text-align: right; }

        @media print {
            body { padding: 0; }
            .no-print { display: none; }
            .print-info { display: none; }
            @page { margin: 15mm 10mm; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DATA PENERIMA BLT NAGARI</h1>
        <div class="sub">TAHUN {{ $tahun }}</div>
    </div>

    <div class="header-left">
        <div class="sub"><span class="label">Nagari</span>: <strong>{{ $profil['nama_pemerintahan'] ?? 'Nagari' }}</strong></div>
        <div class="sub"><span class="label">Kecamatan</span>: <strong>{{ $profil['kecamatan'] ?? 'Lembah Melintang' }}</strong></div>
        <div class="sub"><span class="label">Tahun</span>: <strong>{{ $tahun }}</strong></div>
        <div class="sub"><span class="label">Total Penerima</span>: <strong>{{ $data->count() }} KK</strong></div>
    </div>

    @if($data->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">NO</th>
                <th style="width: 18%;">NAMA</th>
                <th style="width: 14%;">NIK</th>
                <th style="width: 12%;">NO KK</th>
                <th style="width: 16%;">TEMPAT DAN TANGGAL LAHIR</th>
                <th style="width: 12%;">ALAMAT (JALAN)</th>
                <th style="width: 8%;">JORONG</th>
                <th style="width: 10%;">PEKERJAAN</th>
                <th style="width: 6%;">JML ANGGOTA KELUARGA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->nik }}</td>
                <td>{{ $item->no_kk ?? '-' }}</td>
                <td>
                    @if($item->tempat_lahir || $item->tanggal_lahir)
                        {{ $item->tempat_lahir ?? '-' }}{{ $item->tempat_lahir && $item->tanggal_lahir ? ', ' : '' }}
                        @if($item->tanggal_lahir){{ $item->tanggal_lahir->format('d/m/Y') }}@endif
                    @else
                        -
                    @endif
                </td>
                <td>{{ $item->alamat_jalan ?? '-' }}</td>
                <td>{{ $item->alamat_jorong ?? '-' }}</td>
                <td>{{ $item->pekerjaan ?? '-' }}</td>
                <td style="text-align: center;">{{ $item->jumlah_anggota_keluarga }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p style="text-align: center; padding: 30px; font-style: italic; font-size: 12px;">
        Tidak ada data penerima BLT Nagari tahun {{ $tahun }}.
    </p>
    @endif

    <div class="signature-section">
        <div class="signature-box">
            <div>Mengetahui,<br>{{ $walinagari?->jabatan?->nama_jabatan ?? 'Wali Nagari' }} {{ $profil['nama_nagari'] ?? '' }}</div>
            <div class="nama">{{ strtoupper($walinagari?->penduduk?->nama_lengkap ?? $profil['nama_wali_nagari'] ?? '(                           )') }}</div>
            <div class="nip">NIP. {{ $profil['nip_wali_nagari'] ?? '19840330 201101 1 003' }}</div>
        </div>

        <div class="signature-box">
            <div><br>Operator,</div>
            <div class="nama">{{ strtoupper(Auth::user()->name ?? '(                           )') }}</div>
        </div>
    </div>

    <div class="print-info">
        Dicetak pada: {{ now()->format('d F Y H:i:s') }}
    </div>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">Print / Cetak</button>
        <button class="btn-close" onclick="window.close()">Tutup</button>
    </div>
</body>
</html>
