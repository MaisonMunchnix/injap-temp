@extends('layouts.default.master')
@section('title','Codes Facility')
@section('page-title','Codes Facility')

@section('stylesheets')
{{-- additional style here --}}
@endsection

@section('content')
{{-- content here --}}
<div class="content-body">
    <div class="content">
        <div class="card">
            <div class="element-box">
                <div class="card-body">
                    <h5 class="form-header text-center">Package Codes Facility</h5>
                    <div class="table-responsive">
                        <table id="act_table" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Codes</th>
                                    <th>Pin</th>
                                    <th>Type</th>
                                    <th>Used by</th>
                                    <th>Activation Date</th>
                                    <th>Created date</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Codes</th>
                                    <th>Pin</th>
                                    <th>Type</th>
                                    <th>Used by</th>
                                    <th>Activation Date</th>
                                    <th>Created date</th>
                                </tr>
                            </tfoot>
                        </table>
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
        var save_code = "{{route('save-product-codes')}}";

        $('#act_table').DataTable({
            "order": [
                [5, "desc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            processing: true,
            serverSide: true,
            "ajax": {
                "url": "{{ route('get-codes') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token,
                    type: 'package'
                }
            },
            "columns": [{
                    "data": "code"
                },
                {
                    "data": "security_pin"
                },
                {
                    "data": "name"
                },
                {
                    "data": "username"
                },
                {
                    "data": "updated_at"
                },
                {
                    "data": "created_at"
                }
            ]
        });
    });

</script>
@endsection
