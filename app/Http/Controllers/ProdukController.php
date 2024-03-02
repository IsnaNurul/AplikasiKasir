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
    public function index()
    {
        $data['produk'] = Produk::with('kategori_produk')->get();
        $data['kategori_produk'] = KategoriProduk::all();
        $data['diskon_produk'] = DiskonProduk::all();

        //// Mengambil entri terakhir dari tabel produk
        $lastProduct = Produk::latest()->first();

        // Inisialisasi nomor kode terakhir
        $lastProductNumber = 0;

        if ($lastProduct) {
            // Jika ada entri terakhir, ekstrak nomor dari kode produk
            $lastProductNumber = intval(substr($lastProduct->kode_produk, 4));
        }

        // Increment nomor produk
        $lastProductNumber++;

        // Format nomor kode produk agar menjadi tiga digit (contoh: 001)
        $formattedNumber = str_pad($lastProductNumber, 3, '0', STR_PAD_LEFT);

        // Atur nilai kode produk
        $data['kd_produk'] = "PRD-" . $formattedNumber;

        // Menghapus diskon jika melewati batas akhir
        $currentDate = now();
        foreach ($data['diskon_produk'] as $diskon) {
            if ($diskon->berlaku_selesai < $currentDate) {
                $diskon->delete();
            }
        }


        return view('administrator.produk', $data);
    }

    public function create()
    {
        $data['produk'] = Produk::with('kategori_produk', 'diskon_produk')->get();
        $data['kategori_produk'] = KategoriProduk::all();
        return view('administrator.produk-create', $data);
    }

    public function add(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'kode_produk' => ['required'],
            'nama_produk' => 'required',
            'harga' => 'required',
            'stok' => 'required',
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

    public function editDiskon(Request $req)
    {

        $data = Produk::where('kode_produk', $req->kode_produk)->update([
            'diskon_produk_id' => $req->diskon_produk_id,

        ]);

        if ($data) {
            return redirect('/produk')->with('success', 'Diskon berhasil disimpan!');
        }
        return redirect()->back()->with('error', 'Data gagal disimpan!');
    }

    public function hapusDiskon(Request $req)
    {

        $data = Produk::where('kode_produk', $req->kode_produk)->update([
            'diskon_produk_id' => null,

        ]);

        if ($data) {
            return redirect('/produk')->with('success', 'Diskon berhasil dihapus dari produk!');
        }
        return redirect()->back()->with('error', 'Data gagal disimpan!');
    }


    public function edit(Request $req)
    {
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
            // Jika ada file gambar yang diunggah, hapus foto lama jika ada
            if ($produk->gambar_produk) {
                Storage::delete($produk->gambar_produk);
            }

            // Simpan foto baru
            $photoPath = $req->file('gambar_produk')->storeAs('gambar_produk', $req->file('gambar_produk')->hashName());
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


    public function hapus(Request $req)
    {
        $produk = Produk::where('kode_produk', $req->kode_produk)->first();
        $data = Produk::where('kode_produk', $req->kode_produk)->delete();
        Storage::delete($produk->gambar_produk);

        if ($data) {
            return redirect('/produk')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Data gagal dihapus!');
        }
    }
}
