<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\KandidatModel;
use Illuminate\Http\Request;

class KandidatController extends Controller
{
    public function show() {
        return view('admin.kandidat', ['data' => KandidatModel::showData()]);
    }

    public function post(Request $request) {
        try {
            $request->validate([
                'nama' => 'required',
                'foto' => 'required|image|mimes:jpeg,jpg,png|max:10240',
                'visi' => 'required',
                'misi' => 'required',
                'no_urut' => 'required|numeric|unique:kandidat_models,no_urut',
            ], [
                'required' => ':attribute harus diisi.',
                'image' => 'File yang diupload bukan gambar.',
                'mimes' => 'File yang diupload tidak sesuai format, format yang sesuai adalah jpeg, jpg, png.',
                'max' => 'File yang diupload melebihi batas ukuran, batas ukuran adalah 10 MB.',
                'numeric' => 'Nomor urut harus berupa angka.',
                'unique' => 'Nomor urut sudah ada.'
            ]);

            $data = $request->except(['_token']);

            if ($request->hasFile('foto')) {
                $hasName        = $request->file('foto')->hashName();
                $request->file('foto')->move(public_path('assets/data/kandidat'), $hasName);
                $data['foto']   = $hasName;
            }
            KandidatModel::tambahData($data);
            return response()->json(['status' => 'success', 'message' => 'Data kandidat berhasil ditambahkan.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function edit(Request $request, $id) {
        try {
            $request->validate([
                'nama' => 'required',
                'visi' => 'required',
                'misi' => 'required',
                'no_urut' => 'required|numeric|unique:kandidat_models,no_urut,' . $id,
            ], [
                'required' => ':attribute harus diisi.',
                'numeric' => 'Nomor urut harus berupa angka.',
                'unique' => 'Nomor urut sudah ada.'
            ]);

            $data = $request->except(['_token']);
            if ($request->hasFile('foto')) {
                $hasName        = $request->file('foto')->hashName();
                $request->file('foto')->move(public_path('assets/data/kandidat'), $hasName);
                $data['foto']   = $hasName;
            }
            KandidatModel::editData($id, $data);
            return redirect()->back()->with('success', 'Data kandidat berhasil diubah.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete($id) {
        if (KandidatModel::hapusData($id)) {
            return redirect()->back()->with('success', 'Data kandidat berhasil dihapus.');
        }
    }
}
