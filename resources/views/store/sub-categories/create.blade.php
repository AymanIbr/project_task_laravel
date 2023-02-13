@extends('store.layout.master')
@section('Title', 'Create SubCategory')
@section('subtitle', 'Create SubCategory')
@section('Broser', 'Create SubCategory')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create SubCategory</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="create-form">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control categories" id="category_id" style="width: 100%;">
                        @foreach ($categories as $category )
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                  </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" value="{{ old('name') }}"
                        placeholder="Enter name">
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="active">
                        <label class="custom-control-label" for="active">Active</label>
                    </div>
                </div>
            </div>

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
        $('.categories').select2({
            theme: 'bootstrap4'
        })
        function store() {
            axios.post('/store/admin/sub-categories',{
                name :document.getElementById('name').value,
                category_id :document.getElementById('category_id').value,
                active :document.getElementById('active').checked,
            })
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
