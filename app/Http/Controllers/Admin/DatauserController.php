<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posyandu;
use App\Models\ProfilNagari;
use App\Models\Keluarga;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DatauserController extends Controller
{
    public function index()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();

        $datausers = User::orderBy('created_at', 'desc')->get();
        return view('admin.datauser.index', compact('datausers', 'profil'));
    }

    public function create()
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $jorongs = Keluarga::distinct()
            ->whereNotNull('jorong')
            ->where('jorong', '!=', '')
            ->orderBy('jorong')
            ->pluck('jorong');
        $posyanduList = Posyandu::where('status', 'aktif')->orderBy('nama_posyandu')->get();
        return view('admin.datauser.create', compact('profil', 'jorongs', 'posyanduList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:30|unique:users,username|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,operator,warga,kajor,petugas,kader',
            'nik' => 'nullable|string|max:20',
            'jorong' => 'nullable|string|max:50',
            'posyandu_id' => 'nullable|exists:posyandu,id',
        ], [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username hanya boleh huruf, angka, dan underscore.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role harus dipilih.',
            'role.in' => 'Role tidak valid.',
        ]);

        if ($validated['role'] === 'kajor') {
            $request->validate([
                'jorong' => 'required|string|max:50',
            ], [
                'jorong.required' => 'Wilayah Jorong harus dipilih untuk role Kepala Jorong.',
            ]);
        }

        if ($validated['role'] === 'kader') {
            $request->validate([
                'posyandu_id' => 'required|exists:posyandu,id',
            ], [
                'posyandu_id.required' => 'Pos Yandu harus dipilih untuk role Kader.',
                'posyandu_id.exists' => 'Pos Yandu tidak valid.',
            ]);
        }

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'nik' => $validated['nik'],
            'jorong' => $validated['role'] === 'kajor' ? $validated['jorong'] : null,
            'posyandu_id' => $validated['role'] === 'kader' ? $validated['posyandu_id'] : null,
        ]);

        return redirect()->route('data-user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $datauser = User::findOrFail($id);
        return view('admin.datauser.show', compact('datauser', 'profil'));
    }

    public function edit(string $id)
    {
        $profil = ProfilNagari::pluck('setting_value', 'setting_key')->toArray();
        $datauser = User::findOrFail($id);
        $jorongs = Keluarga::distinct()
            ->whereNotNull('jorong')
            ->where('jorong', '!=', '')
            ->orderBy('jorong')
            ->pluck('jorong');
        $posyanduList = Posyandu::where('status', 'aktif')->orderBy('nama_posyandu')->get();
        return view('admin.datauser.edit', compact('datauser', 'profil', 'jorongs', 'posyanduList'));
    }

    public function update(Request $request, string $id)
    {
        $datauser = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:30', Rule::unique('users')->ignore($datauser->id), 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($datauser->id)],
            'role' => 'required|in:admin,operator,warga,kajor,petugas,kader',
            'nik' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'jorong' => 'nullable|string|max:50',
            'posyandu_id' => 'nullable|exists:posyandu,id',
        ], [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username hanya boleh huruf, angka, dan underscore.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role harus dipilih.',
            'role.in' => 'Role tidak valid.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validated['role'] === 'kajor') {
            $request->validate([
                'jorong' => 'required|string|max:50',
            ], [
                'jorong.required' => 'Wilayah Jorong harus dipilih untuk role Kepala Jorong.',
            ]);
        }

        if ($validated['role'] === 'kader') {
            $request->validate([
                'posyandu_id' => 'required|exists:posyandu,id',
            ], [
                'posyandu_id.required' => 'Pos Yandu harus dipilih untuk role Kader.',
                'posyandu_id.exists' => 'Pos Yandu tidak valid.',
            ]);
        }

        $updateData = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'nik' => $validated['nik'],
            'jorong' => $validated['role'] === 'kajor' ? $validated['jorong'] : null,
            'posyandu_id' => $validated['role'] === 'kader' ? $validated['posyandu_id'] : null,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $datauser->update($updateData);

        return redirect()->route('data-user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $datauser = User::findOrFail($id);
        
        if (auth()->user()->id === $datauser->id) {
            return redirect()->route('data-user.index')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $datauser->delete();

        return redirect()->route('data-user.index')->with('success', 'User berhasil dihapus.');
    }
}