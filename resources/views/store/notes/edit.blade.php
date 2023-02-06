@extends('store.layout.master')
@section('Title', 'Update Note')
@section('subtitle', 'Update Note')
@section('Broser', 'Update Note')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Update Note</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form >
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" value="{{ $note->title }}"
                        placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="info">Info</label>
                    <input type="text" class="form-control" id="info" value="{{ $note->info }}"
                        placeholder="Enter info">
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" @if ($note->done) checked @endif class="custom-control-input" id="done">
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
        function store() {
            axios.put('/store/admin/notes/{{ $note->id }}' ,{
                title :document.getElementById('title').value,
                info : document.getElementById('info').value,
                done :document.getElementById('done').checked,
            })
                .then(function(response) {
                    // handle success
                    console.log(response);
                    toastr.success(response.data.message);
                    window.location.href = "/store/admin/notes";
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
