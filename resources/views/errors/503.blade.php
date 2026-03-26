@extends('layouts.teller.login.master')

@section('title', 'Under Maintenance')

@section('contents')
<style>
    .img-fluid {
        max-width: 90% !important;
        height: auto;
    }

    .auth-box.error-box .error-image {
        margin: 5px !important;
    }

    .auth-box>.row {
        padding: 5px 0 !important;
    }

</style>
<!-- Start row -->
<div class="auth-box error-box">
    <!-- Start row -->
    <div class="row no-gutters align-items-center justify-content-center">
        <!-- Start col -->
        <div class="text-center">
            <img src="{{ asset('new_landing/images/logs.png') }}" class="img-fluid error-logo" alt="logo">
            <br>
            <img src="{{ asset('teller_assets/images/error/maintenance.svg') }}" class="img-fluid error-image" alt="Maintenance">
            <h4 class="error-subtitle mb-4">Under Maintenance</h4>
            <p class="mb-4">Sorry for the onconvenience, website is under maintenance. Please try again later.</p>
            <a href="{{ URL::previous() }}" class="btn btn-warning font-16"><i class="feather icon-home mr-2"></i> Go back</a>
        </div>

        <!-- End col -->
    </div>
    <!-- End row -->
</div>
<!-- End row -->
@endsection
