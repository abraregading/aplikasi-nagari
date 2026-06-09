<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilNagari;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $query = Comment::with(['berita', 'user', 'approver'])
            ->withCount('replies');

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->berita_id) {
            $query->where('berita_id', $request->berita_id);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('konten', 'like', '%' . $request->search . '%');
            });
        }

        $comments = $query->orderByDesc('created_at')->paginate(15);
        $beritas = Berita::orderBy('judul_berita')->get();

        return view('admin.komentar.index', compact('comments', 'beritas', 'profil'));
    }

    public function pending()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $comments = Comment::with(['berita', 'user'])
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.komentar.pending', compact('comments', 'profil'));
    }

    public function show($komentar)
    {
        $comment = Comment::findOrFail($komentar);
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.komentar.show', compact('comment', 'profil'));
    }

    public function action($komentar, $action)
    {
        $comment = Comment::findOrFail($komentar);

        if (!in_array($action, ['approve', 'reject'])) {
            return redirect()->route('komentar.index')->with('error', 'Aksi tidak valid.');
        }

        $comment->update([
            'status' => $action === 'approve' ? 'approved' : 'rejected',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        $message = $action === 'approve' ? 'Komentar berhasil disetujui.' : 'Komentar ditolak.';
        return redirect()->route('komentar.show', $comment->id)->with('success', $message);
    }

    public function bulkAction(Request $request)
    {
        
        $ids = $request->input('comment_ids', []);
        $action = $request->input('action');

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Pilih komentar terlebih dahulu.');
        }

        $status = $action === 'approve' ? 'approved' : 'rejected';

        Comment::whereIn('id', $ids)->update([
            'status' => $status,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        $message = count($ids) . ' komentar berhasil ' . ($action === 'approve' ? 'disetujui' : 'ditolak');
        return redirect()->back()->with('success', $message);
    }

    public function destroy($komentar)
    {
        $comment = Comment::findOrFail($komentar);
        $comment->delete();
        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }

    public function byBerita(Berita $berita)
    {
            $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $comments = Comment::with(['user', 'replies'])
            ->where('berita_id', $berita->id)
            ->whereNull('parent_id')
            ->where('status', 'approved')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.komentar.by-berita', compact('berita', 'comments', 'profil'));
    }
}