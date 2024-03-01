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
                        {{-- <div class="list-product-header">
                            <div>
                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap"
                                    data-whatever="@getbootstrap"><i class="fa fa-plus"></i>Tambah</a>
                            </div>
                        </div> --}}
                        <div class="list-product">
                            <table class="table" id="project-status">
                                <thead>
                                    <tr>
                                        <th style="width: 10%"> <span class="f-light f-w-600">Transaction ID</span></th>
                                        <th style="width: 10%"> <span class="f-light f-w-600">Dibuat</span></th>
                                        <th style="width: 10%"> <span class="f-light f-w-600">Pelanggan</span></th>
                                        <th style="width: 60%"> <span class="f-light f-w-600">Produk</span></th>
                                        <th style="width: 10%"> <span class="f-light f-w-600">Total</span></th>
                                        <th style="width: 10%"> <span class="f-light f-w-600">Action</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pesanan as $key => $item)
                                        <tr class="product-removes">
                                            <td>
                                                <p class="f-light">{{ $item->kode_transaksi }}</p>
                                            </td>
                                            <td>
                                                <p class="f-light">
                                                    {{ $item->pengguna ? $item->pengguna->username : '-' }}</p>
                                            </td>
                                            <td>
                                                <p class="f-light">
                                                    {{ $item->pelanggan_id ? $item->pelanggan->nama_pelanggan : '-' }}</p>
                                            </td>
                                            <td>
                                                <ul>

                                                </ul>
                                                <p class="f-light">
                                                    @foreach ($detail_jual[$item->id_penjualan] as $detail)
                                                        {{ $detail->produk ? $detail->produk->nama_produk : 'No Product' }}
                                                        <br>
                                                    @endforeach
                                                </p>
                                            </td>

                                            <td>
                                                <p class="f-light">
                                                    {{ $item->total_harga ? 'Rp. ' . number_format($item->total_harga) : '-' }}
                                                </p>
                                            </td>
                                            <td>
                                                <div class="product-action">
                                                    <a href="" data-bs-toggle="modal"
                                                        data-bs-target="#modalBayar{{ $item->id_penjualan }}"
                                                        class="btn btn-success btn-sm">BAYAR</a>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Modal Bayar --}}
                                        <div class="modal fade modal-md" id="modalBayar{{ $item->id_penjualan }}"
                                            data-bs-backdrop="static" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div
                                                        class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                                        <h3 class="modal-header justify-content-center border-0">
                                                            {{ $item->total_harga ? 'Rp. ' . number_format($item->total_harga, '0', ',', '.') : '0' }}
                                                        </h3>
                                                        <div class="modal-body p-4">
                                                            <form action="/pesanan/update/{{ $item->id_penjualan }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="customer-info block-section mb-3">
                                                                    <h6>Informasi Pelanggan</h6>
                                                                    <div class="input-block d-flex align-items-center">
                                                                        <div class="flex-grow-1 me-2 mt-2">
                                                                            <select name="pelanggan_id"
                                                                                class="form-select select" required>
                                                                                <option value="">Tanpa Pelanggan
                                                                                </option>
                                                                                @foreach ($pelanggan as $pelanggans)
                                                                                    <option
                                                                                        value="{{ $pelanggans->id_pelanggan }}"
                                                                                        {{ $item->pelanggan_id == $pelanggans->id_pelanggan ? 'selected' : '' }}>
                                                                                        {{ $pelanggans->nama_pelanggan }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="input-block mt-2">
                                                                        <div class="flex-grow-1 me-2 mt-2">
                                                                            <select name="tipe_penjualan"
                                                                                class="form-select select">
                                                                                <option value="dine in">Dine in</option>
                                                                                <option value="take away">Take away</option>
                                                                                <option value="online">Online</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="mb-3">Metode Pembayaran</h6>
                                                                <div
                                                                    class="text-center d-flex justify-content-between mb-3">
                                                                    <div class="col-md-6 me-1">
                                                                        <a style="width: 100%"
                                                                            class="btn btn-lg btn-outline-success tunai-btn">Tunai</a>
                                                                    </div>
                                                                    <div class="col-md-6 ms-1">
                                                                        <a style="width: 100%"
                                                                            class="btn btn-lg btn-outline-success transfer-btn">Transfer</a>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group-wrapper">
                                                                    <div id="tunai-form" class="mb-3"
                                                                        style="display:none;">
                                                                        <h6 class="mb-2">Uang Bayar</h6>
                                                                        <div class="input-group">
                                                                            <input class="form-control" type="number"
                                                                                name="jumlah_bayar" 
                                                                                id="jumlah-bayar"
                                                                                onchange="hitungUangKembali()" required>
                                                                        </div>
                                                                        <h6 class="mb-2">Uang Kembali</h6>
                                                                        <div class="input-group">
                                                                            <input class="form-control" type="number"
                                                                                placeholder="" id="uang-kembali"
                                                                                placeholder="" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div id="transfer-form" class="mb-3"
                                                                        style="display:none;">
                                                                        <h6 class="mb-2">Transfer</h6>
                                                                        <div class="input-group mb-3">
                                                                            <select class="form-select"
                                                                                name="tipe_pembayaran" id="">
                                                                                <option value=""></option>
                                                                                <option value="BCA(87578997)">BCA
                                                                                    - 87578997</option>
                                                                                <option value="BRI(12880866)">BRI
                                                                                    - 12880866</option>
                                                                                <option value="DANA(0882889387894)">
                                                                                    DANA - 0882889387894</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 d-flex justify-content-end">
                                                                    <button class="btn btn-primary"
                                                                        type="submit">Bayar</button>
                                                                    <button class="btn ms-2 btn-secondary" type="button"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tunaiForm = document.getElementById("tunai-form");
            const transferForm = document.getElementById("transfer-form");
            const tunaiBtn = document.querySelector(".tunai-btn");
            const transferBtn = document.querySelector(".transfer-btn");

            tunaiBtn.addEventListener("click", function() {
                tunaiForm.style.display = "block";
                transferForm.style.display = "none";
            });

            transferBtn.addEventListener("click", function() {
                transferForm.style.display = "block";
                tunaiForm.style.display = "none";
            });
            const deleteButtons = document.querySelectorAll('.hapus-item');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');

                    // Tampilkan konfirmasi SweetAlert
                    Swal.fire({
                        title: "Hapus Data!",
                        text: "Apakah kamu yakin akan menghapus data ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus itu!",
                        cancelButtonText: "Tidak, batalkan"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika konfirmasi "Ya", arahkan ke URL penghapusan
                            window.location.href =
                                url; // <-- URL akan diarahkan setelah konfirmasi
                        }
                    });
                });
            });
        });
    </script>
@endsection
