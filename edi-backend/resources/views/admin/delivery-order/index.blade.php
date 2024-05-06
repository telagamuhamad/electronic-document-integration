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
                            <th class="text-center">Status Pengiriman</th>
                            <th class="text-center">Mobil</th>
                            <th class="text-center">Kurir</th>
                            <th class="text-center">Surat Jalan</th>
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
                                <td>{{ $deliveryOrder->status ?? '-' }}</td>
                                <td>{{ !empty($deliveryOrder->car) ? $deliveryOrder->car->license_plate : '-' }}</td>
                                <td>{{ !empty($deliveryOrder->car) ? $deliveryOrder->car->driver_name_1 : '-' }} | {{ !empty($deliveryOrder->car) ? $deliveryOrder->car->driver_name_2 : '-' }}</td>
                                <td>{{ !empty($deliveryOrder->travelDocument) ? $deliveryOrder->travelDocument->travel_document_number : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.edi.delivery-order.show', [
                                        'id' => $deliveryOrder->id
                                    ]) }}" class="btn btn-primary btn-sm">Detail</a>
                                    @if (!$deliveryOrder->is_converted)
                                        <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $deliveryOrder->id }})">Hapus</a>
                                        <form id="delete-form-{{ $deliveryOrder->id }}" action="{{ route('admin.edi.delivery-order.destroy', ['id' => $deliveryOrder->id]) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
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

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function confirmDelete(deliveryOrderId) {
            if (confirm('Apakah Anda yakin ingin menghapus pengiriman ini?')) {
                document.getElementById('delete-form-' + deliveryOrderId).submit();
            }
        }
    </script>
    
@stop