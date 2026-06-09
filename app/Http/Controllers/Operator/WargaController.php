<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penduduk;
use App\Models\ProfilNagari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();

        $query = User::where('role', 'warga');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $wargas = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('operator.warga.index', compact('profil', 'wargas'));
    }

    public function show(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $user = User::where('role', 'warga')->findOrFail($id);

        $penduduk = null;
        if ($user->nik_hash) {
            $penduduk = Penduduk::where('nik_hash', $user->nik_hash)->first();
        }
        if (!$penduduk && $user->nik) {
            $penduduk = Penduduk::where('nik', $user->nik)->first();
        }

        return view('operator.warga.show', compact('profil', 'user', 'penduduk'));
    }

    public function approve(string $id)
    {
        $user = User::where('role', 'warga')->findOrFail($id);
        $user->update(['status' => 'approved']);

        \Log::info('Warga approved', [
            'user_id' => $user->id,
            'username' => $user->username,
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('operator.warga.index')
            ->with('success', "Akun {$user->name} berhasil disetujui.");
    }

    public function reject(Request $request, string $id)
    {
        $request->validate(['alasan' => 'nullable|string|max:255']);

        $user = User::where('role', 'warga')->findOrFail($id);
        $user->update(['status' => 'rejected']);

        \Log::info('Warga rejected', [
            'user_id' => $user->id,
            'username' => $user->username,
            'rejected_by' => Auth::id(),
            'alasan' => $request->alasan,
        ]);

        return redirect()->route('operator.warga.index')
            ->with('success', "Akun {$user->name} telah ditolak.");
    }
}
