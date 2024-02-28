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

        $data['pesanan'] = $data['penjualan']->get();

        foreach ($data['pesanan'] as $key => $value) {
            $data['detail_jual'][$value->id_penjualan] = DetailJual::where('penjualan_id', $value->id_penjualan)->with('produk')->get();
        }

        return view('laporan', $data);
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-d');
        $endDate = $request->end_date ?? date('Y-m-d');

        $pesanan = Penjualan::whereBetween('tanggal_jual', [$startDate, $endDate])->where('status', 'selesai')->with('pelanggan')->get();

        $detail_jual = [];
        
        foreach ($pesanan as $key => $value) {
            $detail_jual[$value->id_penjualan] = DetailJual::where('penjualan_id', $value->id_penjualan)->with('produk')->get();
        }

        return Excel::download(new LaporanExport($pesanan, $detail_jual, $startDate, $endDate), 'laporan-penjualan.xlsx');
    }
}