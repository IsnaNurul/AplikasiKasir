<?php

namespace App\Http\Controllers;

use App\Models\DetailBeli;
use App\Models\Pembelian;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Before;

class PembelianController extends Controller
{
    //
    public function index(){
        $data['pembelian'] = Pembelian::with('pengguna', 'detail_beli')->get();
        $data['produk'] = Produk::all();

        //Validasi Produk Expired
        // $tanggal = Carbon::now('Asia/Jakarta');
        // $data['produk'] = Produk::where('tanggal_kadaluarsa', '>', $tanggal)->get();

        return view('administrator.pembelian', $data);
    }

    public function add(Request $req){
        $validator = Validator::make($req->all(), [
            'tanggal_beli' => 'required',
            'pengguna_id' => 'required',
            'harga' => 'required',
            'jumlah_beli' => 'required',
            'pembelian_id' => 'required',
            'produk_kode' => 'required',
        ]);

        $pembelian = Pembelian::create([
            'tanggal_beli' => $req->tanggal_beli,
            'pengguna_id' => Auth::user()->id_pengguna,
        ]);

        if ($pembelian) {
            $detail = DetailBeli::create([
                'harga' => $req->harga,
                'jumlah_beli' => $req->jumlah_beli,
                'pembelian_id' => $pembelian->id_pembelian,
                'produk_kode' => $req->produk_kode
            ]);

            if ($detail) {
                return redirect('/pembelian')->with('success', 'Data berhasil disimpan!');
            } else {
                return redirect()->back()->with('error', 'Data gagal disimpan!');
            }
        }
    }

    public function hapus(Request $req){
        $pembelian = Pembelian::where('id_pembelian', $req->id_pembelian)->delete(); 
        
        if ($pembelian) {
            return redirect('/pembelian')->with('success', 'Data berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Data gagal dihapus!');
    }
    
}
