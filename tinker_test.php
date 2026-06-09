<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$schema = DB::getSchemaBuilder();
$cols = $schema->getColumnListing('riwayat_surat');
echo 'data_surat exists: ' . (in_array('data_surat', $cols) ? 'YES' : 'NO') . PHP_EOL;

if (in_array('data_surat', $cols)) {
    $s = App\Models\RiwayatSurat::create([
        'nik_pemohon' => '9999999999999999',
        'jenis_surat' => 'TEST',
        'data_surat' => ['test_field' => 'hello'],
        'penandatangan_id' => 1,
        'jorong' => 'TEST',
        'tanggal_pengantar' => '2026-06-01',
        'status' => 'diajukan',
        'tanggal_pengajuan' => now(),
    ]);
    echo 'Created ID: ' . $s->id . PHP_EOL;
    echo 'data_surat: ';
    var_dump($s->data_surat);
    echo PHP_EOL;

    // Read fresh from DB
    $fresh = App\Models\RiwayatSurat::find($s->id);
    echo 'Fresh from DB data_surat: ';
    var_dump($fresh->data_surat);
    echo PHP_EOL;

    // Clean up
    $s->delete();
    echo 'Deleted test record' . PHP_EOL;
} else {
    echo 'ERROR: data_surat column does not exist!' . PHP_EOL;
}
