<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    use HasFactory;

    protected $fillable = [
        'penduduk_id',
        'jabatan_id',
        'profil',
        'gambar',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
