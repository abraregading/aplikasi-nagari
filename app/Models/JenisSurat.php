<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    protected $table = 'jenis_surat';

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'persyaratan',
        'template_id',
        'form_fields',
        'template_file',
        'form_template',
    ];

    protected $casts = [
        'form_fields' => 'array',
    ];

    const UPDATED_AT = null;

    /**
     * Relasi ke template surat
     */
    public function templateSurat()
    {
        return $this->belongsTo(TemplateSurat::class, 'template_id');
    }

    /**
     * Relasi ke riwayat surat
     */
    public function riwayatSurat()
    {
        return $this->hasMany(RiwayatSurat::class, 'jenis_surat', 'nama_layanan');
    }
}
