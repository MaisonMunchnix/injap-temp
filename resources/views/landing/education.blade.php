@extends('layouts.landing.master')
@section('title', 'Education - Courses')
@section('page-title', 'INJAP - Education')

@section('stylesheets')
    <style>
        .course-card {
            height: 100%;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f0f0f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #e2e8f0;
        }

        .course-image-wrapper {
            position: relative;
            overflow: hidden;
            aspect-ratio: 16 / 9;
        }

        .course-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .course-card:hover .course-image {
            transform: scale(1.08);
        }

        .course-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .course-card:hover .course-image-overlay {
            opacity: 1;
        }

        .price-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: #ffffff;
            color: #1a202c;
            padding: 6px 14px;
            border-radius: 100px;
            font-weight: 800;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 2;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .course-category {
            position: absolute;
            top: 16px;
            left: 16px;
            background: var(--accent-color);
            color: #ffffff;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            z-index: 2;
        }

        .course-content {
            padding: 24px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .course-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1a202c;
            line-height: 1.4;
            transition: color 0.2s ease;
        }

        .course-card:hover .course-title {
            color: var(--accent-color);
        }

        .course-instructor {
            font-size: 0.85rem;
            color: #718096;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .course-instructor i {
            font-size: 1rem;
            margin-right: 6px;
            color: #a0aec0;
        }

        .course-description {
            color: #4a5568;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 24px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }

        .course-footer {
            margin-top: auto;
            border-top: 1px solid #f7fafc;
            padding-top: 20px;
        }

        .btn-view-course {
            width: 100%;
            background: var(--accent-color);
            color: #ffffff;
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            transition: all 0.2s ease;
            border: 2px solid var(--accent-color);
            display: inline-block;
            text-align: center;
        }

        .btn-view-course:hover {
            background: transparent;
            color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .btn-view-course:active {
            transform: translateY(0);
        }
    </style>
@endsection

@section('content')
    <!-- Page Header Start -->
    <div class="page-header parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header-box">
                        <h1 class="text-anime" style="color: white;">Educational Courses</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="our-articles">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Section Title Start -->
                    <div class="section-title text-center">
                        <h3 class="wow fadeInUp" data-wow-delay="0.25s">Our Courses</h3>
                        <h2 class="text-anime">Small Lessons. Big Progress.</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                @forelse ($courses as $course)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="course-card wow fadeInUp" data-wow-delay="0.50s">
                            <div class="course-image-wrapper">
                                <div class="course-category">Course</div>
                                <div class="price-badge">
                                    ₱{{ number_format($course->price ?? $course->suggested_price, 2) }}
                                </div>
                                <img src="{{ $course->cover_photo ? asset($course->cover_photo) : asset('new_landing/images/video-placeholder.jpg') }}"
                                    alt="{{ $course->title }}" class="course-image">
                                <div class="course-image-overlay"></div>
                            </div>
                            <div class="course-content">
                                <h3 class="course-title">{{ $course->title }}</h3>
                                <div class="course-instructor">
                                    <i class="fa fa-user-circle"></i>
                                    {{ $course->instructor ? $course->instructor->username : 'Administrator' }}
                                </div>
                                <div class="course-description">
                                    {!! strip_tags($course->description) !!}
                                </div>
                                <div class="course-footer">
                                    <a href="{{ route('login') }}" class="btn-view-course">Enroll Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="wow fadeInUp" data-wow-delay="0.50s">No published courses available at the moment. Please
                            check back later.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- additional scripts here --}}
@endsection