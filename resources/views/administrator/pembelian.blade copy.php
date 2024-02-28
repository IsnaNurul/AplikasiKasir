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
                Pembelian Produk</h4>
            </div>
            <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">                                       
                    <svg class="stroke-icon">
                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg></a></li>
                <li class="breadcrumb-item">Apps</li>
                <li class="breadcrumb-item active">Pembelian Produk</li>
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
                                    <th> <span class="f-light f-w-600">No</span></th>
                                    <th> <span class="f-light f-w-600">Id Pembelian</span></th>
                                    <th> <span class="f-light f-w-600">Produk</span></th>
                                    <th> <span class="f-light f-w-600">Harga Produk</span></th>
                                    <th> <span class="f-light f-w-600">Jumlah Beli</span></th>
                                    <th> <span class="f-light f-w-600">Admin</span></th>
                                    <th> <span class="f-light f-w-600">Tanggal Pembelian</span></th>
                                    <th> <span class="f-light f-w-600">Action</span></th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach ($detail_beli as $key => $item)
                                    <tr class="product-removes">
                                        <td> 
                                            <p class="f-light">{{ $key+1 }}</p>
                                        </td>
                                        <td> 
                                            <div class="product-names">
                                            <p class="f-light">{{ $item->pembelian_id ? $item->pembelian_id : '-' }}</p>
                                            </div>
                                        </td>
                                        <td> 
                                            <div class="product-names">
                                            <p class="f-light">{{ $item->produk ? $item->produk->nama_produk : '-' }}</p>
                                            </div>
                                        </td>
                                        <td> 
                                            <p class="f-light">{{ $item->harga ? 'Rp.' . number_format($item->harga) : '-' }}</p>
                                        </td>
                                        <td> 
                                            <p class="f-light">{{ $item->jumlah_beli ? $item->jumlah_beli : '-' }}</p>
                                        </td>
                                        <td> 
                                            <p class="f-light">{{ $item->pembelian ? $item->pembelian->pengguna->username : '-' }}</p>
                                        </td>
                                        <td> 
                                            <p class="f-light"> {{ \Carbon\Carbon::parse($item->pembelian->tanggal_beli)->locale('id')->translatedFormat('j F Y') }}</p>
                                        </td>
                                        
                                        <td> 
                                            <div class="product-action">
                                                <a href="#" class="me-3 edit-admin" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_diskon_produk }}" data-whatever="@getbootstrap"><i class="fa fa-pencil-square-o" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"></i></a>
                                                <a class="hapus-item" href="/pembelian/hapus/{{ $item->pembelian_id }}/{{ $item->id_detail_beli }}"><i class="fa fa-trash-o text-danger"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hapus"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Modal Edit --}}
                                    {{-- <div class="modal fade" id="modalEdit{{ $item->id_diskon_produk }}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                                    <h3 class="modal-header justify-content-center border-0">Mengubah Diskon Produk</h3>
                                                    <div class="modal-body p-4">
                                                        <form action="/diskon-produk/edit/{{ $item->id_diskon_produk }}" method="post" class="row g-3 needs-validation" novalidate>
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label" for="validationCustom01">Nama Diskon</label>
                                                                    <input class="form-control" id="validationCustom01" type="text" name="nama_diskon" value="{{ $item->nama_diskon }}" placeholder="Masukan nama diskon" required="">
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label" for="validationCustom03">Nilai Diskon</label>
                                                                    <input class="form-control" id="validationCustom03" type="number" name="nilai" value="{{ $item->nilai }}" placeholder="Masukan nilai diskon" required="">
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label" for="validationCustom04">Jenis Diskon</label>
                                                                    <select class="form-select" name="jenis_diskon" id="">
                                                                        <option value="">Pilih Jenis Diskon</option>
                                                                        <option value="persentase" {{ $item->jenis_diskon == "persentase" ? 'selected' : '' }}>Persentase</option>
                                                                        <option value="nominal" {{ $item->jenis_diskon == "nominal" ? 'selected' : '' }}>Nominal</option>
                                                                    </select>
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label" for="validationCustom03">Tanggal Mulai</label>
                                                                    <input class="form-control" id="validationCustom03" type="date" name="berlaku_mulai" value="{{ $item->berlaku_mulai }}" placeholder="" required="">
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label" for="validationCustom03">Tanggal Selesai</label>
                                                                    <input class="form-control" id="validationCustom03" type="date" name="berlaku_selesai" value="{{ $item->berlaku_selesai }}" placeholder="" required="">
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label" for="validationCustom05">Deskripsi</label>
                                                                    <textarea name="deskripsi" id="validationCustom06"  class="form-control" cols="30" rows="2" required="" placeholder="Masukan deskirpsi diskon">{{ $item->deskripsi }}</textarea>
                                                                    <div class="valid-feedback">Looks good!</div>
                                                                </div>  
                                                                <div class="col-md-12 justify-content-end"> 
                                                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
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
    <div class="modal fade" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Pembelian Produk</h3>
                    <div class="modal-body p-4">
                        <form action="/pembelian/add" method="post" class="row g-3 needs-validation" novalidate>
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom03">Tanggal Pembelian</label>
                                <input class="form-control" id="validationCustom03" type="date" name="tanggal_beli" placeholder="Masukan harga produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom04">Produk</label>
                                <select class="form-select" name="produk_kode" id="" required="">
                                    <option value="">Pilih Produk</option>
                                    @foreach ($produk as $item)
                                        <option value="{{ $item->kode_produk }}">{{ $item->kode_produk . ' - ' . $item->nama_produk }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label" for="validationCustom01">Harga Produk</label>
                                <input class="form-control" id="validationCustom01" type="number" name="harga" placeholder="Masukan harga produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="validationCustom02">Jumlah</label>
                                <input class="form-control" id="validationCustom02" type="text" name="jumlah_beli"  placeholder="Masukan nama produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="category-buton col-md-6"><a href="#!" data-bs-toggle="modal" data-bs-target="#modalKategori"><i class="me-2 fa fa-plus"> </i>Tambah Produk </a></div>
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
                            window.location.href = url; // <-- URL akan diarahkan setelah konfirmasi
                        }
                    });
                });
            });
        });
    </script>
    
    
@endsection