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
                pelanggan</h4>
            </div>
            <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">                                       
                    <svg class="stroke-icon">
                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg></a></li>
                <li class="breadcrumb-item">Pengguna</li>
                <li class="breadcrumb-item active">pelanggan</li>
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
                                    <th> <span class="f-light f-w-600">Nama pelanggan</span></th>
                                    <th> <span class="f-light f-w-600">Username</span></th>
                                    <th> <span class="f-light f-w-600">No Telepon</span></th>
                                    <th> <span class="f-light f-w-600">Alamat</span></th>
                                    <th> <span class="f-light f-w-600">Action</span></th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach ($pelanggan as $key => $item)
                                    <tr class="product-removes">
                                        <td> 
                                            <p class="f-light">{{ $key+1 }}</p>
                                        </td>
                                        <td> 
                                            <div class="product-names">
                                            {{-- <div class="light-product-box"><img class="img-fluid" src="../assets/images/dashboard-8/product-categories/laptop.png" alt="laptop"></div> --}}
                                            <p>{{ $item->nama_pelanggan }}</p>
                                            </div>
                                        </td>
                                        <td> 
                                            <p class="f-light">{{ $item->pengguna->username }}</p>
                                        </td>
                                        <td> 
                                            <p class="f-light">{{ $item->no_telepon }}</p>
                                        </td>
                                        <td> 
                                            <p class="f-light">{{ $item->alamat }}</p>
                                        </td>
                                        <td> 
                                            <div class="product-action">
                                                <a href="#" class="me-3 edit-admin" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_pelanggan }}" data-whatever="@getbootstrap"><i class="fa fa-pencil-square-o" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"></i></a>
                                                <a class="delete-item" href="/pengguna/pelanggan/hapus/{{ $item->pengguna_id }}"><i class="fa fa-trash-o text-danger"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hapus"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="modalEdit{{ $item->id_pelanggan }}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                                    <h3 class="modal-header justify-content-center border-0">Mengubah pelanggan</h3>
                                                    <div class="modal-body p-4">
                                                        <form action="/pengguna/pelanggan/edit/{{ $item->pengguna_id }}" method="post" class="row g-3 needs-validation" novalidate="">
                                                            @csrf
                                                            <h6 class="mb-3">Akun</h6>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label" for="validationCustom01">Username</label>
                                                                <input class="form-control" id="validationCustom01" type="text" name="username" placeholder="Masukan username" value="{{ $item->pengguna->username }}" required='true'>
                                                                <div class="valid-feedback">Looks good!</div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label" for="validationCustom02">Password</label>
                                                                <input class="form-control" id="validationCustom02" type="password" name="password"  placeholder="Kosongkan jika tidak akan mengubah password">
                                                                <div class="valid-feedback">Looks good!</div>
                                                            </div>
                                                            <h6 class="mb-2">Data Diri</h6>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label" for="validationCustom03">Nama Lengkap</label>
                                                                <input class="form-control" id="validationCustom03" type="text" name="nama_pelanggan" placeholder="Masukan nama lengkap" value="{{ $item->nama_pelanggan }}" required='true'>
                                                                <div class="valid-feedback">Looks good!</div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label" for="validationCustom04">No Telepon</label>
                                                                <input class="form-control" id="validationCustom03" type="text" name="no_telepon" placeholder="62882xxxxxx" value="{{ $item->no_telepon }}" required='true'>
                                                                <div class="valid-feedback">Looks good!</div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="form-label" for="validationcustom05">Alamat</label>
                                                                <textarea class="form-control" id="" cols="20" rows="3" name="alamat" placeholder="Masukan alamat" required='true'>{{ $item->alamat }}</textarea>
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
                    <h3 class="modal-header justify-content-center border-0">Menambahkan pelanggan</h3>
                    <div class="modal-body p-4 mt-2">
                        <form action="/pengguna/pelanggan/add" method="post" class="row g-3 needs-validation" novalidate>
                            @csrf
                            <h6 class="">Akun</h6>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom01">Username</label>
                                <input class="form-control" id="validationCustom01" type="text" name="username" placeholder="Masukan username" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom02">Password</label>
                                <input class="form-control" id="validationCustom02" type="password" name="password"  placeholder="*******" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <h6 class="">Data Diri</h6>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom03">Nama Lengkap</label>
                                <input class="form-control" id="validationCustom03" type="text" name="nama_pelanggan" placeholder="Masukan nama lengkap" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom04">No Telepon</label>
                                <input class="form-control" id="validationCustom03" type="text" name="no_telepon" placeholder="62882xxxxxx" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label for="form-label" for="validationcustom05">Alamat</label>
                                <textarea class="form-control" id="" cols="20" rows="3" name="alamat" placeholder="Masukan alamat" required=""></textarea>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-item');
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