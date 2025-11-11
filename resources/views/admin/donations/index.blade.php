@extends('layouts.default.admin.master')
@section('title','Donations')

@section('stylesheets')
{{-- additional style here --}}
<!-- swal -->

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
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin-dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-center">@yield('title') Lists</h6>
                <table id="donation_table" width="100%" class="table table-striped table-lightfont">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Username</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if(!empty($donations))
                        @foreach($donations as $donation)
                        <tr class="text-capitalize">
                            <td>{{ $donation->username }}</td>
                            <td>{{ $donation->amount }}</td>
                            <td>{{ $donation->created_at }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                        data-toggle="dropdown">Action </button>
                                    <div class="dropdown-menu">
                                        <a href="#" class="dropdown-item btn-swal" data-id="{{$donation->id}}"
                                            data-action="accept">Accept</a>
                                        <a href="#" class="dropdown-item btn-swal" data-id="{{$donation->id}}"
                                            data-action="delete">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- end content-i -->
@endsection

@section('scripts')
{{-- additional scripts here --}}
<!-- Sweetalert -->

<script>
    $('#donation_table').DataTable();
    $('.btn-swal').click(function (e) {
        var id = $(this).data('id');
        var action = $(this).data('action');
        var title = "";
        if (action == 'accept') {
            title = "Approve Confirmation";
        } else {
            title = "Reject Confirmation";
        }
        swal({
                title: "Are you sure?",
                text: title,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log(action);
                    processAction(id, action)
                }
            });
    });

    function processAction(id, action) {
        var form_data = new FormData();
        form_data.append('_token', token);
        form_data.append('id', id);
        form_data.append('action', action);
        var text = "";
        if (action == 'accept') {
            text = "Approved";
        } else if (action == 'delete') {
            text = "Deleted";
        } else {
            text = "cancelled";
        }
        $.ajax({
            url: "{{ route('admin.donations.action') }}",
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.send-loading').show();

            },
            success: function (response) {
                $('#view-remark-modal').modal('hide');
                $('#remark').val('');
                $('.send-loading').hide();
                swal({
                    title: "Success!",
                    text: "successfully " + text + ".",
                    type: "success"
                });
                location.reload();
            },
            error: function (error) {
                console.log(error);
                $('.send-loading').hide();
                swal({
                    title: "Warning!",
                    text: "Something went wrong please try again later",
                    type: "warning",
                });
            }
        });
    }

</script>
@endsection
