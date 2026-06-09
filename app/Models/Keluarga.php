<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $table = 'keluarga';
    protected $fillable = [
        'no_kk',
        'kepala_keluarga_nik',
        'kepala_keluarga_nik_hash',
        'alamat',
        'jorong',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_pos',
        'jumlah_anggota',
        'status',
    ];

    protected $casts = [
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->kepala_keluarga_nik) {
                $model->kepala_keluarga_nik_hash = hash('sha256', $model->kepala_keluarga_nik);
            }
        });
    }

    public function penduduks()
    {
        return $this->hasMany(Penduduk::class, 'no_kk', 'no_kk');
    }

    public function kepalaKeluarga()
    {
        return $this->belongsTo(Penduduk::class, 'kepala_keluarga_nik', 'nik');
    }
}
