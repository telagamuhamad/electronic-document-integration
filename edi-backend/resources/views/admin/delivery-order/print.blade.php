<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Detail Pengiriman</title>
    <style>
        /* Style CSS untuk cetak detail pengiriman */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-details img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Detail Pengiriman</h2>
        </div>
        <div class="invoice-details">
            <img src="{{ url('images/logo.png') }}" alt="Logo Perusahaan">
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="2">Data Pengiriman</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nama Pengirim</td>
                                <td>{{ $delivery_order->sender_name ?? ''}}</td>
                            </tr>
                            <tr>
                                <td>Nama Penerima</td>
                                <td>{{ $delivery_order->receiver_name ?? ''}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="6">Data Barang</th>
                            </tr>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kode Barang</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Berat</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Pecah Belah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count ($delivery_order_items) <= 0)
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                </tr>
                            @endif
                            @foreach ($delivery_order_items as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $item->item_code ?? '' }}</td>
                                    <td class="text-center">{{ $item->description ?? '' }}</td>
                                    <td class="text-center">{{ $item->item_weight ?? '' }}</td>
                                    <td class="text-center">{{ $item->item_price ?? '' }}</td>
                                    <td class="text-center">{{ $item->is_fragile ? 'YA' : 'TIDAK' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    window.print();
</script>