<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPerubahanPenduduk extends Model
{
    protected $table = 'pengajuan_perubahan_penduduk';

    protected $fillable = [
        'user_id',
        'penduduk_id',
        'data_baru',
        'alasan',
        'status',
        'catatan',
    ];

    protected $casts = [
        'data_baru' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }
}
