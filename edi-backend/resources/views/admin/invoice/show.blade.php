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
            Detail Invoice
        </div>
        <div class="panel-body">
            <a href="{{ route('admin.edi.invoice.print', [
                'id' => $invoice->id
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
                            <td>{{ !empty($invoice->goodsReceipt) ? $invoice->goodsReceipt->sender_name : ''}}</td>
                        </tr>
                        <tr>
                            <td>Alamat Pengirim</td>
                            <td>{{ !empty($invoice->goodsReceipt) ? $invoice->goodsReceipt->sender_address : '' }}</td>
                        </tr>
                        <tr>
                            <td>Nama Penerima</td>
                            <td>{{ !empty($invoice->goodsReceipt) ? $invoice->goodsReceipt->receiver_name : '' }}</td>
                        </tr>
                        <tr>
                            <td>Alamat Penerima</td>
                            <td>{{ !empty($invoice->goodsReceipt) ? $invoice->goodsReceipt->receiver_address : ''}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Permintaan Pengiriman</td>
                            <td>{{ $invoice->deliveryOrder->delivery_order_number ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Tanda Terima</td>
                            <td>{{ !empty($invoice->goodsReceipt) ? $invoice->goodsReceipt->goods_receipt_number : '' }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Invoice</td>
                            <td>{{ $invoice->invoice_number ?? '' }}</td>
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
                        </tr>
                    </thead>
                    <tbody>
                        @if (count ($invoice_items) <= 0)
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif
                        @foreach ($invoice_items as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $item->item_code ?? '' }}</td>
                                <td class="text-center">{{ $item->description ?? '' }}</td>
                                <td class="text-center">{{ number_format($item->item_weight, 0) ?? '' }} Kg</td>
                                <td class="text-center">{{ $item->item_price ?? '' }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-center">Total</td>
                            <td class="text-center">{{ number_format($invoice->total_cost, 2) ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>
                @if (!$invoice->is_paid)
                    <form action="{{ route('admin.edi.invoice.confirm-payment', [
                            'id' => $invoice->id
                        ])}}" method="POST" id="payment-form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" colspan="2">Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">Status Pembayaran</td>
                                    <td class="text-center">{{ $invoice->formatted_payment_status ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">Total Harus Dibayar</td>
                                    <td class="text-center">{{ number_format($invoice->total_cost, 2) ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">Metode Pembayaran</td>
                                    <td>
                                        <select name="payment_method" id="payment_method" class="form-control">
                                            <option value="">Pilih Metode</option>
                                            <option value="Cash">Tunai</option>
                                            <option value="Transfer">Transfer</option>
                                        </select>
                                        @error('payment_method')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr id="payment_input">
                                    <td class="text-center">Jumlah Pembayaran</td>
                                    <td>
                                        <input type="number" name="payment_amount" id="payment_amount" class="form-control" onchange="calculatePaymentChangeAmount()">
                                        @error('payment_amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr id="payment_change">
                                    <td class="text-center">Kembalian</td>
                                    <td>
                                        <input type="number" name="payment_change_input" id="payment_change_input" class="form-control" readonly>
                                        @error('payment_change_input')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr id="payment_upload">
                                    <td class="text-center">Upload Bukti</td>
                                    <td>
                                        <input type="file" name="payment_image" id="payment_image" accept="image/*" class="form-control">
                                        @error('payment_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right"><button type="submit" class="btn btn-success">Konfirmasi</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                @else
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="2">Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-right">Status Pembayaran</td>
                                <td class="text-center">{{ $invoice->formatted_payment_status ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-right">Total Harus Dibayar</td>
                                <td class="text-center">{{ number_format($invoice->total_cost, 2) ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-right">Metode Pembayaran</td>
                                <td class="text-center">{{ $invoice->formatted_payment_method ?? '' }}</td>
                            </tr>
                            @if (empty($invoice->payment_document))
                                <tr>
                                    <td class="text-right">Jumlah Pembayaran</td>
                                    <td class="text-center">{{ number_format($invoice->paid_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">Kembalian</td>
                                    <td class="text-center">{{ number_format($invoice->payment_change, 2) }}</td>
                                </tr>
                            @endif
                            @if (!empty($invoice->payment_document))
                                <tr>
                                    <td class="text-right">Bukti Pembayaran</td>
                                    <td class="text-center">
                                        {{-- <a href="{{ url('storage/'.$invoice->payment_upload) }}" target="_blank">Lihat Dokumen</a> --}}
                                        <img src="{{ url('storage/'.$invoice->payment_document) }}" alt="">
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        //get value from db
        let totalCost = '{{ $invoice->total_cost }}';
        $(document).ready(function() {
            $('#payment_input, #payment_change, #payment_upload').hide();  
        })
        $('#payment_method').on('change', function() {
            if ($(this).val() == 'Transfer') {
                $('#payment_input').hide();
                $('#payment_change').hide();
                $('#payment_upload').show();
            } else {
                $('#payment_input').show();
                $('#payment_change').show();
                $('#payment_upload').hide();
            }
        });

        function calculatePaymentChangeAmount() {
            let paymentAmount = parseFloat($('#payment_amount').val());
            let paymentChangeAmount = 0;

            if (!isNaN(paymentAmount) && !isNaN(totalCost)) {
                paymentChangeAmount = paymentAmount - totalCost;
                $('#payment_change_input').val(paymentChangeAmount.toFixed(2));
            } else {
                $('#payment_change_input').val(paymentChangeAmount.toFixed(2));
            }
        }
    </script>
@stop