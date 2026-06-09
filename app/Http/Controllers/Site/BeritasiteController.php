<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Berita;
use App\Models\Kategoriberita;
use App\Models\ProfilNagari;

class BeritasiteController extends Controller
{
    public function index()
    {
        $profilnagari = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $berita = Berita::orderBy('created_at', 'desc')->get();
        
        $kategoriBerita = Kategoriberita::withCount('berita')->get();
        
        return view('site.konten.berita.index', compact('berita', 'kategoriBerita', 'profilnagari'));
    }


    public function show($slug)
    {
        $profilnagari = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $berita = Berita::where('slug', $slug)->firstOrFail();
    
        $berita->increment('views');
    
        $kategoriBerita = Kategoriberita::withCount('berita')->get();
        
        $berita_side = Berita::orderBy('created_at', 'desc')->paginate(5);
        $kategori = Kategoriberita::all();
        
        $comments = Comment::with(['user', 'approvedReplies.user'])
            ->where('berita_id', $berita->id)
            ->whereNull('parent_id')
            ->where('status', 'approved')
            ->orderByDesc('created_at')
            ->get();
        
        $komentar = Comment::where('berita_id', $berita->id)
                    ->where('status', 'approved')
                    ->get();
        $komentarcount = Comment::where('berita_id', $berita->id)
                    ->where('status', 'approved')
                    ->count();
        // dd($berita);
        // 
        return view('site.konten.berita.detail.index', compact('berita', 'kategoriBerita', 'berita_side', 'kategori', 'profilnagari', 'comments', 'komentar', 'komentarcount'));
    }
}
