<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\DataPemilihModel;
use Illuminate\Http\Request;

class DataPemilihController extends Controller
{
    public function show() {
        return view('admin.data-pemilih', ['data' => DataPemilihModel::showData()]);
    }
}
