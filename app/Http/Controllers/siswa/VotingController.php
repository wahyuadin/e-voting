<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\admin\DataPemilihModel;
use App\Models\admin\KandidatModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class VotingController extends Controller
{
    public function show() {
        return view('siswa.voting' , ['data' => KandidatModel::showData()]);
    }

    public function post($id) {
        try {
            if (DataPemilihModel::where('user_id', auth()->user()->id)->where('kandidat_id', $id)->exists()) {
                Alert::error('Error', 'Anda sudah melakukan voting');
                return redirect()->back();
            }
            DataPemilihModel::tambahData(['user_id' => auth()->user()->id, 'kandidat_id' => $id]);
            return redirect()->back()->with('success', 'Voting Berhasil');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }
}
