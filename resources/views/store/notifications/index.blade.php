
@extends('store.layout.master')
@section('Title','notifications')
@section('Subtitle','notifications')
@section('Broser','notifications')

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
                  <h3 class="card-title">Notifications</h3>

                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

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
                        <th>Title</th>
                        <th>Message</th>
                        <th>Created At</th>
                      </tr>
                    </thead>
                    <tbody>
                     @foreach ( $notifications as $notification )
                     <tr>
                        {{-- <td>{{$loop->iteration}}</td> --}}
                        <td>{{$notification->data['title']}}</td>
                        <td>{{$notification->data['message']}}</td>
                        <td>{{$notification->created_at->diffForHumans()}}</td>
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

        function confirmDestroy(id,reference){
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
                    destroy(id,reference);
                }
                })
            }
            function destroy(id,reference){
                axios.delete('/store/admin/users/'+id)
                .then(function (response) {
                    // handle success
                    //فئة ال200
                    console.log(response);
                    ShowMessage(response.data);
                    reference.closest('tr').remove();
                })
                .catch(function (error) {
                    // handle error
                    //فئة ال400
                    console.log(error);
                    ShowMessage(error.response.data)
                })
                .then(function () {
                    // always executed
            });

                                }
            function ShowMessage(data){
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
