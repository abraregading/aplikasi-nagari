<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PopulateNikHash extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-nik-hash';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate nik_hash for existing data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating Penduduk nik_hash...');
        $penduduks = \App\Models\Penduduk::whereNotNull('nik')->whereNull('nik_hash')->get();
        foreach ($penduduks as $p) {
            $p->nik_hash = hash('sha256', $p->nik);
            $p->save();
        }
        $this->info('Updated ' . $penduduks->count() . ' penduduk');

        $this->info('Updating Keluarga nik_hash...');
        $keluargas = \App\Models\Keluarga::whereNotNull('kepala_keluarga_nik')->whereNull('kepala_keluarga_nik_hash')->get();
        foreach ($keluargas as $k) {
            $k->kepala_keluarga_nik_hash = hash('sha256', $k->kepala_keluarga_nik);
            $k->save();
        }
        $this->info('Updated ' . $keluargas->count() . ' keluarga');

        $this->info('Updating User nik_hash...');
        $users = \App\Models\User::whereNotNull('nik')->whereNull('nik_hash')->get();
        foreach ($users as $u) {
            $u->nik_hash = hash('sha256', $u->nik);
            $u->save();
        }
        $this->info('Updated ' . $users->count() . ' users');

        $this->info('Done!');
    }
}
