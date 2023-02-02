@extends('store.layout.master')
@section('Title','Create Roles')
@section('subtitle','Create Roles')
@section('Broser','Create Roles')
@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('BackEnd/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('BackEnd/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')

<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Create Roles</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
   <form id="create-form">
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                        <label>User Type</label>
                        <select class="form-control guards" id="guard_name" style="width: 100%;">
                          <option value="admin">Admin</option>
                          <option value="user">User</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text"  class="form-control" id="name" value="{{old('name')}}" placeholder="Enter Name">
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
            axios.post('/store/admin/roles',{
                name: document.getElementById('name').value,
                guard_name: document.getElementById('guard_name').value
            })
            .then(function (response) {
                // handle success
                console.log(response);
                toastr.success(response.data.message);
                document.getElementById('create-form').reset();
                //الذهاب لصفحة
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
