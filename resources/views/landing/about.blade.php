@extends('layouts.landing.master')
@section('title', 'INJAP - Innovation Japan | About')

@section('stylesheets')
    <style>
        /* ── Gallery Section ── */
        .gallery-section {
            background: linear-gradient(160deg, #f0f4f8 0%, #e8eef5 100%);
            padding: 80px 0;
        }

        .gallery-section-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .gallery-section-header .eyebrow {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #4e8fbf;
            margin-bottom: 12px;
        }

        .gallery-section-header h2 {
            font-size: 2.4rem;
            font-weight: 800;
            color: #1a2a3a;
            margin-bottom: 14px;
            line-height: 1.2;
        }

        .gallery-section-header .divider {
            display: block;
            width: 56px;
            height: 4px;
            border-radius: 2px;
            background: linear-gradient(90deg, #4e8fbf, #7ab8d9);
            margin: 0 auto 16px;
        }

        .gallery-section-header p {
            color: #6b7c8d;
            font-size: 1.05rem;
            max-width: 480px;
            margin: 0 auto;
        }

        /* ── Grid ── */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 28px;
        }

        /* ── Card ── */
        .gallery-item {
            display: flex;
            flex-direction: column;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.03);
            transition: transform 0.4s cubic-bezier(0.25,0.8,0.25,1), box-shadow 0.4s ease;
            cursor: default;
        }

        .gallery-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1), 0 5px 15px rgba(0,0,0,0.05);
        }

        /* ── Card Image Area ── */
        .gallery-item-image {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 3;
            background: #e8eef5; /* fallback for broken images */
            overflow: hidden;
        }

        .gallery-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.6s cubic-bezier(0.25,0.8,0.25,1);
        }

        .gallery-item:hover .gallery-item-image img {
            transform: scale(1.05);
        }

        /* ── Card Content Area ── */
        .gallery-item-content {
            padding: 24px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            border-top: 1px solid rgba(0,0,0,0.03);
        }

        /* thin accent line above description */
        .gallery-item-content::before {
            content: '';
            display: block;
            width: 36px;
            height: 3px;
            border-radius: 2px;
            background: linear-gradient(90deg, #7ab8d9, #4e8fbf);
            margin-bottom: 16px;
        }

        /* ── Description typography ── */
        .gallery-item-content .description {
            color: #4a5568;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Style Summernote HTML output inside cards */
        .gallery-item-content .description p {
            margin: 0 0 8px;
            color: #4a5568;
        }

        .gallery-item-content .description p:last-child {
            margin-bottom: 0;
        }

        .gallery-item-content .description ul,
        .gallery-item-content .description ol {
            margin: 0 0 8px 0;
            padding-left: 20px;
        }

        .gallery-item-content .description li {
            color: #4a5568;
            margin-bottom: 4px;
            font-size: 0.9rem;
        }

        .gallery-item-content .description strong,
        .gallery-item-content .description b {
            color: #1a2a3a;
            font-weight: 700;
        }

        .gallery-item-content .description li:first-child {
            /* Treat the first list item like a title */
            font-size: 1.05rem;
            font-weight: 700;
            color: #1a2a3a;
            letter-spacing: 0.01em;
            list-style: none;
            margin-left: -20px;
            margin-bottom: 8px;
        }

        /* ── Truncation & See More ── */
        .gallery-item-content .description-preview {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 16px;
        }
        
        .see-more-link {
            font-size: 0.9rem;
            font-weight: 700;
            color: #4e8fbf;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: color 0.3s ease;
            margin-top: auto;
        }

        .see-more-link:hover {
            color: #1a2a3a;
            text-decoration: underline;
        }

        /* ── Modal Styling ── */
        .gallery-modal .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        
        .gallery-modal .modal-body {
            padding: 0;
        }
        
        .gallery-modal-layout {
            display: flex;
            flex-wrap: wrap;
        }
        
        .gallery-modal-image {
            flex: 1 1 50%;
            min-height: 400px;
            background: #e8eef5;
            position: relative;
        }
        
        .gallery-modal-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        .gallery-modal-text {
            flex: 1 1 50%;
            padding: 48px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .gallery-modal .btn-close-custom {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255,255,255,0.9);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 1.5rem;
            line-height: 1;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .gallery-modal .btn-close-custom:hover {
            transform: scale(1.1);
            background: #fff;
        }

        @media (max-width: 992px) {
            .gallery-modal-image, .gallery-modal-text {
                flex: 1 1 100%;
            }
            .gallery-modal-image {
                min-height: 300px;
                position: relative;
            }
            .gallery-modal-image img {
                position: relative;
            }
            .gallery-modal-text {
                padding: 32px;
                max-height: none;
            }
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
    <div class="gallery-section">
        <div class="container">
            <div class="gallery-section-header wow fadeInUp" data-wow-delay="0.2s">
                <span class="eyebrow">Our Community</span>
                <h2>Our Journey in Pictures</h2>
                <span class="divider"></span>
                <p>A glimpse into our dedication and growth.</p>
            </div>
            <div class="gallery-grid">
                @foreach($galleries as $gallery)
                <div class="gallery-item wow fadeInUp" data-wow-delay="{{ 0.1 * $loop->iteration }}s">
                    <div class="gallery-item-image">
                        <img src="{{ asset($gallery->image_path) }}" alt="Gallery Image" onerror="this.style.opacity='0'">
                    </div>
                    <div class="gallery-item-content">
                        <div class="description description-preview">
                            {!! $gallery->description !!}
                        </div>
                        <a href="javascript:void(0);" class="see-more-link" data-toggle="modal" data-bs-toggle="modal" data-target="#galleryModal{{ $gallery->id }}" data-bs-target="#galleryModal{{ $gallery->id }}">
                            See more &rarr;
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Gallery Modals -->
    @foreach($galleries as $gallery)
    <div class="modal fade gallery-modal" id="galleryModal{{ $gallery->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close-custom" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                <div class="modal-body">
                    <div class="gallery-modal-layout">
                        <div class="gallery-modal-image">
                            <img src="{{ asset($gallery->image_path) }}" alt="Gallery Image" onerror="this.style.opacity='0'">
                        </div>
                        <div class="gallery-modal-text">
                            <div class="gallery-item-content" style="border:none; padding:0;">
                                <div class="description">
                                    {!! $gallery->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- Gallery Section End -->
    @endif
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var previews = document.querySelectorAll('.description-preview');
            previews.forEach(function(preview) {
                // Check if the actual text height is larger than the visible container height
                // Add a small 2px buffer to account for subpixel rendering differences
                if (preview.scrollHeight <= preview.clientHeight + 2) {
                    var link = preview.nextElementSibling;
                    if (link && link.classList.contains('see-more-link')) {
                        link.style.display = 'none';
                        preview.style.marginBottom = '0'; // Remove extra gap if link is hidden
                    }
                }
            });
        });
    </script>
@endsection