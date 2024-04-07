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
            Invoice
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nomor Pengiriman</th>
                            <th class="text-center">Nomor Tanda Terima</th>
                            <th class="text-center">Status Pengiriman</th>
                            <th class="text-center">Total Harga</th>
                            <th class="text-center">Status Pembayaran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($invoices) <= 0)
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif
                        @foreach ($invoices as $index => $invoice)
                            <tr>
                                <td>{{ $invoices->firstItem() + $index }}</td>
                                <td>{{ !empty($invoice->deliveryOrder) ? $invoice->deliveryOrder->delivery_order_number : '-' }}</td>
                                <td>{{ !empty($invoice->goodsReceipt) ? $invoice->goodsReceipt->goods_receipt_number : '-' }}</td>
                                <td>{{ $invoice->formatted_delivery_status ?? '' }}</td>
                                <td>{{ $invoice->total_cost ?? '-' }}</td>
                                <td>{{ $invoice->formatted_payment_status ?? ''}}</td>
                                <td>
                                    <a href="{{ route('admin.edi.invoice.show', [
                                        'id' => $invoice->id
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
                {!! $invoices->appends($_GET)->links() !!}
            </nav>
        </div>
    </div>
@stop