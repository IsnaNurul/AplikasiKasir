<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProdukController;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::middleware(['statuslogin'])->group(function () {
    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    //administrator
    Route::get('/pengguna/administrator', [AdminController::class, 'index']);
    Route::post('/pengguna/administrator/add', [AdminController::class, 'add']);
    Route::post('/pengguna/administrator/edit/{pengguna_id}', [AdminController::class, 'edit']);
    Route::get('/pengguna/administrator/hapus/{pengguna_id}', [AdminController::class, 'hapus']);

    //Petugas
    Route::get('/pengguna/petugas', [PetugasController::class, 'index']);
    Route::post('/pengguna/petugas/add', [PetugasController::class, 'add']);
    Route::post('/pengguna/petugas/edit/{pengguna_id}', [PetugasController::class, 'edit']);
    Route::get('/pengguna/petugas/hapus/{pengguna_id}', [PetugasController::class, 'hapus']);

    //Pelanggan
    Route::get('/pengguna/pelanggan', [PelangganController::class, 'index']);
    Route::post('/pengguna/pelanggan/add', [PelangganController::class, 'add']);
    Route::post('/pengguna/pelanggan/edit/{pengguna_id}', [PelangganController::class, 'edit']);
    Route::get('/pengguna/pelanggan/hapus/{pengguna}', [PelangganController::class, 'hapus']);


    //kategori
    Route::get('/kategori-produk', [KategoriController::class, 'index']);
    Route::post('/kategori-produk/add', [KategoriController::class, 'add']);
    Route::post('/kategori-produk/edit/{id_kategori_produk}', [KategoriController::class, 'edit']);
    Route::get('/kategori-produk/hapus/{id_kategori_produk}', [KategoriController::class, 'hapus']);

    //produk
    Route::get('/produk', [ProdukController::class, 'index']);
    Route::get('/produk/create', [ProdukController::class, 'create']);
    Route::post('/produk/add', [ProdukController::class, 'add']);
    Route::post('/produk/edit/{kode_produk}', [ProdukController::class, 'edit']);
    Route::get('/produk/hapus/{kode_produk}', [ProdukController::class, 'hapus']);

    //diskon produk
    Route::get('/diskon-produk', [DiskonController::class, 'index']);
    Route::post('/diskon-produk/add', [DiskonController::class, 'add']);
    Route::post('/diskon-produk/edit/{id_diskon_produk}', [DiskonController::class, 'edit']);
    Route::get('/diskon-produk/hapus/{id_diskon_produk}', [DiskonController::class, 'hapus']);

    //penjualan
    Route::get('/penjualan', [PenjualanController::class, 'index']);

    //pembelian
    Route::get('/pembelian', [PembelianController::class, 'index']);
    Route::post('/pembelian/add', [PembelianController::class, 'add']);
    Route::get('/pembelian/hapus/{id_pembelian}', [PembelianController::class, 'hapus']);
    Route::post('/pembelian/edit/{id_pembelian}', [PembelianController::class, 'edit']);
    Route::post('/pembelian/detail/add', [PembelianController::class, 'addDetail']);
    Route::get('/pembelian/detail/{id_pembelian}', [PembelianController::class, 'indexDetail']);
    Route::get('/pembelian/detail/hapus/{id_detail_beli}', [PembelianController::class, 'hapusDetail']);
    Route::post('/pembelian/detail/edit/{id_detail_beli}', [PembelianController::class, 'editDetail']);

    //penjualan
    Route::get('/penjualan', [PenjualanController::class, 'index']);
    Route::get('/penjualan/riwayat', [PenjualanController::class, 'riwayat']);
    Route::post('/penjualan', [PenjualanController::class, 'search']);
    Route::post('/penjualan/add', [PenjualanController::class, 'add']);
    Route::get('/penjualan/hapus/{id}', [PenjualanController::class, 'hapus']);
    Route::post('/penjualan/addData', [PenjualanController::class, 'addData']);
    Route::post('/penjualan/simpan', [PenjualanController::class, 'simpan']);
    Route::get('/penjualan/cart/{kode_produk}', [PenjualanController::class, 'addCart']);
    Route::get('/penjualan/cartHapus/{nama_produk}', [PenjualanController::class, 'hapusCart']);
    Route::post('/penjualan/cartUpdate/{nama_produk}', [PenjualanController::class, 'updateCart']);
    Route::get('/penjualan/cartAllHapus', [PenjualanController::class, 'hapusAllCart']);

    //pesanan
    Route::get('/pesanan', [PesananController::class, 'index']);
    Route::post('/pesanan/update/{id_penjualan}', [PesananController::class, 'update']);

    //Pengiriman
    Route::get('/pengiriman', [PengirimanController::class, 'index']);
    Route::post('/pengiriman/add', [PengirimanController::class, 'add']);
    Route::post('/pengiriman/edit/{id_pengiriman}', [PengirimanController::class, 'edit']);
    Route::get('/pengiriman/hapus/{id_pengiriman}', [PengirimanController::class, 'hapus']);

    //laporan
    Route::get('/laporan-penjualan', [LaporanController::class, 'index']);
    Route::get('/laporan-penjualan/filterDate', [LaporanController::class, 'index']);
    Route::get('/laporan-penjualan/invoice/{id}', [LaporanController::class, 'invoice']);
    Route::get('/laporan-penjualan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan-penjualan.export-excel');
});

Route::post('/login', [AuthController::class, 'auth']);
Route::get('/logout', [AuthController::class, 'logout']);
