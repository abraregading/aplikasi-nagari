<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    protected $table = 'posyandu';

    protected $fillable = [
        'kode_posyandu',
        'nama_posyandu',
        'alamat',
        'jorong',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function kaders()
    {
        return $this->hasMany(PosyanduKader::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }
}
