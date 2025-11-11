@extends('layouts.landing.master')
@section('title', 'Diamond Package')

@section('stylesheets')
    {{-- additional style here --}}

@endsection

@section('content')
    <section class="space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    <h2 class="h4">Diamond Package - Achieve the Highest Level</h2>
                    <p>For those who have big dreams and want to reach the very top, the Diamond Package is the best choice.
                        With this package, you don't just take part; you lead and achieve extraordinary success. Here's what
                        you get when you choose the Diamond Package:</p>
                    <h2 class="h4">Referral Bonus</h2>
                    <p>With the Diamond Package, you'll get a referral bonus of 750 PHP for every new member you introduce
                        to {{ env('app_name') }}. Your earnings can soar as you bring more people into this incredible
                        opportunity.</p>
                    <h2 class="h4">Pairing Bonus</h2>
                    <p>Enjoy a generous pairing bonus of 1,000 PHP for every successful pairing within your network. Your
                        network's success becomes your success.</p>

                    <p>Seize the opportunity to not just succeed but to excel, lead, and inspire. The Diamond Package is
                        your invitation to join an elite circle of achievers and carve a path to financial greatness that
                        few ever dare to tread.</p>

                    <p>Choose the package that aligns with your ambitions and aspirations. Whether you're starting small
                        with the Silver Package or aiming high with the Diamond Package, {{ env('app_name') }} is here
                        to support your journey towards financial empowerment and success.</p>
                </div>






                <div class="col-lg-4 mt-30 mt-lg-0">
                    <div class="project-box">
                        <h3 class="project-box__title h5">Package Information</h3>

                        <div class="project-box__item">

                            <div class="media-body"><span class="project-box__label">Package Inclusions:</span>
                            <h4 class="project-box__info">1x CAMU CAMU VITAMIN C (100 CAPS IN A BOTTLE) worth 1,200 PHP</h4>
                                <br>
                                <h4 class="project-box__info">3x LIVER LIVE PRO (30 CAPS IN BLISTER PACK) worth 1,000 PHP</h4>
                                <br>
                                <h4 class="project-box__info">1x MX PRO (MANGOSTEEN EXTRACT - 100 CAPS PER BOX IN BLISTER) worth 1,500 PHP</h4>
                                <br>
                                <h4 class="project-box__info">2x ENERGIZER COFFEE (10 SACHETS PER BOX) worth 1,000 PHP</h4>
                                <br>
                                <h4 class="project-box__info">1x PERFUME (MEN AND WOMEN) worth 800 PHP</h4>
                            </div>
                        </div>


                        <div class="project-box__item">

                            <div class="media-body"><span class="project-box__label">Package Price:</span>
                                <h4 class="project-box__info">7,500 PHP</h4>
                            </div>
                        </div>
                        <div class="project-box__item">

                            <div class="media-body"><span class="project-box__label">Referral Bonus:</span>
                                <h4 class="project-box__info">750 PHP</h4>
                            </div>
                        </div>
                        <div class="project-box__item">

                            <div class="media-body"><span class="project-box__label">Pairing Bonus:</span>
                                <h4 class="project-box__info">1000 PHP</h4>
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
