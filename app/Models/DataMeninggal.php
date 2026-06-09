<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataMeninggal extends Model
{
    protected $table = 'data_meninggal';

    protected $fillable = [
        'penduduk_id',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_kk',
        'jorong',
        'tanggal_meninggal',
        'waktu_meninggal',
        'tempat_meninggal',
        'sebab_meninggal',
        'keterangan',
        'status_hubungan',
        'nama_saksi',
        'no_hp_saksi',
        'created_by',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_meninggal' => 'date',
        'waktu_meninggal' => 'datetime:H:i',
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
