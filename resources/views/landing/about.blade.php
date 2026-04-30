@extends('layouts.landing.master')
@section('title', 'INJAP - Innovation Japan | About')

@section('stylesheets')
    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 50px 0;
        }

        .gallery-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.4s ease;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: scale 0.6s ease;
        }

        .gallery-item:hover img {
            scale: 1.1;
        }

        .glass-reveal {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            transform: translateY(100%);
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gallery-item:hover .glass-reveal {
            transform: translateY(0);
        }

        .glass-reveal .description {
            color: #fff;
            font-size: 1rem;
            line-height: 1.5;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease 0.2s;
        }

        .gallery-item:hover .glass-reveal .description {
            opacity: 1;
            transform: translateY(0);
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
        }
    </style>
@endsection

@section('content')

    <!-- About Section Start -->
    <div class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 order-lg-1 order-2">
                    <!-- About image start -->
                    <div class="about-video wow fadeInLeft" data-wow-delay="0.25s">
                        <figure class="image-anime">
                            <img src="{{ asset('new_landing/images/our-mission-img.jpg')}}" alt="About Us">
                        </figure>
                    </div>
                    <!-- About image end -->
                </div>

                <div class="col-lg-6 col-md-12 order-lg-2 order-1">
                    <div class="about-content">
                        <!-- Section Title start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp" data-wow-delay="0.25s">ABOUT US</h3>
                            <h2 class="text-anime">Dedicated to Your Growth and Success</h2>
                        </div>
                        <!-- Section Title end -->

                        <div class="about-body">
                            <p class="wow fadeInUp" data-wow-delay="0.50s">Welcome to {{ env('APP_NAME') }}, your go-to
                                destination for essential products and an exceptional networking business experience. Our
                                company was founded with a dedication to delivering top-quality goods while nurturing
                                entrepreneurial growth. We are proud to be your dependable partner on the path to achieving
                                financial independence and self-sufficiency through networking opportunities.</p>

                            <p class="wow fadeInUp" data-wow-delay="0.75s">At {{ env('APP_NAME') }}, we understand the power
                                of building connections and leveraging them for mutual benefit. Our networking business
                                model offers you a unique avenue to explore entrepreneurship, connect with like-minded
                                individuals, and access essential products at competitive prices.</p>

                            <p class="wow fadeInUp" data-wow-delay="1.0s">We believe that networking is more than just a
                                business strategy; it's a way of fostering meaningful relationships, sharing opportunities,
                                and collectively achieving success. With RCBO Consumer Goods Trading, you can be part of a
                                community that values collaboration, personal development, and financial empowerment.</p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Section End -->

    @if(count($galleries) > 0)
    <!-- Gallery Section Start -->
    <div class="gallery-section py-5">
        <div class="container">
            <div class="section-header wow fadeInUp" data-wow-delay="0.2s">
                <h2>Our Journey in Pictures</h2>
                <p>A glimpse into our dedication and growth.</p>
            </div>
            <div class="gallery-grid">
                @foreach($galleries as $gallery)
                <div class="gallery-item wow fadeInUp" data-wow-delay="{{ 0.1 * $loop->iteration }}s">
                    <img src="{{ asset($gallery->image_path) }}" alt="Gallery Image">
                    <div class="glass-reveal">
                        <div class="description">
                            {!! $gallery->description !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Gallery Section End -->
    @endif
@endsection


@section('scripts')
    {{-- additional scripts here --}}
@endsection