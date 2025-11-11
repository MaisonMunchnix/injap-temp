@extends('layouts.landing.master')
@section('title', $advertisement->title)

@section('stylesheets')
    {{-- additional style here --}}

@endsection

@section('content')
    <div class="container space-top">
        <div class="row flex-row-reverse align-items-center gx-70">
            <div class="section-title text-center">
                <h2>{{ $advertisement->title }}</h2>
            </div>
            <div class="row mb-5">
                <div class="col-md-8 offset-md-2">
                    <div class="blog-item">
                        <div class="blog-img">
                            <a href="#">
                                <img class="card-img-top" src="{{ asset($advertisement->image) }}">
                            </a>
                            <div class="tag">
                                <a href="#">
                                    Posted By : {{ strtoupper(str_replace('_', ' ', $advertisement->user->username)) }}
                                </a>
                            </div>
                        </div>
                        <div class="content">
                            <div>
                                {!! $advertisement->content !!}
                            </div>
                            <a href="{{ route('landing.contact') }}" class="read-btn">Contact Us</a>
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
