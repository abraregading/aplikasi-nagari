<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatans';
    
    protected $fillable = [
        'nama_jabatan',
    ];


    public function staf()
    {
        return $this->hasMany(Staf::class);
    }

    public function perangkat()
    {
        return $this->hasMany(Perangkat::class);
    }
}
