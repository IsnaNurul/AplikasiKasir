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
                        <div>
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i class="fa fa-plus"></i>Tambah</a>
                        </div>
                    </div>
                    <div class="list-product">
                        <table class="table" id="project-status">
                            <thead> 
                                <tr> 
                                    {{-- <th> <span class="f-light f-w-600">No</span></th> --}}
                                    <th> <span class="f-light f-w-600">Kode Transaksi</span></th>
                                    <th> <span class="f-light f-w-600">Admin</span></th>
                                    <th> <span class="f-light f-w-600">Pelanggan</span></th>
                                    <th> <span class="f-light f-w-600">Metode Pembayaran</span></th>
                                    <th> <span class="f-light f-w-600">Tanggal penjualan</span></th>
                                    <th> <span class="f-light f-w-600">Action</span></th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach ($penjualan as $key => $item)
                                    <tr class="product-removes">
                                        {{-- <td> 
                                            <p class="f-light">{{ $key+1 }}</p>
                                        </td> --}}
                                        <td> 
                                            <div class="product-names">
                                            <p class="f-light">{{ $item->kode_transaksi ? $item->kode_transaksi : '-' }}</p>
                                            </div>
                                        </td>
                                        <td> 
                                            <p class="f-light">{{ $item->pengguna ? $item->pengguna->username : '-' }}</p>
                                        </td>
                                        <td> 
                                            <p class="f-light">{{ $item->pelanggan ? $item->pelanggan->nama_pelanggan : '-' }}</p>
                                        </td>
                                        <td> 
                                            <p class="f-light">{{ $item->metode_pembayaran ? $item->metode_pembayaran : '-' }}</p>
                                        </td>
                                        <td> 
                                            <p class="f-light"> {{ \Carbon\Carbon::parse($item->tanggal_beli)->locale('id')->translatedFormat('j F Y') }}</p>
                                        </td>
                                        
                                        <td> 
                                            <div class="product-action">
                                                <a href="#" class="me-3 edit-admin" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_penjualan }}" data-whatever="@getbootstrap"><i class="fa fa-pencil-square-o" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"></i></a>
                                                <a class="hapus-item me-3" href="/penjualan/hapus/{{ $item->id_penjualan }}"><i class="fa fa-trash-o text-danger"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hapus"></i></a>
                                                {{-- <a class="" href="/penjualan/detail/{{ $item->id_penjualan }}"><i class="fa fa-eye text-success"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail penjualan"></i></a> --}}
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="modalEdit{{ $item->id_penjualan }}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                                    <h3 class="modal-header justify-content-center border-0">penjualan Produk</h3>
                                                    <div class="modal-body p-4">
                                                        <form action="/penjualan/add" method="post" class="row g-3 needs-validation" novalidate>
                                                            @csrf
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label" for="validationCustom03">Tanggal penjualan</label>
                                                                <input class="form-control" id="validationCustom03" type="date" name="tanggal_beli" placeholder="Masukan harga produk" required="">
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
    <div class="modal fade modal-md" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Penjualan Produk</h3>
                    <div class="modal-body p-4">
                        <form action="/penjualan/addData" method="post" class="row g-3 needs-validation" novalidate>
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom01">Kode Transaksi</label>
                                <input class="form-control" id="validationCustom01" type="text" name="kode_transaksi" value="{{ $kode_otomatis }}" readonly>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom01">Tanggal</label>
                                <input class="form-control" id="validationCustom01" value="{{ date('Y-m-d') }}" type="date" name="tanggal_jual" placeholder="Masukan harga produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom04">Pelanggan</label>
                                <select class="form-select" name="pelanggan_id" id="" required="">
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach ($pelanggan as $item)
                                        <option value="{{ $item->nama_pelanggan }}">{{ $item->no_telepon . ' - ' . $item->nama_pelanggan }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom04">Produk</label>
                                <select class="form-select" name="produk_kode" id="" required="">
                                    <option value="">Pilih Produk</option>
                                    @foreach ($produk as $item)
                                        <option value="{{ $item->kode_produk }}">{{ $item->kode_produk . ' - ' . $item->nama_produk }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom01">Jumlah Produk</label>
                                <input class="form-control" id="validationCustom01" value="" type="text" name="jumlah_produk" placeholder="" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom04">Metode Pembayaran</label>
                                <select class="form-select" name="metode_pembayaran" id="" required="">
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            {{-- <div class="category-buton col-md-12"><a href="#!" data-bs-toggle="modal" data-bs-target="#modalProduk"><i class="me-2 fa fa-plus"> </i>Produk Baru</a></div> --}}
                            
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

    {{-- Modal Tambah Produk--}}
    <div class="modal fade" id="modalProduk" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Menambahkan Produk</h3>
                    <div class="modal-body p-4">
                        <form action="/produk/add" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom02">Nama Produk</label>
                                <input class="form-control" id="validationCustom02" type="text" name="nama_produk"  placeholder="Masukan nama produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom01">Kode Produk</label>
                                <input class="form-control" id="validationCustom01" type="text" name="kode_produk" placeholder="Masukan kode produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom02">Nama Produk</label>
                                <input class="form-control" id="validationCustom02" type="text" name="nama_produk"  placeholder="Masukan nama produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label" for="validationCustom03">Harga</label>
                                <input class="form-control" id="validationCustom03" type="number" name="harga" placeholder="Masukan harga produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="validationCustom03">Stok</label>
                                <input class="form-control" id="validationCustom03" type="number" name="stok" placeholder="Masukan stok produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom04">Kategori</label>
                                <select class="form-select" name="kategori_produk_id" id="">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori_produk as $item)
                                        <option value="{{ $item->id_kategori_produk }}">{{ $item->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom05">Expired</label>
                                <input class="form-control" id="validationCustom05" type="date" name="tanggal_kadaluarsa" placeholder="" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="category-buton col-md-6"><a href="#!" data-bs-toggle="modal" data-bs-target="#modalKategori"><i class="me-2 fa fa-plus"> </i>kategori baru </a></div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom06">Gambar Produk</label>
                                <input class="form-control" id="validationCustom06" type="file" name="gambar_produk" placeholder="" required="">
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

    {{-- Modal Kategori --}}
    <div class="modal fade" id="modalKategori" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <div class="modal-body p-4">
                        <form action="/kategori-produk/add" method="post" class="row g-3 needs-validation" novalidate>
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom01">Nama Kategori</label>
                                <input class="form-control" id="validationCustom01" type="text" name="nama_kategori" placeholder="Masukan nama kategori" required="">
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
                            window.location.href = url; // <-- URL akan diarahkan setelah konfirmasi
                        }
                    });
                });
            });
        });
    </script>
    
    
@endsection