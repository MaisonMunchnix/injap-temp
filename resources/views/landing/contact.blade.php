@extends('layouts.landing.master')
@section('title', 'Contact Us')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    <section class="space-top space-extra-bottom">
        <div class="container">

            <div class="tab-content" id="nav-contactTabContent">
                <div class="tab-pane fade show active" id="nav-GermanyAddress" role="tabpanel"
                    aria-labelledby="nav-GermanyAddress-tab">
                    <div class="row">
                        <div class="col-lg-6 mb-30">
                            <div class="contact-box">
                                <h3 class="contact-box__title h4">Contact Information</h3>
                                <p class="contact-box__text">Join our growing community and experience the difference that
                                    our networking business can make in your life.</p>


                                <div class="contact-box__item">






                                    <div class="contact-box__icon"><i class="fal fa-phone-alt"></i></div>
                                    <div class="media-body">
                                        <h4 class="contact-box__label">Contact Number</h4>
                                        <p class="contact-box__info"><a>+81-595-51-6639</a>
                                        </p>
                                        <p class="contact-box__info"><a>+63-995-965-7236 </a>
                                        </p>
                                    </div>


                                </div>


                                <div class="contact-box__item">






                                    <div class="contact-box__icon"><i class="fal fa-envelope"></i></div>
                                    <div class="media-body">
                                        <h4 class="contact-box__label">Email Address</h4>
                                        <p class="contact-box__info"><a
                                                href="mailto:{{ config('mail.support.address') }}">{{ config('mail.support.address') }}</a>
                                        </p>
                                    </div>


                                </div>
                                <div class="contact-box__item">
                                    <div class="contact-box__icon"><i class="far fa-map-marker-alt"></i></div>
                                    <div class="media-body">
                                        <h4 class="contact-box__label">Our Office Address</h4>
                                        <p class="contact-box__info">518-0835 Japan Mie ken Midorigaoka Minami machi 3885-3
                                        </p>
                                        <br>
                                        <p class="contact-box__info">Purok 3 Brgy Fatima New Bataan Davao De Oro
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 mb-30">
                            <div class="contact-box">
                                <h3 class="contact-box__title h4">Leave a Message</h3>
                                <p class="contact-box__text">We’re Ready To Help You</p>
                                <form class="contact-box__form ajax-contact" action="" method="POST">
                                    <div class="row gx-20">
                                        <div class="col-md-6 form-group"><input type="text" name="name" id="name"
                                                placeholder="Your Name"> <i class="fal fa-user"></i></div>
                                        <div class="col-md-6 form-group">
                                            <input type="email" name="email" id="email" placeholder="Email Address">
                                            <i class="fal fa-envelope"></i>
                                        </div>
                                        <div class="col-12 form-group">
                                            <input type="text" name="subject" id="subject" placeholder="Subject"> <i
                                                class="fal fa-subject"></i>
                                        </div>
                                        <div class="col-12 form-group">
                                            <textarea name="message" id="message" placeholder="Type Your Message"></textarea>
                                        </div>
                                        <div class="col-12"><button class="vs-btn">Submit Message<i
                                                    class="far fa-arrow-right"></i></button></div>
                                    </div>
                                </form>
                                <p class="form-messages mb-0 mt-3"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-AustraliaAddress" role="tabpanel"
                    aria-labelledby="nav-AustraliaAddress-tab">
                    <div class="row">
                        <div class="col-lg-6 mb-30">
                            <div class="contact-box">
                                <h3 class="contact-box__title h4">Australia Office Address</h3>
                                <p class="contact-box__text">Completely recaptiualize 24/7 communities via standards
                                    compliant metrics whereas web-enabled content</p>
                                <div class="contact-box__item">
                                    <div class="contact-box__icon"><i class="fal fa-phone-alt"></i></div>
                                    <div class="media-body">
                                        <h4 class="contact-box__label">Phone Number & Email</h4>
                                        <p class="contact-box__info"><a href="tel:+310259121563">+(310) 2591 21563</a><a
                                                href="mailto:info@example.com">info@example.com</a></p>
                                    </div>
                                </div>
                                <div class="contact-box__item">
                                    <div class="contact-box__icon"><i class="far fa-map-marker-alt"></i></div>
                                    <div class="media-body">
                                        <h4 class="contact-box__label">Our Office Address</h4>
                                        <p class="contact-box__info">258 Dancing Street, Miland Line, HUYI 21563, Canberra
                                        </p>
                                    </div>
                                </div>
                                <div class="contact-box__item">
                                    <div class="contact-box__icon"><i class="far fa-clock"></i></div>
                                    <div class="media-body">
                                        <h4 class="contact-box__label">Official Work Time</h4>
                                        <p class="contact-box__info">7:00am - 6:00pm ( Mon - Fri ) Sat, Sun & Holiday Closed
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-30">
                            <div class="contact-box">
                                <h3 class="contact-box__title h4">Leave a Message</h3>
                                <p class="contact-box__text">We’re Ready To Help You</p>
                                <form class="contact-box__form ajax-contact2" action="" method="POST">
                                    <div class="row gx-20">
                                        <div class="col-md-6 form-group"><input type="text" name="name"
                                                id="name2" placeholder="Your Name"> <i class="fal fa-user"></i></div>
                                        <div class="col-md-6 form-group"><input type="email" name="email"
                                                id="email2" placeholder="Email Address"> <i
                                                class="fal fa-envelope"></i></div>
                                        <div class="col-12 form-group"><select name="subject" id="subject2">
                                                <option selected="selected" disabled="disabled" hidden>Select subject
                                                </option>
                                                <option value="Web Development">Web Development</option>
                                                <option value="UI Design">UI Design</option>
                                                <option value="CMS Development">CMS Development</option>
                                                <option value="Theme Development">Theme Development</option>
                                                <option value="Wordpress Development">Wordpress Development</option>
                                            </select></div>
                                        <div class="col-12 form-group">
                                            <textarea name="message" id="message2" placeholder="Type Your Message"></textarea>
                                        </div>
                                        <div class="col-12"><button class="vs-btn">Submit Message<i
                                                    class="far fa-arrow-right"></i></button></div>
                                    </div>
                                </form>
                                <p class="form-messages mb-0 mt-3"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="row">
                        <div class="col-lg-6 mb-30">
                            <div class="contact-box">
                                <h3 class="contact-box__title h4">United State Office Address</h3>
                                <p class="contact-box__text">Completely recaptiualize 24/7 communities via standards
                                    compliant metrics whereas web-enabled content</p>
                                <div class="contact-box__item">
                                    <div class="contact-box__icon"><i class="fal fa-phone-alt"></i></div>
                                    <div class="media-body">
                                        <h4 class="contact-box__label">Phone Number & Email</h4>
                                        <p class="contact-box__info"><a href="tel:+310259121563">+(310) 2591 21563</a><a
                                                href="mailto:info@example.com">info@example.com</a></p>
                                    </div>
                                </div>
                                <div class="contact-box__item">
                                    <div class="contact-box__icon"><i class="far fa-map-marker-alt"></i></div>
                                    <div class="media-body">
                                        <h4 class="contact-box__label">Our Office Address</h4>
                                        <p class="contact-box__info">258 Dancing Street, Miland Line, HUYI 21563, NewYork
                                        </p>
                                    </div>
                                </div>
                                <div class="contact-box__item">
                                    <div class="contact-box__icon"><i class="far fa-clock"></i></div>
                                    <div class="media-body">
                                        <h4 class="contact-box__label">Official Work Time</h4>
                                        <p class="contact-box__info">7:00am - 6:00pm ( Mon - Fri ) Sat, Sun & Holiday
                                            Closed</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-30">
                            <div class="contact-box">
                                <h3 class="contact-box__title h4">Leave a Message</h3>
                                <p class="contact-box__text">We’re Ready To Help You</p>
                                <form class="contact-box__form ajax-contact3"
                                    action="https://html.vecurosoft.com/techbiz/demo/mail.php" method="POST">
                                    <div class="row gx-20">
                                        <div class="col-md-6 form-group"><input type="text" name="name"
                                                id="name3" placeholder="Your Name"> <i class="fal fa-user"></i></div>
                                        <div class="col-md-6 form-group"><input type="email" name="email"
                                                id="email3" placeholder="Email Address"> <i
                                                class="fal fa-envelope"></i></div>
                                        <div class="col-12 form-group"><select name="subject" id="subject3">
                                                <option selected="selected" disabled="disabled" hidden>Select subject
                                                </option>
                                                <option value="Web Development">Web Development</option>
                                                <option value="UI Design">UI Design</option>
                                                <option value="CMS Development">CMS Development</option>
                                                <option value="Theme Development">Theme Development</option>
                                                <option value="Wordpress Development">Wordpress Development</option>
                                            </select></div>
                                        <div class="col-12 form-group">
                                            <textarea name="message" id="message3" placeholder="Type Your Message"></textarea>
                                        </div>
                                        <div class="col-12"><button class="vs-btn">Submit Message<i
                                                    class="far fa-arrow-right"></i></button></div>
                                    </div>
                                </form>
                                <p class="form-messages mb-0 mt-3"></p>
                            </div>
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
