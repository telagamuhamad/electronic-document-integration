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
            Pengiriman Baru
        </div>
        <form action="{{ route('admin.edi.delivery-order.store') }}" method="POST" enctype="multipart/form-data" id="delivery-order-form">
            @csrf
            <div class="panel-body">
                <div class="form-group">
                    <label for="">No. Resi <sup style="color: red">*</sup></label>
                    <input type="text" name="resi" id="resi" class="form-control" value="{{ $do_number }}" readonly>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sender_name">Nama Pengirim <sup style="color: red">*</sup></label>
                            <input type="text" name="sender_name" id="sender_name" class="form-control" value="">
                            @error('sender_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="sender_phone">Nomor Telepon Pengirim <sup style="color: red">*</sup"></label>
                            <input type="number" name="sender_phone" id="sender_phone" class="form-control">
                            @error('sender_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="sender_address">Alamat Pengirim <sup style="color: red">*</sup"></label>
                    <textarea name="sender_address" id="sender_address" class="form-control"></textarea>
                    @error('sender_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="receiver_name">Nama Penerima <sup style="color: red">*</sup></label>
                            <input type="text" name="receiver_name" id="receiver_name" class="form-control">
                            @error('receiver_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="receiver_phone">Nomor Telepon Penerima <sup style="color: red">*</sup></label>
                            <input type="number" name="receiver_phone" id="receiver_phone" class="form-control">
                            @error('receiver_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="receiver_address">Alamat Penerima <sup style="color: red">*</sup></label>
                    <textarea name="receiver_address" id="receiver_address" class="form-control"></textarea>
                    @error('receiver_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="add-item-btn" onclick="addItem()">Tambah Item</button>
                </div>
                <div class="form-group">
                    <label for="car_id">Mobil</label>
                    <select name="car_id" id="car_id" class="form-control">
                        <option value="">Pilih Mobil</option>
                        @foreach ($cars as $car)
                            <option value="{{ $car->id }}">{{ $car->license_plate }} - {{ $car->capacity }}</option>
                        @endforeach
                    </select>
                    @error('car_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="total_weight">Total Berat <sup style="color: red">*</sup></label>
                            <input type="text" name="total_weight" id="total_weight" class="form-control" readonly>
                            @error('total_weight')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="total_cost">Total Biaya <sup style="color: red">*</sup"></label>
                            <input type="text" name="total_cost" id="total_cost" class="form-control" readonly>
                            @error('total_cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="payment_method">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" class="form-control">
                        <option value="">Pilih Metode</option>
                        <option value="Cash">Cash</option>
                        <option value="Transfer">Transfer</option>
                    </select>
                    @error('payment_method')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
@stop

@section('scripts')
    <script>
        function addItem() {
            // Generate random item code
            var randomCode = Math.floor(Math.random() * 1000000); // Generate random number
            var itemCode = 'ITM-' + randomCode;
            
            var newItemHtml = `
                <div class="form-group item">
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-12">
                            <label>Kode Item <sup style="color: red">*</sup></label>
                            <input type="text" name="item_code[]" class="form-control" value="${itemCode}" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-6">
                            <label>Berat Barang <sup style="color: red">*</sup></label>
                            <input type="number" name="item_weight[]" class="form-control" onchange="calculateTotalCost()">
                        </div>
                        <div class="col-md-6">
                            <label>Harga <sup style="color: red">*</sup></label>
                            <input type="number" name="item_price[]" class="form-control" onchange="calculateTotalCost()" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-12">
                            <label>Deskripsi</label>
                            <textarea name="description[]" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-12">
                            <input type="checkbox" name="is_fragile[]">
                            <label>Pecah Belah <sup style="color: red">*</sup></label>
                        </div>
                    </div>
                </div>
            `;
            $('#add-item-btn').before(newItemHtml);
        }

        function calculateTotalCost() {
            var total_cost = 0;
            var total_weight = 0;
            var total_item = 0;
            
            $('.item').each(function() {
                var item_weight = parseInt($(this).find('input[name="item_weight[]"]').val());
                total_item++; // Increment total_item for each item
                
                if (!isNaN(item_weight)) {
                    var item_cost = item_weight * 1500;
                    total_cost += item_cost;
                    total_weight += item_weight;
                    $(this).find('input[name="item_price[]"]').val(item_cost);
                }
            });
            
            $('#total_cost').val(total_cost);
            $('#total_weight').val(total_weight);
            $('#total_item').val(total_item);
        }
    </script>
@stop