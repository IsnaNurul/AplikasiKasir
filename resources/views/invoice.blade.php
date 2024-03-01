<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from admin.pixelstrap.com/cuba/template/invoice-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 13 Feb 2024 08:04:34 GMT -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="../assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    <title>Cuba - Premium Admin Template</title>
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/themify.css">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <style type="text/css" media="print">
        .print-hidden {
            display: none;
        }
    </style>

    <style type="text/css">
        body {
            font-family: Rubik, sans-serif;
            display: block;
            color: #000248;
        }

        .table-wrapper {
            width: 1160px;
            margin: 0 auto;
        }

        h2 {
            margin: 0;
            font-weight: 500;
            font-size: 40px;
        }

        h6 {
            font-size: 18px;
            font-weight: 400;
            line-height: 1.5;
            margin: 0;
        }

        span {
            font-size: 18px;
            line-height: 1.5;
            font-weight: 400;
        }

        .banner-image {
            margin: 13px 0 10px;
        }

        .order-details td span {
            margin-bottom: -4px;
            display: block;
        }

        .order-details th:first-child,
        .order-details td:first-child {
            min-width: 490px;
        }

        .order-details th:nth-child(2),
        .order-details td:nth-child(2) {
            width: 20%;
        }

        @media (max-width: 1199px) {
            .table-wrapper {
                width: 930px;
            }

            .address {
                width: 21% !important;
            }
        }
    </style>
</head>

<body>
    <table class="table-wrapper">
        <tbody>
            <tr>
                <td>
                    <table class="logo-wrappper" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td><img src="../../assets/images/logo/logo.png" alt="logo"><span
                                        style="color: #52526C;opacity: 0.8;display:block;margin-top: 10px;">202-555-0258</span>
                                </td>
                                <td class="address" style="text-align: right; color: #52526C;opacity: 0.8; width: 16%;">
                                    <span>
                                        1982 Harvest Lane New York, NY12210
                                        United State</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td> <img class="banner-image" src="../../assets/images/email-template/invoice-1/1.png"
                        alt="background"></td>
            </tr>
            <tr>
                <td>
                    <table class="bill-content" style="width: 100%;">
                        <tbody>
                            <tr>
                                @php
                                    $totalharga = 0;
                                    $kembali = 0;
                                    $subtotal = $penjualan->total_harga;
                                    $totalharga += $subtotal;
                                    $kembali = $penjualan->jumlah_bayar - $totalharga;
                                @endphp
                                <td style="width: 36%"><span style="color: #52526C;opacity: 0.8;">Pelanggan</span>
                                    <h6 style="width: 46%">{{ $penjualan->pelanggan->nama_pelanggan }} </h6>
                                </td>
                                <td style="width: 21%;"><span style="color: #52526C;opacity: 0.8;">Tanggal
                                        Transaksi</span>
                                    <h6> {{ $penjualan->tanggal_jual? \Carbon\Carbon::parse($penjualan->tanggal_jual)->locale('id')->translatedFormat('j F Y, H:i'): '-' }}</h6>
                                </td>
                                <td><span style="color: #52526C;opacity: 0.8;">Transaksi Id</span>
                                    <h6>#{{ $penjualan['kode_transaksi'] }}</h6>
                                </td>
                                <td style="text-align: right;"><span style="color: #52526C;opacity: 0.8;">Grand
                                        Total</span>
                                    <h2>{{ 'Rp. ' . number_format($totalharga), 0, ',', '.' }}</h2>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="order-details" style="width: 100%;border-collapse: separate;border-spacing: 0 10px;">
                        <thead>
                            <tr
                                style="background: #7366FF;border-radius: 8px;overflow: hidden;box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;">
                                <th
                                    style="padding: 18px 15px;border-top-left-radius: 8px;border-bottom-left-radius: 8px;text-align: left">
                                    <span style="color: #fff;">Produk</span>
                                </th>
                                <th style="padding: 18px 15px;text-align: left"><span style="color: #fff;">Harga
                                        Satuan</span></th>
                                <th style="padding: 18px 15px;text-align: left"><span style="color: #fff;">Qty</span>
                                </th>
                                <th
                                    style="padding: 18px 15px;border-top-right-radius: 8px;border-bottom-right-radius: 8px;text-align: right">
                                    <span style="color: #fff;">Sub Total</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail_jual as $index => $detail)
                                <tr
                                    style="box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;">
                                    <td style="padding: 18px 15px;"><span>#{{ $detail['produk_kode'] }} -
                                            {{ $detail->produk['nama_produk'] }}</span></td>
                                    <td style="padding: 18px 15px;">
                                        <span>{{ 'Rp. ' . number_format($detail->harga_jual / $detail->jumlah_produk, 0, ',', '.') }}</span>
                                    </td>
                                    <td style="padding: 18px 15px;"> <span>{{ $detail['jumlah_produk'] }}</span></td>
                                    <td style="padding: 18px 15px;text-align: right">
                                        <span>{{ 'Rp. ' . number_format($detail['harga_jual'], 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- <tr> 
                  <td> </td>
                  <td> </td>
                  <td style="padding: 5px 0; padding-top: 15px;"> <span style="color: #52526C;">Subtotal</span></td>
                  <td style="padding: 5px 0;text-align: right;padding-top: 15px;"><span>$26,000.00</span></td>
                </tr>
                <tr> 
                  <td> </td>
                  <td> </td>
                  <td style="padding: 5px 0;padding-top: 0;"> <span style="color: #52526C;">Tax(5%)</span></td>
                  <td style="padding: 5px 0;text-align: right;padding-top: 0;"><span>$1,000.00</span></td>
                </tr> --}}
                            <tr>
                                <td> </td>
                                <td> </td>

                                <td style="padding: 10px 0;"> <span style="font-weight: 600;">Grand Total</span></td>
                                <td style="padding: 10px 0;text-align: right"><span
                                        style="font-weight: 600;">{{ 'Rp. ' . number_format($totalharga), 0, ',', '.' }}</span>
                                </td>
                            </tr>
                            @if ($penjualan->metode_pembayaran == 'cash')
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td style="padding: 5px 0;padding-top: 0;"> <span style="color: #52526C;">Bayar
                                            Tunai</span></td>
                                    <td style="padding: 5px 0;text-align: right;padding-top: 0;">
                                        <span>{{ 'Rp. ' . number_format($penjualan->jumlah_bayar), 0, ',', '.' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td style="padding: 5px 0;padding-top: 0;"> <span
                                            style="color: #52526C;">Kembali</span></td>
                                    <td style="padding: 5px 0;text-align: right;padding-top: 0;">
                                        <span>{{ 'Rp. ' . number_format($kembali), 0, ',', '.' }}</span>
                                    </td>
                                </tr>
                            @elseif ($penjualan->metode_pembayaran == 'transfer')
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td style="padding: 5px 0;padding-top: 0;"> <span style="color: #52526C;">Transfer
                                            {{ $penjualan->rekening_tujuan }}</span></td>
                                    <td style="padding: 5px 0;text-align: right;padding-top: 0;">
                                        <span>{{ 'Rp. ' . number_format($penjualan->jumlah_bayar), 0, ',', '.' }}</span>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
        <tr style="width: 100%; display: flex; justify-content: space-between; margin-top: 12px;">
            <td> <img src="../../assets/images/email-template/invoice-1/sign.png" alt="sign"><span
                    style="display:block;background: rgba(82, 82, 108, 0.3);height: 1px;width: 200px;margin-bottom:10px;"></span><span
                    style="color: rgba(82, 82, 108, 0.8);">Authorized Sign</span></td>
            <td> <span style="display: flex; justify-content: end; gap: 15px;"><a class="print-hidden" style="background: rgba(115, 102, 255, 1); color:rgba(255, 255, 255, 1);border-radius: 10px;padding: 18px 27px;font-size: 16px;font-weight: 600;outline: 0;border: 0; text-decoration: none;" href="#!" onclick="window.print();">Print Invoice<i class="icon-arrow-right" style="font-size:13px;font-weight:bold; margin-left: 10px;"></i></a>
              {{-- <a class="print-hidden" style="background: rgba(115, 102, 255, 0.1);color: rgba(115, 102, 255, 1);border-radius: 10px;padding: 18px 27px;font-size: 16px;font-weight: 600;outline: 0;border: 0; text-decoration: none;" href="invoice-1.html" download="">Share<i class="icon-arrow-right" style="font-size:13px;font-weight:bold; margin-left: 10px;"></i></a> --}}
              </span></td>
        </tr>
    </table>
</body>

<!-- Mirrored from admin.pixelstrap.com/cuba/template/invoice-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 13 Feb 2024 08:04:34 GMT -->

</html>
