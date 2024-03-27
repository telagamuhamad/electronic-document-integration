@extends('admin.layouts.admin')

@section('content')

    @if(Session::has('success_message'))
        <div class='callout callout-success mB-20'>
            {{ Session::get('success_message') }}
        </div>
    @endif

    @if(Session::has('error_message'))
        <div class='callout callout-danger mB-20'>
            {{ Session::get('error_message') }}
        </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">
            Pengiriman Barang
        </div>
        <div class="panel-body">
            <a href="{{ route('admin.edi.delivery-order.create') }}" class="btn btn-success" style="margin-bottom: 10px; float: right">Pengiriman Baru</a href="{{ route('admin.edi.delivery-order.create') }}">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nomor Pengiriman</th>
                            <th class="text-center">Tanggal Pengiriman</th>
                            <th class="text-center">Tipe Pengiriman</th>
                            <th class="text-center">Status Pengiriman</th>
                            <th class="text-center">Kurir</th>
                            <th class="text-center">Aksi</th>
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
                                    {{ !empty($deliveryOrder->courier) ? $deliveryOrder->courier->name1 : '-' }} - 
                                    {{ !empty($deliveryOrder->courier) ? $deliveryOrder->courier->name2 : '-' }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.edi.delivery-oder.show', [
                                        'id' => $deliveryOrder->id
                                    ]) }}" class="btn btn-primary btn-sm">Detail</a>
                                    <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav class='mT-20'>
                {!! $deliveryOrders->appends($_GET)->links() !!}
            </nav>
        </div>
    </div>
@stop