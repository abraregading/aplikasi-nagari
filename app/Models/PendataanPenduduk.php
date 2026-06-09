<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendataanPenduduk extends Model
{
    use HasFactory;

    protected $table = 'pendataan_penduduk';

    protected $fillable = [
        'petugas_id',
        'nik',
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
        'status_verifikasi',
        'catatan',
        'tanggal_pendataan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pendataan' => 'datetime',
    ];

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}