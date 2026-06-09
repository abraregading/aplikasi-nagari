@extends('admin.layouts.app')

@section('title', 'Dokumentasi Aplikasi')

@section('head')
<style>
    .doc-container { padding: 2rem; }
    .doc-header {
        text-align: center;
        margin-bottom: 2rem;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
        border-radius: 16px;
        border: 1px solid rgba(99, 102, 241, 0.2);
    }
    .doc-header h1 {
        font-size: 1.8rem;
        color: #6366f1;
        margin-bottom: 0.5rem;
    }
    .doc-header p {
        color: var(--text-muted);
    }
    .btn-export {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: #6366f1;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-export:hover {
        background: #5558e3;
        transform: translateY(-2px);
    }
    .role-section {
        margin-bottom: 2rem;
    }
    .role-card {
        background: var(--glass);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 16px;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    .role-card-header {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(139, 92, 246, 0.1) 100%);
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .role-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-main);
    }
    .role-route {
        font-size: 0.85rem;
        color: #6366f1;
        background: rgba(99, 102, 241, 0.15);
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
    }
    .role-card-body {
        padding: 1.5rem;
    }
    .role-desc {
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    .role-middleware {
        font-size: 0.8rem;
        color: #888;
        margin-bottom: 1.5rem;
        padding: 0.4rem 0.8rem;
        background: rgba(255,255,255,0.05);
        border-radius: 6px;
        display: inline-block;
    }
    .feature-table {
        width: 100%;
        border-collapse: collapse;
    }
    .feature-table th {
        text-align: left;
        padding: 0.75rem 1rem;
        color: var(--text-muted);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        background: rgba(255,255,255,0.03);
    }
    .feature-table td {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        border-bottom: 1px solid rgba(255,255,255,0.04);
    }
    .feature-table td:first-child {
        font-weight: 600;
        color: #6366f1;
        width: 25%;
    }
    .badge-role {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .bg-admin { background: rgba(220, 38, 38, 0.15); color: #fca5a5; }
    .bg-operator { background: rgba(37, 99, 235, 0.15); color: #93c5fd; }
    .bg-petugas { background: rgba(5, 150, 105, 0.15); color: #6ee7b7; }
    .bg-warga { background: rgba(124, 58, 237, 0.15); color: #c4b5fd; }
    .bg-kajor { background: rgba(234, 88, 12, 0.15); color: #fdba74; }
    .bg-public { background: rgba(107, 114, 128, 0.15); color: #d1d5db; }
</style>
@endsection

@section('konten')
<div class="doc-container">
    <div class="doc-header">
        <h1><i class="ri-book-2-line"></i> Dokumentasi Aplikasi SIYanDuk</h1>
        <p>Sistem Informasi Layanan Administrasi Kependudukan Nagari Kuamangalai</p>
        <p style="margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">
            Generated: {{ now()->format('d-m-Y H:i') }}
        </p>
        <div style="margin-top: 1.5rem;">
            <p style="font-size: 0.9rem; color: var(--text-muted);">
                <i class="ri-information-line"></i> Dokumen juga tersedia di file: <code>dokumentasi-app.md</code> dan <code>deploy.md</code> di root folder project
            </p>
        </div>
    </div>

    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.2rem; margin-bottom: 1rem; color: var(--text-main);">Daftar Role Pengguna</h3>
        <table class="feature-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Role</th>
                    <th>Route</th>
                    <th>Middleware</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['roles'] as $index => $role)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><span class="badge-role bg-{{ $role['slug'] }}">{{ $role['name'] }}</span></td>
                    <td>{{ $role['route'] }}</td>
                    <td style="font-size: 0.8rem;">{{ $role['middleware'] }}</td>
                    <td>{{ $role['deskripsi'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach($data['roles'] as $role)
    <div class="role-section">
        <div class="role-card">
            <div class="role-card-header">
                <span class="role-title">{{ $role['name'] }}</span>
                <span class="role-route">{{ $role['route'] }}</span>
            </div>
            <div class="role-card-body">
                <p class="role-desc">{{ $role['deskripsi'] }}</p>
                <span class="role-middleware">Middleware: {{ $role['middleware'] }}</span>

                <table class="feature-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Fitur</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($role['fitur'] as $index => $fitur)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $fitur['nama'] }}</td>
                            <td>{{ $fitur['deskripsi'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection