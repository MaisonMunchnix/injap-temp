@extends('layouts.default.master')
@section('title','Network Checker')
@section('page-title','Network Checker')

@section('stylesheets')
{{-- additional style here --}}
@endsection

@section('content')
{{-- content here --}}
<div class="content-body">
    <div class="content">
        <div class="card">
            <!-- <h6 class="element-header">Data Tables</h6> -->
            <div class="element-box">


                <div class="card-body">
                    <h5 class="form-header text-center">Network Checker</h5>

                    <div class="table-responsive">
                        <table id="act_table2" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Left</th>
                                    <th>Right</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($dataChecker as $data)
                            <tr>
                                <td>{{$data['Date']}}</td>
                                <td>{{$data['left']}}</td>
                                <td>{{$data['right']}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>total</td>
                                <td>{{$left_total}}</td>
                                <td>{{$right_total}}</td>
                            </tr>
                            
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Date</th>
                                    <th>Left</th>
                                    <th>Right</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>



@endsection

@section('scripts')
{{-- additional scripts here --}}
<script>
    $(document).ready(function() {

        $('#act_table2').DataTable({
            "order": [
                [0, "asc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });


    });

</script>
@endsection
