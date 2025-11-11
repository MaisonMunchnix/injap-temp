@extends('layouts.default.master')
@section('title','Weekly Encashments')
@section('page-title','Weekly Encashments')

@section('stylesheets')
{{-- additional style here --}}
<style>
	.border-red {
		border: 1px solid red !important;
	}
</style>
@endsection

@section('content')
{{-- content here --}}

	<div class="content-body">
		<div class="content">
			<div class="card">
                <div class="card-body">
                    <h6 class="card-title">@yield('page-title')</h6>                
                    <div class="row">
                		<div class="col-lg-6 col-md-12">
                		    <div class="card bg-success-gradient">
                		        <div class="card-body">
                		            <div class="d-flex justify-content-between">
                		                <h6 class="card-title">Total Weekly Encashed Amount</h6>	
                		            </div>
                		            <div class="d-flex justify-content-between align-items-center">
                		                <h2 class="font-weight-bold">@if(!empty($total_encashment)) {{$total_encashment}} @else 0 @endif</h2>
                		                <div class="avatar border-0">
                		                    <span class="avatar-title rounded-circle bg-success">
                		                        <i class="ti-arrow-top-right"></i>
                		                    </span>
                		                </div>
                		            </div>
                		        </div>
                		    </div>
                		</div>              
                        <div class="col-lg-6 col-md-12">
                    		<div class="card bg-warning-gradient">
                    		    <div class="card-body">
                    		        <div class="d-flex justify-content-between">
                    		            <h6 class="card-title">Weekly Available Balance</h6>		
                    		        </div>
                    		        <div class="d-flex justify-content-between align-items-center">
                    		            <h2 class="font-weight-bold">@if(!empty($total_balance)) {{$total_balance}} @else 0 @endif</h2>
                    		            <div class="avatar border-0">
                    		                <span class="avatar-title rounded-circle bg-warning">
                    		                    <i class="ti-wallet"></i>
                    		                </span>
                    		            </div>
                    		        </div>
                    		    </div>
                    		</div>
                		</div>                  
            		</div> 
                </div>
			</div>			
			<div class="card">
				<div class="card-body">
				<div class="table-responsive">
						<table id="encashment_tbl" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Date Requested</th>
									<th>Amount Requested</th>
									<th>Amount Approved</th>
									<th>Amount Claimed</th>
									<th>Date Processed</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Date Requested</th>
									<th>Amount Requested</th>
									<th>Amount Approved</th>
									<th>Amount Claimed</th>
									<th>Date Processed</th>
								</tr>
							</tfoot>
							<tbody>
								@if(!empty($get_encashment))
									@foreach($get_encashment as $data)
									<tr class="text-capitalize">
										<td>{{$data->created_at}}</td>
										
										<td class="numbers">{{$data->amount_requested}}</td>
										<td>@if($data->status=='pending') Pending @else <span class="numbers">{{$data->amount_approved}}</span> @endif</td>
										<td>
											@if($data->status=='claimed')
												@php
													$temp=$data->amount_approved;
													$tax=$temp*0.10;
													$amount_claimed=$temp-$tax-20;
												@endphp
												<span class="numbers">{{$amount_claimed}}</span>
											@elseif($data->status=='pending')
												Pending
											@elseif($data->status=='approved')
												Not yet claim
											@else
												0
											@endif
										</td>
										<td>@if($data->status=='pending') Pending @else {{$data->updated_at}} @endif</td>
									</tr>
									@endforeach
								@endif
							</tbody>
						</table>
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>	
		</div>
	</div>

@endsection

@section('scripts')
{{-- additional scripts here --}}
<script>
	var balance='{{$total_balance}}';
</script>
<script src="{{asset('js/user/member-encashment.js')}}"></script>
@endsection
