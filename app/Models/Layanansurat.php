<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanantsurat extends Model
{
    protected $table = 'jenis_layanan';

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'persyaratan',
    ];

    public $timestamps = true;
}
