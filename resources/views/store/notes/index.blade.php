@extends('store.layout.master')
@section('Broser', 'Notes')
@section('Title', 'Notes')
@section('subtitle', 'Notes')

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
                            <h3 class="card-title">Notes</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width:10px">#</th>
                                        <th>Title</th>
                                        <th>Info</th>
                                        <th>SubCategory</th>
                                        <th>Done</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notes as $note)
                                        <tr>
                                            <td>{{ $note->id }}</td>
                                            <td>{{ $note->title }}</td>
                                            <td>{{ $note->info }}</td>
                                            <td>
                                                <span class="badge bg-info ">{{ $note->subCategory->name }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge @if ($note->done) bg-success @else bg-warning @endif">{{ $note->done_status }}</span>
                                            </td>
                                            <td>{{ $note->created_at->format('d - m - Y') }}</td>
                                            <td>{{ $note->updated_at->format('d - m - Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    @can('Update-Note')
                                                        <a href="{{ route('notes.edit', $note->id) }}"
                                                            class="btn btn-warning btn-sm"><i class=" fas fa-edit"></i></a>
                                                    @endcan
                                                    @can('Delete-Note')
                                                        <a href="#" onclick="confirmDestroy({{ $note->id }},this)"
                                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
            axios.delete('/store/admin/notes/' + id)
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
