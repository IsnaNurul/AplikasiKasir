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
                        Produk</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Apps</li>
                        <li class="breadcrumb-item active">Produk</li>
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
                            @if (auth()->user()->level_akses == 'administrator')
                                <div>
                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalgetbootstrap" data-whatever="@getbootstrap"><i
                                            class="fa fa-plus"></i>Tambah</a>
                                </div>
                            @endif
                        </div>
                        <div class="list-product">
                            <table class="table" id="project-status">
                                <thead>
                                    <tr>
                                        <th> <span class="f-light f-w-600">No</span></th>
                                        <th> <span class="f-light f-w-600">Kode produk</span></th>
                                        <th> <span class="f-light f-w-600">Nama produk</span></th>
                                        <th> <span class="f-light f-w-600">Harga</span></th>
                                        <th> <span class="f-light f-w-600">Stok</span></th>
                                        <th> <span class="f-light f-w-600">Kategori</span></th>
                                        <th> <span class="f-light f-w-600">Diskon</span></th>
                                        @if (auth()->user()->level_akses == 'administrator')
                                            <th> <span class="f-light f-w-600">Action</span></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produk as $key => $item)
                                        <tr class="product-removes">
                                            <td>
                                                <p class="f-light">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                <div class="product-names">
                                                    <p>{{ $item->kode_produk }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="product-names">
                                                    <img class="img-fluid" style="width: 80px; height: 80px;"
                                                        src="{{ asset('storage/' . $item->gambar_produk) }}" alt="laptop">
                                                    {{-- <div class="light-product-box"></div> --}}
                                                    <p>{{ $item->nama_produk }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="f-light">{{ 'Rp. ' . number_format($item->harga, '0', ',', '.') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="f-light">{{ $item->stok }}</p>
                                            </td>
                                            {{-- <td>
                                                @php
                                                    $date = date('Y-m-d');
                                                @endphp
                                                <p
                                                    class="f-light {{ $item->tanggal_kadaluarsa > $date ? 'text-dark' : 'text-danger' }}">
                                                    {{ $item->tanggal_kadaluarsa }}</p>
                                            </td> --}}
                                            <td>
                                                <p class="f-light">{{ $item->kategori_produk->nama_kategori }}</p>
                                            </td>
                                            <td>
                                                @if (!empty($item->diskon_produk_id))
                                                    <span class="badge badge-light-success">{{ $item->diskon_produk->jenis_diskon == 'persentase' ? $item->diskon_produk->nilai . '%' : 'Rp. ' . number_format($item->diskon_produk->nilai) }}</span>

                                                    {{-- <button class="btn btn-pill btn-outline-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lihat Diskon">Diskon</button> --}}
                                                @else
                                                    @if (auth()->user()->level_akses == 'petugas')
                                                        <span class="badge badge-light-secondary" data-bs-toggle="modal"
                                                            data-bs-target="#modalEdit{{ $item->kode_produk }}"
                                                            data-whatever="@getbootstrap">Tidak ada diskon</span>
                                                    @elseif (auth()->user()->level_akses == 'administrator')
                                                        <span class="badge badge-light-secondary">Tidak ada diskon</span>
                                                    @endif

                                                    {{-- <button class="btn btn-pill btn-outline-success btn-sm" disabled type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lihat Diskon">Diskon</button> --}}
                                                @endif

                                            </td>
                                            @if (auth()->user()->level_akses == 'administrator')
                                                <td>
                                                    <div class="product-action">
                                                        <a class="hapus-item"
                                                            href="/produk/hapus/{{ $item->kode_produk }}"><i
                                                                class="fa fa-trash-o text-danger" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" data-bs-title="Hapus"></i></a>
                                                        <a href="#" class="me-3 edit-admin" data-bs-toggle="modal"
                                                            data-bs-target="#modalEdit{{ $item->kode_produk }}"
                                                            data-whatever="@getbootstrap"><i class="fa fa-pencil-square-o"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-title="Edit"></i></a>
                                                    </div>
                                                </td>
                                            @elseif (auth()->user()->level_akses == 'petugas')
                                            {{-- <td>
                                                <a class="delete-item2"
                                                    href="/produk/hapusDiskon/{{ $item->kode_produk }}"><i
                                                        class="fa fa-trash-o text-danger" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Hapus"></i></a>
                                                <a class="delete-item2"
                                                    href="/produk/hapusDiskon/{{ $item->kode_produk }}"><i
                                                        class="fa fa-trash-o text-danger" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Hapus"></i></a>

                                            </td> --}}
                                            @endif
                                        </tr>
                                        @if (auth()->user()->level_akses == 'administrator')
                                            {{-- Modal Edit --}}
                                            <div class="modal fade" id="modalEdit{{ $item->kode_produk }}"
                                                data-bs-backdrop="static" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div
                                                            class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                                            <h3 class="modal-header justify-content-center border-0">
                                                                Mengubah Produk</h3>
                                                            <div class="modal-body p-4">
                                                                <form action="/produk/edit/{{ $item->kode_produk }}"
                                                                    enctype="multipart/form-data" method="post"
                                                                    class="row g-3 needs-validation" novalidate>
                                                                    @csrf
                                                                    <div class="row">

                                                                        <div class="col-md-12 mb-3">
                                                                            <label class="form-label"
                                                                                for="validationCustom01">Kode
                                                                                Produk</label>
                                                                            <input class="form-control"
                                                                                id="validationCustom01" type="text"
                                                                                name="kode_produk"
                                                                                placeholder="Masukan kode produk"
                                                                                value="{{ $item->kode_produk }}"
                                                                                required="" readonly>
                                                                            <div class="valid-feedback">Looks good!</div>
                                                                        </div>
                                                                        <div class="col-md-12 mb-3">
                                                                            <label class="form-label"
                                                                                for="validationCustom02">Nama
                                                                                Produk</label>
                                                                            <input class="form-control"
                                                                                id="validationCustom02" type="text"
                                                                                name="nama_produk"
                                                                                value="{{ $item->nama_produk }}"
                                                                                placeholder="Masukan nama produk"
                                                                                required="">
                                                                            <div class="valid-feedback">Looks good!</div>
                                                                        </div>
                                                                        <div class="col-md-12 mb-3">
                                                                            <label class="form-label"
                                                                                for="validationCustom04">Kategori</label>
                                                                            <select class="form-select"
                                                                                name="kategori_produk_id" id="">
                                                                                @foreach ($kategori_produk as $value)
                                                                                    <option
                                                                                        value="{{ $value->id_kategori_produk }}"
                                                                                        {{ $value->id_kategori_produk == $item->kategori_produk_id ? 'selected' : '' }}>
                                                                                        {{ $value->nama_kategori }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="valid-feedback">Looks good!</div>
                                                                            <a href="#!" data-bs-toggle="modal"
                                                                                data-bs-target="#modalKategori"><i
                                                                                    class="me-2 fa fa-plus"> </i>kategori
                                                                                baru </a>
                                                                        </div>
                                                                        <div class="col-md-7 mb-3">
                                                                            <label class="form-label"
                                                                                for="validationCustom03">Harga</label>
                                                                            <input class="form-control"
                                                                                value="{{ $item->harga }}"
                                                                                id="validationCustom03" type="number"
                                                                                name="harga"
                                                                                placeholder="Masukan harga produk"
                                                                                required="">
                                                                            <div class="valid-feedback">Looks good!</div>
                                                                        </div>
                                                                        <div class="col-md-3 mb-3">
                                                                            <label class="form-label"
                                                                                for="validationCustom03">Stok</label>
                                                                            <input class="form-control"
                                                                                value="{{ $item->stok }}"
                                                                                id="validationCustom03" type="number"
                                                                                name="stok" placeholder=""
                                                                                required="">
                                                                            <div class="valid-feedback">Looks good!</div>
                                                                        </div>
                                                                        <div class="col-md-2 mb-3">
                                                                            <div>
                                                                                <label for=""
                                                                                    class="mt-3"></label>
                                                                                <p>Porsi</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 mb-2">
                                                                            <label class="form-label"
                                                                                for="validationCustom06">Gambar
                                                                                Produk</label>
                                                                            <input class="form-control"
                                                                                id="validationCustom06" type="file"
                                                                                name="gambar_produk" placeholder=""
                                                                                value="{{ asset('storage/' . $item->gambar_produk) }}">
                                                                            <div class="valid-feedback">Looks good!</div>
                                                                        </div>
                                                                        @if ($item->gambar_produk)
                                                                            <div class="col-col-md-6 mb-3">
                                                                                <img class="img-fluid"
                                                                                    src="{{ asset('storage/' . $item->gambar_produk) }}"
                                                                                    width="80" alt="">
                                                                            </div>
                                                                        @endif
                                                                        <div class="col-md-12 justify-content-end">
                                                                            <button class="btn btn-primary"
                                                                                type="submit">Simpan</button>
                                                                            <button class="btn btn-secondary"
                                                                                type="button"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{-- Modal Edit --}}
                                            <div class="modal fade" id="modalEdit{{ $item->kode_produk }}"
                                                data-bs-backdrop="static" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div
                                                            class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                                                            <h3 class="modal-header justify-content-center border-0">
                                                                Memasukan Diskon</h3>
                                                            <div class="modal-body p-4">
                                                                <form action="/produk/editDiskon/{{ $item->kode_produk }}"
                                                                    enctype="multipart/form-data" method="post"
                                                                    class="row g-3 needs-validation" novalidate>
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                            <label class="form-label"
                                                                                for="validationCustom04">Diskon
                                                                                Produk</label>
                                                                            <select class="form-select"
                                                                                name="diskon_produk_id" id="">
                                                                                <option value="">Pilih Diskon
                                                                                </option>
                                                                                @foreach ($diskon_produk as $value)
                                                                                    <option
                                                                                        value="{{ $value->id_diskon_produk }}"
                                                                                        {{ $value->id_diskon_produk == $item->diskon_produk_id ? 'selected' : '' }}>
                                                                                        {{ $value->nama_diskon . ' - '. $value->nilai . ' - '. $value->jenis_diskon}}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="valid-feedback">Looks good!</div>
                                                                        </div>
                                                                        <div class="col-md-12 justify-content-end">
                                                                            <button class="btn btn-primary"
                                                                                type="submit">Simpan</button>
                                                                            <button class="btn btn-secondary"
                                                                                type="button"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

    {{-- Modal Tambah --}}
    <div class="modal fade" id="exampleModalgetbootstrap" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <h3 class="modal-header justify-content-center border-0">Menambahkan Produk</h3>
                    <div class="modal-body p-4">
                        <form action="/produk/add" method="post" enctype="multipart/form-data"
                            class="row g-3 needs-validation" novalidate>
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom01">Kode Produk</label>
                                <input class="form-control" id="validationCustom01" value="{{ $kd_produk }}"
                                    type="text" name="kode_produk" placeholder="Masukan kode produk" required=""
                                    readonly>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom02">Nama Produk</label>
                                <input class="form-control" id="validationCustom02" type="text" name="nama_produk"
                                    placeholder="Masukan nama produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom04">Kategori</label>
                                <select class="form-select" name="kategori_produk_id" id="">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori_produk as $item)
                                        <option value="{{ $item->id_kategori_produk }}">{{ $item->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <a href="#!" data-bs-toggle="modal" data-bs-target="#modalKategori"><i
                                        class="me-2 fa fa-plus"> </i>kategori baru </a>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label" for="validationCustom03">Harga</label>
                                <input class="form-control" id="validationCustom03" type="number" name="harga"
                                    placeholder="Masukan harga produk" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="validationCustom03">Stok</label>
                                <input class="form-control" id="validationCustom03" type="number" name="stok"
                                    placeholder="" required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-2">
                                <label for="" class="mt-3"></label>
                                <div>
                                    <p>Porsi</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom06">Gambar Produk</label>
                                <input class="form-control" id="validationCustom06" type="file" name="gambar_produk"
                                    placeholder="" required="">
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
    <div class="modal fade" id="modalKategori" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                    <div class="modal-body p-4">
                        <form action="/kategori-produk/add" method="post" class="row g-3 needs-validation" novalidate>
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom01">Nama Kategori</label>
                                <input class="form-control" id="validationCustom01" type="text" name="nama_kategori"
                                    placeholder="Masukan nama kategori" required="">
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
                            window.location.href =
                                url; // <-- URL akan diarahkan setelah konfirmasi
                        }
                    });
                });
            });
        });
    </script>
@endsection
