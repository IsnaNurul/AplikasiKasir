<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengirimanController extends Controller
{
    //
    public function index(){
        $data['pengiriman'] = Pengiriman::with('penjualan')->get();
        $data['penjualan'] = Penjualan::all();

        return view('administrator.pengiriman', $data);
    }

    public function add(Request $req){
        $validator = Validator::make($req->all(), [
            'tanggal_pengiriman' => 'required',
            'biaya_pengiriman' => 'required',
            'penjualan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        $data = Pengiriman::create([
            'tanggal_pengiriman' => $req->tanggal_pengiriman,
            'biaya_pengiriman' => $req->biaya_pengiriman,
            'status_pengiriman' => 'proses',
            'penjualan_id' => $req->penjualan_id,
            'alamat_pengiriman' => $req->alamat_pengiriman
        ]);

        if ($data) {
            return redirect('/pengiriman')->with('success', 'Data berhasil disimpan!');
        }
            return back()->with('error', 'Data gagal disimpan!');
    }

    public function edit(Request $req){
        $validator = Validator::make($req->all(), [
            'tanggal_pengiriman' => 'required',
            'biaya_pengiriman' => 'required',
            'penjualan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        $data = Pengiriman::where('id_pengiriman', $req->id_pengiriman)->update([
            'tanggal_pengiriman' => $req->tanggal_pengiriman,
            'biaya_pengiriman' => $req->biaya_pengiriman,
            'status_pengiriman' => 'proses',
            'penjualan_id' => $req->penjualan_id
        ]);

        if ($data) {
            return redirect('/pengiriman')->with('success', 'Data berhasil diubah!');
        }
            return back()->with('error', 'Data gagal diubah!');
    }

    public function hapus($id_pengiriman){
        $Pengiriman = Pengiriman::where('id_pengiriman', $id_pengiriman)->delete();

        if ($Pengiriman) {
            return redirect('/pengiriman')->with('success', 'Data berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Data gagal dihapus!');

    }
}
