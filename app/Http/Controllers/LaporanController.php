<?php

namespace App\Http\Controllers;

use App\Models\DetailJual;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data pesanan
        $data['penjualan'] = Penjualan::with(['pelanggan'])->where('status', 'selesai');

        // Jika terdapat filter tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $data['startDate'] = $request->input('start_date');
            $data['endDate'] = $request->input('end_date');

            // Menambahkan kondisi untuk filter tanggal
            $data['penjualan']->whereDate('tanggal_jual', '>=', $data['startDate'])
                ->whereDate('tanggal_jual', '<=', $data['endDate']);
        }

        $data['pesanan'] = $data['penjualan']->orderBy('tanggal_jual', 'desc')->get();

        foreach ($data['pesanan'] as $key => $value) {
            $data['detail_jual'][$value->id_penjualan] = DetailJual::where('penjualan_id', $value->id_penjualan)->with('produk')->get();
        }

        return view('laporan', $data);
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->start_date ?? null;
        $endDate = $request->end_date ?? null;
        // dd($startDate, $endDate);

        $pesananQuery = Penjualan::where('status', 'selesai');

        // Jika terdapat filter tanggal, tambahkan kondisi ke query
        if ($startDate != null && $endDate != null) {
          
            $pesananQuery->whereDate('tanggal_jual', '>=', $startDate)
            ->whereDate('tanggal_jual', '<=', $endDate);;
        }

        // dd($startDate,$endDate);

        // Ambil pesanan sesuai dengan query yang telah dibuat
        $pesanan = $pesananQuery->with('pelanggan')->orderBy('tanggal_jual', 'desc')->get();

        // Cek apakah ada data penjualan
        if ($pesanan->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data penjualan yang tersedia.');
        }
        
        $detail_jual = [];

        foreach ($pesanan as $key => $value) {
            $detail_jual[$value->id_penjualan] = DetailJual::where('penjualan_id', $value->id_penjualan)->with('produk')->get();
        }

        // Lakukan pengunduhan data sesuai dengan data yang telah diproses
        return Excel::download(new LaporanExport($pesanan, $detail_jual, $startDate, $endDate), 'laporan-penjualan.xlsx');
    }

    public function invoice($id){
        $data['penjualan'] = Penjualan::with(['pelanggan'])->where('id_penjualan', $id)->first();

        $data['pesanan'] = $data['penjualan']->get();
        $data['detail_jual'] = DetailJual::where('penjualan_id', $id)->with('produk')->get();

        // dd($data);
        return view('invoice', $data);
    }
}
