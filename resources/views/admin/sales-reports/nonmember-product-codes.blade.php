@extends('layouts.default.admin.master')
@section('title','Non-Members Product Codes')
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
                    <h5 class="text-center">@yield('title')</h5><br>
                </div>
                <div class="">
                    <div class="table-responsive border-bottom">
                        <table class="table thead-border-top-0" id="allcodes" style="width:100% !important">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Receipt #</th>
                                    <th>Code</th>
                                    <th>Security Pin</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                        </table>
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
            "pageLength": 100,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                text: 'Export to Excel',
                exportOptions: {
                    modifier: {
                        // DataTables core
                        order: 'index', // 'current', 'applied', 'index',  'original'
                        page: 'all', // 'all',     'current'
                        selected: null,
                        search: 'null' // 'none',    'applied', 'removed'
                    }
                }
            }],
            "order": [
                [0, "desc"]
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('non-members-code') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token
                }
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "receipt_no"
                },
                {
                    "data": "code"
                },
                {
                    "data": "security_pin"
                },
                {
                    "data": "type"
                },
                {
                    "data": "created_at"
                }
            ]
        });

    });

</script>
@endsection
