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
                    <div class="form-desc text-center">@if(!empty($bonus_type)) {!!$trans_type[$bonus_type]!!} @endif</div>
                    
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
                                @if(!empty($referral_array))
                                    @foreach($referral_array as $key_bonus=>$value_bonus)                                                                             
                                        <tr>
                                            <td>{{$value_bonus['count']}}</td>
                                            <td>{{$value_bonus['trans_date']}}</td>
                                            <td>{{$value_bonus['trans_type']}}</td>
                                            <td>{{$value_bonus['source']}}</td>
                                            <td class="numbers">{{$value_bonus['amount']}}</td>
                                        </tr>                                     
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>    
                    <br/>
                    <h5 class="form-header text-right">Total: <span class=" text-danger">P @if(!empty($total_sum)) <span class="numbers">{{$total_sum}}</span> @else 0 @endif</span></h5>                    
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script>
        $('#income_table').dataTable();
        $(document).ready(function(){
            $('#income_table_wrapper').removeClass('form-inline');
            $(".numbers").each(function() {
                var new_txt = $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $(this).text(new_txt)
            });
        });
    </script>
@endsection
