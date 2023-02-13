@extends('store.layout.master')
@section('Title', 'Create Note')
@section('subtitle', 'Create Note')
@section('Broser', 'Create Note')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create Note</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="create-form">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control categories" id="category_id" style="width: 100%;">
                        <option value="-1">Select from below</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>SubCategory</label>
                    <select class="form-control sub_categories" id="sub_category_id" style="width: 100%;">
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" value="{{ old('title') }}"
                        placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="info">Info</label>
                    <input type="text" class="form-control" id="info" value="{{ old('info') }}"
                        placeholder="Enter info">
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="done">
                        <label class="custom-control-label" for="done">Done</label>
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
    <script>
        $('#category_id').on('click',function(){
            console.log('Category Clicked');
        });
        $('#category_id').on('change', function() {
            if (this.value != -1) {
                controlFormStatus(false);
                getSubCategories(this.value);
            } else {
                $('#sub_category_id').empty();
                controlFormStatus(true);
            }
        });

        function controlFormStatus(status) {
            $('#sub_category_id').attr('disabled', status);
            $('#title').attr('disabled', status);
            $('#info').attr('disabled', status);
        }

        //show
        function getSubCategories(categoryId){
            axios.get('/store/admin/categories/'+categoryId)
                .then(function(response) {
                    $('#sub_category_id').empty();
                    if(response.data.subCategories.length > 0){
                        $.each(response.data.subCategories,function(i,item){
                        console.log(item.name);
                        //هنا بنظيفوا على sub category
                        $('#sub_category_id').append(new Option(item.name , item.id))
                    });
                    }else{
                        controlFormStatus(true);
                    }

                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
                .then(function() {
                    // always executed
                });
        }
    </script>

    <!-- Select2 -->
    <script src="{{ asset('BackEnd/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.categories').select2({
            theme: 'bootstrap4'
        })
        $('.sub_categories').select2({
            theme: 'bootstrap4'
        })

        function store() {
            axios.post('/store/admin/notes', {
                    title: document.getElementById('title').value,
                    sub_category_id: document.getElementById('sub_category_id').value,
                    info: document.getElementById('info').value,
                    done: document.getElementById('done').checked,
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
