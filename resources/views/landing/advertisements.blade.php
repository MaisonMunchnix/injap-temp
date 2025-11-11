@extends('layouts.landing.master')
@section('title', 'Advertisements')

@section('stylesheets')
    {{-- additional style here --}}

@endsection

@section('content')
    <div class="container space-top">
        <div class="row flex-row-reverse align-items-center gx-70">
            <div class="section-title text-center">
                <h2>Advertisement</h2>
            </div>

            @foreach ($ads as $ad)
                <div class="row mb-5">
                    <div class="col-md-8 offset-md-2">
                        <div class="blog-item">
                            <div class="blog-img">
                                <a href="{{ route('landing.advertisement', $ad->slug) }}">
                                    <img class="card-img-top" src="{{ asset($ad->image) }}">
                                </a>
                                <div class="tag">
                                    <a href="#">
                                        Posted By : {{ strtoupper(str_replace('_', ' ', $ad->username)) }}
                                    </a>
                                </div>
                            </div>
                            <div class="content">
                                <h3><a href="{{ route('landing.advertisement', $ad->slug) }}">{{ $ad->title }}</a></h3>
                                <div>
                                    {!! $ad->content !!}
                                </div>
                                <a href="{{ route('landing.contact') }}" class="read-btn">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="row">
                <div class="col-lg-12 col-md-12 text-center">
                    <div class="pagination-area">
                        {{ $ads->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    {{-- additional scripts here --}}
@endsection
