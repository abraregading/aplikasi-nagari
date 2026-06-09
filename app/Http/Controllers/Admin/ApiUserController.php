<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{
    public function index()
    {
        $apiUsers = ApiUser::latest()->paginate(10);
        return view('admin.api-user.index', compact('apiUsers'));
    }

    public function create()
    {
        return view('admin.api-user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:api_users',
            'password' => 'required|min:8',
            'app_name' => 'required',
            'app_description' => 'nullable',
        ]);

        ApiUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'app_name' => $request->app_name,
            'app_description' => $request->app_description,
            'status' => 'aktif',
        ]);

        return redirect()->route('api-user.index')->with('success', 'API User berhasil dibuat');
    }

    public function show(ApiUser $apiUser)
    {
        return view('admin.api-user.show', compact('apiUser'));
    }

    public function edit(ApiUser $apiUser)
    {
        return view('admin.api-user.edit', compact('apiUser'));
    }

    public function update(Request $request, ApiUser $apiUser)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:api_users,email,' . $apiUser->id,
            'app_name' => 'required',
            'app_description' => 'nullable',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'app_name' => $request->app_name,
            'app_description' => $request->app_description,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $apiUser->update($data);

        return redirect()->route('api-user.index')->with('success', 'API User berhasil diupdate');
    }

    public function destroy(ApiUser $apiUser)
    {
        $apiUser->delete();
        return redirect()->route('api-user.index')->with('success', 'API User berhasil dihapus');
    }

    public function toggleStatus(ApiUser $apiUser)
    {
        $apiUser->update([
            'status' => $apiUser->status === 'aktif' ? 'nonaktif' : 'aktif'
        ]);
        return redirect()->route('api-user.index')->with('success', 'Status API User berhasil diubah');
    }
}