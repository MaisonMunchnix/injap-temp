@extends('layouts.landing.master')
@section('title', 'Announcement')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    <section class="vs-blog-wrapper blog-details space-top space-extra-bottom">
        <div class="container">
            <div class="row gx-40">
                <div class="col-lg-8">
                    <div class="vs-blog blog-single">
                        <div class="blog-img"><img src="{{ asset('landing/img/blog/blog-s-1-5.jpg') }}" alt="Blog Image"></div>
                        <div class="blog-content">
                            <div class="blog-meta"><a href="{{ route('landing.announcements') }}"><i
                                        class="far fa-calendar"></i>24 August,
                                    2023</a> <a href="{{ route('landing.announcements') }}"></div>
                            <h2 class="blog-title">Sample Announcement Title 1</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia diam ut nibh vestibulum,
                                non auctor massa tristique. In bibendum odio a augue auctor volutpat. Suspendisse potenti.
                                Vivamus id urna quis est semper aliquam. Proin vehicula elit eu fermentum blandit. Fusce
                                efficitur, ligula sit amet lacinia feugiat, urna lectus dictum sapien, eget eleifend tortor
                                arcu id dui. Aenean eget justo ut augue vestibulum efficitur nec eu quam. Cras nec metus id
                                odio gravida vulputate. Sed eget massa eu nisi scelerisque dictum. Integer hendrerit
                                bibendum lectus, vel luctus lorem lacinia nec. Nulla eget sapien sit amet urna efficitur
                                laoreet a at quam. Donec hendrerit dolor et neque fringilla, in ultrices justo iaculis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    {{-- additional scripts here --}}
@endsection
