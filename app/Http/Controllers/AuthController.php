<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function auth(Request $req){
        $creadentials = $req->only('username', 'password');
        if (Auth::attempt($creadentials)) {
            return redirect('/dashboard')->with('success', 'Login Berhasil');
        }else{
            return redirect()->back()->with('error', 'Login gagal');
        }
    }

    public function logout(){
        Auth::logout();
        return  redirect('/')->with('success', 'Logout Berhasil!');
    }
}
