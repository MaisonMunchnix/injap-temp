<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password | {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ asset('new_landing/images/logs.png') }}" />
    <link rel="stylesheet" href="{{asset('dashboard/vendors/bundle.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/app.min.css')}}" type="text/css">
</head>
<body class="form-membership">
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <div class="form-wrapper">
        <div id="logo">
            <img class="logo img-fluid" src="{{ asset('new_landing/images/logs.png') }}" alt="{{ env('APP_NAME') }}">
        </div>
        <h5>Reset password</h5>
        <form action="" method="post" id="reset_form">
            @csrf
            <h4 class="text-primary mb-4">@yield('title')</h4>
            <div class="form-group">
                <input type="text" class="form-control" id="username" placeholder="Enter Username/Email here" name="username" autocomplete="off" autofocus required>
            </div>
            <div class="row mb-10">
                <!-- <div class="col-md-6">
                    <a href="{{ route('login') }}" class="btn btn-danger btn-md btn-block font-18">{{ __('Cancel') }}</a>
                </div> -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-md btn-block font-18">{{ __('Reset') }}</button>
                </div>
                <br><br><br><br><br><br>
            </div>
        </form>
    </div>
    <script src="{{asset('dashboard/vendors/bundle.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/app.min.js')}}"></script>
    <script>
        var token = "{{csrf_token()}}";
    </script>
<script>
    $('body').on('submit', '#reset_form', function(event) {
        event.preventDefault();
        var formData = new FormData();
        formData.append("username", $('#username').val());
        formData.append('_token', token);
        $.ajax({
            url: "{{ route('forgot-password-submit') }}",
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.preloader').css('display','');
            },
            success: function(data) {
                $('.preloader').css('display','none');

                if (data.message == 'sucess') {
                    swal({
                            title: "Success!",
                            text: "Password Reset Sent",
                            type: "success",
                            showConfirmButton: true
                        }).then(function() {
                            window.location.href = '/';
                        });
                }

            },
            error: function(error) {
                $('.preloader').css('display','none');
                swal({
                    title: 'Error!',
                    text: "Error Msg: " + error.responseJSON.message + "",
                    //timer: 1500,
                    type: "error",
                })
            }
        });
    });
</script>
</body>
</html>
