<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use RealRashid\SweetAlert\Facades\Alert;

class AuthentifikasiController extends Controller
{
    public function login() {
        $rememberDevice = Cookie::get('remember_device', false);
        return view('template.login', compact('rememberDevice'));
    }

    public function verif(Request $request) {
        if ($request->has('remember_device')) {
            Cookie::queue(Cookie::forever('remember_device', json_encode($request->all())));
        } else {
            Cookie::queue(Cookie::forget('remember_device'));
        }

        if (Auth::attempt($request->only('nis', 'password'))) {
            Alert::success('Login Berhasil', 'Selamat Datang, '.auth()->user()->nama);
            return redirect()->route('dashboard.'. Auth::user()->role);
        } else {
            Alert::error('Login Gagal', 'Email atau Password yang anda masukkan salah');
            return redirect()->back();
        }
    }


    public function logout() {
        try {
            Auth::logout();
            Alert::success('Success', 'logout Berhasil !');
            return redirect(route('login'));
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }
}
