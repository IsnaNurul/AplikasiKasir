@extends('component.template')

@if (auth()->user()->level_akses == 'petugas' || auth()->user()->level_akses == 'administrator')
    @section('style')
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .card .me-2 {
                transition: transform 0.3s ease-in-out;
            }

            .card .me-2:hover {
                transform: translateY(-5px);
                /* Misalnya, menggeser elemen ke atas 5px saat dihover */
            }

            .order-total {
                background-color: #f4f4f4;
                border-radius: 8px;
                padding: 10px;
            }

            aside.product-order-list .head {
                background-color: #f4f4f4;
                border-radius: 8px;
                padding: 10px;
            }

            aside.product-order-list .block-section {
                margin: 20px 0;
                padding: 0 0 20px;
                border-bottom: 1px solid #f3f6f9;
            }

            aside.product-order-list .block-section {
                margin: 20px 0;
                padding: 0 0 20px;
                border-bottom: 1px solid #f3f6f9;
            }

            .product-wrap .product-list {
                box-shadow: 0 4px 60px 0 rgba(231, 231, 231, .47);
                margin: 0 0 10px;
                padding: 10px;
            }
        </style>
    @endsection
    @section('content')
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>
                            Penjualan</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index-2.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Apps</li>
                            <li class="breadcrumb-item active"> Penjualan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-md-12 box-col-12">
                    <div class="file-content">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <form class="form-inline" action="/penjualan" method="post">
                                        @csrf
                                        <div class="form-group mb-0 d-flex justify-content-between"> <i
                                                class="fa fa-search"></i>
                                            <input class="form-control-plaintext" name="nama" type="search"
                                                placeholder="Search...">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body file-manager">
                            <h4 class="mb-3">Semua Produk</h4>
                            {{-- <h6>Recently opened files</h6> --}}
                            <ul class="files">
                                <div class="row">
                                    @foreach ($produk as $item)
                                        <div class="card me-2" style="width: 14rem; height:25rem"
                                            data-id="{{ $item->kode_produk }}">
                                            @if ($item->diskon_produk_id)
                                                @if ($item->diskon_produk->jenis_diskon == 'persentase')
                                                    <div class="ribbon ribbon-success ribbon-right me-2">
                                                        {{ $item->diskon_produk->nilai . '%' }}</div>
                                                @else
                                                    <div class="ribbon ribbon-danger ribbon-right me-2">Sale</div>
                                                @endif
                                            @endif
                                            @if ($item->gambar_produk)
                                                <img class="card-img-top" style="height: 200px"
                                                    src="{{ asset('storage/' . $item->gambar_produk) }}" alt="">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title mb-0">{{ $item->nama_produk }}</h5>
                                                <p class="card-text mb-1">{{ $item->kategori_produk->nama_kategori }}
                                                </p>
                                                <div class="row mb-2">
                                                    @if ($item->diskon_produk_id)
                                                        <a href="#" class="harga-produk"
                                                            style="width: 70%;  font-size:15px"><b>{{ 'Rp. ' . number_format($item->harga_diskon) }}</b>
                                                            <br><del class=""
                                                                style="color: darkgray; font-size:10px">{{ 'Rp. ' . number_format($item->harga) }}</del>
                                                        </a>
                                                    @else
                                                        <a href="#" class="harga-produk mb-4"
                                                            style="width: 70%;  font-size:15px"><b>{{ 'Rp. ' . number_format($item->harga) }}</b>
                                                        </a>
                                                    @endif
                                                    <a href="#" class="text-end"
                                                        style="width: 30%; font-size:11px">#{{ $item->stok }}</a>
                                                </div>
                                                <a href="/penjualan/cart/{{ $item->kode_produk }}"
                                                    class="btn btn-primary btn-block w-100">
                                                    <i data-feather="plus-square"></i> Pilih
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-8 pe-0">
                <div class="md-sidebar"><a class="btn btn-primary md-sidebar-toggle" href="javascript:void(0)">file
                        filter</a>
                    <div class="md-sidebar-aside job-left-aside custom-scrollbar">
                        <div class="file-sidebar">
                            <div class="card">
                                <div class="card-body">
                                    <aside class="product-order-list">
                                        <div class=" mb-3 head d-flex align-items-center justify-content-between w-100">
                                            <div class>
                                                <h5>Order List</h5>
                                                <span>Transaction ID : #{{ $kode_otomatis }}</span>
                                            </div>
                                            <div class>
                                                <a class="confirm-text" href="/penjualan/cartAllHapus"><i
                                                        data-feather="trash-2" class="feather-16 text-danger"></i></a>
                                            </div>
                                        </div>
                                        <form id="myForm" method="post">
                                            @csrf
                                            <div class="customer-info block-section">
                                                <h6>Informasi Pelanggan</h6>
                                                <div class="input-block d-flex align-items-center">
                                                    <div class="flex-grow-1 me-2 mt-3">
                                                        <select id="selectPelanggan" name="pelanggan_id"
                                                            class="form-select select select2" required>
                                                            @foreach ($pelanggan as $pelanggans)
                                                                <option value="{{ $pelanggans->id_pelanggan }}">
                                                                    {{ $pelanggans->nama_pelanggan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <a href="#" class="btn btn-primary btn-icon"
                                                        data-bs-toggle="modal" data-bs-target="#modalPelanggan">
                                                        <i data-feather="user-plus" class="feather-16"></i>
                                                    </a>
                                                </div>

                                                <div class="input-block mt-2">
                                                    <div class="flex-grow-1 me-2 mt-2">
                                                        <select name="tipe_penjualan" class="form-select select">
                                                            <option value="dine in">Dine in</option>
                                                            <option value="take away">Take away</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-added block-section">
                                                <div class="head-text d-flex align-items-center justify-content-start">
                                                    <h6 class="d-flex align-items-center mb-2">List Produk
                                                    </h6>
                                                </div>
                                                <div class="product-wrap">
                                                    <div
                                                        class="product-list d-flex align-items-center justify-content-between">
                                                        <table class="table  table-responsive table-borderless">
                                                            @php $total = 0; @endphp
                                                            @php $totalDiskon = 0; @endphp
                                                            @php $diskonFinal = 0; @endphp
                                                            @php $totalFinal = 0; @endphp
                                                            @if (session('carts'))
                                                                @foreach (session('carts') as $kode_produk => $details)
                                                                    @php
                                                                        if ($details['diskon_produk_id'] != null) {
                                                                            $diskon = DB::table('diskon_produks')
                                                                                ->where(
                                                                                    'id_diskon_produk',
                                                                                    $details['diskon_produk_id'],
                                                                                )
                                                                                ->first();
                                                                            if ($diskon->jenis_diskon == 'persentase') {
                                                                                $totalDiskon =
                                                                                    $details['harga'] *
                                                                                    ($diskon->nilai / 100) *
                                                                                    $details['jumlah_produk'];
                                                                            } else {
                                                                                $totalDiskon =
                                                                                    $diskon->nilai *
                                                                                    $details['jumlah_produk'];
                                                                            }

                                                                            $diskonFinal += $totalDiskon;
                                                                            $hargaFinal =
                                                                                $details['harga'] *
                                                                                    $details['jumlah_produk'] -
                                                                                $totalDiskon;
                                                                        }
                                                                    @endphp

                                                                    @php $total += $details['harga'] * $details['jumlah_produk']; @endphp
                                                                    @php $totalFinal = $total - $diskonFinal; @endphp
                                                                    <td class="text-start">
                                                                        {{ $details['nama_produk'] }} x
                                                                        <b>{{ $details['jumlah_produk'] }}</b> <br>
                                                                        @if ($details['keterangan'])
                                                                            {{ $details['keterangan'] }} <br>
                                                                        @endif
                                                                        @if ($details['diskon_produk_id'] != null)
                                                                            Disc. - {{ number_format($totalDiskon) }}
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-end">
                                                                        {{ 'Rp. ' . number_format($details['harga'] * $details['jumlah_produk']) }}
                                                                        <br>
                                                                        @if ($details['keterangan'])
                                                                            <span></span> <br>
                                                                        @endif
                                                                        @if ($details['diskon_produk_id'] != null)
                                                                            {{ 'Rp. ' . number_format($hargaFinal) }}
                                                                        @endif

                                                                    </td>
                                                                    <td class="text-end" style="width: 1%">
                                                                        <a href="#" class="update-product-btn"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#exampleModalgetbootstrap{{ $kode_produk }}">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        @if ($details['keterangan'])
                                                                            <span></span> <br>
                                                                        @endif
                                                                        @if ($details['diskon_produk_id'] != null)
                                                                            <span></span>
                                                                        @endif
                                                                    </td>
                                                                    {{-- <td>{{ $totalDiskon }}</td> --}}
                                                                    <td class="text-end" style="width: 1%">
                                                                        <a href="/penjualan/cartHapus/{{ $kode_produk }}"
                                                                            class="remove-product-btn">
                                                                            <i class="fa fa-trash text-danger"></i>
                                                                        </a>
                                                                        @if ($details['keterangan'])
                                                                            <span></span> <br>
                                                                        @endif
                                                                        @if ($details['diskon_produk_id'] != null)
                                                                            <span></span>
                                                                        @endif
                                                                    </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="block-section">
                                                <div class="order-total">
                                                    <table class="table table-responsive table-borderless">
                                                        <tr>
                                                            <td>Sub Total</td>
                                                            @if (session('carts'))
                                                                <td class="text-end">
                                                                    {{ 'Rp. ' . number_format($total) }}
                                                                </td>
                                                            @else
                                                                <td class="text-end">0</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td class="text-danger">Diskon</td>
                                                            <td class="danger text-danger text-end">
                                                                {{ session('carts') ? '- ' . 'Rp. ' . number_format($diskonFinal) : '0' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>TOTAL</b></td>
                                                            <td class="text-end">
                                                                <b>{{ session('carts') ? 'Rp. ' . number_format($totalFinal) : '0' }}</b>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="btn-row d-sm-flex align-items-center justify-content-between">
                                                <a type="button" id="simpanButton"
                                                    class="btn btn-info btn-icon me-2 flex-fill">
                                                    <span class="me-1 d-flex align-items-center"><i data-feather="pause"
                                                            class="feather-16"></i></span>Simpan
                                                </a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalBayar"
                                                    class="btn btn-success btn-icon ms-2 flex-fill"><span
                                                        class="me-1 d-flex align-items-center"><i
                                                            data-feather="credit-card" class="feather-16"></i></span>Bayar
                                                </a>
                                            </div>

                                            {{-- Modal Bayar --}}
                                            <div class="modal fade modal-md" id="modalBayar" data-bs-backdrop="static"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div
                                                            class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                                            <h3 class="modal-header justify-content-center border-0">
                                                                {{ session('carts') ? 'Rp. ' . number_format($totalFinal) : '0' }}
                                                            </h3>
                                                            <div class="modal-body p-4">
                                                                <h6 class="mb-2">Metode Pembayaran</h6>
                                                                <div
                                                                    class="text-center d-flex justify-content-between mb-2">
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
                                                                                name="jumlah_bayar" id="jumlah-bayar"
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
                                                                    <button id="bayarButton" class="btn btn-primary"
                                                                        type="submit">Bayar</button>
                                                                    <button class="btn ms-2 btn-secondary" type="button"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Tambah --}}
        <div class="modal fade" id="modalPelanggan" data-bs-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                        <h3 class="modal-header justify-content-center border-0">Menambahkan pelanggan</h3>
                        <div class="modal-body p-4">
                            <form action="/pengguna/pelanggan/add" method="post" class="row g-3 needs-validation"
                                novalidate>
                                @csrf
                                <h6 class="">Data Diri</h6>
                                <div class="col-md-12">
                                    <label class="form-label" for="validationCustom03">Nama Lengkap</label>
                                    <input class="form-control" id="validationCustom03" type="text"
                                        name="nama_pelanggan" placeholder="Masukan nama lengkap">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="validationCustom04">No Telepon</label>
                                    <input class="form-control" id="validationCustom03" type="text" name="no_telepon"
                                        placeholder="62882xxxxxx">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-12">
                                    <label for="form-label" for="validationcustom05">Alamat</label>
                                    <textarea class="form-control" id="" cols="20" rows="3" name="alamat"
                                        placeholder="Masukan alamat"></textarea>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-12 justify-content-end">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <button class="btn btn-secondary" type="button"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal  --}}
        @if (session('carts') != null)
            @foreach (session('carts') as $kode_produk => $details)
                <div class="modal fade" id="exampleModalgetbootstrap{{ $kode_produk }}" data-bs-backdrop="static"
                    tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-toggle-wrapper text-start dark-sign-up">
                                <div class="modal-body p-4">
                                    <form action="/penjualan/cartUpdate/{{ $kode_produk }}" method="post"
                                        class="row g-3 needs-validation" novalidate>
                                        @csrf
                                        <div class="col-md-12">
                                            <label class="form-label" for="validationCustom01">Jumlah
                                                Produk</label>
                                            <input class="form-control" id="validationCustom01" type="text"
                                                name="jumlah_produk"
                                                value="{{ $details['jumlah_produk'] ? $details['jumlah_produk'] : '' }}"
                                                placeholder="" required="">
                                            <div class="valid-feedback">
                                                Looks good!</div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="validationCustom01">Keterangan</label>
                                            <textarea class="form-control" name="keterangan" id="" cols="30" rows="2">{{ $details['keterangan'] ? $details['keterangan'] : '' }}</textarea>
                                            <div class="valid-feedback">
                                                Looks good!</div>
                                        </div>
                                        <div class="col-md-12 justify-content-end">
                                            <button class="btn btn-primary" type="submit">Simpan</button>
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
        @endif

        <div class="modal fade" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenter1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-toggle-wrapper text-start dark-sign-up">
                        <div class="modal-body p-4">
                            <form action="/kategori-produk/add" method="post" class="row g-3 needs-validation"
                                novalidate>
                                @csrf
                                <div class="col-md-12">
                                    <label class="form-label" for="validationCustom01">Jumlah Produk</label>
                                    <input class="form-control" id="validationCustom01" type="text"
                                        name="nama_kategori" placeholder="" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="validationCustom01">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" id="" cols="30" rows="2"></textarea>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-12 justify-content-end">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <button class="btn btn-secondary" type="button"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endif



@section('script')
    {{-- <script>
        $(document).ready(function () {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showCancelButton: true,
                    confirmButtonText: 'Cetak Invoice',
                    cancelButtonText: 'Tutup',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var blob = new Blob([new Uint8Array({{ session('pdf') }})], { type: 'application/pdf' });
                        var url = URL.createObjectURL(blob);
                        var a = document.createElement('a');
                        a.href = url;
                        a.download = 'invoice.pdf';
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                    }
                });
            @endif
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        function hitungUangKembali() {
            const jumlahBayarInput = document.getElementById("jumlah-bayar");
            const jumlahBayar = parseFloat(jumlahBayarInput.value);
            const totalFinal = parseFloat("{{ $totalFinal }}");
            const uangKembaliElement = document.getElementById("uang-kembali");

            if (!isNaN(jumlahBayar)) {
                const uangKembali = jumlahBayar - totalFinal;
                // Menghapus angka nol di belakang
                const formattedUangKembali = uangKembali.toFixed(2).replace(/\.?0+$/, "");
                // Jika uang kembali positif, tampilkan nilainya, jika tidak, tampilkan 0
                uangKembaliElement.value = uangKembali > 0 ? formattedUangKembali : 0;
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
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

            document.getElementById("simpanButton").addEventListener("click", function() {
                document.getElementById("myForm").action = "/penjualan/simpan";
                document.getElementById("myForm").submit();
            });

            document.getElementById("bayarButton").addEventListener("click", function() {
                document.getElementById("myForm").action = "/penjualan/add";
                document.getElementById("myForm").submit();
            });
        });
    </script>
    <!-- Plugins JS start-->
    <script src="../assets/js/sidebar-menu.js"></script>
    <script src="../assets/js/sidebar-pin.js"></script>
    <script src="../assets/js/clock.js"></script>
    <script src="../assets/js/slick/slick.min.js"></script>
    <script src="../assets/js/slick/slick.js"></script>
    <script src="../assets/js/header-slick.js"></script>
    <script src="../assets/js/chart/apex-chart/apex-chart.js"></script>
    <script src="../assets/js/chart/apex-chart/stock-prices.js"></script>
    <script src="../assets/js/chart/apex-chart/moment.min.js"></script>
    <script src="../assets/js/notify/bootstrap-notify.min.js"></script>
    <script src="../assets/js/dashboard/default.js"></script>
    <script src="../assets/js/notify/index.js"></script>
    <script src="../assets/js/typeahead/handlebars.js"></script>
    <script src="../assets/js/typeahead/typeahead.bundle.js"></script>
    <script src="../assets/js/typeahead/typeahead.custom.js"></script>
    <script src="../assets/js/typeahead-search/handlebars.js"></script>
    <script src="../assets/js/typeahead-search/typeahead-custom.js"></script>
    <script src="../assets/js/height-equal.js"></script>
    <script src="../assets/js/animation/wow/wow.min.js"></script>
    <!-- Plugins JS Ends-->
@endsection
