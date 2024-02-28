<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $data['total_penjualan'] = Penjualan::count();
        $data['total_pembelian'] = Pembelian::count();
        return view('component.dashboard', $data);
    }
}
