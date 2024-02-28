<?php

namespace App\Http\Controllers;

use App\Models\DiskonProduk;
use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class ProdukController extends Controller
{
    //
    public function index(){
        $data['produk'] = Produk::with('kategori_produk')->get();
        $data['kategori_produk'] = KategoriProduk::all();
        $data['diskon_produk'] = DiskonProduk::all();
        return view('administrator.produk', $data);
    }

    public function create(){
        $data['produk'] = Produk::with('kategori_produk', 'diskon_produk')->get();
        $data['kategori_produk'] = KategoriProduk::all();
        return view('administrator.produk-create', $data);
    }

    public function add(Request $req){
        $validator = Validator::make($req->all(), [
            'kode_produk' => ['required'],
            'nama_produk' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'tanggal_kadaluarsa' => 'required',
            'kategori_produk_id' => 'required',
            'gambar_produk' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        if ($req->hasFile('gambar_produk')) {
            $photoPath = $req->file('gambar_produk')->storeAs('gambar_produk', $req->file('gambar_produk')->hashName());
        } else {
            $photoPath = null;
        }

        $data = Produk::create([
            'kode_produk' => $req->kode_produk,
            'nama_produk' => $req->nama_produk,
            'harga' => $req->harga,
            'stok' => $req->stok,
            'tanggal_kadaluarsa' => $req->tanggal_kadaluarsa,
            'kategori_produk_id' => $req->kategori_produk_id,
            'gambar_produk' => $photoPath
        ]);

        if ($data) {
            return redirect('/produk')->with('success', 'Data berhasil disimpan!');
        }
        return redirect()->back()->with('error', 'Data gagal disimpan!');
    }

    public function  edit(Request $req){
        $produk = Produk::where('kode_produk', $req->kode_produk)->first();
        
        $validator = Validator::make($req->all(), [
            'kode_produk' => ['required'],
            'nama_produk' => ['required', 'min:3'],
            'harga' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        $photoPath = $produk->gambar_produk; 

        if ($req->hasFile('gambar_produk')) {
            if ($produk->kode_produk) {
                Storage::delete($produk->gambar_produk);
            }

            $photoPath = $req->file('gambar_produk')->storeAs('gambar_produk', $req->file('gambar_produk')->hashName());
        } else {
            $photoPath = null;
        }

        $data = Produk::where('kode_produk', $req->kode_produk)->update([
            'kode_produk' => $req->kode_produk,
            'nama_produk' => $req->nama_produk,
            'harga' => $req->harga,
            'stok' => $req->stok,
            'tanggal_kadaluarsa' => $req->tanggal_kadaluarsa,
            'kategori_produk_id' => $req->kategori_produk_id,
            'gambar_produk' => $photoPath
        ]);

        if ($data) {
            return redirect('/produk')->with('success', 'Data berhasil disimpan!');
        }
        return redirect()->back()->with('error', 'Data gagal disimpan!');
    }

    public function hapus(Request $req){
        $produk = Produk::where('kode_produk', $req->kode_produk)->first();
        $data = Produk::where('kode_produk', $req->kode_produk)->delete();
        Storage::delete($produk->gambar_produk);
        
        if ($data) {
            return redirect('/produk')->with('success', 'Data berhasil dihapus!');
        }else{
            return redirect()->back()->with( 'error', 'Data gagal dihapus!');
        }
    }
}
