<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_berita',
        'kategoriberita_id',
        'slug',
        'isi_berita1',
        'isi_berita2',
        'isi_berita3',
        'quote',
        'gambar_berita',
        'views',
    ];

    public function kategoriberita()
    {
        return $this->belongsTo(Kategoriberita::class, 'kategoriberita_id', 'id');
    }
}
