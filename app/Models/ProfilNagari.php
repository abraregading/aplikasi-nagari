<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilNagari extends Model
{
    protected $table = 'profil_nagari';
    public $timestamps = false;
    protected $fillable = [
        'setting_key',
        'setting_value',
        'updated_at',
    ];
}
