@extends('store.layout.master')
@section('Title', 'Create User')
@section('subtitle', 'Create User')
@section('Broser', 'Create User')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                    <label for="role_id">Roles</label>
                    <select class="form-control roles" id="role_id" style="width: 100%;">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">User Name</label>
                    <input type="text" class="form-control" id="name" value="{{ old('name') }}"
                        placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control gender" id="gender" style="width: 100%;">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">User Image</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="image">
                      <label class="custom-file-label" for="image">Choose image</label>
                    </div>
                  </div>
                <div class="form-group">
                    <label for="city_id">Cities</label>
                    <select class="form-control city" id="city_id" style="width: 100%;">
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">User Email</label>
                    <input type="text" class="form-control" id="email" value="{{ old('email') }}"
                        placeholder="Enter Email">
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
    <script src="{{ asset('BackEnd/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.roles').select2({
            theme: 'bootstrap4'
        })
        $('.city').select2({
            theme: 'bootstrap4'
        })
        $('.gender').select2({
            theme: 'bootstrap4'
        })
        function store() {
            let formData = new FormData();
            formData.append('name',document.getElementById('name').value);
            formData.append('image',document.getElementById('image').files[0]);
            formData.append('role_id',document.getElementById('role_id').value);
            formData.append('city_id',document.getElementById('city_id').value);
            formData.append('gender',document.getElementById('gender').value);
            formData.append('email',document.getElementById('email').value);
            formData.append('active',document.getElementById('active').checked ? 1 : 0);
            axios.post('/store/admin/users',formData)
                .then(function(response) {
                    // handle success
                    console.log(response);
                    toastr.success(response.data.message);
                    document.getElementById('create-form').reset();
                    //الذهاب لصفحة
                    // window.location.href = "/admin/cities";
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                })
                .then(function() {
                    // always executed
                });
        }
    </script>
@endsection
