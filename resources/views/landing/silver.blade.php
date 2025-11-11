@extends('layouts.landing.master')
@section('title', 'WGC Membership')

@section('stylesheets')
    {{-- additional style here --}}

@endsection

@section('content')
    <section class="space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    <h2 class="h4">WGC Membership - Empower Your Start</h2>
                    <p>Unlock your journey to financial freedom with our WGC Membership, designed for those who
                        are willing to help mission works by insuring friends and family to protect their day to day life
                        due to accident and ready to take their first steps towards success. Here's what you can expect:</p>
                    <h2 class="h4">Referral Bonus</h2>
                    <p>Earn a referral bonus of 250 PHP for every new member you introduce to . This is your chance to start
                        building your network and earning rewards right from the beginning.</p>
                    <h2 class="h4">Pairing Bonus</h2>
                    <p>As a WGC Membership holder, you'll enjoy a pairing bonus of 350 PHP for every successful
                        pairing within your network. Watch your earnings grow as you help others succeed.</p>


                    <h2 class="h4">Insurance</h2>

                    <p>As a WGC Membership holder, you'll enjoy an Annual Personal Accident Insurance coverage of
                        up to 75k PHP . And you can also insured your family member. Watch your earnings grow as you help
                        others succeed.</p>

                    <p>Take the first step towards financial independence today with our WGC Membership.</p>

                    <p>Choose the package that aligns with your ambitions and aspirations. Whether you're starting small
                        with the WGC Membership or aiming high with the Diamond Package, {{ env('app_name') }} is
                        here
                        to support your journey towards financial empowerment and success.</p>
                </div>
                <div class="col-lg-4 mt-30 mt-lg-0">
                    <div class="project-box">
                        <h3 class="project-box__title h5">Package Information</h3>
                        <div class="project-box__item">

                            <div class="media-body"><span class="project-box__label">Package Inclusions:</span>
                                <h4 class="project-box__info">Accident Insurance worth 75,000 PHP</h4>
                            </div>
                        </div>
                        <div class="project-box__item">

                            <div class="media-body"><span class="project-box__label">Package Price:</span>
                                <h4 class="project-box__info">2,500 PHP</h4>
                            </div>
                        </div>
                        <div class="project-box__item">

                            <div class="media-body"><span class="project-box__label">Referral Bonus:</span>
                                <h4 class="project-box__info">250 PHP</h4>
                            </div>
                        </div>
                        <div class="project-box__item">

                            <div class="media-body"><span class="project-box__label">Pairing Bonus:</span>
                                <h4 class="project-box__info">350 PHP</h4>
                            </div>
                        </div>

                    </div>
                    <div class="project-contact" data-bg-src="{{ asset('landing/img/bg/sidebox-bg-1-1.jpg') }}">
                        <h3 class="project-contact__title h5">Need Any Help?</h3>
                        <p class="project-contact__text">Need Any Help, Call Us 24/7 For Support</p>
                        <p class="project-contact__info"><i class="fas fa-phone-alt"></i><a
                                href="tel:+63-995-965-7236">+63-995-965-7236</a></p>

                        <p class="project-contact__info"><i class="fas fa-envelope"></i><a
                                href="mailto:{{ config('mail.support.address') }}">{{ config('mail.support.address') }}</a>
                        </p>
                        <p class="project-contact__info"><i class="fas fa-map-marker-alt"></i>518-0835 Japan Mie ken
                            Midorigaoka Minami machi 3885-3</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    {{-- additional scripts here --}}
@endsection
