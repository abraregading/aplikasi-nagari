<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ProfilNagari;
use Illuminate\Support\Facades\File;

class ProfilnagariController extends Controller
{
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $fields = config('profilnagari');
        return view('admin.profil.index', compact('profil', 'fields'));
    }

    public function create()
    {
        return view('admin.profil.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        return view('admin.profil.edit');
    }

    public function update(Request $request)
    {
        // Handle text fields
        $textFields = ['nama_nagari', 'nama_aplikasi', 'nama_pemerintahan', 'bentuk_pemerintahan', 
                       'alamat', 'kecamatan', 'kabupaten', 'provinsi', 'titikkoordinat', 'no_hp', 'email', 'kode_desa'];
        
        foreach ($textFields as $key) {
            if ($request->has($key)) {
                ProfilNagari::updateOrCreate(
                    ['setting_key' => $key],
                    ['setting_value' => $request->input($key)]
                );
            }
        }

        // Handle hero image upload - save to public folder
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'hero.' . $extension;
            $destinationPath = public_path('site/assets');
            
            // Create directory if not exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            // Delete old hero images
            $oldExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            foreach ($oldExtensions as $ext) {
                $oldFile = $destinationPath . '/hero.' . $ext;
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }
            
            // Upload new file
            $file->move($destinationPath, $filename);
            
            // Save to database
            ProfilNagari::updateOrCreate(
                ['setting_key' => 'hero_image'],
                ['setting_value' => 'site/assets/hero.' . $extension]
            );
        }

        // Handle hero image URL
        if ($request->filled('hero_image_url')) {
            // Clear local hero image if URL is provided
            $destinationPath = public_path('site/assets');
            $oldExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            foreach ($oldExtensions as $ext) {
                $oldFile = $destinationPath . '/hero.' . $ext;
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }
            // Delete database entry for local file
            ProfilNagari::where('setting_key', 'hero_image')->delete();
            
            // Save URL
            ProfilNagari::updateOrCreate(
                ['setting_key' => 'hero_image_url'],
                ['setting_value' => $request->input('hero_image_url')]
            );
        }

        return redirect()->back()->with('success', 'Profil Nagari berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        //
    }
}