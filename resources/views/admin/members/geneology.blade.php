@extends('layouts.default.admin.master')
@section('title','Member Geneology')
@section('page-title','Member Geneology')

@section('stylesheets')
    {{-- additional style here --}}
	<link href="{{asset('css/genealogy.css')}}" type="text/css" rel="stylesheet">
@endsection

@section('content')
	<div class="content-body">
        <div class="content">
			<div class="genealogy-container">
				<section class="genealogy mx-auto">
					<input type="hidden" value="{{$user_id}}" id="user_id">
					<div class="genea-body"></div>
				</section>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
	{{-- additional scripts here --}}
<script>
	const GET_GENEO_DATA_URL = "{{ route('get-member-geneo-data', ':uid') }}";
	$(document).ready(function() {
		geGeneoData();
	})


function geGeneoData() {
    var uid = $('#user_id').val();
	let url = GET_GENEO_DATA_URL.replace(':uid', uid);
    $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function() {
            //console.log('Getting data...');
            $('.preloader').css('display','');
        },
        success: function(response) {
            console.log('success..'+response.data);
            $('.genea-body').html(response.data);
            $('.preloader').css('display','none');
        },
        error: function(error) {
            console.log('error...');
            console.log(error);
            $('.preloader').css('display','none');
            swal({
                title: "Error!",
                text: "Something went wrong please try again later. Error: " + error.responseJSON.message,
                type: "error",
            }, function() {
                window.location.href = '/staff';
            });


        }
    });
}
</script>
@endsection
