@extends('layouts.default.master')
@section('title','Upgrade Account')
@section('page-title','Upgrade Account')

@section('stylesheets')
{{-- additional style here --}}
@endsection

@section('content')
{{-- content here --}}
<div class="content-body">
    <div class="content">
        <div clas="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Upgrade Account</h3>
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="upgrade_code">Product Code</label>
                                        <input class="form-control up-acc-input" id="upgrade_code" placeholder="Enter product code" type="text" autocomplete="off">
                                        <span class="text-danger d-none display-error">Error</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="upgrade_pin">Pin</label>
                                        <input class="form-control up-acc-input" id="upgrade_pin" type="number" autocomplete="off">
                                        <span class="text-danger d-none display-error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none" id="up-error">
                                    <div class="form-group">
                                        <div class="alert alert-danger" role="alert"><strong>Warning! </strong>Please check empty or invalid fields.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary pull-right" id="btn-upgrade">Submit</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- additional scripts here --}}
<script>
    $(document).ready(function() {
        var code_err = 0,
            pin_err = 0;
        var url_upgrade = '';
        var url_check_pin = '';
        var url_check_code = '';
        $('#btn-upgrade').click(function() {
            var pcode = $('#upgrade_code').val();
            var pin = $('#upgrade_pin').val();
            var count_null_fields = 0; // for counting the empty fields
            var fields_require = $('.up-acc-input');
            for (var i = 0; i < fields_require.length; i++) {
                var data = $(fields_require[i]).val();
                if (data == "") {
                    $(fields_require[i]).closest('.form-group').find('.display-error').text('This field is required.');
                    $(fields_require[i]).closest('.form-group').find('.display-error').removeClass('d-none');
                    $(fields_require[i]).addClass("border-red");
                    count_null_fields++;
                    code_err++;
                    pin_err++;
                } else {
                    $(fields_require[i]).removeClass("border-red");
                }
            }
            if (code_err == 0 && pin_err == 0 && count_null_fields == 0) {
                $('#up-error').addClass('d-none');
                var formData = new FormData();
                formData.append("activation_code", pcode);
                formData.append("sec_pin", pin);
                formData.append('_token', token);

                $.ajax({
                    url: 'member-upgrade',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.preloader').css('display', '');
                    },
                    success: function(response) {
                        $('.preloader').css('display', 'none');
                        swal({
                            title: "Success!",
                            text: "Upgrading account success, you may now enjoy more benefits.",
                            type: "success",
                        }).then(function() {
                            location.reload();
                        });

                    },
                    error: function(error) {
                        $('.preloader').css('display', 'none');
                        swal({
                            title: "Error!",
                            text: error.responseJSON.message,
                            type: "error",
                        });
                    }
                });
            } else {
                $('#up-error').removeClass('d-none');
            }
        });
    });

</script>
@endsection
