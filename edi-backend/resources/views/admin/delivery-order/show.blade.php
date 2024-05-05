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
            Detail Pengiriman
        </div>
        <div class="panel-body">
            @if (!$delivery_order->is_received)
                <a href="{{ route('admin.edi.delivery-order.receive', $delivery_order->id) }}" class="btn btn-success btn-sm" style="margin-bottom:10px; margin-left: 10px; float: right" onclick="return confirmReceive()">Tandai Sudah Diterima</a>
                <form action="{{ route('admin.edi.delivery-order.receive', $delivery_order->id) }}" method="POST" id="receive-form">
                    @csrf
                </form>
            @endif
            <a href="{{ route('admin.edi.delivery-order.print', [
                'id' => $delivery_order->id
            ]) }}" class="btn btn-success btn-sm" style="margin-bottom:10px; float: right" target="_blank">Cetak</a>
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
                            <td>{{ $delivery_order->sender_name }}</td>
                        </tr>
                        <tr>
                            <td>Kontak dan Alamat Pengirim</td>
                            <td>{{ $delivery_order->sender_phone_number }} | {{ $delivery_order->sender_address }}</td>
                        </tr>
                        <tr>
                            <td>Nama Penerima</td>
                            <td>{{ $delivery_order->receiver_name }}</td>
                        </tr>
                        <tr>
                            <td>Kontak dan Alamat Penerima</td>
                            <td>{{ $delivery_order->receiver_phone_number }} | {{ $delivery_order->receiver_address }}</td>
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
                        @if (count ($delivery_order_items) <= 0)
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif
                        @foreach ($delivery_order_items as $index => $item)
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
                @if (!$delivery_order->is_converted)
                    <a href="{{ route('admin.edi.delivery-order.convert', $delivery_order->id) }}" class="btn btn-success" style="float: right" onclick="return confirmConversion()">Konversi Tanda Terima</a>
                @endif
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        function confirmConversion() {
            return confirm("Apakah Anda yakin ingin mengkonversi tanda terima ini?");
        }

        function confirmReceive() {
            event.preventDefault();
            if (confirm('Apakah Anda yakin ingin menerima pengiriman ini?')) {
                document.getElementById('receive-form').submit();
            }
        }
    </script>
@stop