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
        $data['pembelian'] = Pembelian::with('pengguna', 'detail_beli')->orderBy('tanggal_beli', 'desc')->get();
        $data['produk'] = Produk::all();
        $data['kategori_produk'] = KategoriProduk::all();
        // $data['detail']
        // $data['jml_produk'] = DetailBeli::groupBy('pembelian_id')->get()->count();
        // dd($data['jml_produk']);

        //Validasi Produk Expired
        // $tanggal = Carbon::now('Asia/Jakarta');
        // $data['produk'] = Produk::where('tanggal_kadaluarsa', '>', $tanggal)->get();

        return view('administrator.pembelian', $data);
    }

    public function edit(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'tanggal_beli' => 'required',
            'supplier' => 'required',
        ]);

        $pembelian = Pembelian::where('id_pembelian', $req->id_pembelian)->update([
            'tanggal_beli' => $req->tanggal_beli,
            'supplier' => $req->supplier
        ]);

        if ($pembelian) {
            return redirect('/pembelian')->with('success', 'Data berhasil diubah!');
        } else {
            return redirect()->back()->with('error', 'Data gagal diubah!');
        }
    }

    public function add(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'tanggal_beli' => 'required',
            'pengguna_id' => 'required',
            'harga' => 'required',
            'jumlah_beli' => 'required',
            'supplier' => 'required',
            'pembelian_id' => 'required',
            'produk_kode' => 'required',
        ]);

        $pembelian = Pembelian::create([
            'tanggal_beli' => $req->tanggal_beli,
            'pengguna_id' => Auth::user()->id_pengguna,
            'supplier' => $req->supplier
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
            } else {
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
        $data['pembelian'] = Pembelian::where('id_pembelian', $id_pembelian)->first();

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

        $dataProdukDetail = DetailBeli::where('produk_kode', $req->produk_kode)->first();

        if ($dataProdukDetail) {
            // Dapatkan jumlah_beli sebelumnya
            $jumlahBeliSebelumnya = $dataProdukDetail->jumlah_beli;
            // Hitung selisih antara jumlah_beli sebelumnya dan jumlah_beli baru
            $selisihJumlahBeli = $req->jumlah_beli - $jumlahBeliSebelumnya;

            // Update jumlah_beli di detail beli
            $updateDetailBeli = DetailBeli::where('produk_kode', $req->produk_kode)
                ->update(['jumlah_beli' => $dataProdukDetail['jumlah_beli'] + $req->jumlah_beli]);

            // Perbarui stok produk
            $produk = Produk::where('kode_produk', $req->produk_kode)->first();
            if ($produk) {
                $stokBaru = $produk->stok + $selisihJumlahBeli;
                $updateStok = Produk::where('kode_produk', $req->produk_kode)
                    ->update(['stok' => $stokBaru]);

                if ($updateStok) {

                    $produk->update([
                        'stok' => $produk->stok + $req->jumlah_beli
                    ]);
                    // Lakukan apa yang diperlukan setelah berhasil memperbarui stok
                    return redirect('/pembelian/detail/' . $id_pembelian)->with('success', 'Data berhasil disimpan!');
                } else {
                    // Tindakan jika gagal memperbarui stok produk
                    return redirect()->back()->with('error', 'Gagal memperbarui stok produk!');
                }
            } else {
                // Tindakan jika produk tidak ditemukan
                return redirect()->back()->with('error', 'Produk tidak ditemukan!');
            }
        } else {
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
