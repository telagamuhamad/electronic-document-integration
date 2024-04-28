<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Detail Tanda Terima</title>
    <style>
        /* Style CSS untuk cetak detail tanda terima */
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
            <h2>Detail Tanda Terima #{{ $goods_receipt_header->goods_receipt_number }}</h2>
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
                                <th class="text-center" colspan="2">Data Tanda Terima</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nama Pengirim</td>
                                <td>{{ $goods_receipt_header->sender_name ?? ''}}</td>
                            </tr>
                            <tr>
                                <td>Nama Penerima</td>
                                <td>{{ $goods_receipt_header->receiver_name ?? ''}}</td>
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
                            @if (count ($goods_receipt_items) <= 0)
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                </tr>
                            @endif
                            @foreach ($goods_receipt_items as $index => $item)
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