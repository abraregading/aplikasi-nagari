@extends('layouts.backend.main')

@section('title', 'Riwayat Pendataan Keluarga')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Riwayat Pendataan Keluarga</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari No. KK atau Nama Kepala Keluarga..."
                                    value="{{ request('search') }}">
                                <select name="aksi" class="form-select" style="width: 150px;">
                                    <option value="">Semua Aksi</option>
                                    <option value="create" {{ request('aksi') == 'create' ? 'selected' : '' }}>Dibuat</option>
                                    <option value="update" {{ request('aksi') == 'update' ? 'selected' : '' }}>Diperbarui</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('petugas.pendataankeluarga.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No. KK</th>
                                    <th>Kepala Keluarga</th>
                                    <th>Aksi</th>
                                    <th>Petugas</th>
                                    <th>QR Code</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayats as $index => $riwayat)
                                <tr>
                                    <td>{{ $riwayats->firstItem() + $index }}</td>
                                    <td>{{ $riwayat->tanggal_update->format('d/m/Y H:i') }}</td>
                                    <td>{{ $riwayat->no_kk }}</td>
                                    <td>{{ $riwayat->kepala_keluarga_nama ?? '-' }}</td>
                                    <td>
                                        @if($riwayat->aksi == 'create')
                                        <span class="badge bg-success">Dibuat</span>
                                        @elseif($riwayat->aksi == 'update')
                                        <span class="badge bg-warning">Diperbarui</span>
                                        @else
                                        <span class="badge bg-danger">{{ $riwayat->aksi }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $riwayat->petugas->name ?? '-' }}</td>
                                    <td>
                                        <img src="{{ $riwayat->qr_code_url }}" alt="QR Code" class="img-thumbnail" style="width: 50px; height: 50px;">
                                    </td>
                                    <td>
                                        <a href="{{ route('petugas.pendataankeluarga.riwayatshow', $riwayat->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="ri-eye-line"></i> Detail
                                        </a>
                                        <a href="{{ $riwayat->qr_url }}" target="_blank"
                                            class="btn btn-sm btn-primary">
                                            <i class="ri-qr-code-line"></i> Buka Link
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada riwayat pendataan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $riwayats->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection