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
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Permintaan Pengiriman</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($travel_document->deliveryOrders) <= 0)
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data</td>
                        </tr>
                    @endif
                    @foreach ($travel_document->deliveryOrders as $index => $order)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $order->delivery_order_number ?? ''}}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.edi.travel-document.show-item', [
                                    'id' => $order->id
                                ]) }}" class="btn btn-primary btn-sm">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('admin.edi.travel-document.print', [
                'id' => $travel_document->id
            ]) }}" class="btn btn-success btn-sm" style="margin-top:10px; float: right" target="_blank">Cetak</a>
        </div>
    </div>
@stop