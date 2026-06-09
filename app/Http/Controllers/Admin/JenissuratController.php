<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilNagari;
use App\Models\JenisSurat;
use App\Models\TemplateSurat;
use Illuminate\Validation\ValidationException;

class JenissuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jenisSurat = JenisSurat::with('templateSurat')->get();
        return view('admin.jenis.index', compact('jenisSurat', 'profil'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $templates = TemplateSurat::where('is_active', true)->orderBy('nama_template')->get();
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.jenis.create', compact('templates', 'profil'));
    }

    /**
     * Store a newly created resource in storage.
     */
    protected function parseLooseArray($input)
    {
        $input = trim($input);

        $curlyQuotes = ["\u{201C}", "\u{201D}", "\u{2018}", "\u{2019}", "\u{FF02}", "\u{201E}", "\u{201A}"];
        $input = str_replace($curlyQuotes, '"', $input);

        $input = preg_replace("/'([^']*?)'(\s*[:,\]])/", '"$1"$2', $input);
        $input = preg_replace("/([{,]\s*)'([^']*?)'(\s*:)/", '$1"$2"$3', $input);
        $input = preg_replace('/([{,]\s*)"([^"]*?)"\s*:/', '$1"$2"$3', $input);

        $input = str_replace(["\r\n", "\r", "\n"], ' ', $input);
        $input = preg_replace('/\s+/', ' ', $input);

        $decoded = json_decode($input, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        if (!str_starts_with(trim($input), '[')) {
            $input = '[' . $input . ']';
        }

        $input = preg_replace('/,\s*([\]}])/', '$1', $input);

        if (preg_match('/^\[\s*\{.*\}\s*\]$/', $input)) {
            $decoded = @json_decode($input, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        $inside = substr($input, 1, -1);
        $depth = 0;
        $objects = [];
        $current = '';
        for ($i = 0; $i < strlen($inside); $i++) {
            $ch = $inside[$i];
            if ($ch === '{') { $depth++; $current .= $ch; }
            elseif ($ch === '}') { $depth--; $current .= $ch; if ($depth === 0) { $objects[] = trim($current); $current = ''; } }
            elseif ($depth > 0) { $current .= $ch; }
        }
        if (trim($current) !== '') $objects[] = trim($current);

        $result = [];
        foreach ($objects as $objStr) {
            $objStr = trim($objStr);
            if (str_starts_with($objStr, '{') && str_ends_with($objStr, '}')) {
                $objStr = substr($objStr, 1, -1);
            }

            $pairs = $this->splitPairs($objStr);
            $obj = [];
            foreach ($pairs as $pair) {
                $colonPos = strpos($pair, ':');
                if ($colonPos === false) continue;
                $key = trim(substr($pair, 0, $colonPos));
                $val = trim(substr($pair, $colonPos + 1));

                $key = trim($key, '"\' ');
                $val = trim($val, '"\' ');

                if (strtolower($val) === 'true') $val = true;
                elseif (strtolower($val) === 'false') $val = false;
                elseif (is_numeric($val)) $val = $val + 0;

                $obj[$key] = $val;
            }
            $result[] = $obj;
        }

        return $result;
    }

    protected function splitPairs($inner)
    {
        $pairs = [];
        $current = '';
        $depth = 0;
        $inStr = false;
        $strChar = null;

        for ($i = 0; $i < strlen($inner); $i++) {
            $ch = $inner[$i];

            if ($inStr) {
                $current .= $ch;
                if ($ch === $strChar && ($i === 0 || $inner[$i - 1] !== '\\')) {
                    $inStr = false;
                }
            } else {
                if ($ch === '"' || $ch === "'") {
                    $inStr = true;
                    $strChar = $ch;
                    $current .= $ch;
                } elseif ($ch === '{' || $ch === '[') {
                    $depth++;
                    $current .= $ch;
                } elseif ($ch === '}' || $ch === ']') {
                    $depth--;
                    $current .= $ch;
                } elseif ($ch === ',' && $depth === 0) {
                    $pairs[] = trim($current);
                    $current = '';
                } else {
                    $current .= $ch;
                }
            }
        }
        $remaining = trim($current);
        if ($remaining !== '') $pairs[] = $remaining;

        return $pairs;
    }

    protected function parseFormFields($value)
    {
        if (empty($value)) return null;

        if (is_array($value)) return $value;

        try {
            $result = $this->parseLooseArray($value);
            return $result;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException(
                'Format input tidak dikenali. Gunakan format: [{"name":"field","label":"Nama Field","type":"text","required":true}]'
            );
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'persyaratan' => 'nullable|string',
            'template_id' => 'nullable|exists:template_surat,id',
            'form_fields' => 'nullable|string',
            'template_file' => 'nullable|string|max:100',
            'form_template' => 'nullable|string|max:100',
        ]);

        try {
            $formFields = $this->parseFormFields($request->form_fields);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['form_fields' => $e->getMessage()])->withInput();
        }

        $formTemplate = $request->form_template;
        $templateFile = $request->template_file;

        if ($request->template_id) {
            $template = TemplateSurat::find($request->template_id);
            if ($template) {
                if ($template->form_template) $formTemplate = $template->form_template;
                if ($template->cetak_template) $templateFile = $template->cetak_template;
            }
        }

        JenisSurat::create([
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
            'persyaratan' => $request->persyaratan,
            'template_id' => $request->template_id,
            'form_fields' => $formFields,
            'template_file' => $templateFile,
            'form_template' => $formTemplate,
        ]);

        return redirect()->route('jenis-surat.index')->with('success', 'Jenis layanan surat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $templates = TemplateSurat::where('is_active', true)->orderBy('nama_template')->get();
        return view('admin.jenis.edit', compact('jenisSurat', 'templates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'persyaratan' => 'nullable|string',
            'template_id' => 'nullable|exists:template_surat,id',
            'form_fields' => 'nullable|string',
            'template_file' => 'nullable|string|max:100',
            'form_template' => 'nullable|string|max:100',
        ]);

        try {
            $formFields = $this->parseFormFields($request->form_fields);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['form_fields' => $e->getMessage()])->withInput();
        }

        $jenisSurat = JenisSurat::findOrFail($id);
        $formTemplate = $request->form_template;
        $templateFile = $request->template_file;

        if ($request->template_id) {
            $template = TemplateSurat::find($request->template_id);
            if ($template) {
                if ($template->form_template) $formTemplate = $template->form_template;
                if ($template->cetak_template) $templateFile = $template->cetak_template;
            }
        }

        $jenisSurat->update([
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
            'persyaratan' => $request->persyaratan,
            'template_id' => $request->template_id,
            'form_fields' => $formFields,
            'template_file' => $templateFile,
            'form_template' => $formTemplate,
        ]);

        return redirect()->route('jenis-surat.index')->with('success', 'Jenis layanan surat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->delete();

        return redirect()->route('jenis-surat.index')->with('success', 'Jenis layanan surat berhasil dihapus.');
    }
}
