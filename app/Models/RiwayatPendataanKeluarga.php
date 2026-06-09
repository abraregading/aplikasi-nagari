<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPendataanKeluarga extends Model
{
    protected $table = 'riwayat_pendataan_keluarga';

    protected $fillable = [
        'petugas_id',
        'keluarga_id',
        'no_kk',
        'kepala_keluarga_nama',
        'data_sebelum',
        'data_sesudah',
        'qr_token',
        'tanggal_update',
        'catatan',
        'aksi',
    ];

    protected $casts = [
        'data_sebelum' => 'array',
        'data_sesudah' => 'array',
        'tanggal_update' => 'datetime',
    ];

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class, 'keluarga_id');
    }

    public static function generateQrToken(): string
    {
        return 'QRKEL-' . time() . '-' . bin2hex(random_bytes(4));
    }

    public function getQrUrlAttribute(): string
    {
        return url('/petugas-pendataan-keluarga/' . $this->keluarga_id . '/edit?token=' . $this->qr_token);
    }

    public function getQrCodeUrlAttribute(): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($this->qr_url);
    }
}