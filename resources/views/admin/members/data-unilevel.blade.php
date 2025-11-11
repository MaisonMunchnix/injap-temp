@extends('layouts.default.admin.master')
@section('title',"Unilevel Data")
@section('page-title','Unilevel Data')

@section('stylesheets')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css">

<link rel="stylesheet" href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css">
<style>
    .border-red {
        border: 1px solid red !important;
    }

    .select2-container--default .select2-selection--single {
        height: calc(1.5em + .75rem + 3px) !important;
        border-radius: 0.5rem !important;
    }


    .sweet_loader {
	width: 140px;
	height: 140px;
	margin: 0 auto;
	animation-duration: 0.5s;
	animation-timing-function: linear;
	animation-iteration-count: infinite;
	animation-name: ro;
	transform-origin: 50% 50%;
	transform: rotate(0) translate(0,0);
}
@keyframes ro {
	100% {
		transform: rotate(-360deg) translate(0,0);
	}
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
                        <a href="#">Distributor List</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                </ol>
            </nav>
        </div>
    

          <div class="card">
            <div class="card-body">
                <h6 class="card-title text-center">Unilevel Release</h6>
              <button type="button" class="btn btn-primary btn-lg btn-block unilevel-btn">Unilevel Release cash</button>
              
            </div>
        </div>
    </div>
    
</div>
@include('admin.members.edit-modal')
@include('admin.members.edit-password-modal')
<!-- end content-i -->
@endsection

@section('scripts')
<!-- Sweetalert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {


        var sweet_loader = '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';


        $('.unilevel-btn').click(function(){

            	swal.fire({
                allowOutsideClick: false,
                showConfirmButton: false,
			    html: '<h4>Loading...</h4>',
			    onRender: function() {
				$('.swal2-content').prepend(sweet_loader);
			    }
		});

           var formData = new FormData();
            formData.append('_token', token);
            formData.append('product_codeId', 1);

            $.ajax({
                url: 'unilevel-execute',
                type: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                    console.log(response);                   
                 if(response >0){
                    unilevel (response);
                }else{

                     setTimeout(function() {
			        swal.fire({
			        	icon: 'success',
			        	html: '<h4>Success!</h4>'
			        });
		            }, 700);
                }
               
                },
                error: function(error) {

                }
            });
        });

        function unilevel (lastID){
            if(lastID >0){
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('product_codeId', lastID);

            $.ajax({
                url: 'unilevel-execute',
                type: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                console.log(response);
                if(response >0){
                    unilevel (response);
                }else{

                    setTimeout(function() {
			swal.fire({
				icon: 'success',
				html: '<h4>Success!</h4>'
			});
		}, 700);
                }
                
                },
                error: function(error) {

                }
            });
            }
        }




    });

</script>
@endsection
