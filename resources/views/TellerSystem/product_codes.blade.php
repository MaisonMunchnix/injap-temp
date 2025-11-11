<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.teller.master')

@section('title', 'Home')

@section('stylesheets')

@endsection

@section('breadcrumbs')
<div class="row align-items-center">
	<div class="col-md-8 col-lg-8">
		<h3 class="page-title">@yield('title')</h3>
		<div class="breadcrumb-list">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{!! url('teller-admin/'); !!}">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
			</ol>
		</div>
	</div>
	<!--<div class="col-md-4 col-lg-4">
		<div class="widgetbar">
			<button class="btn btn-primary" data-toggle="modal" data-target="#add-modal"><i class='feather icon-plus'></i> Package</button>
		</div>
	</div>-->
</div>
@endsection

@section('contents')
<div class="card-header">
	<h5 class="card-title">@yield('title')</h5>
</div>
<div class="card-body">
	<ul class="nav nav-tabs nav-tabs-custom" role="tablist">
		<li class="nav-item">
			<a href="#products_today" class="nav-link active" data-toggle="tab" role="tab" aria-controls="tab-21" aria-selected="true">
				<span class="nav-link__count">Codes Generated Today</span>
			</a>
		</li>
		<li class="nav-item">
			<a href="#all_products" class="nav-link" data-toggle="tab" role="tab" aria-selected="false">
				<span class="nav-link__count">All Generated Codes</span>
			</a>
		</li>
	</ul>
	<div class="card">
		<div class="card-body tab-content">
			<div class="tab-pane active show fade" id="products_today">
				<h3><strong class="headings-color float-left">Product Codes Today ({{ date('F d, Y') }})</strong></h3>
				<form action="{{ route('print-codes') }}" method="post">
					@csrf
					<div class="table-responsive border-bottom" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
						<table class="table mb-0 thead-border-top-0" id="today_codes_table" style="width:100% !important">
							<thead>
								<tr>
									<th><input type="checkbox" id="checkAl"> Select All</th>
									<th>Code</th>
									<th>Security Pin</th>
									<th>Category</th>
									<th>Status</th>
									<th>Date</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody class="list">
								@foreach($product_codes_today as $product_code_today)
								<tr>
									<td>
										<input type="checkbox" class="codes_today_id" name="checkbox[{{$product_code_today->id}}]" value="{{$product_code_today->id}}">
									</td>
									<td>{{ $product_code_today->code }}</td>
									<td>{{ $product_code_today->security_pin }}</td>
									<td style="text-transform: capitalize;">{{ $product_code_today->type }}</td>
									<td>{{ $product_code_today->status }}</td>
									<td>{{ $product_code_today->created_at }}</td>
									<td>
										<div class="dropdown ml-auto">
											<a href="#" data-toggle="dropdown" data-caret="false" class="text-muted"><i class="material-icons">keyboard_arrow_down</i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="javascript:;" class="dropdown-item deleteRecord" data-id="{{ $product_code_today->id }}"><i class="fa fa-trash"></i> Delete</a>
											</div>
										</div>
									</td>
								</tr>
								@endforeach

							</tbody>
						</table>
					</div>
					<div class="col-lg-12 card-body">
					</div>
					<button type="submit" class="btn btn-primary" name="print"><i class="material-icons">print</i> Print </button>
				</form>
			</div>
			<div class="tab-pane fade" id="all_products">
				<h3><strong class="headings-color float-left">All Product Codes</strong></h3>
				<form action="{{ route('print-codes2') }}" method="post">
					@csrf
					<div class="table-responsive border-bottom" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>
						<table class="table mb-0 thead-border-top-0" id="generated_codes_table" style="width:100% !important">
							<thead>
								<tr>
									<th><input type="checkbox" id="checkAll"> Select All</th>
									<th>Code</th>
									<th>Security Pin</th>
									<th>Category</th>
									<th>Status</th>
									<th>Date</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody class="list">
								@foreach($product_codes as $product_code)
								<tr>
									<td>
										<input type="checkbox" class="codes_id" name="checkbox[{{$product_code->id}}]" value="{{$product_code->id}}">
									</td>
									<td>{{ $product_code->code }}</td>
									<td>{{ $product_code->security_pin }}</td>
									<td style="text-transform: capitalize;">{{ $product_code->type }}</td>
									<td>{{ $product_code->status }}</td>
									<td>{{ $product_code->created_at }}</td>
									<td>
										<div class="dropdown ml-auto">
											<a href="#" data-toggle="dropdown" data-caret="false" class="text-muted"><i class="material-icons">keyboard_arrow_down</i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="javascript:;" class="dropdown-item deleteRecord" data-id="{{ $product_code->id }}"><i class="fa fa-trash"></i> Delete</a>
											</div>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<button type="submit" class="btn btn-primary" name="print"><i class="material-icons">print</i> Print </button>
				</form>
			</div>

		</div>
	</div>
</div>

@endsection

@section('scripts')

<script>
	$(document).ready(function() {
		$("#checkAl").click(function() {
			$('.codes_today_id').not(this).prop('checked', this.checked);
		});
		$("#checkAll").click(function() {
			$('.codes_id').not(this).prop('checked', this.checked);
		});

		$('#generated_codes_table').DataTable();
		$('#today_codes_table').DataTable();
	});

</script>
@endsection
