@extends('store.layout.master')
@section('Broser', 'Permissions')
@section('Title', 'Permissions')
@section('subtitle', 'Permissions')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->
            {{-- @include('user.layout.succes') --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Permissions Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Guard</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            {{-- <td>{{$loop->iteration}}</td> --}}
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td><span
                                                    class="badge @if ($permission->guard_name == 'admin') bg-info @else bg-success @endif">{{ $permission->guard_name }}</span>
                                            </td>
                                            <td>{{ $permission->created_at->format('d - m - Y') }}</td>
                                            <td>{{ $permission->updated_at->format('d - m - Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    @can('Update-Permission')
                                                        <a href="{{ route('permissions.edit', $permission->id) }}"
                                                            class="btn btn-warning btn-sm"><i class=" fas fa-edit"></i></a>
                                                    @endcan
                                                    @can('Delete-Permission')
                                                        {{-- @if (auth('user')->user()->id != $user->id) --}}
                                                        <a href="#" onclick="confirmDestroy({{ $permission->id }},this)"
                                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                        {{-- @endif --}}
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{$users->links()}} --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection


@section('script')
    <script>
        function confirmDestroy(id, reference) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    destroy(id, reference);
                }
            })
        }

        function destroy(id, reference) {
            axios.delete('/store/admin/permissions/' + id)
                .then(function(response) {
                    // handle success
                    //فئة ال200
                    console.log(response);
                    ShowMessage(response.data);
                    reference.closest('tr').remove();
                })
                .catch(function(error) {
                    // handle error
                    //فئة ال400
                    console.log(error);
                    ShowMessage(error.response.data)
                })
                .then(function() {
                    // always executed
                });

        }

        function ShowMessage(data) {
            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text,
                showConfirmButton: false,
                timer: 1500
            })
        }
    </script>
@endsection
