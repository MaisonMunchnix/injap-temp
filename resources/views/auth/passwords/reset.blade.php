<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Password | {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon.ico') }}" />
    <link rel="stylesheet" href="{{asset('dashboard/vendors/bundle.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('dashboard/assets/css/app.min.css')}}" type="text/css">
</head>
<body class="form-membership">
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <div class="form-wrapper">
        <div id="logo">
            <img class="logo img-fluid" src="{{ asset('images/logo.png') }}" alt="image">
        </div>
        <h5>Reset password</h5>
        <form action="" method="post" id="update_form">
                    @csrf
                    <h4 class="text-primary mb-4">@yield('title')</h4>
                    <div class="form-group">
                        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                        <input id="token" type="hidden" class="form-control" name="token" value="{{ $token ?? old('token') }}" required>
                        <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                        <input id="password_confirm" type="password" class="form-control" name="password_confirm" required autocomplete="new-password">
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-md btn-block font-18">{{ __('Reset') }}</button>
                        </div>
                        <!-- <div class="col-12">
                            <a href="{{ route('login') }}" class="btn btn-danger btn-md btn-block font-18">{{ __('Cancel') }}</a>
                        </div> -->
                    </div>
                </form>
    </div>
    <script src="{{asset('dashboard/vendors/bundle.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/app.min.js')}}"></script>
    <script>
        var token = "{{csrf_token()}}";
    </script>
    <script>
    $('body').on('submit', '#update_form', function(event) {
        event.preventDefault();
        var password = $('#password').val();
        var password_confirm = $('#password_confirm').val();

        if (password != password_confirm) {
            swal({
                title: "Error!",
                text: "Password Not Match!",
                type: "error",
                showConfirmButton: true

            });
        } else {
            var formData = new FormData();
            formData.append("email", $('#email').val());
            formData.append("password", password);
            formData.append("password_confirm", password_confirm);
            formData.append("token", $('#token').val());
            formData.append('_token', token);

            $.ajax({
                url: "{{ route('password-update-submit') }}",
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
                                text: "Password Sucessfuly Updated",
                                type: "success",
                                //timer: 2000,
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
        }
    });

</script>
</body>
</html>