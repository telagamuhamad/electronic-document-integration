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
            Detail Tanda Terima
        </div>
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
                            <td>{{ $goods_receipt_header->sender_name }}</td>
                        </tr>
                        <tr>
                            <td>Kontak dan Alamat Pengirim</td>
                            <td>{{ $goods_receipt_header->deliveryOrder->sender_phone_number ?? ''}} | {{ $goods_receipt_header->sender_address }}</td>
                        </tr>
                        <tr>
                            <td>Nama Penerima</td>
                            <td>{{ $goods_receipt_header->receiver_name }}</td>
                        </tr>
                        <tr>
                            <td>Kontak dan Alamat Penerima</td>
                            <td>{{ $goods_receipt_header->deliveryOrder->receiver_phone_number ?? ''}} | {{ $goods_receipt_header->receiver_address }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Permintaan Pengiriman</td>
                            <td>{{ $goods_receipt_header->deliveryOrder->delivery_order_number ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Tanda Terima</td>
                            <td>{{ $goods_receipt_header->goods_receipt_number }}</td>
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
            @if (!$goods_receipt_header->is_invoice_created)
                <a href="{{ route('admin.edi.good-return-note.convert', [
                    'id' => $goods_receipt_header->id
                ]) }}" class="btn btn-success" id="btn-convert" onclick="return confirmConversion()" style="float: right">Buat Invoice</a>
            @endif
        </div>
    </div>
@stop

@section('scripts')
    <script>
        function confirmConversion() {
            return confirm("Apakah Anda yakin ingin membuat invoice?");
        }
    </script>
@stop