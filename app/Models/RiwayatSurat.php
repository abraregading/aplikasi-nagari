<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatSurat extends Model
{
    protected $table = 'riwayat_surat';

    protected $fillable = [
        'user_id',
        'nik_pemohon',
        'jenis_surat',
        'keterangan',
        'pernyataan',
        'data_surat',
        'penandatangan_id',
        'jorong',
        'nama_jalan',
        'tanggal_pengantar',
        'nomor_surat',
        'status',
        'file_lampiran',
        'tanggal_pengajuan',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_pengantar' => 'date',
        'tanggal_pengajuan' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'data_surat' => 'array',
    ];

    /**
     * Relasi ke data penduduk berdasarkan NIK
     */
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'nik_pemohon', 'nik');
    }

    /**
     * Relasi ke penandatangan surat
     */
    public function penandatangan()
    {
        return $this->belongsTo(Penandatangan::class, 'penandatangan_id');
    }

    /**
     * Relasi ke user (pemohon)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
