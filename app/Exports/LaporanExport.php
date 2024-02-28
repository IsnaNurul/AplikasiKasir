<?php

namespace App\Exports;

use App\Models\Penjualan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    protected $pesanan;
    protected $detail_jual;
    protected $startDate;
    protected $endDate;

    public function __construct($pesanan, $detail_jual, $startDate, $endDate)
    {
        $this->pesanan = $pesanan;
        $this->detail_jual = $detail_jual;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        return view('exports.pesanan_excel', [
            'pesanan' => $this->pesanan,
            'detail_jual' => $this->detail_jual,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }
}
