@extends('layouts.teller.login.master')

@section('title', 'Under Maintenance')

@section('contents')
    <!-- Start row -->
    <div class="auth-box error-box">
        <!-- Start row -->
        <div class="row no-gutters align-items-center justify-content-center">
            <!-- Start col -->
            <div class="text-center">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid error-logo" alt="logo">
                <br>
                <img src="{{ asset('teller_assets/images/error/maintenance.svg') }}" class="img-fluid error-image"
                    alt="Maintenance">
                <h4 class="error-subtitle mb-4">Under Maintenance</h4>
                <p class="mb-4">Sorry for the onconvenience, website is under maintenance. Please try again later.</p>
                <a href="{{ env('APP_URL') }}" class="btn btn-warning font-16"><i class="feather icon-home mr-2"></i> Go
                    back</a>
            </div>

            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End row -->
@endsection
