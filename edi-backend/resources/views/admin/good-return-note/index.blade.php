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
            Tanda Terima
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nomor Pengiriman</th>
                            <th class="text-center">Nomor Tanda Terima</th>
                            <th class="text-center">Tanggal Pengiriman</th>
                            <th class="text-center">Asal Pengiriman</th>
                            <th class="text-center">Tujuan Pengiriman</th>
                            <th class="text-center">Total Harga</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($goods_receipt_headers) <= 0)
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif
                        @foreach ($goods_receipt_headers as $index => $gr)
                            <tr>
                                <td>{{ $goods_receipt_headers->firstItem() + $index }}</td>
                                <td>{{ !empty($gr->deliveryOrder) ? $gr->deliveryOrder->delivery_order_number : '-' }}</td>
                                <td>{{ $gr->goods_receipt_number ?? '-'}}</td>
                                <td>{{ $gr->delivery_date ?? '-'}}</td>
                                <td>{{ $gr->sender_name ?? '-' }} - {{ $gr->sender_address ?? '-' }}</td>
                                <td>{{ $gr->receiver_name ?? '-' }} - {{ $gr->receiver_address ?? '-' }}</td>
                                <td>{{ $gr->total_cost ?? '-' }}</td>
                                <td>{{ !empty($gr->deliveryOrder) ? $gr->deliveryOrder->status : '' }}</td>
                                <td>
                                    <a href="{{ route('admin.edi.good-return-note.show', [
                                        'id' => $gr->id
                                    ]) }}" class="btn btn-primary btn-xs">Detail</a>
                                    <a href="#" class="btn btn-danger btn-xs">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav class='mT-20'>
                {!! $goods_receipt_headers->appends($_GET)->links() !!}
            </nav>
        </div>
    </div>
@stop