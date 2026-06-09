<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat - {{ $surat->jenis_surat }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            background: #e8e8e8;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px 0;
        }

        .toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #1e293b;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .toolbar button,
        .toolbar a {
            padding: 8px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-cetak { background: #3b82f6; color: white; }
        .btn-cetak:hover { background: #2563eb; }

        .btn-kembali { background: #10b981; color: white; }
        .btn-kembali:hover { background: #059669; }

        .btn-tutup { background: #64748b; color: white; }
        .btn-tutup:hover { background: #475569; }

        .toolbar-info {
            position: absolute;
            left: 24px;
            color: rgba(255,255,255,0.7);
            font-size: 13px;
            font-family: 'Segoe UI', sans-serif;
        }

        .page {
            width: 8.5in;
            height: 13in;
            background: #fff;
            margin-top: 60px;
            padding: 0.75in 1in 0.75in 1in;
            box-shadow: 0 4px 24px rgba(0,0,0,0.15), 0 1px 4px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 8px;
            border-bottom: 3px solid #000;
            position: relative;
        }

        .kop-surat::after {
            content: '';
            position: absolute;
            bottom: 3px;
            left: 0;
            right: 0;
            border-bottom: 1px solid #000;
        }

        .kop-logo { width: 75px; height: 90px; flex-shrink: 0; }
        .kop-logo img { width: 100%; height: 100%; object-fit: contain; }

        .kop-text { text-align: center; flex: 1; }
        .kop-text .kab { font-size: 15pt; font-weight: bold; letter-spacing: 1px; }
        .kop-text .kec { font-size: 14pt; font-weight: bold; letter-spacing: 0.5px; }
        .kop-text .nagari { font-size: 15pt; font-weight: bold; text-decoration: none; letter-spacing: 1px; }
        .kop-text .alamat { font-size: 9pt; font-style: italic; margin-top: 2px; }

        .judul-surat { text-align: center; margin: 20px 0 16px 0; }
        .judul-surat h2 { font-size: 14pt; text-decoration: underline; font-weight: bold; margin-bottom: 2px; }
        .judul-surat .nomor { font-size: 11pt; }

        .isi-surat { font-size: 12pt; line-height: 1.7; text-align: justify; }
        .isi-surat p { margin-bottom: 10px; text-indent: 40px; }
        .isi-surat p.no-indent { text-indent: 0; }

        .data-table { width: 80%; margin: 8px auto 8px 60px; border-collapse: collapse; }
        .data-table td { padding: 2px 4px; vertical-align: top; font-size: 12pt; }
        .data-table td:first-child { width: 140px; }
        .data-table td:nth-child(2) { width: 14px; text-align: center; }
        .bold { font-weight: bold; }

        .ttd-section { margin-top: 60px; padding-top: 0px; }
        .ttd-wrapper { float: right; text-align: center; width: 320px; font-size: 12pt; }
        .ttd-wrapper .jabatan { font-size: 12pt; font-weight: bold; margin-top: 0; }
        .ttd-wrapper .nama-ttd { font-size: 12pt; font-weight: bold; text-decoration: underline; margin-top: 70px; }
        .ttd-wrapper .nip { font-size: 11pt; }

        @media print {
            @page { size: 8.5in 13in; margin: 0; }
            body { background: none; padding: 0; display: block; }
            .toolbar { display: none !important; }
            .page { width: 8.5in; height: 13in; margin: 0; padding: 0.75in 1in 0.75in 1in; box-shadow: none; page-break-after: avoid; page-break-inside: avoid; }
        }

        @media screen and (max-width: 900px) {
            .page { width: 100%; height: auto; min-height: 13in; padding: 0.5in; }
            .toolbar-info { display: none; }
        }
    </style>
</head>
<body>

    <div class="toolbar">
        <span class="toolbar-info">{{ $surat->jenis_surat }} - {{ $penduduk->nama_lengkap ?? $surat->nik_pemohon }}</span>
        <button class="btn-cetak" onclick="window.print()">Cetak / Download PDF</button>
        <a href="{{ route('buatsurat.proses') }}" class="btn-kembali">Kembali ke Proses</a>
        <button class="btn-tutup" onclick="window.close(); history.back();">Tutup</button>
    </div>

    <div class="page">

        <div class="kop-surat">
            <div class="kop-logo">
                <img src="{{ asset('tempalate/Pasaman_Barat.png') }}" alt="Logo Kabupaten">
            </div>
            <div class="kop-text">
                <div class="kab">PEMERINTAH {{ strtoupper($profil['kabupaten'] ?? 'KABUPATEN PASAMAN BARAT') }}</div>
                <div class="kec">{{ strtoupper($profil['kecamatan'] ?? 'KECAMATAN LEMBAH MELINTANG') }}</div>
                <div class="nagari">{{ strtoupper($profil['bentuk_pemerintahan'] ?? 'KUAMANG ALAI UJUNG GADING') }} {{ strtoupper($profil['nama_pemerintahan'] ?? 'KUAMANG ALAI UJUNG GADING') }}</div>
                <div class="alamat">Alamat : {{ $profil['alamat_kantor'] ?? 'Jalan Flores Jorong Kuamang' }}, Email : {{ $profil['email'] ?? '-' }}, Kode Pos {{ $profil['kode_pos'] ?? '-' }}</div>
            </div>
        </div>

        @if(isset($hasCustomForm) && $hasCustomForm)
            @include($formTemplate, compact('surat', 'profil', 'penduduk', 'penandatangan', 'dataSurat'))
        @else
            @include('operator.buatsurat.forms.surat-umum')
        @endif

    </div>

</body>
</html>