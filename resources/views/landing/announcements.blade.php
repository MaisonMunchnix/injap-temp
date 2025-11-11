@extends('layouts.landing.master')
@section('title', 'Announcements')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    <section class="vs-blog-wrapper space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <img src="{{ asset('landing/img/blog/blog-1-1.jpg') }}" alt="Blog Image" class="w-100" />
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <a href="{{ route('landing.announcements') }}"><i class="far fa-calendar"></i>24 August,
                                        2023</a> <a href="{{ route('landing.announcements') }}"></a>
                                </div>
                                <h3 class="blog-title h5"><a href="{{ route('landing.announcements.page', 'test') }}">Sample
                                        Announcement Title 1</a></h3>
                                <a href="{{ route('landing.announcements.page', 'test') }}" class="link-btn">Read Details<i
                                        class="far fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <img src="{{ asset('landing/img/blog/blog-1-4.jpg') }}" alt="Blog Image" class="w-100" />
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <a href="{{ route('landing.announcements') }}"><i class="far fa-calendar"></i>25 August,
                                        2023</a> <a href="{{ route('landing.announcements') }}"></a>
                                </div>
                                <h3 class="blog-title h5"><a href="{{ route('landing.announcements.page', 'test') }}">Sample
                                        Announcement Title 2</a></h3>
                                <a href="{{ route('landing.announcements.page', 'test') }}" class="link-btn">Read Details<i
                                        class="far fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="vs-blog blog-style1">
                        <div class="blog-img">
                            <img src="{{ asset('landing/img/blog/blog-1-2.jpg') }}" alt="Blog Image" class="w-100" />
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <a href="{{ route('landing.announcements') }}"><i class="far fa-calendar"></i>26
                                        August, 2023</a> <a href="{{ route('landing.announcements') }}"></a>
                                </div>
                                <h3 class="blog-title h5"><a
                                        href="{{ route('landing.announcements.page', 'test') }}">Sample
                                        Announcement Title 3</a></h3>
                                <a href="{{ route('landing.announcements.page', 'test') }}" class="link-btn">Read Details<i
                                        class="far fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="vs-pagination pt-20 text-center">
                <ul>
                    <li><a class="active" href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#"><i class="far fa-arrow-right"></i></a></li>
                </ul>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    {{-- additional scripts here --}}
@endsection
