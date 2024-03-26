@extends('admin.layouts.admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Pengiriman Barang
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Pengiriman</th>
                            <th>Tanggal Pengiriman</th>
                            <th>Tipe Pengiriman</th>
                            <th>Status Pengiriman</th>
                            <th>Kurir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($deliveryOrders) <= 0)
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif
                        @foreach ($deliveryOrders as $index => $deliveryOrder)
                            <tr>
                                <td>{{ $deliveryOrders->firstItem() + $index }}</td>
                                <td>{{ $deliveryOrder->delivery_order_number ?? '-'}}</td>
                                <td>{{ $deliveryOrder->delivery_date ?? '-'}}</td>
                                <td>{{ $deliveryOrder->delivery_type ?? '-' }}</td>
                                <td>{{ $deliveryOrder->status ?? '-' }}</td>
                                <td>
                                    {{ !empty($deliverOrder->courier) ? $deliveryOrder->courier->name1 : '-' }} - 
                                    {{ !empty($deliverOrder->courier) ? $deliveryOrder->courier->name2 : '-' }}
                                </td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm">Detail</a>
                                    <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop