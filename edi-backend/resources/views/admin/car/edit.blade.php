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
            Tambah Data Mobil
        </div>
        <form action="{{ route('admin.edi.car.update', [
            'id' => $car->id
        ]) }}" method="POST" enctype="multipart/form-data" id="car-form">
            @csrf
            @method('PUT')
            <div class="panel-body">
                <div class="form-group">
                    <label for="">Nomor Polisi <sup style="color: red">*</sup></label>
                    <input type="text" name="license_plate" id="license_plate" class="form-control" value="{{ $car->license_plate }}">
                    @error('license_plate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="driver_name_1">Nama Supir 1 <sup style="color: red">*</sup></label>
                    <input type="text" name="driver_name_1" id="driver_name_1" class="form-control" value="{{ $car->driver_name_1 }}">
                    @error('driver_name_1')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="driver_name_2">Nama Supir 2</label>
                    <input type="text" name="driver_name_2" id="driver_name_2" class="form-control" value="{{ $car->driver_name_2 }}">
                    @error('driver_name_2')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </form>
    </div>
@stop