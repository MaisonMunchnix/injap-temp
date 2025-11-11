@extends('layouts.default.admin.master')
@section('title',"Pv points Checker")
@section('page-title','Add Users')

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
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Account Transaction list</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">@yield('title')</h6>
                <table id="members_table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Source</th>
                            <th>Pv Point</th>
                            <th>Left</th>
                            <th>Right</th>
                            <th>Amount</th>
                            <th>Cycle</th>
                            <th>Cycle_time</th>
                            <th>Fifth_pair</th>
                            <th>Created_at</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                           <th>Username</th>
                            <th>Source</th>
                            <th>Pv Point</th>
                            <th>Left</th>
                            <th>Right</th>
                            <th>Amount</th>
                            <th>Cycle</th>
                            <th>Cycle_time</th>
                            <th>Fifth_pair</th>
                            <th>Created_at</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        @if(!empty($datas))
                        @foreach($datas as $data)
                        <tr class="text-capitalize">
                            <td>{{ $data['username'] }}</td>
                            <td>{{ $data['source'] }}</td>                                                      
                            <td>{{ $data['PV_Point'] }}</td>    
                            <td>{{ $data['left'] }}</td>                                                      
                            <td>{{ $data['right'] }}</td>   
                            <td>{{ $data['amount'] }}</td>                                                   
                            <td>{{ $data['cycle'] }}</td>                                                      
                            <td>{{ $data['cycle_time'] }}</td>                                                      
                            <td>{{ $data['fifth_pair'] }}</td>                                                      
                            <td>{{ $data['created_at'] }}</td>                                                      
                        </tr>
                        @endforeach
                        @endif
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@include('admin.members.edit-modal')
<!-- end content-i -->
@endsection

@section('scripts')
<!-- Sweetalert -->

<script src="{{asset('js/admin/members.js')}}"></script>
<script>
 $('#members_table').DataTable({
        "order": [[ 9, "asc" ]]
    } );
//    $(document).ready(function() {
//        $('#members_table').DataTable({
//            "processing": true,
//            "serverSide": true,
//            "ajax": {
//                "url": "{{ route('today-members') }}",
//                "dataType": "json",
//                "type": "POST",
//                "data": {
//                    _token: "{{csrf_token()}}"
//                }
//            },
//            "columns": [{
//                    "data": "username"
//                },
//                {
//                    "data": "first_name"
//                },
//                {
//                    "data": "last_name"
//                },
//                {
//                    "data": "package"
//                },
//                {
//                    "data": "sponsor"
//                },
//                {
//                    "data": "plain_pass"
//                },
//                {
//                    "data": "created_at"
//                },
//                {
//                    "data": "options",
//                    "searchable": false,
//                    "orderable": false
//                }
//            ],
//
//        });
//
//
//      
//    });

</script>
@endsection
