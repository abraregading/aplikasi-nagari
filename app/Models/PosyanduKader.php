<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosyanduKader extends Model
{
    protected $table = 'posyandu_kader';

    protected $fillable = [
        'posyandu_id',
        'nama_kader',
        'jabatan',
        'no_hp',
    ];

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }
}
