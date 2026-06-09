<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentSiteController extends Controller
{
    public function store(Request $request, $slug)
    {
        // dd($slug );
        $berita = Berita::where('slug', $slug)->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'konten' => 'required|string',
        ]);
        Comment::create([
            'berita_id' => $berita->id,
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'email' => $request->email,
            'konten' => $request->konten,
            'status' => 'pending',
        ]);


        return redirect()->back()->with('comment_success', 'Komentar Anda akan ditampilkan setelah diverifikasi oleh admin.');
    }

    public function getComments($slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();

        $comments = Comment::with(['user', 'approvedReplies.user'])
            ->where('berita_id', $berita->id)
            ->whereNull('parent_id')
            ->where('status', 'approved')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($comments);
    }
}