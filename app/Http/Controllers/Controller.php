<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function editProfile(Request $request, $id) {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required',
            'email' => 'required',
            'foto' => 'nullable|mimes:jpg,jpeg,png|max:10240',
            'password' => 'nullable',
            'repassword' => 'nullable|same:password',
        ], [
            'required' => ':attribute wajib diisi',
            'unique' => ':attribute sudah terdaftar',
            'mimes' => ':attribute harus berupa gambar',
            'max' => ':attribute maksimal 10MB',
        ]);

        $data = $request->except(['_token', 'repassword']);
        $data['password'] = bcrypt($request->password);
        if ($request->hasFile('foto')) {
            $hasName        = $request->file('foto')->hashName();
            $request->file('foto')->move(public_path('assets/data/profile'), $hasName);
            $data['foto']   = $hasName;
        }

        try {
            User::editData($id, $data);
            return redirect()->back()->with('success', 'Data user berhasil ditambahkan.');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }
}
