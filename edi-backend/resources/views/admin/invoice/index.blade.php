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
                            <th class="text-center">Tanggal Pengiriman</th>
                            <th class="text-center">Asal Pengiriman</th>
                            <th class="text-center">Tujuan Pengiriman</th>
                            <th class="text-center">Total Harga</th>
                            <th class="text-center">Status</th>
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
                                <td>{{ !empty($invoice->deliveryOrder) ? $invoice->deliveryOrder->delivery_date : '-' }}</td>
                                <td>{{ !empty($invoice->goodReturnNote) ? $invoice->goodReturnNote->delivery_from : '-' }}</td>
                                <td>{{ !empty($invoice->goodReturnNote) ? $invoice->goodReturnNote->delivery_to : '-' }}</td>
                                <td>{{ $invoice->total_cost ?? '-' }}</td>
                                <td>{{ $invoice->status ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.edi.good-return-note.show', [
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