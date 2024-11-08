<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function editProfile(Request $request) {
        $request->validate([
            'nama' => 'required|unique:users',
            'nis' => 'required|unique:users',
            'email' => 'required|unique:users',
            'foto' => 'nullable|mimes:jpg,jpeg,png|max:10240',
            'password' => 'required',
        ], [
            'required' => ':attribute wajib diisi',
            'unique' => ':attribute sudah terdaftar',
            'mimes' => ':attribute harus berupa gambar',
            'max' => ':attribute maksimal 10MB',
        ]);

        $data = $request->except(['_token']);
        $data['password'] = bcrypt($request->password);
        if ($request->hasFile('foto')) {
            $hasName        = $request->file('foto')->hashName();
            $request->file('foto')->move(public_path('assets/data/profile'), $hasName);
            $data['foto']   = $hasName;
        }

        try {
            User::tambahData($data);
            return redirect()->back()->with('success', 'Data user berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
