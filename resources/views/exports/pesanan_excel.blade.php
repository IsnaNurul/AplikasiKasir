<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <table>
        <thead>
            <tr>
                <th>Transaksi Id</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Dibuat</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Sub Total</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- Set variabel grand total sebelum loop -->
            @php
                $grandTotal = 0;
                $subtotal = 0; // variabel untuk menghitung subtotal per pesanan
            @endphp
            @foreach ($pesanan as $key => $item)
                @php
                    $produkCount = count($detail_jual[$item->id_penjualan]);
                @endphp
                @foreach ($detail_jual[$item->id_penjualan] as $index => $detail)
                    @php
                        $subtotal = $item->total_harga;
                    @endphp
                    <tr>
                        @if ($index === 0)
                            <td rowspan="{{ $produkCount }}">{{ $item->kode_transaksi }}</td>
                            <td rowspan="{{ $produkCount }}">
                                {{ $item->tanggal_jual ? \Carbon\Carbon::parse($item->tanggal_jual)->locale('id')->translatedFormat('j F Y') : '-' }}
                            </td>
                            <td rowspan="{{ $produkCount }}" style="width: 15%">
                                {{ $item->tipe_penjualan }}, <br>
                                {{ $item->metode_pembayaran }}
                            </td>
                            <td rowspan="{{ $produkCount }}">{{ $item->pengguna->username }}</td>
                            <td rowspan="{{ $produkCount }}">
                                {{ $item->pelanggan_id ? $item->pelanggan->nama_pelanggan : '-' }}
                            </td>
                            @php
                                $subtotal = $item->total_harga;
                            @endphp
                        @endif
                        <td>{{ $detail->produk ? $detail->produk->nama_produk : 'No Product' }}
                        </td>
                        <td>{{ $detail->jumlah_produk ? $detail->jumlah_produk : '0' }}</td>
                        <td>{{ $detail->jumlah_produk > 0 ? 'Rp. ' . number_format($detail->harga_jual / $detail->jumlah_produk, 0, ',', '.') : '0' }}
                        </td>
                        <td>Rp. {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                        @if ($index === 0)
                            <td rowspan="{{ $produkCount }}">Rp.
                                {{ $item->total_harga ? number_format($item->total_harga, '0', ',', '.') : '-' }}
                            </td>
                        @endif
                        {{-- <td>
                            <a class="btn btn-sm" onclick="window.print();" href="#"><i style="font-size: 20px"
                                class="fa fa-file-excel-o"></i>Print</a>
                        </td> --}}
                    </tr>
                @endforeach
                @php
                    $grandTotal += $subtotal;
                @endphp
                <!-- Sisipkan total dari pesanan ini di bagian paling bawah -->
                @if ($loop->last)
                    <tr>
                        <td colspan="9"><strong>Grand Total</strong></td>
                        <td><strong>Rp. {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

</body>

</html>
