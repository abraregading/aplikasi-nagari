<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="13%">NIK</th>
            <th width="22%">Nama Lengkap</th>
            <th width="5%">JK</th>
            <th width="15%">Tgl Meninggal</th>
            <th width="15%">Tempat</th>
            <th width="15%">Sebab</th>
            <th width="10%">Pelapor</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataMeninggal as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nik }}</td>
            <td>{{ $item->nama_lengkap }}</td>
            <td>{{ $item->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
            <td>{{ $item->tanggal_meninggal->format('d/m/Y') }}</td>
            <td>{{ $item->tempat_meninggal ?? '-' }}</td>
            <td>{{ $item->sebab_meninggal ?? '-' }}</td>
            <td>{{ $item->creator ? $item->creator->name : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
