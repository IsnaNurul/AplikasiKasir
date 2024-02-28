<?php

namespace App\Http\Controllers;

use App\Models\DiskonProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Termwind\Components\Raw;

class DiskonController extends Controller
{
    //
    public function index(){
        $data['produk'] = Produk::with('diskon_produk')->get();
        $data['diskon_produk'] = DiskonProduk::all();
        return view('administrator.diskon', $data);
    }

    public function add(Request $req){
        $validator = Validator::make($req->all(), [
            'nama_diskon' => 'required',
            'jenis_diskon' => 'required',
            'nilai' => 'required',
            'deskripsi' => 'required',
            'berlaku_mulai' => 'required',
            'berlaku_selesai' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('erros', $validator->messages()->all()[0])->withInput();
        }

        $data = DiskonProduk::create([
            'nama_diskon' => $req->nama_diskon,
            'jenis_diskon' => $req->jenis_diskon,
            'nilai' => $req->nilai,
            'deskripsi' => $req->deskripsi,
            'berlaku_mulai' => $req->berlaku_mulai,
            'berlaku_selesai' => $req->berlaku_selesai
        ]);

        if ($data) {
            return redirect('/diskon-produk')->with('success', 'Data berhasil disimpan!');
        } else {
            return back()->with('error', 'Data gagal disimpan!');
        }
    } 

    public function edit(Request $req){
        $validator = Validator::make($req->all(), [
            'nama_diskon' => 'required',
            'jenis_diskon' => 'required',
            'nilai' => 'required',
            'deskripsi' => 'required',
            'berlaku_mulai' => 'required',
            'berlaku_selesai' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('erros', $validator->messages()->all()[0])->withInput();
        }

        $data = DiskonProduk::where('id_diskon_produk', $req->id_diskon_produk)->update([
            'nama_diskon' => $req->nama_diskon,
            'jenis_diskon' => $req->jenis_diskon,
            'nilai' => $req->nilai,
            'deskripsi' => $req->deskripsi,
            'berlaku_mulai' => $req->berlaku_mulai,
            'berlaku_selesai' => $req->berlaku_selesai
        ]);

        if ($data) {
            return redirect('/diskon-produk')->with('success', 'Data berhasil diubah!');
        } else {
            return back()->with('error', 'Data gagal diubah!');
        }
    }

    public function hapus(Request $req){
        $data =  DiskonProduk::where('id_diskon_produk',$req->id_diskon_produk)->delete();

        if ($data) {
            return redirect('/diskon-produk')->with('success', 'Data berhasil dihapus!');
        } else {
            return back()->with('error', 'Data gagal dihapus!');
        }
    }
}
