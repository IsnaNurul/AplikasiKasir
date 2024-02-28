@extends('component.template')

@section('style')
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/js-datatables/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/owlcarousel.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/sweetalert2.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>
                        Pesanan Produk</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Apps</li>
                        <li class="breadcrumb-item active">pengiriman Produk</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="list-product-header">
                            <form action="/laporan-penjualan/filterDate" method="get">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="">MULAI</label>
                                        <input class="form-control" value="{{ $startDate ?? date('Y-m-d') }}" type="date"
                                            name="start_date" id="start_date">
                                    </div>
                                    <div class="col">
                                        <label for="">SAMPAI</label>
                                        <input class="form-control" value="{{ $endDate ?? date('Y-m-d') }}" type="date"
                                            name="end_date" id="end_date">
                                    </div>
                                    <div class="col mt-4">
                                        <label for=""></label>
                                        @php
                                            $defaultStartDate = $startDate ?? date('Y-m-d');
                                            $defaultEndDate = $endDate ?? date('Y-m-d');
                                        @endphp
                                        <a href="{{ route('laporan-penjualan.export-excel', ['start_date' => $defaultStartDate, 'end_date' => $defaultEndDate]) }}"
                                            class="btn btn-secondary float-middle float-end mt-n1 ms-2"><i
                                                class="fa fa-file-excel-o"></i>Export</a>
                                        <button type="submit" onclick="validateForm()"
                                            class="btn btn-primary ms-2 float-middle float-end mt-n1">Terapkan</button>
                                    </div>


                                </div>
                                @if (request()->is('laporan-penjualan/filterDate*'))
                                    <div class="row mb-2">
                                        <a href="/laporan-penjualan" class="">--Reset Filter--</a>
                                    </div>
                                @endif
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead style="background-color: rgb(132, 155, 228)">
                                    <tr>
                                        <th> <span class="text-white f-w-600">Nomor</span></th>
                                        <th> <span class="text-white f-w-600">Tanggal</span></th>
                                        <th> <span class="text-white f-w-600">Keterangan</span></th>
                                        <th> <span class="text-white f-w-600">Dibuat</span></th>
                                        <th> <span class="text-white f-w-600">Pelanggan</span></th>
                                        <th> <span class="text-white f-w-600">Produk</span></th>
                                        <th> <span class="text-white f-w-600">Qty</span></th>
                                        <th> <span class="text-white f-w-600">Harga Satuan</span></th>
                                        <th> <span class="text-white f-w-600">Sub Total</span></th>
                                        <th> <span class="text-white f-w-600">Total</span></th>
                                        {{-- <th> <span class="text-white f-w-600">#</span></th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pesanan as $key => $item)
                                        @php
                                            $produkCount = count($detail_jual[$item->id_penjualan]);
                                        @endphp
                                        @foreach ($detail_jual[$item->id_penjualan] as $index => $detail)
                                            <tr>
                                                @if ($index === 0)
                                                    <td rowspan="{{ $produkCount }}">{{ $item->kode_transaksi }}</td>
                                                    <td rowspan="{{ $produkCount }}">
                                                        {{ $item->tanggal_jual ? \Carbon\Carbon::parse($item->tanggal_jual)->isoFormat('D MMMM YYYY, HH:mm:ss') : '-' }}
                                                    </td>
                                                    <td rowspan="{{ $produkCount }}" style="width: 15%">
                                                        {{ $item->tipe_penjualan }}, <br>
                                                        {{ $item->metode_pembayaran }}
                                                    </td>
                                                    <td rowspan="{{ $produkCount }}">{{ $item->pengguna->username }}</td>
                                                    <td rowspan="{{ $produkCount }}">
                                                        {{ $item->pelanggan_id ? $item->pelanggan->nama_pelanggan : '-' }}
                                                    </td>
                                                @endif
                                                <td>{{ $detail->produk ? $detail->produk->nama_produk : 'No Product' }}
                                                </td>
                                                <td>{{ $detail->jumlah_produk ? $detail->jumlah_produk : '0' }}</td>
                                                <td>{{ $detail->jumlah_produk > 0 ? 'Rp. ' . number_format($detail->harga_jual / $detail->jumlah_produk, 0, ',', '.') : '0' }}
                                                </td>
                                                <td>Rp. {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                                                @if ($index === 0)
                                                    <td rowspan="{{ $produkCount }}">Rp.
                                                        {{ $item->total_harga ? number_format($item->total_harga, '0', ',', '.') : '-' }}
                                                    </td>
                                                @endif
                                                {{-- <td>
                                                    <a class="btn btn-sm" onclick="window.print();" href="#"><i style="font-size: 20px"
                                                        class="fa fa-file-excel-o"></i>Print</a>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid Ends-->
@endsection

@section('script')
    <script>
        function validateForm() {
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;

            var diffInDays = getDiffInDays(startDate, endDate);

            if (diffInDays > 30) {
                alert('Jarak tanggal maksimal adalah 1 bulan.');
            } else {
                document.getElementById('filterForm').submit();
            }
        }

        function getDiffInDays(startDate, endDate) {
            var start = new Date(startDate);
            var end = new Date(endDate);
            var diffInMs = end - start;
            var diffInDays = diffInMs / (1000 * 60 * 60 * 24);
            return diffInDays;
        }
    </script>
    <!-- Plugins JS start-->
    <script src="../assets/js/sidebar-menu.js"></script>
    <script src="../assets/js/sidebar-pin.js"></script>
    <script src="../assets/js/slick/slick.min.js"></script>
    <script src="../assets/js/slick/slick.js"></script>
    <script src="../assets/js/header-slick.js"></script>
    <script src="../assets/js/js-datatables/simple-datatables%40latest.js"></script>
    <script src="../assets/js/custom-list-product.js"></script>
    <script src="../assets/js/owlcarousel/owl.carousel.js"></script>
    <script src="../assets/js/ecommerce.js"></script>
    <script src="../assets/js/tooltip-init.js"></script>
    <script src="../assets/js/modalpage/validation-modal.js"></script>
    <!-- Plugins JS Ends-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
