<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penandatangan extends Model
{
    use HasFactory;

    protected $table = 'penandatangan';

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'pangkat_golongan',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * Relasi ke riwayat surat yang ditandatangani
     */
    public function riwayatSurat()
    {
        return $this->hasMany(RiwayatSurat::class, 'penandatangan_id');
    }

    /**
     * Scope hanya penandatangan aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Ambil penandatangan default
     */
    public static function getDefault()
    {
        return static::where('is_default', true)->where('is_active', true)->first();
    }
}
