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
            Manajemen User
        </div>
        <div class="panel-body">
            <a href="{{ route('admin.edi.user-access-management.create') }}" class="btn btn-success" style="float: right; margin-bottom: 10px">Buat User Baru</a>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($users) <= 0)
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data</td>
                            </tr>
                        @endif

                        @foreach ($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $users->firstItem() + $index }}</td>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">{{ $user->role }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.edi.user-access-management.show', [
                                        'id' => $user->id
                                    ]) }}" class="btn btn-primary btn-sm">Detail</a>
                                    <a href="#" class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">Hapus</a>
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.edi.user-access-management.destroy', ['id' => $user->id]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <nav class='mT-20'>
                {!! $users->appends($_GET)->links() !!}
            </nav>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        function deleteUser(userId) {
            if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                event.preventDefault();
                document.getElementById('delete-form-' + userId).submit();
            }
        }
    </script>
@append