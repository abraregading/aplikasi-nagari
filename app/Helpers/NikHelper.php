<?php

namespace App\Helpers;

use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\User;

class NikHelper
{
    public static function hashNik(string $nik): string
    {
        return hash('sha256', $nik);
    }

    public static function findPenduduk(string $nik): ?Penduduk
    {
        return Penduduk::where('nik_hash', self::hashNik($nik))->first();
    }

    public static function findKeluargaByNik(string $nik): ?Keluarga
    {
        return Keluarga::where('kepala_keluarga_nik_hash', self::hashNik($nik))->first();
    }

    public static function findUserByNik(string $nik): ?User
    {
        return User::where('nik_hash', self::hashNik($nik))->first();
    }

    public static function existsPenduduk(string $nik): bool
    {
        return Penduduk::where('nik_hash', self::hashNik($nik))->exists();
    }

    public static function searchPenduduk(string $nik): \Illuminate\Database\Eloquent\Collection
    {
        return Penduduk::where('nik', 'like', "%{$nik}%")->get();
    }
}