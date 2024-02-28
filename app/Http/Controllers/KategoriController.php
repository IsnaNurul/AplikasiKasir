<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    //
    public function index(){
        $data['produk'] = Produk::with('kategori_produk')->get();
        $data['kategori'] = KategoriProduk::all();
        return view('administrator.kategori', $data);
    }

    public function add(Request $req){
        $validator = Validator::make($req->all(), [
            'nama_kategori' => ['required', 'min:3']
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        $data = KategoriProduk::create([
            'nama_kategori' => $req->nama_kategori
        ]);

        if ($data) {
            return redirect('/kategori-produk')->with('success', 'Data berhasil disimpan!');
        } else {
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }
    }

    public function edit(Request $req){
        $validator = Validator::make($req->all(), [
            'nama_kategori' => ['required', 'min:3']
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        $data = KategoriProduk::where('id_kategori_produk', $req->id_kategori_produk)->update([
            'nama_kategori' => $req->nama_kategori 
        ]);

        if ($data) {
            return redirect('/kategori-produk')->with('succes', 'Data berhasil diubah!');
        } else {
            return redirect()->back()->with('error', 'Data gagal diubah!');
        }
    }

    public function hapus(Request $req){
        $data =  KategoriProduk::where('id_kategori_produk',$req->id_kategori_produk)->delete();

        if ($data) {
            return redirect('/kategori-produk')->with('success', 'Data berhasil dihapus!');
        } else {
            return back()->with('error', 'Data gagal dihapus!');
        }
    }
}
