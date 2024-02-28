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
                Kategori Produk</h4>
            </div>
            <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">                                       
                    <svg class="stroke-icon">
                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg></a></li>
                <li class="breadcrumb-item">Apps</li>
                <li class="breadcrumb-item active">Kategori Produk</li>
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
                                        <th> <span class="f-light f-w-600">Nama Kategori</span></th>
                                        <th> <span class="f-light f-w-600">Status</span></th>
                                        <th> <span class="f-light f-w-600">Action</span></th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @foreach ($kategori as $key => $item)
                                        <tr class="product-removes">
                                            <td> 
                                                <p class="f-light">{{ $key+1 }}</p>
                                            </td>
                                            <td> 
                                                <div class="product-names">
                                                <p>{{ $item->nama_kategori }}</p>
                                                </div>
                                            </td>
                                            <td> 
                                                <p class="f-light">
                                                    @php
                                                        $statusDiskon = false;
                                                        foreach ($produk as $diskon) {
                                                            if ($diskon->kategori_produk_id == $item->id_kategori_produk) {
                                                                $statusDiskon = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                            
                                                    @if($statusDiskon == true)
                                                        <span class="badge badge-light-danger">digunakan</span>
                                                    @else
                                                        <span class="badge badge-light-warning">tidak digunakan</span>
                                                    @endif
                                                </p>
                                            </td>
                                            <td> 
                                                <div class="product-action">
                                                    <a href="#" class="me-3 edit-admin" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_kategori_produk }}" data-whatever="@getbootstrap"><i class="fa fa-pencil-square-o" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"></i></a>
                                                    @if($statusDiskon == true)
                                                        <a class="hapus-item disabled" href="#" onclick="return false;"><i class="fa fa-trash-o text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hapus"></i></a>
                                                    @else
                                                        <a class="hapus-item" href="/kategori-produk/hapus/{{ $item->id_kategori_produk }}"><i class="fa fa-trash-o text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hapus"></i></a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Modal Edit --}}
                                        <div class="modal fade" id="modalEdit{{ $item->id_kategori_produk }}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true" style="top: 0;">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                                        <div class="modal-body p-4">
                                                            <form action="/kategori-produk/edit/{{ $item->id_kategori_produk }}" method="post" class="row g-3 needs-validation" novalidate>
                                                                @csrf
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label" for="validationCustom01">Nama Kategori</label>
                                                                    <input class="form-control" id="validationCustom01" type="text" name="nama_kategori" placeholder="Masukan nama kategori" value="{{ $item->nama_kategori }}" required="">
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
    <div class="modal fade" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Plugins JS Ends-->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.hapus-item');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    const disabled = this.classList.contains('disabled');

                    console.log(url, disabled);

                    if (disabled) {
                        // Tampilkan pesan bahwa diskon sedang digunakan
                        Swal.fire({
                            title: "Kategori Produk digunakan",
                            text: "Tidak dapat menghapus kategori produk ini",
                            icon: "warning",
                        });
                    } else {
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
                    }
                });
            });
        });
    </script>
@endsection