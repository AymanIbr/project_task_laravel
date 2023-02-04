<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('BackEnd/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('BackEnd/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{ asset('BackEnd/dist/css/adminlte.min.css?v=3.2.0') }}">
</head>

<body class="login-page" style="min-height: 332.781px;">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Store</b>LTE</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                <form >
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" id="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" onclick="performForgotpassword()" class="btn btn-primary btn-block">Request new password</button>
                        </div>
                    </div>
                </form>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p>
            </div>

        </div>
    </div>
    <script src="{{asset('BackEnd/plugins/jquery/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastr -->
    <script src="{{asset('BackEnd/plugins/toastr/toastr.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('BackEnd/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('BackEnd/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{asset('BackEnd/dist/js/adminlte.min.js')}}"></script>
<script>
    function performForgotpassword(){
        axios.post('/store/forgot-password', {
            email: document.getElementById('email').value,
        })
        .then(function (response) {
            console.log(response);
            toastr.success(response.data.message);
            // window.location.href = '/cms/admin'
        })
        .catch(function (error) {
            console.log(error);
            toastr.error(error.response.data.message);
        });
    }
</script>
</body>

</html>
