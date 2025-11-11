@extends('layouts.default.teller.master')
@section('title','Process Orders')
@section('page-title','Process Orders')
@section('content')
<div class="content-body" style="min-height:100vh">
	<!-- start content- -->
	<div class="content">
		<div class="row">
			<div class="col-sm-12">
				<div class="">
					
					<br><br>
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-body">
							<h6 class="element-header">@yield('title')</h6><br/>
								<div class="table-responsive">
									<table id="process-order" width="100%" class="table table-striped table-lightfont">
										<thead>
											<tr>
												<th>Date</th>
												<th>Transaction #</th>
												<th>Member</th>
												<!-- <th>Customer Note</th> -->
												<th>Total</th>
												<th>Paid</th>
												<th>Status</th>
												<!-- <th>Requires Shipping</th> -->
												<th>Actions</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Date</th>
												<th>Transaction #</th>
												<th>Member</th>
												<!-- <th>Customer Note</th> -->
												<th>Total</th>
												<th>Paid</th>
												<th>Status</th>
												<!-- <th>Requires Shipping</th> -->
												<th>Actions</th>
											</tr>
										</tfoot>
										<tbody>
											@foreach($orders as $order)
											<tr>
												<td>{{ $order->created_at->format('m/d/Y g:i a') }}</td>
												<td>{{ $order->payment->confirmation_number }}</td>
												<td>{{ $order->getMember() }}</td>
												<!-- <td>{{ Str::limit($order->note, 50) }}</td> -->
												<td>P{{ $order->total }}</td>
												<td>{{ $order->getPaymentStatus() }}</td>
												<td>{{ $order->getStatusDetails() }}</td>
												<!-- <td>{{ $order->ship_to_another_address === 1 || ($order->user == null && $order->payment->driver != 'OverTheCounterPaymentGateway') ? 'Yes' : 'No' }}</td> -->
												<td>
												<div class="dropdown">
												  	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>
													<div class="dropdown-menu">
														<a class="dropdown-item btn-view" data-id="{{$order->id}}" href="#">View</a>
														@if(Auth::user()->userType == 'staff')
															@if(empty($access_data))
																<a href="{{ route('order.approve-purchase', [ 'sale' => $order->id, 'action' => 'approve']) }}" data-action="Approve" class="dropdown-item approve-purchase" type="button"> Approve</a>
															@else
																@if($access_data[0]->ewallet_purches[0]->approve=='true')
																	<a href="{{ route('order.approve-purchase', [ 'sale' => $order->id, 'action' => 'approve']) }}" data-action="Approve" class="dropdown-item approve-purchase" type="button"> Approve</a>
                                                				@endif
															@endif

															@if(empty($access_data))
																<a href="{{ route('order.approve-purchase', [ 'sale' => $order->id, 'action' => 'decline']) }}" data-action="Decline" class="dropdown-item approve-purchase" type="button"> Decline</a>
															@else
																@if($access_data[0]->ewallet_purches[0]->decline=='true')
																	<a href="{{ route('order.approve-purchase', [ 'sale' => $order->id, 'action' => 'decline']) }}" data-action="Decline" class="dropdown-item approve-purchase" type="button"> Decline</a>
                                                				@endif
															@endif
															
															
														@else
															@if($order->products_released == 0 && $order->payment->is_paid == 0 && $order->payment->driver == 'EWalletPaymentGateway')
																<button class="dropdown-item" type="button" disabled> Waiting for approval</button>
															@elseif($order->products_released == 0 && $order->payment->is_paid == 0)
																<a href="{{ route('order.order-receipt', $order->id) }}" data-shipping="{{ $order->ship_to_another_address === 1 || ($order->user == null && $order->payment->driver != 'OverTheCounterPaymentGateway') ? '1' : '0' }}" class="dropdown-item release-order" type="button"> Paid & Release</a>
															@elseif($order->products_released == 0 && $order->payment->is_paid == 1)
																<a href="{{ route('order.order-receipt', $order->id) }}" data-shipping="{{ $order->ship_to_another_address === 1 || ($order->user == null && $order->payment->driver != 'OverTheCounterPaymentGateway') ? '1' : '0' }}" class="dropdown-item release-order" type="button"> Release</a>
															@elseif($order->products_released == 1)
																<a class="dropdown-item" href="#" disabled> Released</a>
															@elseif($order->products_released == 2)
																<a class="dropdown-item" href="#" disabled> Voided</a>
															@endif
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
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('TellerSystem.order_management.view_modal')
</div>
<!-- end content-i -->
@endsection

@section('scripts')
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script>
	$('#process-order').DataTable({
		columnDefs: [ { type: 'date', 'targets': [0] } ],
		order: [[0, 'desc']]
	});
</script>
@if(Auth::user()->userType == 'staff')
<script src="{{asset('js/admin/process-order.js')}}"></script>
@else
<script src="{{asset('js/teller/process-order.js')}}"></script>
@endif
@endsection
