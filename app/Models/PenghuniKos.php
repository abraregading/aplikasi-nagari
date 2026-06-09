<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenghuniKos extends Model
{
    protected $table = 'penghuni_kos';

    protected $fillable = [
        'bisnis_kos_id',
        'petugas_id',
        'nama_lengkap',
        'nik',
        'jekel',
        'tanggal_lahir',
        'tempat_lahir',
        'pekerjaan',
        'asal_desa',
        'asal_kecamatan',
        'asal_kabupaten',
        'no_kamar',
        'harga_sewa',
        'tanggal_masuk',
        'tanggal_keluar',
        'status',
        'catatan',
    ];

    protected $casts = [
        'harga_sewa' => 'decimal:2',
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    public function bisnisKos(): BelongsTo
    {
        return $this->belongsTo(BisnisKos::class, 'bisnis_kos_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'aktif' => 'Aktif',
            'pindah' => 'Pindah',
            'keluar' => 'Keluar',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getJekelLabelAttribute(): string
    {
        return $this->jekel === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}