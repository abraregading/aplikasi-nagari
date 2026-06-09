<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Keluarga - {{ $keluarga->no_kk }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background: #fff; }
        
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #333; padding-bottom: 20px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; text-transform: uppercase; }
        .header h2 { font-size: 18px; font-weight: normal; color: #666; }
        
        .info-section { margin-bottom: 25px; }
        .section-title { 
            font-size: 14px; 
            margin-bottom: 10px; 
            border-bottom: 2px solid #333; 
            padding-bottom: 5px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 15px; }
        .info-item { display: flex; }
        .info-label { font-weight: 600; width: 160px; flex-shrink: 0; }
        
        .card {
            border: 1px solid #333;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .card-header {
            background: #f0f0f0;
            padding: 10px 15px;
            border-bottom: 1px solid #333;
            font-weight: 600;
        }
        .card-body { padding: 15px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; font-weight: 600; }
        
        .badge { 
            padding: 3px 10px; 
            border-radius: 4px; 
            font-size: 11px; 
            font-weight: 600;
        }
        .badge-active { background: #d4edda; color: #155724; }
        .badge-moved { background: #fff3cd; color: #856404; }
        .badge-inactive { background: #f8d7da; color: #721c24; }
        
        .footer { 
            margin-top: 30px; 
            text-align: right; 
            font-size: 12px; 
            border-top: 1px solid #333;
            padding-top: 15px;
        }
        
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signature-box {
            width: 200px;
            text-align: center;
        }
        .signature-box .title {
            font-weight: 600;
            margin-bottom: 50px;
        }
        
        .no-print { 
            position: fixed; 
            bottom: 20px; 
            right: 20px;
            display: flex;
            gap: 10px;
        }
        .no-print button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
        }
        .btn-print { background: #333; color: white; }
        .btn-close { background: #666; color: white; }
        
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $profil['nama_pemerintahan'] ?? 'Nagari' }} {{ $profil['nama_nagari'] ?? '' }}</h1>
        <h2>{{ $profil['nama_aplikasi'] ?? 'Si YanDuk' }} - Data Kartu Keluarga</h2>
    </div>
    
    {{-- Info Petugas --}}
    <div class="info-section">
        <div class="section-title">Informasi Petugas</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama Petugas:</span>
                <span>{{ $petugas->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span>{{ $petugas->email ?? '-' }}</span>
            </div>
        </div>
    </div>
    
    {{-- Info Keluarga --}}
    <div class="card">
        <div class="card-header">Data Kartu Keluarga</div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">No. KK:</span>
                    <span style="font-weight: 600;">{{ $keluarga->no_kk }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="badge badge-{{ $keluarga->status }}">
                        @if($keluarga->status == 'aktif') Aktif
                        @elseif($keluarga->status == 'pindah') Pindah
                        @else Non-Aktif
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Kepala Keluarga:</span>
                    <span>{{ $keluarga->kepala_keluarga_nama ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">NIK Kepala:</span>
                    <span>{{ $keluarga->kepala_keluarga_nik ?? '-' }}</span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Alamat:</span>
                    <span>{{ $keluarga->alamat }}, Jorong {{ $keluarga->jorong ?? '-' }}, {{ $keluarga->desa_kelurahan ?? '-' }}, {{ $keluarga->kecamatan ?? '-' }}, {{ $keluarga->kabupaten_kota ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Jumlah Anggota:</span>
                    <span>{{ $keluarga->jumlah_anggota }} orang</span>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Riwayat Update --}}
    @if($riwayat)
    <div class="card">
        <div class="card-header">Riwayat Pendataan</div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Aksi:</span>
                    <span class="badge {{ $riwayat->aksi == 'create' ? 'badge-active' : 'badge-active' }}">
                        @if($riwayat->aksi == 'create') Dibuat @else Diperbarui @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal:</span>
                    <span>{{ $riwayat->tanggal_update->format('d F Y H:i') }}</span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Catatan:</span>
                    <span>{{ $riwayat->catatan ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    {{-- Anggota Keluarga --}}
    <div class="card">
        <div class="card-header">Data Anggota Keluarga ({{ $keluarga->penduduks->count() }} orang)</div>
        <div class="card-body" style="padding: 0;">
            <table>
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>JK</th>
                        <th>Tgl Lahir</th>
                        <th>Hub. Keluarga</th>
                        <th>Pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keluarga->penduduks as $index => $anggota)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $anggota->nik }}</td>
                        <td>{{ $anggota->nama_lengkap }}</td>
                        <td>{{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $anggota->hubungan_keluarga }}</td>
                        <td>{{ $anggota->pekerjaan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada anggota keluarga</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Footer --}}
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        <p>Petugas: {{ $petugas->name }}</p>
    </div>
    
    {{-- Signature --}}
    <div class="signature-section">
        <div class="signature-box">
            <div class="title">Petugas Pendataan</div>
            <div style="margin-top: 40px; border-top: 1px solid #333; padding-top: 5px;">{{ $petugas->name }}</div>
        </div>
        <div class="signature-box">
            <div class="title">{{ $profil['nama_pemerintahan'] ?? 'Nagari' }} {{ $profil['nama_nagari'] ?? '' }}</div>
            <div style="margin-top: 40px; border-top: 1px solid #333; padding-top: 5px;">{{ $profil['nama_pemerintahan'] ?? 'Wali Nagari' }}</div>
        </div>
    </div>
    
    <div class="no-print">
        <button class="btn-print" onclick="window.print()">
            <i class="ri-printer-line"></i> Print
        </button>
        <button class="btn-close" onclick="window.close()">
            <i class="ri-close-line"></i> Tutup
        </button>
    </div>
</body>
</html>