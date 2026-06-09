<div class="judul-surat">
    <h2>{{ strtoupper($surat->jenis_surat ?? 'KETERANGAN') }}</h2>
    <div class="nomor">Nomor: {{ $surat->nomor_surat ?? '....' }}</div>
</div>

<div class="isi-surat">
    <p>Yang bertanda tangan di bawah ini, Wali Nagari {{ ucwords(strtolower($profil['nagari'] ?? 'Kuamang Alai Ujung Gading')) }}, Kecamatan {{ ucwords(strtolower($profil['kecamatan'] ?? 'Lembah Melintang')) }}, Kabupaten {{ ucwords(strtolower($profil['kabupaten'] ?? 'Pasaman Barat')) }}, penyerahan:</p>

    <table class="data-table">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td class="bold">{{ strtoupper($penduduk->nama_lengkap ?? '....') }}</td>
        </tr>
        <tr>
            <td>Tempat/Tgl Lahir</td>
            <td>:</td>
            <td>{{ ucwords(strtolower($penduduk->tempat_lahir ?? '....')) }}, {{ $penduduk ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->isoFormat('D MMMM Y') : '....' }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $penduduk ? ($penduduk->jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan') : '....' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ ucwords(strtolower($penduduk->agama ?? '....')) }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $penduduk->status_perkawinan ? ucwords(strtolower($penduduk->status_perkawinan)) : '....' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ ucwords(strtolower($penduduk->pekerjaan ?? '....')) }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $surat->nik_pemohon ?? '....' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>
                @php
                    $alamat = ucwords(strtolower($surat->nama_jalan ?? ''));
                    $jorong = ucwords(strtolower($surat->jorong ?? ''));
                    $nagari = ucwords(strtolower($profil['nama_nagari'] ?? ''));
                    $kecamatan = ucwords(strtolower($profil['kecamatan'] ?? ''));
                    $kabupaten = ucwords(strtolower($profil['kabupaten'] ?? ''));
                    
                    $alamatLengkap = trim(
                        ($alamat ? $alamat . ', ' : '') .
                        ($jorong ? 'Jorong ' . $jorong . ', ' : '') .
                        ($nagari ? 'Nagari ' . $nagari . ', ' : '') .
                        ($kecamatan ? 'Kecamatan ' . $kecamatan . ', ' : '') .
                        ($kabupaten ? 'Kabupaten ' . $kabupaten : '')
                    );
                @endphp
                {{ $alamatLengkap ?: '....' }}
            </td>
        </tr>
    </table>

    <p>Adalah benar warga/penduduk Jorong {{ ucwords(strtolower($surat->jorong ?? '....')) }} Nagari {{ ucwords(strtolower($profil['nama_nagari'] ?? 'Kuamang Alai Ujung Gading')) }} dan Berdasarkan Surat Pengantar dari Kepala Jorong {{ ucwords(strtolower($surat->jorong ?? '....')) }} Tanggal {{ $surat->tanggal_pengantar ? \Carbon\Carbon::parse($surat->tanggal_pengantar)->isoFormat('D MMMM Y') : '....' }} benar <span class="bold">{{ ucwords(strtolower($surat->keterangan ?? '....')) }}</span></p>

    <p>Surat keterangan ini dipergunakan untuk <span class="bold">{{ ucwords(strtolower($surat->pernyataan ?? '....')) }}</span></p>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya, agar dapat dipergunakan sebagaimana mestinya.</p>
</div>

<div class="ttd-section">
    <div class="ttd-wrapper">
        <div class="tanggal-surat">{{ ucwords(strtolower($profil['nama_pemerintahan'] ?? 'Kuamang Alai Ujung Gading')) }}, {{ now()->isoFormat('D MMMM Y') }}</div>
        @if($penandatangan && stripos($penandatangan->jabatan, 'Sekretaris') !== false)
        <div class="jabatan" style="font-weight: normal;">An. Penjabat Wali Nagari</div>
        <div class="jabatan">{{ $penandatangan->jabatan }}</div>
        @else
        <div class="jabatan">{{ $penandatangan->jabatan ?? $profil['jabatan_penandatangan'] ?? 'Pejabat Wali Nagari' }}</div>
        @endif
        <div class="jabatan">{{ ucwords(strtolower($profil['nama_pemerintahan'] ?? 'KUAMANG ALAI UJUNG GADING')) }}</div>
        <div class="nama-ttd">{{ $penandatangan->nama ?? $profil['nama_penandatangan'] ?? '....' }}</div>
        @if(!$penandatangan || stripos($penandatangan->jabatan, 'Sekretaris') === false)
        <div class="nip">NIP: {{ $penandatangan->nip ?? $profil['nip_penandatangan'] ?? '....' }}</div>
        @endif
    </div>
    <div style="clear: both;"></div>
</div>