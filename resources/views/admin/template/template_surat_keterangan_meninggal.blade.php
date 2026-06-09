<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SURAT KETERANGAN MENINGGAL DUNIA</title>
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

        /* Toolbar Aksi */
        .toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #2d3748;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .toolbar button {
            padding: 8px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-cetak {
            background: #3182ce;
            color: white;
        }

        .btn-cetak:hover {
            background: #2b6cb0;
        }

        .btn-tutup {
            background: #718096;
            color: white;
        }

        .btn-tutup:hover {
            background: #4a5568;
        }

        /* Kertas Folio: 8.5in x 13in */
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

        /* === KOP SURAT === */
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

        .kop-logo {
            width: 75px;
            height: 90px;
            flex-shrink: 0;
        }

        .kop-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .kop-text {
            text-align: center;
            flex: 1;
        }

        .kop-text .kab {
            font-size: 15pt;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .kop-text .kec {
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .kop-text .nagari {
            font-size: 15pt;
            font-weight: bold;
            text-decoration: none;
            letter-spacing: 1px;
        }

        .kop-text .alamat {
            font-size: 9pt;
            font-style: italic;
            margin-top: 2px;
        }

        /* === JUDUL SURAT === */
        .judul-surat {
            text-align: center;
            margin: 20px 0 16px 0;
        }

        .judul-surat h2 {
            font-size: 14pt;
            text-decoration: underline;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .judul-surat .nomor {
            font-size: 11pt;
        }

        /* === ISI SURAT === */
        .isi-surat {
            font-size: 12pt;
            line-height: 1.7;
            text-align: justify;
            flex: 1;
        }

        .isi-surat p {
            margin-bottom: 8px;
            text-indent: 40px;
        }

        .isi-surat p.no-indent {
            text-indent: 0;
        }

        .section-label {
            margin: 8px 0 4px 0;
            text-indent: 0 !important;
            font-weight: normal;
        }

        .data-table {
            width: 85%;
            margin: 4px auto 8px 60px;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 1px 4px;
            vertical-align: top;
            font-size: 12pt;
        }

        .data-table td:first-child {
            width: 165px;
        }

        .data-table td:nth-child(2) {
            width: 14px;
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        /* === TTD / FOOTER === */
        .ttd-section {
            margin-top: auto;
            padding-top: 16px;
        }

        .ttd-wrapper {
            float: right;
            text-align: center;
            width: 320px;
            font-size: 12pt;
        }

        .ttd-wrapper .jabatan {
            font-size: 12pt;
            font-weight: bold;
            margin-top: 4px;
        }

        .ttd-wrapper .nagari-label {
            font-size: 12pt;
            font-weight: bold;
        }

        .ttd-wrapper .nama-ttd {
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 70px;
        }

        .ttd-wrapper .nip {
            font-size: 11pt;
        }

        /* === PRINT STYLES === */
        @media print {
            @page {
                size: 8.5in 13in;
                margin: 0;
            }

            body {
                background: none;
                padding: 0;
                display: block;
            }

            .toolbar {
                display: none !important;
            }

            .page {
                width: 8.5in;
                height: 13in;
                margin: 0;
                padding: 0.75in 1in 0.75in 1in;
                box-shadow: none;
                page-break-after: avoid;
                page-break-inside: avoid;
            }
        }

        /* Responsive untuk layar kecil */
        @media screen and (max-width: 900px) {
            .page {
                width: 100%;
                height: auto;
                min-height: 13in;
                padding: 0.5in;
            }
        }
    </style>
</head>
<body>

    <!-- Toolbar Aksi -->
    <div class="toolbar">
        <button class="btn-cetak" onclick="window.print()">
            🖨️ Cetak / Download PDF
        </button>
        <button class="btn-tutup" onclick="window.close(); history.back();">
            ✕ Tutup
        </button>
    </div>

    <!-- Halaman Surat -->
    <div class="page">

        <!-- KOP SURAT -->
        <div class="kop-surat">
            <div class="kop-logo">
                <img src="{{ asset('tempalate/Pasaman_Barat.png') }}" alt="Logo Kabupaten Pasaman Barat">
            </div>
            <div class="kop-text">
                <div class="kab">PEMERINTAH KABUPATEN PASAMAN BARAT</div>
                <div class="kec">KECAMATAN LEMBAH MELINTANG</div>
                <div class="nagari">WALI NAGARI KUAMANG ALAI UJUNG GADING</div>
                <div class="alamat">Alamat : Jalan Flores Jorong Kuamang, Email : kuamangalaiug@gmail.com, Kode Pos 26372</div>
            </div>
        </div>

        <!-- JUDUL SURAT -->
        <div class="judul-surat">
            <h2>SURAT KETERANGAN MENINGGAL DUNIA</h2>
            <div class="nomor">Nomor : {{ $nomor_surat ?? '400.7.22/ .... / WN-KA.UG/...../....' }}</div>
        </div>

        <!-- ISI SURAT -->
        <div class="isi-surat">
            <p>Yang bertanda tangan dibawah ini, Penjabat Wali Nagari Kuamang Alai Ujung Gading Kecamatan Lembah Melintang Kabupaten Pasaman Barat dengan ini  menerangkan Berdasarkan Laporan dari :</p>

            <!-- DATA PELAPOR -->
            <table class="data-table">
                <tr><td>Nama</td><td>:</td><td class="bold">{{ $nama_pelapor ?? '....' }}</td></tr>
                <tr><td>Nomor KTP/NIK</td><td>:</td><td>{{ $nik_pelapor ?? '....' }}</td></tr>
                <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $jk_pelapor ?? '....' }}</td></tr>
                <tr><td>Hubungan dg yg Meninggal</td><td>:</td><td>{{ $hubungan ?? '....' }}</td></tr>
                <tr><td>Agama</td><td>:</td><td>{{ $agama_pelapor ?? '....' }}</td></tr>
                <tr><td>Alamat</td><td>:</td><td>{{ $alamat_pelapor ?? '....' }}</td></tr>
            </table>

            <p class="no-indent" style="margin-top: 10px;"></p>
            <p class="no-indent">Melaporkan Bahwa :</p>

            <!-- DATA ALMARHUM/AH -->
            <table class="data-table">
                <tr><td>Nama</td><td>:</td><td class="bold">{{ $nama_almarhum ?? '....' }}</td></tr>
                <tr><td>Tempat/ Tgl Lahir</td><td>:</td><td>{{ $tempat_lahir_almarhum ?? '....' }}, {{ $tanggal_lahir_almarhum ?? '....' }}</td></tr>
                <tr><td>Nomor KTP/NIK</td><td>:</td><td>{{ $nik_almarhum ?? '....' }}</td></tr>
                <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $jk_almarhum ?? '....' }}</td></tr>
                <tr><td>Agama</td><td>:</td><td>{{ $agama_almarhum ?? '....' }}</td></tr>
                <tr><td>Alamat</td><td>:</td><td>{{ $alamat_almarhum ?? '....' }}</td></tr>
            </table>

            <p class="no-indent" style="margin-top: 10px;"></p>
            <p class="no-indent">Telah Meninggal Dunia Pada :</p>

            <!-- DATA KEMATIAN -->
            <table class="data-table">
                <tr><td>Hari/Tanggal</td><td>:</td><td>{{ $hari_meninggal ?? '....' }}/{{ $tanggal_meninggal ?? '....' }}</td></tr>
                <tr><td>Waktu</td><td>:</td><td>{{ $waktu_meninggal ?? '....' }} WIB</td></tr>
                <tr><td>Tempat</td><td>:</td><td>{{ $tempat_meninggal ?? '....' }}</td></tr>
                <tr><td>Penyebab</td><td>:</td><td>{{ $penyebab ?? '....' }}</td></tr>
                <tr><td>Dikebumikan Di</td><td>:</td><td>{{ $tempat_kebumikan ?? '....' }}</td></tr>
            </table>

            <p style="margin-top: 12px;">Demikianlah Surat Keterangan ini dibuat dengan sebenarnya, untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <!-- TANDA TANGAN -->
        <div class="ttd-section">
            <div class="ttd-wrapper">
                <div class="tanggal-surat">Kuamang Alai Ujung Gading, {{ $tanggal_surat ?? '....' }}</div>
                <div class="jabatan">Penjabat Wali Nagari</div>
                <div class="nagari-label">Kuamang Alai Ujung Gading</div>
                <div class="nama-ttd">{{ $nama_penandatangan ?? '....' }}</div>
                <div class="nip">NIP. {{ $nip_penandatangan ?? '....' }}</div>
            </div>
            <div style="clear: both;"></div>
        </div>

    </div>

</body>
</html>
