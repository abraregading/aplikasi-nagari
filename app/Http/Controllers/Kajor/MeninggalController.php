<?php

namespace App\Http\Controllers\Kajor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataMeninggal;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\Perangkat;
use App\Models\ProfilNagari;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MeninggalController extends Controller
{
    private function getJorongName()
    {
        return Auth::user()->jorong;
    }

    public function index(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        $query = DataMeninggal::where('jorong', $jorongName);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_meninggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_meninggal', $request->tahun);
        }

        $dataMeninggal = $query->orderByDesc('tanggal_meninggal')->paginate(15)->withQueryString();

        return view('kajor.meninggal.index', compact('profil', 'dataMeninggal', 'jorongName'));
    }

    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        $noKkList = Keluarga::where('jorong', $jorongName)->pluck('no_kk');
        $penduduks = Penduduk::whereIn('no_kk', $noKkList)
            ->where('status_hidup', 'hidup')
            ->orderBy('nama_lengkap')
            ->get();

        $authUser = Auth::user();

        return view('kajor.meninggal.create', compact('profil', 'penduduks', 'jorongName', 'authUser'));
    }

    public function store(Request $request)
    {
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        $request->validate([
            'nik' => 'required|string|max:20',
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'no_kk' => 'nullable|string|max:20',
            'tanggal_meninggal' => 'required|date',
            'waktu_meninggal' => 'nullable',
            'tempat_meninggal' => 'nullable|string|max:100',
            'sebab_meninggal' => 'nullable|string|max:200',
            'keterangan' => 'nullable|string',
            'status_hubungan' => 'nullable|string|max:50',
            'nama_saksi' => 'nullable|string|max:100',
            'no_hp_saksi' => 'nullable|string|max:20',
        ]);

        DataMeninggal::create([
            'penduduk_id' => $request->penduduk_id,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_kk' => $request->no_kk,
            'jorong' => $jorongName,
            'tanggal_meninggal' => $request->tanggal_meninggal,
            'waktu_meninggal' => $request->waktu_meninggal,
            'tempat_meninggal' => $request->tempat_meninggal,
            'sebab_meninggal' => $request->sebab_meninggal,
            'keterangan' => $request->keterangan,
            'status_hubungan' => $request->status_hubungan,
            'nama_saksi' => $request->nama_saksi,
            'no_hp_saksi' => $request->no_hp_saksi,
            'created_by' => Auth::id(),
        ]);

        if ($request->penduduk_id) {
            Penduduk::where('id', $request->penduduk_id)->update(['status_hidup' => 'meninggal']);
        } elseif ($request->nik) {
            Penduduk::where('nik', $request->nik)->where('status_hidup', 'hidup')->update(['status_hidup' => 'meninggal']);
        }

        return redirect()->route('kajor.meninggal.index')->with('success', 'Data meninggal berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        $data = DataMeninggal::findOrFail($id);

        if (strcasecmp(trim($data->jorong ?? ''), trim($jorongName ?? '')) !== 0) {
            return redirect()->route('kajor.meninggal.index')->with('error', 'Data tidak ditemukan di jorong Anda.');
        }

        return view('kajor.meninggal.show', compact('profil', 'data', 'jorongName'));
    }

    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        $data = DataMeninggal::findOrFail($id);

        if (strcasecmp(trim($data->jorong ?? ''), trim($jorongName ?? '')) !== 0) {
            return redirect()->route('kajor.meninggal.index')->with('error', 'Data tidak ditemukan di jorong Anda.');
        }

        $noKkList = Keluarga::where('jorong', $jorongName)->pluck('no_kk');
        $penduduks = Penduduk::whereIn('no_kk', $noKkList)
            ->where('status_hidup', 'hidup')
            ->orderBy('nama_lengkap')
            ->get();

        $authUser = Auth::user();

        return view('kajor.meninggal.edit', compact('profil', 'data', 'penduduks', 'jorongName', 'authUser'));
    }

    public function update(Request $request, string $id)
    {
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        $data = DataMeninggal::findOrFail($id);

        if (strcasecmp(trim($data->jorong ?? ''), trim($jorongName ?? '')) !== 0) {
            return redirect()->route('kajor.meninggal.index')->with('error', 'Data tidak ditemukan di jorong Anda.');
        }

        $request->validate([
            'nik' => 'required|string|max:20',
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'no_kk' => 'nullable|string|max:20',
            'tanggal_meninggal' => 'required|date',
            'waktu_meninggal' => 'nullable',
            'tempat_meninggal' => 'nullable|string|max:100',
            'sebab_meninggal' => 'nullable|string|max:200',
            'keterangan' => 'nullable|string',
            'status_hubungan' => 'nullable|string|max:50',
            'nama_saksi' => 'nullable|string|max:100',
            'no_hp_saksi' => 'nullable|string|max:20',
        ]);

        $oldPendudukId = $data->penduduk_id;

        $data->update([
            'penduduk_id' => $request->penduduk_id,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_kk' => $request->no_kk,
            'tanggal_meninggal' => $request->tanggal_meninggal,
            'waktu_meninggal' => $request->waktu_meninggal,
            'tempat_meninggal' => $request->tempat_meninggal,
            'sebab_meninggal' => $request->sebab_meninggal,
            'keterangan' => $request->keterangan,
            'status_hubungan' => $request->status_hubungan,
            'nama_saksi' => $request->nama_saksi,
            'no_hp_saksi' => $request->no_hp_saksi,
        ]);

        if ($request->penduduk_id && $request->penduduk_id != $oldPendudukId) {
            if ($oldPendudukId) {
                Penduduk::where('id', $oldPendudukId)->update(['status_hidup' => 'hidup']);
            }
            Penduduk::where('id', $request->penduduk_id)->update(['status_hidup' => 'meninggal']);
        } elseif ($request->penduduk_id) {
            Penduduk::where('id', $request->penduduk_id)->update(['status_hidup' => 'meninggal']);
        } elseif ($oldPendudukId && !$request->penduduk_id) {
            Penduduk::where('id', $oldPendudukId)->update(['status_hidup' => 'hidup']);
        }

        return redirect()->route('kajor.meninggal.index')->with('success', 'Data meninggal berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $jorongName = $this->getJorongName();
        $data = DataMeninggal::findOrFail($id);

        if (strcasecmp(trim($data->jorong ?? ''), trim($jorongName ?? '')) !== 0) {
            return redirect()->route('kajor.meninggal.index')->with('error', 'Data tidak ditemukan di jorong Anda.');
        }

        if ($data->penduduk_id) {
            Penduduk::where('id', $data->penduduk_id)->update(['status_hidup' => 'hidup']);
        }

        $data->delete();

        return redirect()->route('kajor.meninggal.index')->with('success', 'Data meninggal berhasil dihapus.');
    }

    public function laporanIndex(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        $bulan = $request->input('bulan', now()->format('m'));
        $tahun = $request->input('tahun', now()->format('Y'));

        $dataMeninggal = DataMeninggal::with('creator')
            ->where('jorong', $jorongName)
            ->whereYear('tanggal_meninggal', $tahun)
            ->whereMonth('tanggal_meninggal', $bulan)
            ->orderBy('tanggal_meninggal')
            ->get();

        $totalMeninggal = $dataMeninggal->count();
        $totalLaki = $dataMeninggal->where('jenis_kelamin', 'L')->count();
        $totalPerempuan = $dataMeninggal->where('jenis_kelamin', 'P')->count();

        $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $namaBulan = $bulanIndo[(int)$bulan - 1];

        return view('kajor.laporan-meninggal.index', compact(
            'profil', 'jorongName', 'dataMeninggal',
            'bulan', 'tahun', 'namaBulan',
            'totalMeninggal', 'totalLaki', 'totalPerempuan'
        ));
    }

    public function laporanCetak(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongName = $this->getJorongName();

        if (!$jorongName) {
            return redirect()->back()->with('error', 'Anda belum memiliki assigning jorong.');
        }

        $bulan = $request->input('bulan', now()->format('m'));
        $tahun = $request->input('tahun', now()->format('Y'));

        $dataMeninggal = DataMeninggal::with('creator')
            ->where('jorong', $jorongName)
            ->whereYear('tanggal_meninggal', $tahun)
            ->whereMonth('tanggal_meninggal', $bulan)
            ->orderBy('tanggal_meninggal')
            ->get();

        $totalMeninggal = $dataMeninggal->count();
        $totalLaki = $dataMeninggal->where('jenis_kelamin', 'L')->count();
        $totalPerempuan = $dataMeninggal->where('jenis_kelamin', 'P')->count();

        $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $namaBulan = $bulanIndo[(int)$bulan - 1];

        $walinagari = Perangkat::where('jabatan_id', 1)->with('penduduk', 'jabatan')->first();

        return view('kajor.laporan-meninggal.cetak', compact(
            'profil', 'jorongName', 'dataMeninggal',
            'bulan', 'tahun', 'namaBulan',
            'totalMeninggal', 'totalLaki', 'totalPerempuan',
            'walinagari'
        ));
    }

    public function getPendudukByNik(Request $request)
    {
        $jorongName = $this->getJorongName();
        $nik = $request->input('nik');

        $noKkList = Keluarga::where('jorong', $jorongName)->pluck('no_kk');
        $penduduk = Penduduk::whereIn('no_kk', $noKkList)
            ->where('nik', $nik)
            ->where('status_hidup', 'hidup')
            ->first();

        if ($penduduk) {
            return response()->json([
                'found' => true,
                'data' => [
                    'id' => $penduduk->id,
                    'nik' => $penduduk->nik,
                    'nama_lengkap' => $penduduk->nama_lengkap,
                    'jenis_kelamin' => $penduduk->jenis_kelamin,
                    'tanggal_lahir' => $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('Y-m-d') : null,
                    'no_kk' => $penduduk->no_kk,
                    'status_hubungan' => $penduduk->hubungan_keluarga,
                ]
            ]);
        }

        return response()->json(['found' => false]);
    }
}
