<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan</title>
    <style>
        /* Style CSS untuk surat jalan */
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
        .footer {
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Surat Jalan</h2>
        </div>
        <div class="invoice-details">
            <img src="{{ url('images/logo.png') }}" alt="Logo Perusahaan">
            <p><strong>Nomor Surat Jalan:</strong> {{ $travel_document->travel_document_number }}</p>
            <p><strong>Tanggal:</strong> {{ $date_now }}</p>
            <p><strong>Mobil:</strong> {{ !empty($travel_document->car) ? $travel_document->car->license_plate : '-' }} </p>
            <!-- Ganti "path_to_logo/logo.png" dengan path file logo perusahaan Anda -->
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor DO</th>
                    <th>Barang</th>
                    <th>Berat (Kg)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rowSpanCounter = [];
                @endphp
                @foreach($travel_document->deliveryOrders as $index => $do)
                    @php
                        $totalItems = 0;
                        foreach ($do->items as $item) {
                            $totalItems += 1;
                        }
                    @endphp
                    @foreach($do->items as $itemIndex => $item)
                        <tr>
                            @if($itemIndex === 0)
                                <td rowspan="{{ $totalItems }}">{{ $index + 1 }}</td>
                                <td rowspan="{{ $totalItems }}">{{ $do->delivery_order_number }}</td>
                            @endif
                            <td>{{ $item->item_code }} ({{ $item->description }})</td>
                            <td>{{ number_format($item->item_weight, 0) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>


<script>
    window.print();
</script>
