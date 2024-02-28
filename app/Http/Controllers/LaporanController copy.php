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
        $query = Penjualan::with(['pelanggan']);

        // Jika terdapat filter tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $data['startDate'] = $request->input('start_date');
            $data['endDate'] = $request->input('end_date');

            // Menambahkan kondisi untuk filter tanggal
            $query->whereDate('tanggal_jual', '>=', $data['startDate'])
                ->whereDate('tanggal_jual', '<=', $data['endDate']);
        }

        $data['pesanan'] = $query->get();

        foreach ($data['pesanan'] as $key => $value) {
            $data['detail_jual'][$value->id_penjualan] = DetailJual::where('penjualan_id', $value->id_penjualan)->with('produk')->get();
        }

        return view('laporan', $data);
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-d');
        $endDate = $request->end_date ?? date('Y-m-d');

        $pesanan = Penjualan::whereBetween('tanggal_jual', [$startDate, $endDate])->with('pelanggan')->get();

        $detail_jual = [];
        foreach ($pesanan as $key => $value) {
            $detail_jual[$value->id_penjualan] = DetailJual::where('penjualan_id', $value->id_penjualan)->with('produk')->get();
        }

        return Excel::download(new LaporanExport($pesanan, $detail_jual, $startDate, $endDate), 'laporan-penjualan.xlsx');
    }

    private function getData($request)
    {
        $query = Penjualan::with(['pelanggan']);

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query->whereBetween('tanggal_jual', [$startDate, $endDate]);
        }

        return $query->get();
    }
}
