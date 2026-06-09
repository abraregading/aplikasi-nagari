<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\ProfilNagari;
use App\Models\Penduduk;
use App\Models\RiwayatSurat;
use App\Models\PengajuanPerubahanPenduduk;
use App\Models\Pengumuman;

class WargaController extends Controller
{
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $user = Auth::user();

        $penduduk = $user->penduduk;
        if (!$penduduk && $user->nik) {
            $penduduk = Penduduk::where('nik', $user->nik)->first();
        }

        $keluarga = null;
        if ($penduduk && $penduduk->no_kk) {
            $keluarga = \App\Models\Keluarga::where('no_kk', $penduduk->no_kk)->first();
        }

        $suratStats = RiwayatSurat::where('user_id', $user->id)
            ->selectRaw("COUNT(*) as total")
            ->selectRaw("SUM(CASE WHEN status = 'diajukan' THEN 1 ELSE 0 END) as diajukan")
            ->selectRaw("SUM(CASE WHEN status = 'diproses' THEN 1 ELSE 0 END) as diproses")
            ->selectRaw("SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as selesai")
            ->selectRaw("SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak")
            ->first();

        $recentSurat = RiwayatSurat::where('user_id', $user->id)
            ->with('penduduk')
            ->latest()->take(5)->get();

        $pendingPerubahan = PengajuanPerubahanPenduduk::where('user_id', $user->id)
            ->where('status', 'pending')->first();

        $pengumuman = Pengumuman::untukWarga($user->id)->get();

        return view('warga.home.index', compact(
            'profil', 'user', 'penduduk', 'keluarga',
            'suratStats', 'recentSurat', 'pendingPerubahan', 'pengumuman'
        ));
    }

    public function profil()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $user = Auth::user();

        $penduduk = $user->penduduk;
        if (!$penduduk && $user->nik) {
            $penduduk = Penduduk::where('nik', $user->nik)->first();
        }

        return view('warga.profil.index', compact('profil', 'user', 'penduduk'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'photo_data' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('photo_data') && preg_match('/^data:image\/(\w+);base64,/', $request->photo_data)) {
            $base64 = substr($request->photo_data, strpos($request->photo_data, ',') + 1);
            $decoded = base64_decode($base64);
            $photoFileName = 'warga_' . time() . '_' . $user->nik . '.jpg';
            Storage::disk('public')->put('photos/' . $photoFileName, $decoded);
            $data['photo'] = $photoFileName;
        }

        $user->update($data);

        return redirect()->route('warga.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('warga.profil')->with('success', 'Password berhasil diubah.');
    }

    public function ubahPenduduk()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $user = Auth::user();

        $penduduk = $user->penduduk;
        if (!$penduduk && $user->nik) {
            $penduduk = Penduduk::where('nik', $user->nik)->first();
        }

        if (!$penduduk) {
            return redirect()->route('warga.home')->with('error', 'Data kependudukan tidak ditemukan.');
        }

        $existingPengajuan = PengajuanPerubahanPenduduk::where('user_id', $user->id)
            ->where('status', 'pending')->first();

        return view('warga.ubah-penduduk.index', compact('profil', 'user', 'penduduk', 'existingPengajuan'));
    }

    public function simpanUbahPenduduk(Request $request)
    {
        $user = Auth::user();

        $penduduk = $user->penduduk;
        if (!$penduduk && $user->nik) {
            $penduduk = Penduduk::where('nik', $user->nik)->first();
        }

        if (!$penduduk) {
            return redirect()->route('warga.home')->with('error', 'Data kependudukan tidak ditemukan.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
            'alasan' => 'required|string|max:500',
        ]);

        // Cek apakah masih ada pengajuan pending
        $existing = PengajuanPerubahanPenduduk::where('user_id', $user->id)
            ->where('status', 'pending')->first();

        if ($existing) {
            return back()->with('error', 'Anda masih memiliki pengajuan perubahan yang menunggu persetujuan.');
        }

        $dataBaru = [
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'alamat' => $request->alamat,
        ];

        PengajuanPerubahanPenduduk::create([
            'user_id' => $user->id,
            'penduduk_id' => $penduduk->id,
            'data_baru' => $dataBaru,
            'alasan' => $request->alasan,
            'status' => 'pending',
        ]);

        return redirect()->route('warga.ubah-penduduk')->with('success', 'Pengajuan perubahan data berhasil dikirim dan menunggu persetujuan Operator Nagari.');
    }
}
