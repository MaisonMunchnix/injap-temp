@extends('layouts.default.teller.master')
@section('title','Record Sales')
@section('page-title','Record Sales')
@section('content')
<div class="content-body" style="min-height:100vh">
    <!-- start content- -->
    <div class="content">
        {{-- <div class="row"> --}}
        {{-- <div class="col-sm-12"> --}}
        <div class="element-wrapper">

            {{-- <div class="col-sm-12 col-md-12 col-lg-12"> --}}
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="element-header">@yield('title')</h6>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('order.export-sales-data') }}" class="btn btn-primary float-right">Export Data</a>
                            <br><br>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="record-sales" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Transaction Date</th>
                                    <th>Transaction #</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Total</th>
                                   <!--  <th>Paid</th> -->
                                    <!-- <th>Gateway Status</th> -->
                                    <th>Order Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot> 
                                <tr>
                                    <th>Transaction Date</th>
                                    <th>Transaction #</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Total</th>
                                    <!-- <th>Paid</th> -->
                                    <!-- <th>Gateway Status</th> -->
                                    <th>Order Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($orders as $order)
                                 @php
                                   if($order->user_id == ''){
                                       $name = $order->full_name;
                                       $type = "Non Member";
                                   } else {
                                       $name = $order->first_name . ' ' . $order->last_name;
                                       $type = "Member";
                                   }
                                   
                                   
                                   if($order->products_released == 0){
                                   $released = "Pending";
                                   } else {
                                   $released = "Released";
                                   }
                                   
                                   @endphp
                                <tr>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->confirmation_number }}</td>
                                    <td>{{ $type }}</td>
                                    <td>{{ $name }}</td>
                                    <td>P{{ number_format($order->total, 2) }}</td>
                                    <td>{{ $released }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item  btn-view" data-id="{{$order->id}}" href="#">View</a>
                                                <a class="dropdown-item  btn-view" data-id="{{$order->id}}" href="{{ route('teller.code-export',$order->id) }}">Export</a>
                                                
                                                @if($released === 'Released')
                                                <a href="{{ route('order.view-receipt', $order->id) }}" class="dropdown-item" type="button"> View Receipt</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
        {{-- </div> --}}
        {{-- </div> --}}
    </div>
    @include('TellerSystem.order_management.view_modal')
</div>
<!-- end content-i -->
@endsection

@section('scripts')
<script>
    $('#record-sales').DataTable({
        columnDefs: [ { type: 'date', 'targets': [0] } ],
        order: [
            [0, 'desc']
        ]
    });

</script>
<script src="{{asset('js/teller/process-order.js')}}"></script>
@endsection
