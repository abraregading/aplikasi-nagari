<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BltNagari extends Model
{
    protected $table = 'blt_nagari';

    protected $fillable = [
        'penduduk_id',
        'nik',
        'nama',
        'no_kk',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_jalan',
        'alamat_jorong',
        'pekerjaan',
        'jumlah_anggota_keluarga',
        'tahun',
        'created_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tahun' => 'integer',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
