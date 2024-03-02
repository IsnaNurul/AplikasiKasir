<?php

namespace App\Http\Controllers;

use App\Models\DetailBeli;
use App\Models\DetailJual;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Pengguna;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $yesterday = Carbon::yesterday('Asia/Jakarta')->format('Y-m-d');

        $total_penjualan_today = Penjualan::whereDate('tanggal_jual', $today)->sum('total_harga');
        $total_transaksi_today = Penjualan::whereDate('tanggal_jual', $today)->count();
        $penjualan = Penjualan::whereDate('tanggal_jual', $today)->get();
        $total_penjualan_yesterday = Penjualan::whereDate('tanggal_jual', $yesterday)->sum('total_harga');

        // Mengambil tanggal awal bulan ini
        $start_of_month = Carbon::now('Asia/Jakarta')->startOfMonth()->format('Y-m-d');
        // $transaksi = Penjualan::where('status', 'selesai')->count();

        // dd($start_of_month);

        $jumlah_produk_terjual_today = 0; // Initialize the variable here

        // Menghitung jumlah produk terjual pada hari ini
        foreach ($penjualan as $key => $value) {
            $jumlah_produk_terjual_today += DetailJual::where('penjualan_id', $value->id_penjualan)->sum('jumlah_produk');
        }

        // Menghitung total penjualan bulan ini
        $total_penjualan_bulan_ini = Penjualan::whereDate('tanggal_jual', '>=', $start_of_month)->whereDate('tanggal_jual', '<=', $today)->sum('total_harga');

        // Menghitung jumlah hari dalam bulan ini
        $days_in_month = Carbon::now('Asia/Jakarta')->daysInMonth;

        // Menghitung rata-rata penjualan per hari bulan ini
        $rata_rata_penjualan_bulan_ini = $days_in_month != 0 ? $total_penjualan_bulan_ini / $days_in_month : 0;

        // Menghitung rata-rata penjualan per transaksi hari ini
        $rata_rata_penjualan_hari_ini = $total_transaksi_today != 0 ? $total_penjualan_today / $total_transaksi_today : 0;

        $total_penjualann = Penjualan::where('status', 'selesai')->sum('total_harga');

        // Mendapatkan pesanan terbaru
        $recent_orders = DetailJual::with('penjualan')->groupBy('penjualan_id')->latest()->limit(5)->get();

        // Mendapatkan top 3 produk yang sering dibeli
        $top_products = DetailJual::select('produk_kode', DB::raw('SUM(jumlah_produk) as total_penjualan'))
            ->groupBy('produk_kode')
            ->orderByDesc('total_penjualan')->with('produk')
            ->limit(3)
            ->get();

        $persentase_perubahan = 0;
        if ($total_penjualan_yesterday > 0) {
            $persentase_perubahan = (($total_penjualan_today - $total_penjualan_yesterday) / $total_penjualan_yesterday) * 100;
            // Memastikan persentase tidak melebihi 100%
            $persentase_perubahan = min($persentase_perubahan, 100);
        }

        // Tentukan kelas panah berdasarkan perubahan persentase
        if ($persentase_perubahan > 0) {
            $arrow_class = 'icon-arrow-up';
        } elseif ($persentase_perubahan < 0) {
            $arrow_class = 'icon-arrow-down';
        } else {
            $arrow_class = 'icon-arrow-right';
        }
        // Ubah nilai persentase_perubahan menjadi bilangan bulat
        $persentase_perubahan = $persentase_perubahan;

        $total_petugas = Pengguna::where('level_akses', 'petugas')->count();
        $total_pelanggan = Pelanggan::count();


        $data = [
            'total_penjualan' => Penjualan::count(),
            'transaksi' => Penjualan::where('status', 'selesai')->count(),
            'total_penjualan_today' => $total_penjualan_today,
            'total_produk_today' => $jumlah_produk_terjual_today,
            'total_penjualan_thismonth' => $total_penjualan_bulan_ini,
            'rata_rata_penjualan_bulan_ini' => $rata_rata_penjualan_bulan_ini,
            'rata_rata_penjualan_hari_ini' => $rata_rata_penjualan_hari_ini,
            'total_pembelian' => Pembelian::count(),
            'arrow_class' => $arrow_class,
            'recent_order' => $recent_orders,
            'persentase_perubahan' => intval($persentase_perubahan),
            'top_products' => $top_products,
            'total_penjualan' => $total_penjualann,
            'total_petugas' => $total_petugas,
            'total_pelanggan' => $total_pelanggan,
        ];

        return view('component.dashboard', $data);
    }
}
