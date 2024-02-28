<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PelangganController extends Controller
{
    //
    public function index()
    {
        $data['pelanggan'] = Pelanggan::with('pengguna')->get();
        $title = 'Hapus Data!';
        $text = "Apakah kamu yakin akan menghapus data ini?";
        confirmDelete($title, $text);
        return view('pelanggan.main', $data);
    }

    public function add(Request $req)
    {
        if ($req->username != null) {
            $validator = Validator::make($req->all(), [
                'password' => [Password::min(5)],
                'nama_pelanggan' => 'required',
            ]);

            if ($validator->fails()) {
                return back()->with('errors', $validator->messages()->all()[0])->withInput();
            }

            $akun = Pengguna::create([
                'username' => $req->username,
                'password' => bcrypt($req->password),
                'level_akses' => 'pelanggan'
            ]);

            if (!empty($akun)) {
                $pelanggan = Pelanggan::create([
                    'nama_pelanggan' => $req->nama_pelanggan,
                    'alamat' => $req->alamat,
                    'no_telepon' => $req->no_telepon,
                    'pengguna_id' => $akun->id_pengguna
                ]);

                if ($pelanggan) {
                    return redirect('/pengguna/pelanggan')->with('success', 'Data berhasil disimpan!');
                } else {
                    return redirect()->back()->with('error', 'Data  gagal disimpan!');
                }
            }
        } else {
            $data['kode_otomatis'] = Pengguna::latest()->value('id_pengguna');
            $transaksiId = $data['kode_otomatis'] + 1;
            $akun = Pengguna::create([
                'username' => $transaksiId . $req->nama_pelanggan,
                'password' => bcrypt(12345),
                'level_akses' => 'pelanggan'
            ]);

            if (!empty($akun)) {
                $pelanggan = Pelanggan::create([
                    'nama_pelanggan' => $req->nama_pelanggan,
                    'alamat' => $req->alamat,
                    'no_telepon' => $req->no_telepon,
                    'pengguna_id' => $akun->id_pengguna
                ]);

                if ($pelanggan) {
                    return redirect('/penjualan')->with('success', 'Data berhasil disimpan!');
                } else {
                    return redirect()->back()->with('error', 'Data  gagal disimpan!');
                }
            }
        }
    }

    public function edit(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nama_pelanggan' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        $akun = Pengguna::where('id_pengguna', $req->pengguna_id)->update([
            'username' => $req->username,
            'password' => bcrypt($req->password),
            'level_akses' => 'pelanggan'
        ]);

        $pelanggan = Pelanggan::where('pengguna_id', $req->pengguna_id)->update([
            'nama_pelanggan' => $req->nama_pelanggan,
            'alamat' => $req->alamat,
            'no_telepon' => $req->no_telepon,
            'pengguna_id' => $req->pengguna_id
        ]);

        if ($pelanggan) {
            return redirect('/pengguna/pelanggan')->with('success', 'Data berhasil diubah!');
        }

        return redirect()->back()->with('error', 'Data  gagal diubah!');
    }

    public function hapus(Request $req)
    {
        $pelanggan = Pelanggan::where('pengguna_id', $req->pengguna_id)->delete();
        $akun = Pengguna::where('id_pengguna', $req->pengguna_id)->delete();

        if ($akun && $pelanggan) {
            return redirect('/pengguna/pelanggan')->with('Success', 'Data berhasil dihapus!');
        } else {
            return redirect()->back()->with('Error', 'Data gagal dihapus!');
        }
    }
}
