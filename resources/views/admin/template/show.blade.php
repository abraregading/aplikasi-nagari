@extends('admin.layouts.app')

@section('title', 'Detail Template Surat')

@section('head')
<style>
    .detail-card {
        display: grid;
        gap: 1.5rem;
    }
    .detail-row {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
    }
    .detail-value {
        color: var(--text-main);
    }
    .template-preview-frame {
        border-radius: 12px;
        overflow: hidden;
        background: #e8e8e8;
    }
    .template-code {
        background: rgba(0,0,0,0.3);
        color: #e2e8f0;
        padding: 1.5rem;
        border-radius: 12px;
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
        overflow-x: auto;
        white-space: pre-wrap;
        word-wrap: break-word;
        max-height: 500px;
        overflow-y: auto;
    }
    .tab-buttons {
        display: flex;
        gap: 0;
        margin-bottom: 1.5rem;
    }
    .tab-btn {
        padding: 0.7rem 1.5rem;
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--border-glass);
        color: var(--text-muted);
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .tab-btn:first-child {
        border-radius: 8px 0 0 8px;
    }
    .tab-btn:last-child {
        border-radius: 0 8px 8px 0;
    }
    .tab-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
</style>
@endsection

@section('konten')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="{{ route('template-surat.index') }}" class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.5rem 1rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <h2 style="margin: 0;">Detail Template Surat</h2>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('template-surat.edit', $template->id) }}" class="glass-select" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.25); padding: 0.6rem 1.2rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
            <i class="ri-edit-line"></i> Edit
        </a>
        <form action="{{ route('template-surat.destroy', $template->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="glass-select" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); padding: 0.6rem 1.2rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem;">
                <i class="ri-delete-bin-line"></i> Hapus
            </button>
        </form>
    </div>
</div>

{{-- Info Template --}}
<div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 1.5rem;">
    <h3 style="margin-bottom: 1.5rem; color: var(--primary); display: flex; align-items: center; gap: 0.5rem;">
        <i class="ri-file-text-line"></i> Informasi Template
    </h3>
    <div class="detail-card">
        <div class="detail-row">
            <span class="detail-label">Nama Template</span>
            <span class="detail-value" style="font-weight: 600;">{{ $template->nama_template }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Tipe Surat</span>
            <span class="detail-value">
                @if($template->tipe)
                    <span style="background: rgba(99, 102, 241, 0.15); color: #818cf8; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500;">
                        {{ ucfirst($template->tipe) }}
                    </span>
                @else
                    <span style="color: var(--text-muted);">Belum ditentukan</span>
                @endif
            </span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="detail-value">
                @if($template->is_active)
                    <span class="status-badge status-success">Aktif</span>
                @else
                    <span class="status-badge status-danger">Nonaktif</span>
                @endif
            </span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Deskripsi</span>
            <span class="detail-value">{{ $template->deskripsi ?? '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Dibuat</span>
            <span class="detail-value">{{ $template->created_at->format('d M Y, H:i') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Terakhir Diubah</span>
            <span class="detail-value">{{ $template->updated_at->format('d M Y, H:i') }}</span>
        </div>
    </div>
</div>

{{-- Isi Template --}}
<div class="glass" style="padding: 2rem; border-radius: 16px;">
    <h3 style="margin-bottom: 1rem; color: var(--primary); display: flex; align-items: center; gap: 0.5rem;">
        <i class="ri-eye-line"></i> Preview Template
    </h3>

    <div class="tab-buttons">
        <button class="tab-btn active" onclick="switchTab('preview')">
            <i class="ri-eye-line"></i> Preview
        </button>
        <button class="tab-btn" onclick="switchTab('code')">
            <i class="ri-code-s-slash-line"></i> Kode HTML
        </button>
    </div>

    <div id="tab-preview" class="tab-content active">
        <div class="template-preview-frame">
            <iframe id="templateIframe" srcdoc="{{ htmlspecialchars($template->isi_template) }}" style="width: 100%; height: 850px; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; background: #fff;"></iframe>
        </div>
    </div>

    <div id="tab-code" class="tab-content">
        <div class="template-code">{{ $template->isi_template }}</div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    function switchTab(tab) {
        // Remove active from all tabs
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        // Activate selected tab
        document.getElementById('tab-' + tab).classList.add('active');
        event.target.closest('.tab-btn').classList.add('active');
    }
</script>
@endsection
