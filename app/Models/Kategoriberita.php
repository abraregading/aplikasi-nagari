<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoriberita extends Model
{
    use HasFactory;

    protected $table = 'kategoriberitas';
    protected $fillable = ['kategori_berita', 'link'];

    public function berita()
    {
        return $this->hasMany(Berita::class, 'kategoriberita_id', 'id');
    }
}
