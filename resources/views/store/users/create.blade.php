@extends('store.layout.master')
@section('Title','Create User')
@section('subtitle','Create User')
@section('Broser','Create User')
@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('BackEnd/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('BackEnd/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')

<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Create User</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
   <form id="create-form">
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                        <label>Roles</label>
                        <select class="form-control roles" id="role_id" style="width: 100%;">
                            @foreach ($roles as $role )
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                      </div>
                    <div class="form-group">
                      <label for="name">User Name</label>
                      <input type="text"  class="form-control" id="name" value="{{old('name')}}" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="email">User Email</label>
                        <input type="text"  class="form-control" id="email" value="{{old('email')}}" placeholder="Enter Email">
                      </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="active">
                          <label class="custom-control-label" for="active">Active</label>
                        </div>
                      </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="button" onclick="store()" class="btn btn-primary">store</button>
                  </div>
                </form>
  </div>


@endsection


@section('script')
<!-- Select2 -->
<script src="{{asset('BackEnd/plugins/select2/js/select2.full.min.js')}}"></script>
      <script>
             $('.guards').select2({
      theme: 'bootstrap4'
    })
          function store(){
            axios.post('/store/admin/users',{
                name : document.getElementById('name').value,
                role_id :document.getElementById('role_id').value,
                email :document.getElementById('email').value,
                active :document.getElementById('active').checked ? 1 : 0,
            })
            .then(function (response) {
                // handle success
                console.log(response);
                toastr.success(response.data.message);
                document.getElementById('create-form').reset();
                //???????????? ??????????
                // window.location.href = "/admin/cities";
            })
            .catch(function (error) {
                // handle error
                console.log(error);
                toastr.error(error.response.data.message);
            })
            .then(function () {
                // always executed
            });
          }
          </script>
@endsection
