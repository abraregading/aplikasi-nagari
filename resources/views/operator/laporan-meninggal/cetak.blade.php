<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Meninggal {{ $namaBulan }} {{ $tahun }} - {{ config('app.name', 'Si YanDuk') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; padding: 15px; background: #fff; color: #000; font-size: 11px; }

        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; margin-bottom: 3px; text-transform: uppercase; text-decoration: underline; }
        .header h2 { font-size: 14px; font-weight: normal; }
        .header .sub { font-size: 12px; margin-top: 3px; }
        .header .sub strong { font-weight: 500; }

        .stats { display: flex; gap: 15px; margin-bottom: 15px; justify-content: center; }
        .stat-box { text-align: center; padding: 8px 20px; border: 1px solid #000; }
        .stat-box .number { font-size: 20px; font-weight: 700; }
        .stat-box .label { font-size: 10px; margin-top: 2px; }

        .header-left { text-align: left; margin-top: 10px; margin-bottom: 15px; }
        .header-left .sub { font-size: 12px; margin-top: 2px; }
        .header-left .label { display: inline-block; width: 70px; }

        .info-print { font-size: 11px; margin-bottom: 5px; }

        .jorong-section { margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px dashed #ccc; }
        .jorong-section:last-child { border-bottom: none; }
        .jorong-title { font-size: 12px; font-weight: 700; margin-bottom: 5px; }

        table { width: 100%; border-collapse: collapse; font-size: 9px; }
        th, td { border: 1px solid #000; padding: 4px 5px; text-align: left; vertical-align: top; }
        th { background-color: #f0f0f0; font-weight: 700; font-size: 8px; text-align: center; }

        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            text-align: center;
            font-size: 11px;
        }
        .signature-box {
            width: 30%;
        }
        .signature-box .jabatan { margin-bottom: 5px; }
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
       <h1>{{ strtoupper('Laporan Peristiwa Kematian (Buku Pokok Pemakaman)') }}</h1>
    </div>
    <div class="header-left">
        <div class="sub"><span class="label">Nagari</span>: <strong>{{ $profil['nama_pemerintahan'] ?? 'Nagari' }}</strong></div>
        <div class="sub"><span class="label">Kecamatan</span>: <strong>{{ $profil['kecamatan'] ?? 'Lembah Melintang' }}</strong></div>
        <div class="sub"><span class="label">Periode</span>: <strong>{{ $namaBulan }} {{ $tahun }}</strong></div>
        @if($jorongFilter)
        <div class="sub"><span class="label">Jorong</span>: <strong>{{ $jorongFilter }}</strong></div>
        @endif
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="number">{{ $totalMeninggal }}</div>
            <div class="label">Total Kematian</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ $totalLaki }}</div>
            <div class="label">Laki-laki</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ $totalPerempuan }}</div>
            <div class="label">Perempuan</div>
        </div>
    </div>

    @if($dataMeninggal->count() > 0)
        @foreach($dataPerJorong as $jorongName => $items)
        <div class="jorong-section">
            <div class="jorong-title">Jorong: {{ $jorongName }}</div>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 3%;">NO</th>
                        <th rowspan="2" style="width: 11%;">NIK</th>
                        <th rowspan="2" style="width: 14%;">NAMA</th>
                        <th rowspan="2" style="width: 8%;">TEMPAT MENINGGAL</th>
                        <th rowspan="2" style="width: 7%;">HUBUNGAN KELUARGA</th>
                        <th rowspan="2" style="width: 12%;">JAM (WIB), TGL, BLN, THN<br>WAKTU MENINGGAL</th>
                        <th rowspan="2" style="width: 10%;">SEBAB KEMATIAN</th>
                        <th colspan="2">SAKSI MENINGGAL 2 ORANG</th>
                        <th rowspan="2" style="width: 10%;">PELAPOR<br>& NO HP</th>
                    </tr>
                    <tr>
                        <th style="width: 10%;">SAKSI I<br>(NAMA)</th>
                        <th style="width: 10%;">SAKSI II</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->tempat_meninggal ?? '-' }}</td>
                        <td>{{ $item->status_hubungan ?? '-' }}</td>
                        <td>
                            @if($item->waktu_meninggal)
                                {{ \Carbon\Carbon::parse($item->waktu_meninggal)->format('H:i') }} WIB<br>
                            @endif
                            {{ $item->tanggal_meninggal->format('d/m/Y') }}
                        </td>
                        <td>{{ $item->sebab_meninggal ?? '-' }}</td>
                        <td>{{ $item->nama_saksi ?? '-' }}</td>
                        <td></td>
                        <td>
                            @if($item->creator)
                                {{ $item->creator->name }}<br>
                                @if($item->no_hp_saksi)
                                    {{ $item->no_hp_saksi }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    @else
        <p style="text-align: center; padding: 30px; font-style: italic; font-size: 12px;">
            Tidak ada data kematian pada bulan {{ $namaBulan }} {{ $tahun }}.
        </p>
    @endif

    <div class="signature-section">
        <div class="signature-box">
            <div class="jabatan">Mengetahui,<br>{{ $walinagari?->jabatan?->nama_jabatan ?? 'Wali Nagari' }} {{ $profil['nama_nagari'] ?? '' }}</div>
            <div class="nama">{{ strtoupper($walinagari?->penduduk?->nama_lengkap ?? $profil['nama_wali_nagari'] ?? '(                           )') }}</div>
            <div class="nip">NIP. {{ $profil['nip_wali_nagari'] ?? '19840330 201101 1 003' }}</div>
        </div>

        <div class="signature-box">
            <div class="jabatan"><br>Operator,</div>
            <div class="nama">{{ strtoupper(Auth::user()->name ?? '(                           )') }}</div>
        </div>
    </div>

    <div class="print-info">
        Dicetak pada: {{ now()->format('d F Y H:i:s') }}
        @if($jorongFilter) | Jorong {{ $jorongFilter }} @endif
    </div>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">Print / Cetak</button>
        <button class="btn-close" onclick="window.close()">Tutup</button>
    </div>
</body>
</html>
