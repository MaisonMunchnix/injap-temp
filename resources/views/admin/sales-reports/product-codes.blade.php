@extends('layouts.default.admin.master')
@section('title','Members Product Codes')
@section('stylesheets')
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
            <!-- <h6 class="element-header">Data Tables</h6> -->
            <div class="card-body">
                <div class="">
                    <h5 class="text-center">
                        Members Product Codes</h5><br>
                </div>
                <div class="">
                    <form action="" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 offset-md-8 float-right">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search" value="{{ $search ?? '' }}" placeholder="Search by username or code" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather feather-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive border-bottom">
                        <table class="table thead-border-top-0" id="allcodes" style="width:100% !important">
                            <thead>
                                <tr>
                                    <th>Receipt #</th>
                                    <th>Code</th>
                                    <th>Security Pin</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($product_codes)
                                    @foreach ($product_codes as $pcode)
                                        <tr>
                                            <td>{{ ($pcode->receipt_number == NULL) ? 'N/A' : $pcode->receipt_number }}</td>
                                            <td>{{ $pcode->code }}</td>
                                            <td>{{ $pcode->security_pin }}</td>
                                            <td>{{ $pcode->username }}</td>
                                            <td>{{ $pcode->fullname }}</td>
                                            <td>{{ $pcode->type }}</td>
                                            <td>{{ $pcode->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        @if($product_codes)
                            <div class="pull-right">{{ $product_codes->appends(request()->query())->links() }}</div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- end content-i -->
@endsection

@section('scripts')
<!-- Sweetalert -->
<script src="{{asset('js/admin/members.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#allcodes').DataTable({
            "paging": false,
            "bFilter": false
        });
       /*  $('#allcodes').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "order": [
                [6, "desc"]
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('members-code') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token
                }
            },
            "columns": [{
                    "data": "receipt_no"
                },
                {
                    "data": "code"
                },
                {
                    "data": "security_pin"
                },
                {
                    "data": "username"
                },
                {
                    "data": "fullname"
                },
                {
                    "data": "type"
                },
                {
                    "data": "created_at"
                }
            ]
        }); */


    });

</script>
@endsection
