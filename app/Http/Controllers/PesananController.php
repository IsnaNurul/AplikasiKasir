<?php

namespace App\Http\Controllers;

use App\Models\DetailJual;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    //
    public function index(Request $req){
        $data['pelanggan'] = Pelanggan::all();
        $data['pesanan'] = Penjualan::where('status', 'ditunda')->with(['pelanggan', 'pengguna'])->get();
    
        foreach ($data['pesanan'] as $key => $value) {
            $data['detail_jual'][$value->id_penjualan] = DetailJual::where('penjualan_id', $value->id_penjualan)->with('produk')->get();
        }
    
        return view('petugas.pesanan', $data);
    }

    public function update(Request $req)
    {
        $data['kode_otomatis'] = Penjualan::latest()->value('kode_transaksi');
        $tanggal = Carbon::now('Asia/Jakarta');
        $transaksiId = $data['kode_otomatis'] + 1;
        $totalDiskon = 0;
        $total = 0;
        $totalFinal = 0;

        $metode_pembayaran = $req->filled('jumlah_bayar') ? 'cash' : 'transfer';

        $penjualan = Penjualan::where('id_penjualan', $req->id_penjualan)->update([
            'metode_pembayaran' => $metode_pembayaran,
            'pelanggan_id' => $req->pelanggan_id,
            'pengguna_id' => auth()->user()->id_pengguna,
            'status' => 'selesai',
            'tipe_penjualan' => $req->tipe_penjualan,
            'jumlah_bayar' => $req->jumlah_bayar,
            'rekening_tujuan' => $req->tipe_pembayaran
        ]);

        $carts = DetailJual::where('penjualan_id', $req->id_penjualan)->get();

        if ($penjualan) {
            // foreach ($carts as $kode_produk => $details) {

            //     // Kurangi jumlah stok produk di database
            //     $produk = Produk::where('kode_produk', $details['kode_produk'])->first();
            //     $produk->stok -= $details['jumlah_produk'];
            //     $produk->save();

            //     // Buat entri detail penjualan
            //     $detailsPenjualan = DetailJual::where('penjualan_id', $details['penjualan_id'])->first();
            //     $detailsPenjualan->penjualan_id = $transaksiId;
            //     $detailsPenjualan->produk_kode = $details['kode_produk'];
            //     $detailsPenjualan->jumlah_produk = $details['jumlah_produk'];
            //     $detailsPenjualan->save();

            //     $updatePenjualan = Penjualan::where('id_penjualan', $penjualan->id_penjualan)->first();
            //     $updatePenjualan->total_harga = $totalFinal;
            //     $updatePenjualan->save();
            // }

            // session()->forget('carts');

            return redirect('/pesanan')->with('success', 'Transaksi berhasil');
        } else {
            return back()->with('error', 'Gagal menambahkan transaksi ke database!');
        }
    }
}
