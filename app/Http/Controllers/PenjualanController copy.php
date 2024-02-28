<?php

namespace App\Http\Controllers;

use App\Models\DetailJual;
use App\Models\KategoriProduk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    //
    public function index()
    {
        if (auth()->user()->level_akses == 'administrator') {
            $data['penjualan'] = Penjualan::with('pengguna', 'pelanggan')->get();
            $data['produk'] = Produk::all();
            $data['kategori_produk'] = KategoriProduk::all();
            $data['pelanggan'] = Pelanggan::all();
            $data['tanggal'] = Carbon::now('Asia/jakarta');

            return view('administrator.penjualan', $data);
        }

        if (auth()->user()->level_akses == 'petugas') {
            $data['penjualan'] = Penjualan::with('pengguna', 'pelanggan')->get();
            $data['produk'] = Produk::with('diskon_produk')->get();
            $data['kategori_produk'] = KategoriProduk::all();
            $data['pelanggan'] = Pelanggan::all();
            $data['tanggal'] = Carbon::now('Asia/jakarta');

            $data['kode_otomatis'] = Penjualan::latest()->value('kode_transaksi');

            // Jika tidak ada transaksi sebelumnya, kode_transaksi_terakhir akan bernilai null
            if ($data['kode_otomatis']) {

                $data['kode_otomatis'] += 1;
            } else {
                $data['kode_otomatis'] = "1";
            }

            foreach ($data['produk'] as $key => $value) {
                // Menghitung harga setelah diskon
                $hargaSetelahDiskon = $value->harga;


                if ($value->diskon_produk) {
                    if ($value->diskon_produk->jenis_diskon == 'persentase') {
                        $hargaSetelahDiskon -= ($value->harga * ($value->diskon_produk->nilai / 100));
                    } elseif ($value->diskon_produk->jenis_diskon == 'nominal') {
                        $hargaSetelahDiskon -= $value->diskon_produk->nilai;
                    }
                }

                // Menambahkan harga setelah diskon ke dalam array data
                $data['produk'][$key]['harga_diskon'] = $hargaSetelahDiskon;
            }

            return view('petugas.penjualan', $data);
        }
    }

    public function search(Request $req)
    {
        if (auth()->user()->level_akses == 'administrator') {
            $data['penjualan'] = Penjualan::with('pengguna', 'pelanggan')->get();
            $data['produk'] = Produk::all();
            $data['kategori_produk'] = KategoriProduk::all();
            $data['pelanggan'] = Pelanggan::all();
            $data['tanggal'] = Carbon::now('Asia/jakarta');

            return view('administrator.penjualan', $data);
        }

        if (auth()->user()->level_akses == 'petugas') {
            $data['penjualan'] = Penjualan::with('pengguna', 'pelanggan')->get();
            $data['produk'] = Produk::with('diskon_produk')->where('nama_produk', 'LIKE', '%' . $req->nama . '%')->orWhere('kode_produk', 'LIKE', '%' . $req->nama . '%')->get();
            $data['kategori_produk'] = KategoriProduk::all();
            $data['pelanggan'] = Pelanggan::all();
            $data['tanggal'] = Carbon::now('Asia/jakarta');

            $data['kode_otomatis'] = Penjualan::latest()->value('kode_transaksi');

            // Jika tidak ada transaksi sebelumnya, kode_transaksi_terakhir akan bernilai null
            if ($data['kode_otomatis']) {

                $data['kode_otomatis'] += 1;
            } else {
                $data['kode_otomatis'] = "1";
            }

            foreach ($data['produk'] as $key => $value) {
                // Menghitung harga setelah diskon
                $hargaSetelahDiskon = $value->harga;


                if ($value->diskon_produk) {
                    if ($value->diskon_produk->jenis_diskon == 'persentase') {
                        $hargaSetelahDiskon -= ($value->harga * ($value->diskon_produk->nilai / 100));
                    } elseif ($value->diskon_produk->jenis_diskon == 'nominal') {
                        $hargaSetelahDiskon -= $value->diskon_produk->nilai;
                    }
                }

                // Menambahkan harga setelah diskon ke dalam array data
                $data['produk'][$key]['harga_diskon'] = $hargaSetelahDiskon;
            }

            return view('petugas.penjualan', $data);
        }
    }

    public function addCart(Request $req, $kode_produk)
    {
        $produk = Produk::find($kode_produk);

        if (!$produk) {
            abort(404);
        }

        $cart = session()->get('carts');

        if (!$cart) {
            $cart = [
                $kode_produk = [
                    'kode_produk' => $produk->kode_produk,
                    'nama_produk' => $produk->nama_produk,
                    'harga' => $produk->harga,
                    'jumlah_produk' => 1,
                    'diskon_produk_id' => $produk->diskon_produk_id,
                ]
            ];

            session()->put('carts', $cart);
            dd(session('carts'));
            return redirect('/penjualan');
        }

        if ($cart[$kode_produk] == $kode_produk) {
            $cart[$kode_produk]['jumlah_produk']++;
            session()->put('carts', $cart);
            dd(session()->get('carts'));
            return redirect('/penjualan');
        }

        $cart[$kode_produk] = [
            'kode_produk' => $produk->kode_produk,
            'nama_produk' => $produk->nama_produk,
            'harga' => $produk->harga,
            'jumlah_produk' => 1,
            'diskon_produk_id' => $produk->diskon_produk_id,
        ];

        session()->put('carts', $cart);

        // dd(session()->get('cart'));

        return redirect('/penjualan');
    }

    public function hapusCart(Request $request, $nama_produk)
    {
        // $productName = $request->input('nama_produk');

        $cart = session()->get('carts');

        if (isset($cart[$nama_produk])) {
            unset($cart[$nama_produk]); // Menghapus produk dari sesi
            session()->put('carts', $cart); // Menyimpan kembali sesi tanpa produk yang dihapus

            return redirect('/penjualan')->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect('/penjualan')->with('error', 'Produk tidak ditemukan dalam keranjang.');
    }

    public function hapusAllCart()
    {
        $cart = session()->get('carts');

        if (isset($cart)) {
            session()->forget('carts'); // Menghapus produk dari sesi
            return redirect('/penjualan')->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect('/penjualan')->with('error', 'Produk tidak ditemukan dalam keranjang.');
    }

    public function add(Request $req)
    {
        $data['kode_otomatis'] = Penjualan::latest()->value('kode_transaksi');
        $tanggal = Carbon::now('Asia/jakarta');
        $penjulan = Penjualan::create([
            'kode_transaksi' => $data['kode_otomatis'] + 1,
            'tanggal_jual' => $tanggal,
            'pengguna_id' => auth()->user()->id_pengguna,
        ]);

        $carts = session()->get('carts');

        if ($penjulan) {
            foreach ($carts as $kode_produk => $details) {
                $detailsPenjulan = new DetailJual();
                $detailsPenjulan->penjualan_id = $penjulan->id_penjualan;
                $detailsPenjulan->produk_kode = $details['kode_produk'];
                $detailsPenjulan->jumlah_produk = $details['jumlah_produk'];
                $detailsPenjulan->harga_jual = $details['harga'];
                $detailsPenjulan->save();
            }

            session()->forget('carts');

            return redirect('/penjualan')->with('success', 'Tarnsaksi berhasil');
        } else {
            return back()->with('error', 'Gagal menambahkan transaksi ke database!');
        }

        // return  response()->json(['success' => true]);
        return redirect('/penjualan');
    }
}
