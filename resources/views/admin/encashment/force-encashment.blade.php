@extends('layouts.default.admin.master')
@section('title','Encashments test')
@section('page-title','Encashment List')
@section('stylesheets')
{{-- additional style here --}}
@endsection
@section('content')
{{-- content here --}}

<div class="content-body">
    <!-- start content- -->
    <div class="content">
        <div class="card">
            <div class="card-body p-50">
                <form action="" id="encash_form">
                    <button type="submit" class="btn btn-primary">Encash</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{{-- additional scripts here --}}
<script>
    var test_url = "{{route('request-all-encashment')}}";

</script>
<script src="{{asset('js/admin/encashment.js')}}"></script>
@endsection
