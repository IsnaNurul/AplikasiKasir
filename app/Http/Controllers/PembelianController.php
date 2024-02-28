<?php

namespace App\Http\Controllers;

use App\Models\DetailBeli;
use App\Models\KategoriProduk;
use App\Models\Pembelian;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Before;

class PembelianController extends Controller
{
    //
    public function index()
    {
        $data['pembelian'] = Pembelian::with('pengguna', 'detail_beli')->get();
        $data['produk'] = Produk::all();
        $data['kategori_produk'] = KategoriProduk::all();

        //Validasi Produk Expired
        // $tanggal = Carbon::now('Asia/Jakarta');
        // $data['produk'] = Produk::where('tanggal_kadaluarsa', '>', $tanggal)->get();

        return view('administrator.pembelian', $data);
    }

    public function add(Request $req)
    {
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

        $produk_kd = DetailBeli::where('produk_kode', $req->produk_kode)->where('pembelian_id', $pembelian->id_pembelian)->count();

        if ($pembelian) {
            if ($produk_kd > 0) {
                $detail = DetailBeli::where('produk_kode', $req->produk_kode)->update([
                    'harga' => $req->harga,
                    'jumlah_beli' => $req->jumlah_beli,
                    'pembelian_id' => $pembelian->id_pembelian,
                    'produk_kode' => $req->produk_kode
                ]);
            } else{
                $detail = DetailBeli::create([
                    'harga' => $req->harga,
                    'jumlah_beli' => $req->jumlah_beli,
                    'pembelian_id' => $pembelian->id_pembelian,
                    'produk_kode' => $req->produk_kode
                ]);
            }

            if ($detail) {
                $dataProduk = Produk::where('kode_produk', $detail->produk_kode)->first();
    
                $produk = Produk::where('kode_produk', $detail->produk_kode)->update([
                    'stok' => $dataProduk->stok + $detail->jumlah_beli
                ]);
    
                if ($produk) {
                    return redirect('/pembelian/detail/' . $pembelian->id_pembelian)->with('success', 'Data berhasil disimpan!');
                }
            } else {
                return redirect()->back()->with('error', 'Data gagal disimpan!');
            }
        }
    }


    public function hapus(Request $req)
    {
        $pembelian = Pembelian::where('id_pembelian', $req->id_pembelian)->delete();

        if ($pembelian) {
            return redirect('/pembelian')->with('success', 'Data berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Data gagal dihapus!');
    }

    public function indexDetail($id_pembelian)
    {
        $data['detail_beli'] = DetailBeli::where('pembelian_id', $id_pembelian)->with('produk')->get();
        $data['produk'] = Produk::all();
        $data['kategori_produk'] = KategoriProduk::all();

        Session::put('id_pembelian', $id_pembelian);

        return view('administrator.detail-pembelian', $data);
    }

    public function addDetail(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'harga' => 'required',
            'jumlah_beli' => 'required',
            'pembelian_id' => 'required',
            'produk_kode' => 'required',
        ]);

        $id_pembelian = Session::get('id_pembelian');

        $detail = DetailBeli::create([
            'harga' => $req->harga,
            'jumlah_beli' => $req->jumlah_beli,
            'pembelian_id' => $id_pembelian,
            'produk_kode' => $req->produk_kode
        ]);

        if ($detail) {
            $dataProduk = Produk::where('kode_produk', $detail->produk_kode)->first();

            $produk = Produk::where('kode_produk', $detail->produk_kode)->update([
                'stok' => $dataProduk->stok + $detail->jumlah_beli
            ]);

            if ($produk) {
                return redirect('/pembelian/detail/' . $id_pembelian)->with('success', 'Data berhasil disimpan!');
            }
        } else {
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }
    }

    public function hapusDetail(Request $req)
    {
        $detailpembelian = DetailBeli::where('id_detail_beli', $req->id_detail_beli)->delete();
        $id_pembelian = Session::get('id_pembelian');

        if ($detailpembelian) {
            return redirect('/pembelian/detail/' . $id_pembelian)->with('success', 'Data berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Data gagal dihapus!');
    }

    public function editDetail(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'harga' => 'required',
            'jumlah_beli' => 'required',
            'pembelian_id' => 'required',
            'produk_kode' => 'required',
        ]);

        $id_pembelian = Session::get('id_pembelian');

        $detail2 = DetailBeli::where('id_detail_beli', $req->id_detail_beli)->first();

        $detail = DetailBeli::where('id_detail_beli', $req->id_detail_beli)->update([
            'harga' => $req->harga,
            'jumlah_beli' => $req->jumlah_beli,
            'pembelian_id' => $id_pembelian,
            'produk_kode' => $req->produk_kode
        ]);

        if ($detail) {
            $dataProduk = Produk::where('kode_produk', $req->produk_kode)->first();

            // Menghitung selisih jumlah beli baru dengan jumlah beli sebelumnya
            $selisihStok = $req->jumlah_beli - $detail2->jumlah_beli;

            // Menambah stok jika selisih stok positif, mengurangi jika negatif
            $sisaStok = $dataProduk->stok + $selisihStok;

            // Pastikan stok tidak kurang dari 0
            if ($sisaStok < 0) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi!');
            }

            // Update stok produk
            Produk::where('kode_produk', $req->produk_kode)->update([
                'stok' => $sisaStok
            ]);

            return redirect('/pembelian/detail/' . $id_pembelian)->with('success', 'Data berhasil disimpan!');
        } else {
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }
    }
}
