<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PetugasPendataanController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'petugas');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $petugas = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.petugaspendataan.index', compact('petugas'));
    }

    public function create()
    {
        return view('admin.petugaspendataan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:30|unique:users,username|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users,email',
            'nik' => 'nullable|string|max:20|unique:users,nik',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username hanya boleh huruf, angka, dan underscore.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'nik' => $validated['nik'] ?? null,
            'no_telepon' => $validated['no_telepon'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'petugas',
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.petugaspendataan.index')
            ->with('success', 'Petugas pendataan berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('admin.petugaspendataan.show', compact('petugas'));
    }

    public function edit(string $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('admin.petugaspendataan.edit', compact('petugas'));
    }

    public function update(Request $request, string $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:30', Rule::unique('users')->ignore($petugas->id), 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($petugas->id)],
            'nik' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($petugas->id)],
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:6|confirmed',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username hanya boleh huruf, angka, dan underscore.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'nik' => $validated['nik'] ?? null,
            'no_telepon' => $validated['no_telepon'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'status' => $validated['status'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $petugas->update($updateData);

        return redirect()->route('admin.petugaspendataan.index')
            ->with('success', 'Petugas pendataan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        if (auth()->user()->id === $petugas->id) {
            return redirect()->route('admin.petugaspendataan.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $petugas->delete();

        return redirect()->route('admin.petugaspendataan.index')
            ->with('success', 'Petugas pendataan berhasil dihapus.');
    }

    public function updateStatus(Request $request, string $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $petugas->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status petugas berhasil diubah.');
    }
}