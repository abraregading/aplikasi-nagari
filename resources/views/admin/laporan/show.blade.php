@extends('admin.layouts.app')

@section('title', 'Detail Laporan - ' . $laporan->nama)

@section('konten')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('laporan.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #888; text-decoration: none; font-size: 0.9rem;">
        <i class="ri-arrow-left-line"></i> Kembali ke Daftar Laporan
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div>
        <div class="glass" style="padding: 2rem; border-radius: 16px; margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
                <div>
                    <h2 style="margin: 0; font-size: 1.5rem;">{{ $laporan->nama }}</h2>
                    <p style="margin: 0.5rem 0 0; color: #888; font-size: 0.9rem;">
                        <i class="ri-time-line"></i> Dikirim {{ $laporan->created_at->diffForHumans() }}
                    </p>
                </div>
                @if($laporan->status === 'pending')
                    <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">Pending</span>
                @elseif($laporan->status === 'diproses')
                    <span style="background: rgba(59, 130, 246, 0.15); color: #3b82f6; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">Diproses</span>
                @elseif($laporan->status === 'selesai')
                    <span style="background: rgba(34, 197, 94, 0.15); color: #22c55e; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">Selesai</span>
                @else
                    <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">Ditolak</span>
                @endif
            </div>

            <div style="margin-bottom: 1.5rem;">
                <span style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">
                    <i class="ri-folder-line"></i> {{ $laporan->kategori }}
                </span>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
                <h4 style="margin: 0 0 1rem 0; color: #888; font-size: 0.9rem;">Isi Laporan</h4>
                <p style="margin: 0; line-height: 1.8; white-space: pre-wrap;">{{ $laporan->isi_laporan }}</p>
            </div>

            @if($laporan->catatan)
            <div style="background: rgba(59, 130, 246, 0.1); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.2); margin-top: 1.5rem;">
                <h4 style="margin: 0 0 0.5rem 0; color: #3b82f6; font-size: 0.9rem;">
                    <i class="ri-file-edit-line"></i> Catatan Admin
                </h4>
                <p style="margin: 0; color: #ccc;">{{ $laporan->catatan }}</p>
            </div>
            @endif
        </div>

        <div class="glass" style="padding: 2rem; border-radius: 16px;">
            <h3 style="margin: 0 0 1.5rem 0;">Update Status</h3>
            <form action="{{ route('laporan.updateStatus', ['id' => $laporan->id]) }}" method="POST">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #ccc;">Status</label>
                    
                    <select name="status" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: dark;">
                        <option value="pending" {{ $laporan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #ccc;">Catatan (opsional)</label>
                    <textarea name="catatan" rows="3" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: rgba(255,255,255,0.05); color: dark; resize: vertical;">{{ $laporan->catatan }}</textarea>
                </div>
                <button type="submit" style="padding: 0.75rem 2rem; background: var(--primary); border: none; border-radius: 8px; color: white; cursor: pointer;">
                    <i class="ri-save-line"></i> Simpan
                </button>
            </form>
        </div>
    </div>

    <div>
        <div class="glass" style="padding: 2rem; border-radius: 16px;">
            <h3 style="margin: 0 0 1.5rem 0;">Informasi Pelapor</h3>
            
            <div style="margin-bottom: 1.5rem;">
                <p style="margin: 0; color: #888; font-size: 0.85rem;">Nama Lengkap</p>
                <p style="margin: 0.25rem 0 0; font-weight: 600;">{{ $laporan->nama }}</p>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <p style="margin: 0; color: #888; font-size: 0.85rem;">Nomor WhatsApp</p>
                <p style="margin: 0.25rem 0 0;">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $laporan->no_hp) }}" target="_blank" style="color: #22c55e; text-decoration: none;">
                        <i class="ri-whatsapp-line"></i> {{ $laporan->no_hp }}
                    </a>
                </p>
            </div>

            @if($laporan->email)
            <div style="margin-bottom: 1.5rem;">
                <p style="margin: 0; color: #888; font-size: 0.85rem;">Email</p>
                <p style="margin: 0.25rem 0 0;">
                    <a href="mailto:{{ $laporan->email }}" style="color: #3b82f6; text-decoration: none;">
                        <i class="ri-mail-line"></i> {{ $laporan->email }}
                    </a>
                </p>
            </div>
            @endif

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <p style="margin: 0; color: #888; font-size: 0.85rem;">Tanggal Masuk</p>
                <p style="margin: 0.25rem 0 0;">{{ $laporan->created_at->format('d F Y, H:i') }} WIB</p>
            </div>

            @if($laporan->diproses_oleh)
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <p style="margin: 0; color: #888; font-size: 0.85rem;">Diproses Oleh</p>
                <p style="margin: 0.25rem 0 0;">{{ $laporan->diprosesBy->name ?? '-' }}</p>
                @if($laporan->diproses_at)
                <p style="margin: 0.25rem 0 0; font-size: 0.85rem; color: #888;">{{ $laporan->diproses_at->format('d F Y, H:i') }} WIB</p>
                @endif
            </div>
            @endif
        </div>

        <div style="margin-top: 1rem;">
            <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Hapus laporan ini?')" style="width: 100%; padding: 0.75rem; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 8px; color: #ef4444; cursor: pointer;">
                    <i class="ri-delete-bin-line"></i> Hapus Laporan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection