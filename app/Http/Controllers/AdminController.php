<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    //
    public function index(){
        $data['admin'] = Administrator::with('pengguna')->get();
        $title = 'Hapus Data!';
        $text = "Apakah kamu yakin akan menghapus data ini?";
        confirmDelete($title, $text);
        return view('administrator.main', $data);
    }

    public function add(Request $req){
        $validator = Validator::make($req->all(), [
            'username' => ['required', 'min:3'],
            'password' => ['required', Password::min(5)],
            'nama_administrator' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        $akun = Pengguna::create([
            'username' => $req->username,
            'password' => bcrypt($req->password),
            'level_akses' => 'administrator'
        ]);

        if (!empty($akun)) {
            $administrator = Administrator::create([
                'nama_administrator' => $req->nama_administrator,
                'alamat' => $req->alamat,
                'no_telepon' => $req->no_telepon,
                'pengguna_id' => $akun->id_pengguna
            ]);

            if ($administrator) {
                return redirect('/pengguna/administrator')->with('success', 'Data berhasil disimpan!');
            } else{
                return redirect()->back()->with('error', 'Data  gagal disimpan!');
            }
        }
    }

    public function edit(Request $req){
        $validator = Validator::make($req->all(), [
            'username' => ['required', 'min:3'],
            'nama_administrator' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        // $admin = 

        $akun = Pengguna::where('id_pengguna', $req->pengguna_id)->update([
            'username' => $req->username,
            'password' => bcrypt($req->password),
            'level_akses' => 'administrator'
        ]);

        $admin = Administrator::where('pengguna_id', $req->pengguna_id)->update([
            'nama_administrator' => $req->nama_administrator,
            'alamat' => $req->alamat,
            'no_telepon' => $req->no_telepon,
            'pengguna_id' => $req->pengguna_id
        ]);

        if ($admin) {
            return redirect('/pengguna/administrator')->with('success', 'Data berhasil diubah!');
        }

        return redirect()->back()->with('error', 'Data  gagal diubah!');
    }

    public function hapus(Request $req){
        $admin = Administrator::where('pengguna_id', $req->pengguna_id)->delete();
        $akun = Pengguna::where('id_pengguna', $req->pengguna_id)->delete();

        if ($akun && $admin) {
            return redirect('/pengguna/administrator')->with('Success', 'Data berhasil dihapus!');
        }else{
            return redirect()->back()->with( 'Error', 'Data gagal dihapus!');
        }
    }
}
