@extends('store.layout.master')
@section('Title', 'Update permissions')
@section('subtitle', 'Update permissions')
@section('Broser', 'Update permissions')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Update permissions</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="create-form">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Minimal</label>
                    <select class="form-control guard_name" id="guard_name" style="width: 100%;">
                        <option value="admin" @if ($permission->guard_name == 'admin') selected @endif>Admin</option>
                        <option value="user" @if ($permission->guard_name == 'user') selected @endif>User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" value="{{ $permission->name }}"
                        placeholder="Enter Name">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="button" onclick="update({{ $permission->id }})" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>


@endsection


@section('script')
    <!-- Select2 -->
    <script src="{{ asset('BackEnd/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.guards').select2({
            theme: 'bootstrap4'
        })

        function update(id) {

            axios.put('/store/admin/permissions/' + id, {
                    name: document.getElementById('name').value,
                    guard_name: document.getElementById('guard_name').value,
                })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    toastr.success(response.data.message);
                    window.location.href = "/store/admin/permissions";
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                })
        }
    </script>
@endsection
