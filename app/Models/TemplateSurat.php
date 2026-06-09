<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model
{
    use HasFactory;

    protected $table = 'template_surat';

    protected $fillable = [
        'nama_template',
        'deskripsi',
        'isi_template',
        'tipe',
        'is_active',
        'form_template',
        'cetak_template',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $timestamps = true;

    /**
     * Relasi ke jenis layanan yang menggunakan template ini
     */
    public function jenisLayanan()
    {
        return $this->hasMany(JenisSurat::class, 'template_id');
    }
}
