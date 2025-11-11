@extends('layouts.default.admin.master')
@section('title',"Change Sponsor")

@section('stylesheets')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .border-red {
        border: 1px solid red !important;
    }

</style>
@endsection

@section('content')
<div class="content-body">
    <!-- start content- -->
    <div class="content">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">@yield('title')</h6>
                <form method="POST" action="" class="change-form" id="change-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label for="user_id">Username to change Sponsor</label>
                                <select class="username" name="username[]" id="username" multiple="multiple" required>
                                    <option value="">Select Username</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label for="new_username">New Sponsor</label>
                                <select class="username" name="new_sponsor" id="new_sponsor" required>
                                    <option value="">Select Username</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary float-right" id="change-btn">Change Sponsor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end content-i -->
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.username').select2({
            minimumInputLength: 2, // only start searching when the user has input 3 or more characters
            ajax: {
                url: "{{ route('select-members') }}",
                processResults: function(data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data.results
                    };
                }
            }
        });

        $('body').on('submit', '#change-form', function(e) {
            e.preventDefault();
            $('.sweetalert .text-muted').remove();
            var form_data = new FormData(this);

            form_data.append('_token', token);
            $.ajax({
                url: "{{ route('change-sponsor-id') }}",
                type: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#preloader').show();
                },
                success: function(response) {
                    $('#preloader').hide();
                    swal({
                            title: "Success!",
                            text: "Change Sponsor successfully.",
                            type: "success",
                        },
                        function() {
                            location.reload();
                        });
                },
                error: function(error) {
                    $('#preloader').hide();
                    swal({
                        title: "Warning!",
                        text: "Error Message: " + error_message,
                        type: "warning",
                    });

                }
            });
        });
    });

</script>
<script src="{{asset('js/admin/members.js')}}"></script>
@endsection
