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
            Surat Jalan
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nomor Surat Jalan</th>
                            <th class="text-center">Mobil</th>
                            <th class="text-center">Kurir</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($travel_documents) <= 0)
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif
                        @foreach ($travel_documents as $index => $travel_document)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $travel_document->travel_document_number }}</td>
                                <td class="text-center">{{ $travel_document->car->license_plate ?? '' }}</td>
                                <td class="text-center">{{ $travel_document->car->driver_name_1 ?? '' }} - {{ $travel_document->car->driver_name_2 ?? '' }}</td>
                                <td>
                                    <a href="{{ route('admin.edi.travel-document.show', [
                                        'id' => $travel_document->id
                                    ]) }}" class="btn btn-primary btn-sm">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <nav class='mT-20'>
                {!! $travel_documents->appends($_GET)->links() !!}
            </nav>
        </div>
    </div>
@stop