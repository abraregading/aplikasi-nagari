<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProfilNagari;

class ExportdataController extends Controller
{
    protected $excludeTables = [
        'migrations', 'password_reset_tokens', 'sessions', 'cache',
        'cache_locks', 'jobs', 'job_batches', 'failed_jobs', 'personal_access_tokens'
    ];

    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $tables = $this->getBusinessTables();
        return view('admin.export.index', compact('profil', 'tables'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'export_type' => 'required|in:all,specific',
            'table' => 'required_if:export_type,specific',
            'format' => 'required|in:csv,sql',
        ]);

        $format = $request->format;
        $exportType = $request->export_type;

        if ($exportType === 'all') {
            $tables = $this->getBusinessTables();
            return $this->exportAll($tables, $format);
        }

        $table = $request->table;
        if (!in_array($table, $this->getBusinessTables())) {
            return redirect()->back()->with('error', 'Tabel tidak valid.');
        }
        return $this->exportSingle($table, $format);
    }

    private function getBusinessTables()
    {
        $allTables = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        $key = "Tables_in_{$dbName}";
        $tables = [];
        foreach ($allTables as $table) {
            $name = $table->$key;
            if (!in_array($name, $this->excludeTables)) {
                $tables[] = $name;
            }
        }
        sort($tables);
        return $tables;
    }

    private function getColumnNames($table)
    {
        $cols = DB::select("SHOW COLUMNS FROM `{$table}`");
        return array_map(fn($col) => $col->Field, $cols);
    }

    private function exportSingle($table, $format)
    {
        if ($format === 'csv') {
            return $this->downloadCsv($table);
        }
        return $this->downloadSql($table);
    }

    private function exportAll($tables, $format)
    {
        $zip = new \ZipArchive();
        $zipFilename = storage_path('app/export_' . date('Ymd_His') . '.zip');

        if ($zip->open($zipFilename, \ZipArchive::CREATE) !== true) {
            return redirect()->back()->with('error', 'Gagal membuat file ZIP.');
        }

        foreach ($tables as $table) {
            $content = $format === 'csv'
                ? $this->buildCsvContent($table)
                : $this->buildSqlContent($table);
            $zip->addFromString($table . '.' . $format, $content);
        }

        $zip->close();

        return response()->download($zipFilename)->deleteFileAfterSend(true);
    }

    private function downloadCsv($table)
    {
        $filename = $table . '_' . date('Ymd_His') . '.csv';
        $header = $this->getColumnNames($table);

        return response()->stream(function () use ($table, $header) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $header);
            DB::table($table)->orderBy(DB::raw('IFNULL(id, 1)'))->chunk(500, function ($rows) use ($handle, $header) {
                foreach ($rows as $row) {
                    $data = [];
                    foreach ($header as $col) {
                        $data[] = $row->$col ?? '';
                    }
                    fputcsv($handle, $data);
                }
            });
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function buildCsvContent($table)
    {
        $header = $this->getColumnNames($table);
        $handle = fopen('php://temp', 'w');
        fputcsv($handle, $header);
        DB::table($table)->orderBy(DB::raw('IFNULL(id, 1)'))->chunk(500, function ($rows) use ($handle, $header) {
            foreach ($rows as $row) {
                $data = [];
                foreach ($header as $col) {
                    $data[] = $row->$col ?? '';
                }
                fputcsv($handle, $data);
            }
        });
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);
        return $content;
    }

    private function downloadSql($table)
    {
        $filename = $table . '_' . date('Ymd_His') . '.sql';
        $content = $this->buildSqlContent($table);

        return response($content, 200, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function buildSqlContent($table)
    {
        $output = "-- ----------------------------------------\n";
        $output .= "-- Export tabel: {$table}\n";
        $output .= "-- Tanggal: " . date('Y-m-d H:i:s') . "\n";
        $output .= "-- ----------------------------------------\n\n";
        $output .= "SET NAMES utf8mb4;\n\n";

        $create = DB::select("SHOW CREATE TABLE `{$table}`");
        $createStmt = $create[0]->{'Create Table'};
        $output .= "DROP TABLE IF EXISTS `{$table}`;\n";
        $output .= $createStmt . ";\n\n";

        $cols = $this->getColumnNames($table);
        $colList = '`' . implode('`, `', $cols) . '`';

        DB::table($table)->orderBy(DB::raw('IFNULL(id, 1)'))->chunk(200, function ($rows) use (&$output, $table, $cols, $colList) {
            $values = [];
            foreach ($rows as $row) {
                $rowValues = [];
                foreach ($cols as $col) {
                    $val = $row->$col;
                    if ($val === null) {
                        $rowValues[] = 'NULL';
                    } elseif (is_numeric($val) && !str_starts_with((string)$val, '0')) {
                        $rowValues[] = $val;
                    } else {
                        $rowValues[] = "'" . str_replace("'", "''", $val) . "'";
                    }
                }
                $values[] = '(' . implode(', ', $rowValues) . ')';
            }
            if (!empty($values)) {
                $output .= "INSERT INTO `{$table}` ({$colList}) VALUES\n";
                $output .= implode(",\n", $values) . ";\n\n";
            }
        });

        return $output;
    }
}
