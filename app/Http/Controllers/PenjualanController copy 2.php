<?php

namespace App\Http\Controllers;

use App\Models\DetailJual;
use App\Models\KategoriProduk;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    //
    public function index()
    {
        // if (auth()->user()->level_akses == 'administrator') {
        //     $data['penjualan'] = Penjualan::with('pengguna', 'pelanggan')->get();
        //     $data['produk'] = Produk::all();
        //     $data['kategori_produk'] = KategoriProduk::all();
        //     $data['pelanggan'] = Pelanggan::all();
        //     $data['tanggal'] = Carbon::now('Asia/jakarta');
        //     $data['kode_otomatis'] = Penjualan::latest()->value('kode_transaksi');

        //     // Jika tidak ada transaksi sebelumnya, kode_transaksi_terakhir akan bernilai null
        //     if ($data['kode_otomatis']) {

        //         $data['kode_otomatis'] += 1;
        //     } else {
        //         $data['kode_otomatis'] = "1";
        //     }

        //     return view('administrator.penjualan', $data);
        // }

        if (auth()->user()->level_akses == 'petugas' || auth()->user()->level_akses == 'administrator') {
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

    public function riwayat()
    {
        $data['penjualan'] = Penjualan::with('pengguna', 'pelanggan')->get();
        $data['produk'] = Produk::all();
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
        return view('administrator.penjualan', $data);
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
            $cart[$kode_produk] = [
                'kode_produk' => $produk->kode_produk,
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga,
                'jumlah_produk' => 1,
                'diskon_produk_id' => $produk->diskon_produk_id,
                'keterangan' => ''
            ];

            session()->put('carts', $cart);

            return redirect('/penjualan');
        }

        if (isset($cart[$kode_produk])) {
            $cart[$kode_produk]['jumlah_produk']++;
            session()->put('carts', $cart);

            return redirect('/penjualan');
        }

        $cart[$kode_produk] = [
            'kode_produk' => $produk->kode_produk,
            'nama_produk' => $produk->nama_produk,
            'harga' => $produk->harga,
            'jumlah_produk' => 1,
            'diskon_produk_id' => $produk->diskon_produk_id,
            'keterangan' => ''
        ];

        session()->put('carts', $cart);

        return redirect('/penjualan');
    }

    public function hapusCart(Request $request, $nama_produk)
    {
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

    public function updateCart(Request $request, $kode_produk)
    {
        $jumlah_produk = $request->input('jumlah_produk');
        $keterangan = $request->input('keterangan');

        $cart = session()->get('carts');

        if (!$cart || !isset($cart[$kode_produk])) {
            abort(404); // Produk tidak ditemukan dalam keranjang
        }

        $cart[$kode_produk]['jumlah_produk'] = $jumlah_produk;
        $cart[$kode_produk]['keterangan'] = $keterangan;

        session()->put('carts', $cart);

        return redirect('/penjualan');
    }


    public function add(Request $req)
    {
        $data['kode_otomatis'] = Penjualan::latest()->value('kode_transaksi');
        $tanggal = Carbon::now('Asia/Jakarta');
        $transaksiId = $data['kode_otomatis'] + 1;
        $totalDiskon = 0;
        $total = 0;
        $totalFinal = 0;

        $metode_pembayaran = $req->filled('jumlah_bayar') ? 'cash' : 'transfer';

        $penjualan = Penjualan::create([
            'kode_transaksi' => $transaksiId,
            'tanggal_jual' => $tanggal,
            'metode_pembayaran' => $metode_pembayaran,
            'pelanggan_id' => $req->pelanggan_id,
            'pengguna_id' => auth()->user()->id_pengguna,
            'status' => 'selesai',
            'tipe_penjualan' => $req->tipe_penjualan,
            'total_harga' => '',
            'jumlah_bayar' => $req->jumlah_bayar,
            'rekening_tujuan' => $req->tipe_pembayaran
        ]);

        $carts = session()->get('carts');

        if ($penjualan) {
            foreach ($carts as $kode_produk => $details) {
                $diskon = DB::table('diskon_produks')
                    ->where('id_diskon_produk', $details['diskon_produk_id'])
                    ->first();
                if ($details['diskon_produk_id'] != null) {
                    if ($diskon->jenis_diskon == 'persentase') {
                        $totalDiskon = ($details['harga'] * ($diskon->nilai / 100)) * $details['jumlah_produk'];
                    } elseif ($diskon->jenis_diskon == 'nominal') {
                        $totalDiskon = $diskon->nilai * $details['jumlah_produk'];
                    }
                } else {
                    $totalDiskon = 0;
                }

                $hargaFinal = $details['harga'] * $details['jumlah_produk'] - $totalDiskon;
                $totalFinal += $hargaFinal;

                // Kurangi jumlah stok produk di database
                $produk = Produk::where('kode_produk', $details['kode_produk'])->first();
                $produk->stok -= $details['jumlah_produk'];
                $produk->save();

                // Buat entri detail penjualan
                $detailsPenjualan = new DetailJual();
                $detailsPenjualan->penjualan_id = $transaksiId;
                $detailsPenjualan->produk_kode = $details['kode_produk'];
                $detailsPenjualan->jumlah_produk = $details['jumlah_produk'];
                $detailsPenjualan->harga_jual = $hargaFinal;
                $detailsPenjualan->save();

                $updatePenjualan = Penjualan::where('id_penjualan', $penjualan->id_penjualan)->first();
                $updatePenjualan->total_harga = $totalFinal;
                $updatePenjualan->save();
            }

            session()->forget('carts');

            return redirect('/penjualan')->with('success', 'Transaksi berhasil');
        } else {
            return back()->with('error', 'Gagal menambahkan transaksi ke database!');
        }
    }

    public function hapus($id)
    {
        $penjualan = Penjualan::where('id_penjualan', $id)->delete();

        return redirect('/penjualan');
    }

    public function addData(Request $req)
    {
        $tanggal = Carbon::now('Asia/Jakarta');
        $kode_otomatis = Penjualan::latest()->value('kode_transaksi');
        $transaksiId = $kode_otomatis + 1;
        $totalFinal = 0;

        $metode_pembayaran = $req->filled('jumlah_bayar') ? 'cash' : 'transfer';

        $penjualan = Penjualan::create([
            'kode_transaksi' => $transaksiId,
            'tanggal_jual' => $tanggal,
            'metode_pembayaran' => $metode_pembayaran,
            'pelanggan_id' => $req->pelanggan_id,
            'pengguna_id' => auth()->user()->id_pengguna,
            'status' => 'selesai',
        ]);

        if ($penjualan) {
            $kode_produk = $req->kode_produk;
            $jumlah_produk = $req->jumlah_produk;

            $produk = Produk::where('kode_produk', $kode_produk)->first();
            $harga = $produk->harga; // Ambil harga dari tabel produk
            $diskon_produk_id = $produk->diskon_produk_id; // Ambil ID diskon dari tabel produk

            $diskon = null;
            if ($diskon_produk_id) {
                $diskon = DB::table('diskon_produks')
                    ->where('id_diskon_produk', $diskon_produk_id)
                    ->first();
            }

            if ($diskon) {
                if ($diskon->jenis_diskon == 'persentase') {
                    $totalDiskon = ($harga * ($diskon->nilai / 100)) * $jumlah_produk;
                } elseif ($diskon->jenis_diskon == 'nominal') {
                    $totalDiskon = $diskon->nilai * $jumlah_produk;
                }
            } else {
                $totalDiskon = 0;
            }

            $hargaFinal = $harga * $jumlah_produk - $totalDiskon;
            $totalFinal += $hargaFinal;

            // Kurangi jumlah stok produk di database
            $produk->stok -= $jumlah_produk;
            $produk->save();

            // Buat entri detail penjualan
            $detailsPenjualan = new DetailJual();
            $detailsPenjualan->penjualan_id = $transaksiId;
            $detailsPenjualan->produk_kode = $kode_produk;
            $detailsPenjualan->jumlah_produk = $jumlah_produk;
            $detailsPenjualan->harga_jual = $hargaFinal;
            $detailsPenjualan->save();

            $updatePenjualan = Penjualan::where('id_penjualan', $penjualan->id_penjualan)->first();
            $updatePenjualan->total_harga = $totalFinal;
            $updatePenjualan->save();

            return redirect('/penjualan')->with('success', 'Transaksi berhasil');
        } else {
            return back()->with('error', 'Gagal menambahkan transaksi ke database!');
        }
    }


    public function simpan(Request $req)
    {
        $data['kode_otomatis'] = Penjualan::latest()->value('kode_transaksi');
        $tanggal = Carbon::now('Asia/Jakarta');
        $transaksiId = $data['kode_otomatis'] + 1;
        $totalDiskon = 0;
        $total = 0;
        $totalFinal = 0;

        $metode_pembayaran = $req->filled('jumlah_bayar') ? 'cash' : 'transfer';

        $penjualan = Penjualan::create([
            'kode_transaksi' => $transaksiId,
            'tanggal_jual' => $tanggal,
            'metode_pembayaran' => $metode_pembayaran,
            'pelanggan_id' => $req->pelanggan_id,
            'pengguna_id' => auth()->user()->id_pengguna,
            'status' => 'ditunda',
            'tipe_penjualan' => $req->tipe_penjualan,
            'total_harga' => '',
            'jumlah_bayar' => $req->jumlah_bayar,
            'rekening_tujuan' => $req->tipe_pembayaran
        ]);

        $carts = session()->get('carts');

        if ($penjualan) {
            foreach ($carts as $kode_produk => $details) {
                $diskon = DB::table('diskon_produks')
                    ->where('id_diskon_produk', $details['diskon_produk_id'])
                    ->first();
                if ($details['diskon_produk_id'] != null) {
                    if ($diskon->jenis_diskon == 'persentase') {
                        $totalDiskon = ($details['harga'] * ($diskon->nilai / 100)) * $details['jumlah_produk'];
                    } elseif ($diskon->jenis_diskon == 'nominal') {
                        $totalDiskon = $diskon->nilai * $details['jumlah_produk'];
                    }
                } else {
                    $totalDiskon = 0;
                }

                $hargaFinal = $details['harga'] * $details['jumlah_produk'] - $totalDiskon;
                $totalFinal += $hargaFinal;

                // Kurangi jumlah stok produk di database
                $produk = Produk::where('kode_produk', $details['kode_produk'])->first();
                $produk->stok -= $details['jumlah_produk'];
                $produk->save();

                // Buat entri detail penjualan
                $detailsPenjualan = new DetailJual();
                $detailsPenjualan->penjualan_id = $transaksiId;
                $detailsPenjualan->produk_kode = $details['kode_produk'];
                $detailsPenjualan->jumlah_produk = $details['jumlah_produk'];
                $detailsPenjualan->harga_jual = $hargaFinal;
                $detailsPenjualan->save();

                $updatePenjualan = Penjualan::where('id_penjualan', $penjualan->id_penjualan)->first();
                $updatePenjualan->total_harga = $totalFinal;
                $updatePenjualan->save();
            }

            session()->forget('carts');

            return redirect('/penjualan')->with('success', 'Transaksi ditunda');
        } else {
            return back()->with('error', 'Gagal menambahkan transaksi ke database!');
        }
    }
}
