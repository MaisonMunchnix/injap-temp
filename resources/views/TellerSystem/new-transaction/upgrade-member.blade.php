@extends('layouts.default.teller.master')
@section('title','Upgrade Account')
@section('page-title','Upgrade Account')

@section('stylesheets')
{{-- additional style here --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .border-red {
        border: 1px solid red !important;
    }

    .first {
        width: 5% !important;
    }

    .others {
        width: 19% !important;
    }

</style>
@endsection

@section('content')
<div class="content-body">
    <!-- start content- -->
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="">
                    <h6 class="element-header">@yield('title')</h6>
                    <br><br>
                    <div class="col-sm-8 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="formValidate" action="" method="post">
                                    @csrf
                                    <div class="element-info">
                                        <div class="element-info-with-icon">
                                            <div class="element-info-icon">
                                                <div class="os-icon os-icon-user"></div>
                                            </div>
                                            <div class="element-info-text">
                                                <h5 class="element-inner-header">Upgrade Account</h5>
                                                <div class="element-inner-desc">Please fill out all information needed.<br /><br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""> Select Username</label>
                                        <select class="form-control select2 select2-dropdown" name="username" id="username" required style="width:100% !important;">
                                            <option value="" disabled selected> Select Username</option>
                                            <!-- @if(!empty($users))
                                            @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->username }}</option>
                                            @endforeach
                                            @endif-->
                                        </select>
                                    </div>
                                    <duv class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Upgrade Code</label>
                                                <input type="text" class="form-control" name="upgrade_code" id="upgrade_code" placeholder="Upgrade Code" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Security PIN</label>
                                                <input type="text" class="form-control" name="security_pin" id="security_pin" placeholder="Security PIN" required>
                                            </div>
                                        </div>
                                    </duv>

                                    <div class="form-buttons-w">
                                        <button class="btn btn-primary" type="submit"> Upgrade Member</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- end content-i -->
@endsection

@section('scripts')
{{-- additional scripts here --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    var token = "{{csrf_token()}}";
    //console.log('TOKEN:' + token);

</script>

<script>
    $(document).ready(function() {
        $('#username').select2({
            minimumInputLength: 0,
            ajax: {
                url: '{{ route("api.users.search") }}',
                dataType: 'json',
            },
        });

        $('body').on('submit', '#formValidate', function(event) {
            event.preventDefault();
            console.log('btn clicked');
            var username = $("#username").val();
            var upgrade_code = $('input[name=upgrade_code').val();
            var security_pin = $('input[name=security_pin').val();

            var formData = {
                'username': username,
                'upgrade_code': upgrade_code,
                'security_pin': security_pin,
                'token': token
            };
            //var action = 'new-transaction/insert';
            var url = "{{route('newtransaction-upgrade-insert')}}";


            if (!username) {
                swal({
                    title: 'Error!',
                    text: "Username is required!",
                    timer: 2000,
                    icon: "error",
                })
                $(".select2-container").css("border", "1px solid red");
            } else if (!upgrade_code) {
                $("#upgrade_code").css("border", "1px solid red");
                swal({
                    title: 'Error!',
                    text: "Upgrade Code is required!",
                    timer: 2000,
                    icon: "error",
                })
            } else if (!security_pin) {
                $("#security_pin").css("border", "1px solid red");
                swal({
                    title: 'Error!',
                    text: "Security PIN is required!",
                    timer: 2000,
                    icon: "error",
                })
            } else {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('.preloader').show();
                    },
                    success: function(response) {
                        var transaction_id = response.transaction_id;
                        console.log(response);
                        $('.preloader').hide();
                        swal({
                            title: 'Success!',
                            text: 'Upragrade Successfully',
                            timer: 1500,
                            icon: "success",
                        });
                        window.location.href = "{{route('newtransaction-upgrade')}}";
                        //window.location.href = '../view-receipt/' + transaction_id;
                    },
                    error: function(error) {
                        console.log('Product submitting error...');
                        console.log(error);
                        console.log(error.responseJSON.message);
                        $('.preloader').hide();
                        swal({
                            title: 'Error!',
                            text: "Error Msg: " + error.responseJSON.message + "",
                            timer: 1500,
                            icon: "error",
                        })

                    }
                });
            }

        });
    });

</script>
@endsection
