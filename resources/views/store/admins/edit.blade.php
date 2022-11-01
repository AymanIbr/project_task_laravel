@extends('store.layout.master')
@section('Title','Update Admin')
@section('subtitle','Update Admin')
@section('Broser','Update Admin')
@section('css')


@section('content')

<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Update Admin</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form id="create-form">
        @csrf
      <div class="card-body">
        @if (auth('admin')->id() != $admin->id)
        <div class="form-group">
            <label>Role Name</label>
            <select class="form-control roles " id="role_id" style="width: 100%;"
             data-select2-id="1" tabindex="-1" aria-hidden="true">
                @foreach ($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
            </select>
          </div>
          @endif
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text"  class="form-control" id="name" value="@if (old('name')){{old('name')}} @else {{$admin->name}} @endif "  placeholder="Enter Name">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text"  class="form-control" id="email" value="@if (old('email')){{old('email')}} @else {{$admin->email}} @endif "  placeholder="Enter Email">
          </div>
          {{-- // لاخفاء الاكتيف للادمن الي مسجل دخول عند عمل تحديث --}}
          @if($admin->id != auth('admin')->id())
        <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input"
              {{-- @if($admin->id == auth('admin')->id()) disabled @endif --}}
              id="active"
              @if ($admin->active) checked @endif>
              <label class="custom-control-label" for="active">Active</label>
            </div>
          </div>
          @endif
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="button" onclick="update({{$admin->id}},'{{$redirect ?? true }}')" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>


@endsection


@section('script')
      <script>
          function update(id,redirect){
             axios.put('/store/admin/admins/'+id,{
                name:document.getElementById('name').value,
                email:document.getElementById('email').value,
            active:document.getElementById('active').checked ? 1 : 0,
             })
            .then(function (response) {
                // handle success
                console.log(response);
                toastr.success(response.data.message);
                // document.getElementById('create-form').reset();
                //الذهاب لصفحة
                if(redirect){
                    window.location.href = "/store/admin/admins";
                }
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
