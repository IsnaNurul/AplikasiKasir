<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
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
            <th>Nomor</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Pelanggan</th>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga Satuan</th>
            <th>Sub Total</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pesanan as $key => $item)
            @php
                $produkCount = count($detail_jual[$item->id_penjualan]);
            @endphp
            @foreach ($detail_jual[$item->id_penjualan] as $index => $detail)
                <tr>
                    @if ($index === 0)
                        <td rowspan="{{ $produkCount }}">{{ $item->kode_transaksi }}</td>
                        <td rowspan="{{ $produkCount }}">{{ $item->tanggal_jual ? \Carbon\Carbon::parse($item->tanggal_jual)->isoFormat('D MMMM YYYY, HH:mm:ss') : '-' }}</td>
                        <td rowspan="{{ $produkCount }}">{{ $item->tipe_penjualan }}, {{ $item->metode_pembayaran }}, {{ $item->pengguna->username }}</td>
                        <td rowspan="{{ $produkCount }}">{{ $item->pelanggan_id ? $item->pelanggan->nama_pelanggan : '-' }}</td>
                    @endif
                    <td>{{ $detail->produk ? $detail->produk->nama_produk : 'No Product' }}</td>
                    <td>{{ $detail->jumlah_produk ? $detail->jumlah_produk : '0' }}</td>
                    <td>{{ $detail->jumlah_produk > 0 ? 'Rp. ' . number_format($detail->harga_jual / $detail->jumlah_produk, 0, ',', '.') : '0' }}</td>
                    <td>Rp. {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                    @if ($index === 0)
                        <td rowspan="{{ $produkCount }}">Rp. {{ $item->total_harga ? number_format($item->total_harga, '0', ',', '.') : '-' }}</td>
                    @endif
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

</body>
</html>
