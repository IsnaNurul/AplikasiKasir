@extends('component.template')

@section('style')
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/js-datatables/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/owlcarousel.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/sweetalert2.css">
    <!-- Tambahkan animasi CSS menggunakan Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>
                        Penjualan Produk</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Apps</li>
                        <li class="breadcrumb-item active">Penjualan Produk</li>
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
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr class="border-bottom">
                                        <th> <span class=" f-w-600">Nomor</span></th>
                                        <th> <span class=" f-w-600">Tanggal</span></th>
                                        <th> <span class=" f-w-600">Keterangan</span></th>
                                        <th> <span class=" f-w-600">Dibuat</span></th>
                                        <th> <span class=" f-w-600">Pelanggan</span></th>
                                        <th> <span class=" f-w-600">Kategori</span></th>
                                        <th> <span class=" f-w-600">Produk</span></th>
                                        <th> <span class=" f-w-600">Qty</span></th>
                                        <th> <span class=" f-w-600">Harga Satuan</span></th>
                                        <th> <span class=" f-w-600">Sub Total</span></th>
                                        <th> <span class=" f-w-600">Total</span></th>
                                        <th> <span class=" f-w-600">Status</span></th>
                                        {{-- <th> <span class="text-white f-w-600">#</span></th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Set variabel grand total sebelum loop -->
                                    @php
                                        $grandTotal = 0;
                                        $subtotal = 0; // variabel untuk menghitung subtotal per pesanan
                                    @endphp
                                    @foreach ($pesanan as $key => $item)
                                        @php
                                            $produkCount = count($detail_jual[$item->id_penjualan]);
                                        @endphp
                                        @foreach ($detail_jual[$item->id_penjualan] as $index => $detail)
                                            <tr>
                                                @if ($index === 0)
                                                    <td rowspan="{{ $produkCount }}">{{ $item->kode_transaksi }}</td>
                                                    <td rowspan="{{ $produkCount }}">
                                                        {{ $item->tanggal_jual? \Carbon\Carbon::parse($item->tanggal_jual)->locale('id')->translatedFormat('j F Y'): '-' }}
                                                    </td>
                                                    <td rowspan="{{ $produkCount }}" style="width: 15%">
                                                        {{ $item->tipe_penjualan }}, <br>
                                                        {{ $item->metode_pembayaran }}
                                                    </td>
                                                    <td rowspan="{{ $produkCount }}">{{ $item->pengguna->username }}</td>
                                                    <td rowspan="{{ $produkCount }}">
                                                        {{ $item->pelanggan_id ? $item->pelanggan->nama_pelanggan : '-' }}
                                                    </td>
                                                    @php
                                                        $subtotal = $item->total_harga;
                                                    @endphp
                                                @endif
                                                <td>{{ $detail->produk ? $detail->produk->kategori_produk->nama_kategori : 'No Product' }}
                                                </td>
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
                                                <td>
                                                    <div>
                                                        @if ($item->status == 'selesai')
                                                            <a href=""><span
                                                                    class="badge badge-light-success">{{ $item->status }}</span></a>
                                                        @elseif ($item->status == 'ditunda')
                                                            <a href=""><span
                                                                    class="badge badge-light-warning">{{ $item->status }}</span></a>
                                                        @elseif ($item->status == 'dibatalkan')
                                                            <a href=""><span
                                                                    class="badge badge-light-danger">{{ $item->status }}</span></a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @php
                                            $grandTotal += $subtotal;
                                        @endphp
                                        <!-- Sisipkan total dari pesanan ini di bagian paling bawah -->
                                        @if ($loop->last)
                                            <tr>
                                                <td colspan="10"><strong>Grand Total</strong></td>
                                                <td><strong>Rp. {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                                            </tr>
                                        @endif
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

    <!-- Tambahkan fungsi JavaScript untuk animasi -->
    <script>
        // Jalankan animasi saat dokumen selesai dimuat
        document.addEventListener("DOMContentLoaded", function(event) {
            animateAlert();
        });

        // Fungsi untuk menambahkan kelas animasi ke alert
        function animateAlert() {
            // Cari elemen alert
            var alertElement = document.querySelector('.alert');

            // Tambahkan kelas animasi ke elemen alert
            alertElement.classList.add('animate__animated', 'animate__fadeInRight');
        }
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @if (Session::has('error'))
        <script>
            swal("Warning", "{{ Session::get('error') }}", "warning");
        </script>
    @endif
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
