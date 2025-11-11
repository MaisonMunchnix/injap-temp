@extends('layouts.default.master')
@section('title','Purchase')
@section('page-title','Purchase')

@section('stylesheets')
{{-- additional style here --}}
@endsection

@section('content')
{{-- content here --}}
	<div class="content-body">
		<div class="content">
		    <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @if(!empty($products))
                            @foreach($products as $product)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="slider-for">
                                        <div class="slick-slide-item">
                                            <img src="{{asset('dashboard/assets/media/image/products/product_perfume.png')}}" class="img-fluid"
                                                 alt="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <p class="small mb-0"></p>              
                                    </div>
                                    <h2>{{$product->name}}</h2>
                                    <p>
                                        <span class="badge bg-success-bright text-success">In stock</span>
                                    </p>
                                    <p>{{$product->description}}</p>
                                    <div class="font-size-30 mb-2">
                                        {{$product->price}}
                                    </div>
                                    <div class="d-flex">
                                        <ul class="list-inline mb-3 mr-2">
                                            <li class="list-inline-item mb-0">
                                                <i class="fa fa-star text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="fa fa-star text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="fa fa-star text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="fa fa-star text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="fa fa-star-half-o text-warning"></i>
                                            </li>
                                        </ul>
                                        <span>(4.5)</span>
                                    </div>
                                    <p>Inclusion:</p>
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-check mr-2 text-success"></i>{{$product->name}}
                                        </li>                
                                    </ul>
                                    <form class="mt-4 d-flex align-items-center" method="POST" action="">
                                        <div>
                                            <div class="input-group">
                                                <input id="quantity" type="number" class="form-control" value="1">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">QTY</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="ewallet-btn btn btn-primary ml-2 add-to-card" id="{{$product->id}}" type="button">Submit Order</button>
                                    </form>
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

@endsection

@section('scripts')
{{-- additional scripts here --}}
<script>
	$(document).ready(function () {
        
 $(".ewallet-btn").click(function (e) {
          	var id=e.target.id;		
            var quantity = $('#quantity').val();	
			$.ajax({
				type: 'post',
				url: '/e-walletProcess',
				data: {
					'id': id,
                    'quantity':quantity,
                    _token: token
				},
				success: function(data) {
                    console.log(data);
				if(data=="success"){
                    alert("Succes order");
                     window.history.back();
                }
				}
			});
    });

    });
</script>
<!-- <script src="{{asset('js/user/member-encashment.js')}}"></script> -->
@endsection
