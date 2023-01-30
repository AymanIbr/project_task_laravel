@extends('store.layout.master')
@section('Title', 'Update User')
@section('subtitle', 'Update User')
@section('Broser', 'Update User')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Update User</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="create-form">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Role Name</label>
                    <select class="form-control roles " id="role_id" style="width: 100%;" data-select2-id="1" tabindex="-1"
                        aria-hidden="true">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if ($role->id == $userRoles->id) selected @endif>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name"
                        value="{{ $user->name }}"
                        placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control gender" id="gender" style="width: 100%;">
                        <option value="M" @if ($user->gender == 'M') selected @endif >Male</option>
                        <option value="F"@if ($user->gender == 'F') selected @endif >Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="city_id">Cities</label>
                    <select class="form-control city" id="city_id" style="width: 100%;">
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @if ($user->city_id == $city->id) selected @endif >{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email"
                        value="{{ $user->email }}"
                        placeholder="Enter Email">
                </div>
                {{-- // لاخفاء الاكتيف لليوزر الي مسجل دخول عند عمل تحديث --}}
                @if ($user->id != auth('admin')->id())
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" {{-- @if ($admin->id == auth('admin')->id()) disabled @endif --}} id="active"
                                @if ($user->active) checked @endif>
                            <label class="custom-control-label" for="active">Active</label>
                        </div>
                    </div>
                @endif
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="button" onclick="update({{ $user->id }},'{{ $redirect ?? true }}')"
                    class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>


@endsection
@section('script')
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
        function update(id, redirect) {
            axios.put('/store/admin/users/' + id, {
                    role_id: document.getElementById('role_id').value,
                    city_id: document.getElementById('city_id').value,
                    gender: document.getElementById('gender').value,
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    active: document.getElementById('active').checked ? 1 : 0,
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    toastr.success(response.data.message);
                    // document.getElementById('create-form').reset();
                    //الذهاب لصفحة
                    if (redirect) {
                        window.location.href = "/store/admin/users";
                    }
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
