<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BisnisKos extends Model
{
    protected $table = 'bisnis_kos';

    protected $fillable = [
        'petugas_id',
        'nama_usaha',
        'jenis_usaha',
        'alamat',
        'rt',
        'rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'jumlah_kamar',
        'harga_sewa_min',
        'harga_sewa_max',
        'fasilitas',
        'pemilik_nama',
        'pemilik_nik',
        'pemilik_telepon',
        'status',
        'catatan',
    ];

    protected $casts = [
        'harga_sewa_min' => 'decimal:2',
        'harga_sewa_max' => 'decimal:2',
        'jumlah_kamar' => 'integer',
    ];

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function penghunis(): HasMany
    {
        return $this->hasMany(PenghuniKos::class, 'bisnis_kos_id');
    }

    public function getJenisUsahaLabelAttribute(): string
    {
        $labels = [
            'kos' => 'Kos',
            'kontrakan' => 'Kontrakan',
            'rumah_petak' => 'Rumah Petak',
        ];
        return $labels[$this->jenis_usaha] ?? $this->jenis_usaha;
    }

    public function getTotalPenghuniAktifAttribute(): int
    {
        return $this->penghunis()->where('status', 'aktif')->count();
    }
}