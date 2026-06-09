<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPerubahanPenduduk;
use App\Models\ProfilNagari;
use Illuminate\Support\Facades\Auth;

class PengajuanPerubahanController extends Controller
{
    public function index(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();

        $query = PengajuanPerubahanPenduduk::with(['user', 'penduduk']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $pengajuan = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'pending' => PengajuanPerubahanPenduduk::where('status', 'pending')->count(),
            'approved' => PengajuanPerubahanPenduduk::where('status', 'approved')->count(),
            'rejected' => PengajuanPerubahanPenduduk::where('status', 'rejected')->count(),
        ];

        return view('operator.pengajuan-perubahan.index', compact('profil', 'pengajuan', 'counts'));
    }

    public function show(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $pengajuan = PengajuanPerubahanPenduduk::with(['user', 'penduduk'])->findOrFail($id);

        return view('operator.pengajuan-perubahan.show', compact('profil', 'pengajuan'));
    }

    public function approve(string $id)
    {
        $pengajuan = PengajuanPerubahanPenduduk::with('penduduk')->findOrFail($id);

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $dataBaru = $pengajuan->data_baru;

        $updateData = [];
        $allowedFields = ['nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'agama', 'pekerjaan', 'pendidikan_terakhir', 'alamat'];

        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $dataBaru)) {
                $updateData[$field] = $dataBaru[$field];
            }
        }

        if (!empty($updateData)) {
            $pengajuan->penduduk->update($updateData);
        }

        $pengajuan->update([
            'status' => 'approved',
            'catatan' => 'Disetujui oleh Operator Nagari.',
        ]);

        \Log::info('Pengajuan perubahan penduduk disetujui', [
            'pengajuan_id' => $pengajuan->id,
            'penduduk_id' => $pengajuan->penduduk_id,
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('operator.pengajuan-perubahan.index')
            ->with('success', 'Perubahan data penduduk berhasil disetujui.');
    }

    public function reject(Request $request, string $id)
    {
        $request->validate(['catatan' => 'nullable|string|max:500']);

        $pengajuan = PengajuanPerubahanPenduduk::findOrFail($id);

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $pengajuan->update([
            'status' => 'rejected',
            'catatan' => $request->catatan ?? 'Ditolak oleh Operator Nagari.',
        ]);

        \Log::info('Pengajuan perubahan penduduk ditolak', [
            'pengajuan_id' => $pengajuan->id,
            'penduduk_id' => $pengajuan->penduduk_id,
            'rejected_by' => Auth::id(),
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('operator.pengajuan-perubahan.index')
            ->with('success', 'Pengajuan perubahan data ditolak.');
    }
}
