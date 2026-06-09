<?php

namespace App\Helpers;

use App\Models\RiwayatSurat;
use App\Models\SuratCounter;
use App\Models\ProfilNagari;
use App\Models\JenisSurat;

class SuratHelper
{
    public static function bulanRomawi($date)
    {
        $bulan = (int) $date->format('n');
        $romawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        return $romawi[$bulan - 1];
    }

    public static function bersihkanKode($value)
    {
        return trim(preg_replace('/[^A-Za-z0-9.]/', '', $value));
    }

    public static function generateNomorSurat(RiwayatSurat $surat): string
    {
        $tanggal = $surat->tanggal_selesai ?? now();
        $tahun = $tanggal->format('Y');

        $jenis = JenisSurat::where('nama_layanan', $surat->jenis_surat)->first();
        $kodeSurat = self::bersihkanKode($jenis && $jenis->kode_surat ? $jenis->kode_surat : 'XXX');

        $kodeDesa = ProfilNagari::where('setting_key', 'kode_desa')->value('setting_value') ?? '000.0.00';
        $kodeDesa = self::bersihkanKode($kodeDesa);

        $counter = SuratCounter::firstOrCreate(
            ['kode_surat' => $kodeSurat, 'tahun' => $tahun],
            ['counter' => 0]
        );

        $counter->increment('counter');

        $noUrut = str_pad($counter->counter, 3, '0', STR_PAD_LEFT);
        $bulanRomawi = self::bulanRomawi($tanggal);

        return "{$noUrut}/{$kodeSurat}/{$kodeDesa}/{$bulanRomawi}/{$tahun}";
    }
}
