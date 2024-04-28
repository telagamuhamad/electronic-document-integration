<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Detail Invoice</title>
    <style>
        /* Style CSS untuk cetak detail invoice */
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
            <h2>Detail Invoice  #{{ $invoice->invoice_number }}</h2>
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
                                <td>{{ !empty($invoice->goodsReceipt) ? $invoice->goodsReceipt->sender_name : ''}}</td>
                            </tr>
                            <tr>
                                <td>Nama Penerima</td>
                                <td>{{ !empty($invoice->goodsReceipt) ? $invoice->goodsReceipt->receiver_name : '' }}</td>
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
                            </tr>
                        </thead>
                        <tbody>
                            @if (count ($invoice_items) <= 0)
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                </tr>
                            @endif
                            @foreach ($invoice_items as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $item->item_code ?? '' }}</td>
                                    <td class="text-center">{{ $item->description ?? '' }}</td>
                                    <td class="text-center">{{ number_format($item->item_weight, 0) ?? '' }} Kg</td>
                                    <td class="text-center">{{ $item->item_price ?? '' }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-center">Total</td>
                                <td class="text-center">{{ number_format($invoice->total_cost, 2) ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="2">Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-right">Status Pembayaran</td>
                                <td class="text-center">{{ $invoice->formatted_payment_status ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-right">Metode Pembayaran</td>
                                <td class="text-center">{{ $invoice->formatted_payment_method ?? '' }}</td>
                            </tr>
                            @if ($invoice->payment_method === 'Cash')
                                <tr>
                                    <td class="text-right">Uang Dibayar</td>
                                    <td class="text-center">{{ number_format($invoice->paid_amount, 2) ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">Kembalian</td>
                                    <td class="text-center">{{ number_format($invoice->payment_change, 2) ?? '' }}</td>
                                </tr>
                            @endif
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
