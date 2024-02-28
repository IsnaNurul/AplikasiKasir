<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PetugasController extends Controller
{
    //
    public function index(){
        $data['petugas'] = Petugas::with('pengguna')->get();
        $title = 'Hapus Data!';
        $text = "Apakah kamu yakin akan menghapus data ini?";
        confirmDelete($title, $text);
        return view('petugas.main', $data);
    }

    public function add(Request $req){
        $validator = Validator::make($req->all(), [
            'username' => ['required', 'min:3'],
            'password' => ['required', Password::min(5)],
            'nama_petugas' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        $akun = Pengguna::create([
            'username' => $req->username,
            'password' => bcrypt($req->password),
            'level_akses' => 'petugas'
        ]);

        if (!empty($akun)) {
            $petugas = Petugas::create([
                'nama_petugas' => $req->nama_petugas,
                'alamat' => $req->alamat,
                'no_telepon' => $req->no_telepon,
                'pengguna_id' => $akun->id_pengguna
            ]);

            if ($petugas) {
                return redirect('/pengguna/petugas')->with('success', 'Data berhasil disimpan!');
            } else{
                return redirect()->back()->with('error', 'Data  gagal disimpan!');
            }
        }
    }

    public function edit(Request $req){
        $validator = Validator::make($req->all(), [
            'username' => ['required', 'min:3'],
            'nama_petugas' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        $akun = Pengguna::where('id_pengguna', $req->pengguna_id)->update([
            'username' => $req->username,
            'password' => bcrypt($req->password),
            'level_akses' => 'petugas'
        ]);

        $petugas = Petugas::where('pengguna_id', $req->pengguna_id)->update([
            'nama_petugas' => $req->nama_petugas,
            'alamat' => $req->alamat,
            'no_telepon' => $req->no_telepon,
            'pengguna_id' => $req->pengguna_id
        ]);

        if ($petugas) {
            return redirect('/pengguna/petugas')->with('success', 'Data berhasil diubah!');
        }

        return redirect()->back()->with('error', 'Data  gagal diubah!');
    }

    public function hapus(Request $req){
        $petugas = Petugas::where('pengguna_id', $req->pengguna_id)->delete();
        $akun = Pengguna::where('id_pengguna', $req->pengguna_id)->delete();

        if ($akun && $petugas) {
            return redirect('/pengguna/petugas')->with('success', 'Data berhasil dihapus!');
        }else{
            return redirect()->back()->with( 'error', 'Data gagal dihapus!');
        }
    }
}
