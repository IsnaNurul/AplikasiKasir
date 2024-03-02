@if (auth()->user()->level_akses == 'administrator')
    <div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
        <div>
            <div class="logo-wrapper"><a href="index.html"><img class="img-fluid for-light"
                        src="../../assets/images/logo/logo.png" alt=""><img class="img-fluid for-dark"
                        src="../../assets/images/logo/logo_dark.png" alt=""></a>
                <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
                </div>
            </div>
            <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid"
                        src="../../assets/images/logo/logo-icon.png" alt=""></a></div>
            <nav class="sidebar-main">
                <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                <div id="sidebar-menu">
                    <ul class="sidebar-links" id="simple-bar">
                        <li class="back-btn"><a href="index.html"><img class="img-fluid"
                                    src="../../assets/images/logo/logo-icon.png" alt=""></a>
                            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                    aria-hidden="true"></i></div>
                        </li>
                        <li class="pin-title sidebar-main-title">
                            <div>
                                <h6>Pinned</h6>
                            </div>
                        </li>
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="{{ url('/dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-home"></use>
                                </svg><span class="">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">Apps</h6>
                            </div>
                        </li>
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                                href="{{ url('#') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg><span>Pengguna</span></a>
                            <ul class="sidebar-submenu">
                                {{-- <li><a href="{{ url('/pengguna/administrator') }}">Administrator</a></li> --}}
                                <li><a href="{{ url('/pengguna/petugas') }}">Petugas</a></li>
                                <li><a href="{{ url('/pengguna/pelanggan') }}">Pelanggan</a></li>
                            </ul>
                        </li>

                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="{{ url('/kategori-produk') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-others"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-others"></use>
                                </svg><span class="lan-50">Kategori Produk</span>
                            </a>
                        </li>
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                                href="{{ url('/diskon-produk') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-landing-page"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-landing-page"></use>
                                </svg><span>Diskon Produk</span></a>
                        </li>
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                                href="{{ url('/produk') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-board"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-board"></use>
                                </svg><span>Produk</span></a>
                        </li>
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="{{ url('/pembelian') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-task"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-task"></use>
                                </svg><span>Pembelian</span>
                            </a>
                        </li>
                        {{-- <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                            href="{{ url('#') }}">
                            <svg class="stroke-icon">
                                <use href="../../assets/svg/icon-sprite.svg#stroke-ecommerce"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="../../assets/svg/icon-sprite.svg#fill-ecommerce"></use>
                            </svg><span>Penjualan</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ url('/pengguna/administrator') }}">Administrator</a></li>
                            <li><a href="{{ url('/penjualan') }}">Point Of Sale</a></li>
                            <li><a href="{{ url('/penjualan/riwayat') }}">Data Penjualan</a></li>
                        </ul>
                    </li> --}}
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="{{ url('/penjualan/riwayat') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-ecommerce"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-ecommerce"></use>
                                </svg><span>Penjualan</span>
                            </a>
                        </li>

                        {{-- <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title link-nav" href="{{ url('/pengiriman') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#new-order"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-file"></use>
                                </svg><span>Pengiriman</span></a></li> --}}
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ url('/laporan-penjualan') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-board"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-board"></use>
                                </svg><span>Laporan Penjualan</span></a>
                        </li>
                        {{-- <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title link-nav" href="{{ url('/pengaturan-aplikasi') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#setting"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#setting"></use>
                                </svg><span>Pengaturan Aplikasi</span></a>
                        </li> --}}
                    </ul>
                </div>
                <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </nav>
        </div>
    </div>
@endif

@if (Auth::user()->level_akses == 'petugas')
    <div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
        <div>
            <div class="logo-wrapper"><a href="index.html"><img class="img-fluid for-light"
                        src="../../assets/images/logo/logo.png" alt=""><img class="img-fluid for-dark"
                        src="../../assets/images/logo/logo_dark.png" alt=""></a>
                <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
                </div>
            </div>
            <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid"
                        src="../../assets/images/logo/logo-icon.png" alt=""></a></div>
            <nav class="sidebar-main">
                <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                <div id="sidebar-menu">
                    <ul class="sidebar-links" id="simple-bar">
                        <li class="back-btn"><a href="index.html"><img class="img-fluid"
                                    src="../../assets/images/logo/logo-icon.png" alt=""></a>
                            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                    aria-hidden="true"></i></div>
                        </li>
                        <li class="pin-title sidebar-main-title">
                            <div>
                                <h6>Pinned</h6>
                            </div>
                        </li>
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="{{ url('/dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-home"></use>
                                </svg><span class="">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="">Apps</h6>
                            </div>
                        </li>
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="{{ url('/penjualan') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-ecommerce"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-ecommerce"></use>
                                </svg><span>Penjualan</span>
                            </a>
                        </li>
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title" href="{{ url('/pesanan') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-to-do"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-to-do"></use>
                                </svg><span>Pesanan</span>
                            </a>
                        </li>
                        {{-- <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title link-nav" href="{{ url('/pengiriman') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#new-order"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-file"></use>
                                </svg><span>Pengiriman</span></a></li> --}}
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title" href="{{ url('/produk') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-board"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-board"></use>
                                </svg><span>Produk</span></a>
                        </li>
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title link-nav" href="{{ url('/laporan-penjualan') }}">
                                <svg class="stroke-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#stroke-board"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../../assets/svg/icon-sprite.svg#fill-board"></use>
                                </svg><span>Laporan Penjualan</span></a>
                        </li>
                    </ul>
                </div>
                <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </nav>
        </div>
    </div>
@endif
