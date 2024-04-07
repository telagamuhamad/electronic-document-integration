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
            Data Mobil
        </div>
        <div class="panel-body">
            <a href="{{ route('admin.edi.car.create') }}" class="btn btn-success" style="margin-bottom: 10px; float: right">Tambah Mobil</a>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Plat Nomor Kendaraan</th>
                            <th class="text-center">Nama Supir 1</th>
                            <th class="text-center">Nama Supir 2</th>
                            <th class="text-center">Kapasitas (Kg)</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Kode QR</th>
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($cars) <= 0)
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif
                        @foreach ($cars as $index => $car)
                            <tr>
                                <td class="text-center">{{ $cars->firstItem() + $index }}</td>
                                <td class="text-center">{{ $car->license_plate }}</td>
                                <td class="text-center">{{ $car->driver_name_1 }}</td>
                                <td class="text-center">{{ $car->driver_name_2 }}</td>
                                <td class="text-center">{{ number_format($car->capacity, 0) }}</td>
                                <td class="text-center">{{ $car->formatted_capacity_status }} | {{ $car->formatted_departure_status }}</td>
                                <td id="qr-code">{{ $car->qr_code }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.edi.car.edit', [
                                        'id' => $car->id
                                    ]) }}" class="btn btn-primary btn-xs" id="edit-car">Edit</a>
                                    <form method="POST" action="{{ route('admin.edi.car.destroy', $car->id) }}" style="display: inline" id="delete-car-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirmDelete()">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <nav class='mT-20'>
                {!! $cars->appends($_GET)->links() !!}
            </nav>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus mobil ini?");
        }
    </script>
    <script>
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#scanner'),
            },
            decoder: {
                readers: ['ean_reader', 'ean_8_reader', 'code_39_reader', 'code_39_vin_reader', 'codabar_reader', 'upc_reader', 'upc_e_reader', 'i2of5_reader'],
            },
        }, function (err) {
            if (err) {
                console.error('Gagal menginisialisasi pemindai QR code', err);
                return;
            }
            Quagga.start();
        });

        Quagga.onDetected(function (result) {
            var code = result.codeResult.code;
            console.log('Hasil pemindaian QR code:', code);
            
            // // Kirim hasil pemindaian ke server menggunakan Axios
            // axios.post('{{ route("update.car.status") }}', {
            //     _token: '{{ csrf_token() }}', // Ganti dengan token CSRF jika menggunakan Laravel
            //     scanned_data: code, // Kirim hasil pemindaian QR code ke server
            // })
            // .then(function (response) {
            //     console.log('Respons dari server:', response.data);
            //     // Lakukan tindakan lain jika diperlukan setelah berhasil memperbarui status
            // })
            // .catch(function (error) {
            //     console.error('Terjadi kesalahan saat mengirimkan data ke server:', error);
            // });
        });
    </script>
@stop