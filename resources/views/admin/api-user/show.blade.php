@extends('admin.layouts.app')

@section('title', 'Detail API User')

@section('konten')
<h2 style="margin-bottom: 2rem;">Detail API User</h2>

<div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 2rem;">
    <table style="width: 100%;">
        <tr>
            <td style="padding: 0.75rem 0; width: 30%; font-weight: 600;">Nama User</td>
            <td style="padding: 0.75rem 0;">{{ $apiUser->name }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem 0; font-weight: 600;">Email</td>
            <td style="padding: 0.75rem 0;">{{ $apiUser->email }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem 0; font-weight: 600;">Nama Aplikasi</td>
            <td style="padding: 0.75rem 0;">{{ $apiUser->app_name }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem 0; font-weight: 600;">Deskripsi</td>
            <td style="padding: 0.75rem 0;">{{ $apiUser->app_description ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 0.75rem 0; font-weight: 600;">Status</td>
            <td style="padding: 0.75rem 0;">
                @if($apiUser->status === 'aktif')
                <span class="badge" style="background: #10b981; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Aktif</span>
                @else
                <span class="badge" style="background: #ef4444; color: white; padding: 0.25rem 0.75rem; border-radius: 20px;">Nonaktif</span>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding: 0.75rem 0; font-weight: 600;">Dibuat</td>
            <td style="padding: 0.75rem 0;">{{ $apiUser->created_at->format('d M Y H:i') }}</td>
        </tr>
    </table>
</div>

<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <h3 style="margin-bottom: 1.5rem; color: var(--primary);">API Access</h3>

    <div style="margin-bottom: 1.5rem;">
        <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">Email (untuk login)</label>
        <div style="display: flex; gap: 0.5rem;">
            <input type="text" class="glass-input" value="{{ $apiUser->email }}" readonly style="flex: 1;">
            <button onclick="copyToClipboard('{{ $apiUser->email }}')" class="btn" style="background: #6366f1; color: white; padding: 0.5rem 1rem; border-radius: 8px;">
                <i class="ri-file-copy-line"></i> Copy
            </button>
        </div>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">Base URL API</label>
        <input type="text" class="glass-input" value="{{ url('/api') }}" readonly>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label style="font-weight: 600; display: block; margin-bottom: 0.5rem;">Login Endpoint</label>
        <input type="text" class="glass-input" value="{{ url('/api/login') }}" readonly>
    </div>

    <div style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
        <h4 style="margin-bottom: 1rem;">Cara Penggunaan:</h4>
        <p style="font-size: 0.9rem; color: #9ca3af;">1. Login untuk mendapatkan token:</p>
        <pre style="background: #1f2937; padding: 1rem; border-radius: 8px; overflow-x: auto; font-size: 0.85rem; color: #10b981;">POST {{ url('/api/login') }}
{
  "email": "{{ $apiUser->email }}",
  "password": "password_anda"
}</pre>

        <p style="font-size: 0.9rem; color: #9ca3af; margin-top: 1rem;">2. Gunakan token untuk mengakses endpoint:</p>
        <pre style="background: #1f2937; padding: 1rem; border-radius: 8px; overflow-x: auto; font-size: 0.85rem; color: #10b981;">GET {{ url('/api/penduduk') }}
Header: Authorization: Bearer your_token_here</pre>
    </div>

    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
        <a href="{{ route('api-user.index') }}" class="btn" style="background: #6b7280; color: white; padding: 0.75rem 2rem; border-radius: 8px;">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <a href="{{ route('api-user.edit', $apiUser->id) }}" class="btn" style="background: #f59e0b; color: white; padding: 0.75rem 2rem; border-radius: 8px;">
            <i class="ri-edit-line"></i> Edit
        </a>
    </div>
</div>
@endsection

<style>
.glass-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    background: rgba(255,255,255,0.05);
    color: var(--text);
    font-size: 0.95rem;
}
pre {
    margin: 0;
}
</style>

@section('script')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Berhasil disalin!');
    }, function(err) {
        console.error('Gagal menyalin: ', err);
    });
}
</script>
@endsection