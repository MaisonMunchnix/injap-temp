@extends('layouts.default.master')
@section('title','Geneology')
@section('page-title','Geneology')

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
			
			<!-- begin::footer -->
			@include('layouts.default.footer')
			<!-- end::footer -->
		</div>
	</div>

@endsection

@section('scripts')
	{{-- additional scripts here --}}
	<script src="{{asset('js/user/member-geneology.js')}}"></script>
@endsection
