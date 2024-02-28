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
                Diskon Produk</h4>
            </div>
            <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">                                       
                    <svg class="stroke-icon">
                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg></a></li>
                <li class="breadcrumb-item">Apps</li>
                <li class="breadcrumb-item active">Diskon Produk</li>
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
                    <div class="list-product table-responsive">
                        <table class="table" id="project-status">
                            <thead> 
                                <tr> 
                                    <th> <span class="f-light f-w-600">No</span></th>
                                    <th> <span class="f-light f-w-600">Nama Diskon</span></th>
                                    <th> <span class="f-light f-w-600">Jenis Diskon</span></th>
                                    <th> <span class="f-light f-w-600">Nilai</span></th>
                                    <th> <span class="f-light f-w-600">Deskripsi</span></th>
                                    <th> <span class="f-light f-w-600">Tanggal Berlaku</span></th>
                                    <th> <span class="f-light f-w-600">Status</span></th>
                                    <th> <span class="f-light f-w-600">Action</span></th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach ($diskon_produk as $key => $item)
                                    <tr class="product-removes">
                                        <td> 
                                            <p class="f-light">{{ $key+1 }}</p>
                                        </td>
                                        <td> 
                                            <div class="product-names">
                                            <p>{{ $item->nama_diskon }}</p>
                                            </div>
                                        </td>
                                        <td> 
                                            <div class="product-names">
                                            <p>{{ $item->jenis_diskon }}</p>
                                            </div>
                                        </td>
                                        <td> 
                                            <span class="badge badge-light-secondary">{{ $item->jenis_diskon=='persentase'? $item->nilai. '%' : 'Rp.'. number_format($item->nilai) }}</span>
                                        </td>
                                        <td> 
                                            <p class="f-light">{{ $item->deskripsi }}</p>
                                        </td>
                                        <td> 
                                            <p class="f-light"> {{ \Carbon\Carbon::parse($item->berlaku_mulai)->locale('id')->translatedFormat('j F Y') }} s.d {{ \Carbon\Carbon::parse($item->berlaku_selesai)->locale('id')->translatedFormat('j F Y') }}</p>
                                        </td>
                                        <td> 
                                            <p class="f-light">
                                                @php
                                                    $statusDiskon = false;
                                                    foreach ($produk as $diskon) {
                                                        if ($diskon->diskon_produk_id == $item->id_diskon_produk) {
                                                            $statusDiskon = true;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                        
                                                @if($statusDiskon == true)
                                                    <span class="badge badge-light-success">digunakan</span>
                                                @else
                                                    <span class="badge badge-light-info">tidak digunakan</span>
                                                @endif
                                            </p>
                                        </td>
                                        <td> 
                                            <div class="product-action">
                                                <a href="#" class="me-3 edit-admin" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_diskon_produk }}" data-whatever="@getbootstrap"><i class="fa fa-pencil-square-o" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"></i></a>
                                                @if($statusDiskon == true)
                                                    <a class="hapus-item disabled" href="#" onclick="return false;"><i class="fa fa-trash-o text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hapus"></i></a>
                                                @else
                                                    <a class="hapus-item" href="/diskon-produk/hapus/{{ $item->id_diskon_produk }}"><i class="fa fa-trash-o text-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hapus"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="modalEdit{{ $item->id_diskon_produk }}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
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
                    <h3 class="modal-header justify-content-center border-0">Diskon produk</h3>
                    <div class="modal-body p-4">
                        <form action="/diskon-produk/add" method="post" class="row g-3 needs-validation" novalidate>
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom01">Nama Diskon</label>
                                <input class="form-control" id="validationCustom01" type="text" name="nama_diskon" placeholder="Masukan nama diskon" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom03">Nilai Diskon</label>
                                <input class="form-control" id="validationCustom03" type="number" name="nilai" placeholder="Masukan nilai diskon" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom04">Jenis Diskon</label>
                                <select class="form-select" name="jenis_diskon" id="">
                                    <option value=""><span>Pilih Jenis Diskon</span></option>
                                    <option value="persentase">Persentase</option>
                                    <option value="nominal">Nominal</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom03">Tanggal Mulai</label>
                                <input class="form-control" id="validationCustom03" type="date" name="berlaku_mulai" placeholder="" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="validationCustom03">Tanggal Selesai</label>
                                <input class="form-control" id="validationCustom03" type="date" name="berlaku_selesai" placeholder="" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom05">Deskripsi</label>
                                <textarea name="deskripsi" id="validationCustom06"  class="form-control" cols="30" rows="2" placeholder="Masukan deskripsi diskon" required=""></textarea>
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
                    const disabled = this.classList.contains('disabled');

                    console.log(url, disabled);

                    if (disabled) {
                        // Tampilkan pesan bahwa diskon sedang digunakan
                        Swal.fire({
                            title: "Diskon digunakan",
                            text: "Tidak dapat menghapus diskon ini",
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