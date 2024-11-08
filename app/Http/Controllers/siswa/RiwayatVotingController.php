<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\admin\DataPemilihModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatVotingController extends Controller
{
    public function show()
    {
        return view('siswa.riwayat-pemilihan' , ['data' => DataPemilihModel::showData(Auth::user()->id)]);
    }
}
