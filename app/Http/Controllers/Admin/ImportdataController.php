<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\ProfilNagari;
use Illuminate\Http\Request;
    

use App\Http\Controllers\Controller;

class ImportdataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        
        return view('admin.import.index', compact('profil'));
    }

    /**
     * Import data keluarga dari file CSV
     */
    public function importKeluarga(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);
        $file = $request->file('file');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_map('trim', $data[0]);
        unset($data[0]);
        $errors = [];
        foreach ($data as $i => $row) {
            $row = array_combine($header, $row);
            if (!empty($row['no_kk'])) {
                try {
                    // Validasi status
                    $allowedStatus = ['aktif', 'pindah', 'non-aktif'];
                    if (!in_array(strtolower($row['status'] ?? 'aktif'), $allowedStatus)) {
                        $errors[] = 'Baris '.($i+2).': Status "'.$row['status'].'" tidak valid.';
                        continue;
                    }
                    DB::table('keluarga')->updateOrInsert(
                        ['no_kk' => $row['no_kk']],
                        [
                            'kepala_keluarga_nik' => $row['kepala_keluarga_nik'] ?? null,
                            'alamat' => $row['alamat'] ?? null,
                            'jorong' => $row['jorong'] ?? null,
                            'desa_kelurahan' => $row['desa_kelurahan'] ?? null,
                            'kecamatan' => $row['kecamatan'] ?? null,
                            'kabupaten_kota' => $row['kabupaten_kota'] ?? null,
                            'provinsi' => $row['provinsi'] ?? null,
                            'kode_pos' => $row['kode_pos'] ?? null,
                            'jumlah_anggota' => $row['jumlah_anggota'] ?? 0,
                            'status' => strtolower($row['status'] ?? 'aktif'),
                            'updated_at' => now(),
                        ]
                    );
                } catch (\Exception $e) {
                    $errors[] = 'Baris '.($i+2).': '.$e->getMessage();
                }
            } else {
                $errors[] = 'Baris '.($i+2).': no_kk kosong.';
            }
        }
        if (count($errors) > 0) {
            return redirect()->back()->with('error', 'Beberapa data gagal diimport: <br>'.implode('<br>', $errors));
        }
        return redirect()->back()->with('success', 'Import data keluarga berhasil!');
    }

    /**
     * Import data penduduk dari file CSV
     */
    public function importPenduduk(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);
        $file = $request->file('file');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_map('trim', $data[0]);
        unset($data[0]);
        foreach ($data as $row) {
            $row = array_combine($header, $row);
            if (!empty($row['nik'])) {
                DB::table('penduduk')->updateOrInsert(
                    ['nik' => $row['nik']],
                    [
                        'no_kk' => $row['no_kk'] ?? null,
                        'nama_lengkap' => $row['nama_lengkap'] ?? null,
                        'tempat_lahir' => $row['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
                        'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                        'agama' => $row['agama'] ?? null,
                        'status_perkawinan' => $row['status_perkawinan'] ?? null,
                        'hubungan_keluarga' => $row['hubungan_keluarga'] ?? null,
                        'pekerjaan' => $row['pekerjaan'] ?? null,
                        'pendidikan_terakhir' => $row['pendidikan_terakhir'] ?? null,
                        'alamat' => $row['alamat'] ?? null,
                        'status_hidup' => $row['status_hidup'] ?? 'hidup',
                        'updated_at' => now(),
                    ]
                );
            }
        }
        return redirect()->back()->with('success', 'Import data penduduk berhasil!');
    }

    /**
     * Export seluruh data penduduk ke CSV (semua kolom terisi, tidak ada data hilang/rusak)
     */
    public function exportPendudukCsv()
    {
        $header = [
            'nik', 'no_kk', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'status_perkawinan', 'hubungan_keluarga', 'pekerjaan', 'pendidikan_terakhir', 'alamat', 'status_hidup', 'created_at', 'updated_at'
        ];
        $rows = \DB::table('penduduk')->get();
        $filename = 'data_penduduk_'.date('Ymd_His').'.csv';
        $handle = fopen('php://output', 'w');
        ob_start();
        fputcsv($handle, $header);
        foreach ($rows as $row) {
            $data = [];
            foreach ($header as $col) {
                $val = isset($row->$col) ? $row->$col : '';
                // Pastikan tidak null
                if (in_array($col, ['nik', 'no_kk'])) {
                    // Tambahkan tanda kutip agar dibaca sebagai teks di Excel
                    $val = "'" . $val . "'";
                }
                $data[] = $val === null ? '' : $val;
            }
            fputcsv($handle, $data);
        }
        fclose($handle);
        $csv = ob_get_clean();
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    public function importSql(Request $request)
    {
        $request->validate([
            'file_sql' => 'required|mimes:sql,zip,txt',
        ]);

        set_time_limit(300);

        $file = $request->file('file_sql');
        $sqlContents = [];

        if ($file->getClientOriginalExtension() === 'zip') {
            $zip = new \ZipArchive();
            if ($zip->open($file->getRealPath()) !== true) {
                return redirect()->back()->with('error', 'Gagal membuka file ZIP.');
            }
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);
                if (str_ends_with($name, '.sql')) {
                    $sqlContents[] = $zip->getFromIndex($i);
                }
            }
            $zip->close();
            if (empty($sqlContents)) {
                return redirect()->back()->with('error', 'Tidak ada file .sql ditemukan dalam ZIP.');
            }
        } else {
            $sqlContents[] = file_get_contents($file->getRealPath());
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        $totalStatements = 0;
        $successStatements = 0;
        $errors = [];

        foreach ($sqlContents as $sql) {
            $sql = preg_replace('/--.*$/m', '', $sql);
            $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
            $statements = explode(';', $sql);

            foreach ($statements as $stmt) {
                $stmt = trim($stmt);
                if (empty($stmt)) {
                    continue;
                }
                $totalStatements++;
                try {
                    DB::unprepared($stmt);
                    $successStatements++;
                } catch (\Exception $e) {
                    $errors[] = 'Error: ' . mb_substr($stmt, 0, 100) . '... → ' . $e->getMessage();
                }
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        if (count($errors) > 0) {
            $msg = "Import selesai dengan {$successStatements}/{$totalStatements} statement berhasil.";
            $msg .= '<br>' . implode('<br>', array_slice($errors, 0, 10));
            if (count($errors) > 10) {
                $msg .= '<br>' . (count($errors) - 10) . ' error lainnya...';
            }
            return redirect()->back()->with('error', $msg);
        }

        return redirect()->back()->with('success', "Import SQL berhasil! {$successStatements} statement telah dieksekusi.");
    }

}
