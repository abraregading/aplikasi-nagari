<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $table = 'penduduk';
    protected $fillable = [
        'nik',
        'nik_hash',
        'no_kk',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'status_perkawinan',
        'hubungan_keluarga',
        'pekerjaan',
        'pendidikan_terakhir',
        'alamat',
        'status_hidup',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->nik) {
                $model->nik_hash = hash('sha256', $model->nik);
            }
        });
    }

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'no_kk', 'no_kk');
    }
}
