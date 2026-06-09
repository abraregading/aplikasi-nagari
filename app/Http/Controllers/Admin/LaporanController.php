<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilNagari;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $query = Laporan::query();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('isi_laporan', 'like', '%' . $request->search . '%');
            });
        }

        $laporans = $query->orderByDesc('created_at')->paginate(15);
        $kategoris = Laporan::select('kategori')->distinct()->pluck('kategori');

        return view('admin.laporan.index', compact('laporans', 'kategoris', 'profil'));
    }

    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.laporan.show', compact('laporan', 'profil'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
            'diproses_oleh' => Auth::id(),
            'diproses_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();
        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function bulkAction(Request $request)
    {
        try {
            if (!$request->has('laporan_ids') || empty($request->laporan_ids)) {
                return redirect()->back()->with('error', 'Pilih laporan terlebih dahulu.');
            }

            $ids = $request->laporan_ids;
            $action = $request->action;

            if ($action === 'delete') {
                Laporan::whereIn('id', $ids)->delete();
                $message = count($ids) . ' laporan berhasil dihapus.';
            } elseif (in_array($action, ['diproses', 'selesai'])) {
                Laporan::whereIn('id', $ids)->update([
                    'status' => $action,
                    'diproses_oleh' => Auth::id(),
                    'diproses_at' => now(),
                ]);
                $message = count($ids) . ' laporan berhasil diperbarui.';
            } else {
                return redirect()->back()->with('error', 'Aksi tidak valid.');
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}