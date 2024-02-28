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
                        pengiriman Produk</h4>
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
                            <div>
                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap"
                                    data-whatever="@getbootstrap"><i class="fa fa-plus"></i>Tambah</a>
                            </div>
                        </div>
                        <div class="list-product">
                            <table class="table" id="project-status">
                                <thead>
                                    <tr>
                                        <th> <span class="f-light f-w-600">No</span></th>
                                        <th> <span class="f-light f-w-600">Kode Transaksi Penjualan</span></th>
                                        <th> <span class="f-light f-w-600">Alamat Pengiriman</span></th>
                                        <th> <span class="f-light f-w-600">Biaya Pengiriman</span></th>
                                        <th> <span class="f-light f-w-600">Tanggal pengiriman</span></th>
                                        <th> <span class="f-light f-w-600">Status</span></th>
                                        <th> <span class="f-light f-w-600">Action</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengiriman as $key => $item)
                                        <tr class="product-removes">
                                            <td>
                                                <p class="f-light">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                <p class="f-light">
                                                    {{ $item->penjualan_id ? $item->penjualan->kode_transaksi : '-' }}</p>
                                            </td>
                                            <td>
                                                <p class="f-light">Tasikmalaya</p>
                                            </td>
                                            <td>
                                                <p class="f-light">
                                                    {{ $item->biaya_pengiriman ? 'Rp. ' . number_format($item->biaya_pengiriman) : '-' }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="f-light">
                                                    {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->locale('id')->translatedFormat('j F Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="f-light">
                                                    {{ $item->status_pengiriman ? $item->status_pengiriman : '-' }}</p>
                                            </td>
                                            <td>
                                                <div class="product-action">
                                                    <a href="#" class="me-3 edit-admin" data-bs-toggle="modal"
                                                        data-bs-target="#modalEdit{{ $item->id_pengiriman }}"
                                                        data-whatever="@getbootstrap"><i class="fa fa-pencil-square-o"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Edit"></i></a>
                                                    <a class="hapus-item me-3"
                                                        href="/pengiriman/hapus/{{ $item->id_pengiriman }}"><i
                                                            class="fa fa-trash-o text-danger" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-title="Hapus"></i></a>
                                                    {{-- <a class=""
                                                        href="/pengiriman/detail/{{ $item->id_pengiriman }}"><i
                                                            class="fa fa-eye text-success" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            data-bs-title="Detail pengiriman"></i></a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Modal Edit --}}
                                        <div class="modal fade" id="modalEdit{{ $item->id_pengiriman }}"
                                            data-bs-backdrop="static" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div
                                                        class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                                        <h3 class="modal-header justify-content-center border-0">pengiriman
                                                            Produk</h3>
                                                        <div class="modal-body p-4">
                                                            <form action="/pengiriman/edit/{{ $item->id_pengiriman }}"
                                                                method="post" class="row g-3 needs-validation" novalidate>
                                                                @csrf
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label"
                                                                        for="validationCustom03">Tanggal pengiriman</label>
                                                                    <input class="form-control" id="validationCustom03"
                                                                        type="date"
                                                                        value="{{ $item->tanggal_pengiriman }}"
                                                                        name="tanggal_pengiriman"
                                                                        placeholder="Masukan harga produk" required="">
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label" for="validationCustom04">Kode
                                                                        Transaksi Penjualan</label>
                                                                    <select class="form-select" name="penjualan_id"
                                                                        id="" required="">
                                                                        @foreach ($penjualan as $value)
                                                                            <option value="{{ $value->id_penjualan }}"
                                                                                {{ $value->id_penjualan == $item->penjualan_id ? 'selected' : '' }}>
                                                                                {{ $value->kode_transaksi }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label"
                                                                        for="validationCustom01">Alamat Pengiriman</label>
                                                                    <textarea class="form-control" name="alamat_pengiriman" id="validationCustom01" cols="30" rows="2"
                                                                        required="">{{ $item->alamat_pengiriman }}</textarea>
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label"
                                                                        for="validationCustom02">Biaya Pengiriman</label>
                                                                    <input class="form-control" id="validationCustom02"
                                                                        value="{{ $item->biaya_pengiriman }}"
                                                                        type="number" name="biaya_pengiriman"
                                                                        placeholder="Masukan nama produk" required="">
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                </div>
                                                                <div class="col-md-12 justify-content-end">
                                                                    <button class="btn btn-primary"
                                                                        type="submit">Simpan</button>
                                                                    <button class="btn btn-secondary" type="button"
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

    {{-- Modal Tambah --}}
    <div class="modal fade" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">pengiriman Produk</h3>
                    <div class="modal-body p-4">
                        <form action="/pengiriman/add" method="post" class="row g-3 needs-validation" novalidate>
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom03">Tanggal pengiriman</label>
                                <input class="form-control" id="validationCustom03" type="date"
                                    name="tanggal_pengiriman" placeholder="Masukan harga produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom04">Kode Transaksi Penjualan</label>
                                <select class="form-select" name="penjualan_id" id="" required="">
                                    @foreach ($penjualan as $item)
                                        <option value="{{ $item->id_penjualan }}">
                                            {{ $item->kode_transaksi }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom01">Alamat Pengiriman</label>
                                <textarea class="form-control" name="alamat_pengiriman" id="validationCustom01" cols="30" rows="2"
                                    required=""></textarea>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom02">Biaya Pengiriman</label>
                                <input class="form-control" id="validationCustom02" type="number"
                                    name="biaya_pengiriman" placeholder="Masukan nama produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12 justify-content-end">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal  --}}

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
