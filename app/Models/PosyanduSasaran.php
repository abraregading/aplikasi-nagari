<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosyanduSasaran extends Model
{
    protected $table = 'posyandu_sasaran';

    protected $fillable = [
        'posyandu_id',
        'keluarga_id',
        'penduduk_id',
        'no_kk',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_ibu',
        'nama_ayah',
        'hubungan_keluarga',
        'alamat',
        'status',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'status' => 'string',
    ];

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
