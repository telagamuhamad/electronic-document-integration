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
        <div class="panel-body">
            {{-- <div class="form-group">
                <label>Courier 1</label>
                <select name="courier_id_1" id="courier_id_1" class="form-control">
                    <option value="">Select Courier 1</option>
                    @foreach ($couriers as $courier)
                        <option value="{{ $courier->id }}">{{ $courier->name_1 }}</option>
                    @endforeach
                </select>
                @error('courier_id_1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Courier 2</label>
                <select name="courier_id_2" id="courier_id_2" class="form-control">
                    <option value="">Select Courier 2</option>
                    @foreach ($couriers as $courier)
                        <option value="{{ $courier->id }}">{{ $courier->name_2 }}</option>
                    @endforeach
                </select>
                @error('courier_id_2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> --}}
            <div class="form-group">
                <label for="">No. Resi</label>
                <input type="text" name="resi" id="resi" class="form-control" value="{{ $do_number }}" readonly>
            </div>
            <div class="form-group">
                <label for="delivery_type">Jenis Pengiriman</label>
                <select name="delivery_type" id="delivery_type" class="form-control">
                    <option value="">Pilih Jenis Pengiriman</option>
                    <option value="Reguler">Reguler</option>
                    <option value="Express">Express</option>
                </select>
            </div>
            <div class="form-group">
                <label for="delivery_date">Tanggal Pengiriman</label>
                <input type="date" name="delivery_date" id="delivery_date" class="form-control">
                @error('delivery_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
@stop