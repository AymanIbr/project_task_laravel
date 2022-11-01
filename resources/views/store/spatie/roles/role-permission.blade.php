
@extends('store.layout.master')
@section('Title','Role Permissions')
@section('subtitle','Role Permissions')
@section('Broser','Role Permissions')
@section('css')
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{asset('BackEnd/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">{{$role->name}} Permissions </h3>

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
                        <th>Name</th>
                        <th>Guard</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $permission)
                        <tr>
                            <td>{{$permission->name}}</td>
                            <td><span class="badge bg-success ">{{$permission->guard_name}}</span></td>
                            <td>
                                 <div class="icheck-primary d-inline">
                                <input onchange="assignedPermission({{$role->id}},{{$permission->id}})"
                                type="checkbox" id="permission_{{$permission->id}}" @if($permission->assigned)checked @endif >
                                <label for="permission_{{$permission->id}}">
                                </label>
                              </div>
                            </td>
                          </tr>
                        @empty
                        <tr>No data Found</tr>
                        @endforelse
                    </tbody>
                  </table>
                  {{-- {{$cities->links()}} --}}
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
            function assignedPermission(roleId,permissionId){
                axios.post('/store/admin/roles/'+roleId+'/permissions/',{
                    permission_id :permissionId
                })
                .then(function (response) {
                    // handle success
                    //فئة ال200
                    console.log(response);
                    toastr.success(response.data.message);
                })
                .catch(function (error) {
                    // handle error
                    //فئة ال400
                    console.log(error);
                    toastr.error(error.response.data.message);
                })
                .then(function () {
                    // always executed
            });
        }
          </script>
@endsection
