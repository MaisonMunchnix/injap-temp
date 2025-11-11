@extends('layouts.default.master')
@section('title','Income Listing')
@section('page-title','Income Listing')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    {{-- content here --}}
    <div class="content-body">
        <div class="content">
            <div class="card">
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <div class="card-body">
                    <h5 class="form-header text-center">Income Listing</h5>
                    <div class="form-desc text-center">Total Accumulated Income</div>
                    
                    <div class="table-responsive">
                        <table id="income_table" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Trans Date</th>
                                    <th>Transaction Type</th>
                                    <th>Source</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Trans Date</th>
                                    <th>Transaction Type</th>
                                    <th>Source</th>
                                    <th>Value</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if(!empty($result))
                                    @php $count=0; @endphp
                                    @foreach($result as $key=>$value)       
                                        @php $count++; @endphp                                                                     
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{$value['trans_date']}}</td>
                                            <td>{{$value['trans_type']}}</td>
                                            <td>{{$value['source']}}</td>
                                            <td>{!!$value['amount']!!}</td>
                                        </tr>                                     
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>    
                    <br/>
                    <h6 class="form-header text-right">Total Earnings: <span class=" text-success">@if(!empty($total_sum))<span class="numbers">{{$total_sum}}</span> @else 0 @endif</span></h6>  
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script>
        $('#income_table').dataTable({
            "order": [[ 1, 'desc' ]]
        });
        $(document).ready(function(){
            $('#income_table_wrapper').removeClass('form-inline');
            $(".numbers").each(function() {
                var new_txt = $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $(this).text(new_txt)
            });
        });
    </script>
@endsection
