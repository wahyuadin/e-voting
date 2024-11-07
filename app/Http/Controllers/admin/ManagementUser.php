<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ManagementUser extends Controller
{
    public function show() {
        return view('admin.management-user', ['data' => User::all()]);
    }

    public function post(Request $request) {
        $request->validate([
            'nama' => 'required|unique:users',
            'nis' => 'required|unique:users',
            'email' => 'required|unique:users',
            'foto' => 'nullable|mimes:jpg,jpeg,png|max:10240',
        ], [
            'required' => ':attribute wajib diisi',
            'unique' => ':attribute sudah terdaftar',
            'mimes' => ':attribute harus berupa gambar',
            'max' => ':attribute maksimal 10MB',
        ]);

        $data = $request->except(['_token']);
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

    public function postExcel(Request $request) {
        $request->validate([
            'excel' => 'required|mimes:xls,xlsx|max:3072',
        ], [
            'required' => ':attribute wajib diisi',
            'mimes' => ':attribute harus berupa file Excel (xls, xlsx)',
            'max' => ':attribute maksimal 3MB',
        ]);

        if ($request->hasFile('excel')) {
            try {
                $data = Excel::toArray([], $request->file('excel'));
                foreach (array_slice($data[0], 1) as $d) {
                    User::create([
                        'nama' => $d[0],
                        'nis' => $d[1],
                        'email' => $d[2],
                        'password' => bcrypt($d[3]),
                    ]);
                };
                return back()->with('success', 'Data user berhasil ditambahkan.');
            } catch (\Exception $e) {
                Alert::error('Error', $e->getMessage());
                return back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
            }
        }
    }

    public function edit(Request $request, $id) {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'nis' => 'required',
            'password' => 'nullable',
            'repassword' => 'nullable|same:password',
            'foto' => 'nullable|mimes:jpg,jpeg,png|max:10240',
        ], [
            'required' => ':attribute wajib diisi',
            'mimes' => ':attribute harus berupa gambar',
            'max' => ':attribute maksimal 10MB',
            'same' => ':attribute harus sama dengan password',
            'unique' => ':attribute sudah terdaftar',
        ]);

        $data = $request->except(['_token', 'repassword']);
        if ($request->hasFile('foto')) {
            $hasName        = $request->file('foto')->hashName();
            $request->file('foto')->move(public_path('assets/data/profile'), $hasName);
            $data['foto']   = $hasName;
        }

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        try {
            if (User::find($id)->update($data)) {
                return redirect()->back()->with('success', 'Data user berhasil diubah.');
            };
            Alert::error('Error', 'Data user gagal diubah.');
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete($id) {
        if (User::find($id)->delete()) {
            return redirect()->back()->with('success', 'Data user berhasil dihapus.');
        }

        Alert::error('Error', 'Data user gagal dihapus.');
        return redirect()->back();
    }
}
