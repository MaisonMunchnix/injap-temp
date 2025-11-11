@extends('layouts.default.master')
@section('title','E-Wallet')
@section('page-title','Income Listing')

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
		<div class="row">
        <div class="col-md-12">

            <div class="row">
                
                <div class="col-lg-12 col-md-12">   
                    <div class="row">
                        @if(!empty($products))
                        @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <span class="badge badge-success" title="New Product" data-toggle="tooltip">
                                            <i class="ti-star"></i>
                                        </span>
                                    </div>
                                    <div class="my-3">
                                        <a href="#" title="Silver Package D">
                                            <img src="{{asset('dashboard/assets/media/image/products/product_perfume.png')}}"class="img-fluid" alt="HP Pavilion 15-EC0005NT AMD">
                                        </a>
                                    </div>
                                    <div class="text-center">
                                        <a href="#">
                                            <h4>{{$product->name}}</h4>
                                        </a>
                                        <p>
                                            <span class="text-truncate">{{$product->discounted_price}}</span>
                                        </p>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <i class="fa fa-star text-warning"></i>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="fa fa-star text-warning"></i>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="fa fa-star text-warning"></i>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="fa fa-star-half-o text-warning"></i>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="fa fa-star-o"></i>
                                            </li>
                                            <li class="list-inline-item">(23)</li>
                                        </ul>
                                        <div class="mt-2">
                                             <a class="btn btn-primary" id="{{$product->id}}" href="{{route('e-wallet-purchase',$product->id)}}" >Proceed</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        
                      
                    </div>


                </div>
            </div>

        </div>
    </div>
                        			
		</div>
	</div>

@endsection

@section('scripts')
{{-- additional scripts here --}}
@endsection
