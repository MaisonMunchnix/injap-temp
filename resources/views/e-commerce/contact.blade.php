@extends('layouts.guest.master')
@section('title','Purple Life Organic Products - Contact Us')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="css/loader.css">
@endsection

@section('content')
<div class="contact_map pt-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">


                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.664983201382!2d121.0543048148405!3d14.618150789791363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b7ea86b7ddc5%3A0xc01d13cfdce576a2!2sSpark%20Place!5e0!3m2!1sen!2sph!4v1580971340834!5m2!1sen!2sph" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen=""></iframe>


            </div>
        </div>

    </div>
</div>
<!--contact map end-->

<!--contact area start-->
<div class="contact_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="contact_message content">
                    <h3>contact us</h3>
                    <p>If you have a question, see our frequently asked questions and requests that may help you prior to contacting us.</p>
                    <ul>
                        <li><i class="fa fa-fax"></i>  Address : Unit 318-9 3rd Floor SPARK Place, P. Tuazon Blvd., Brgy. Socorro, Cubao, Quezon City, Philippines</li>
                        <li><i class="fa fa-phone"></i>  (632) 397-8255</li>
                        <li><i class="fa fa-envelope-o"></i> <a href="#">info@purplelifeorganics.com</a></li>

                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="contact_message form">
                    <h3>Send Feedback</h3>
                    <form id="contact-us-form" method="POST"  action="">
                        <p>
                            <label> Your Name (required)</label>
                            <input name="name" placeholder="Name *" type="text" required>
                        </p>
                        <p>
                            <label>  Your Email (required)</label>
                            <input name="email" placeholder="Email *" type="email" required>
                        </p>
                        <p>
                            <label>  Subject</label>
                            <input name="subject" placeholder="Subject *" type="text" required>
                        </p>
                        <div class="contact_textarea">
                            <label>  Your Message</label>
                            <textarea placeholder="Message *" name="message"  class="form-control2" required></textarea>
                        </div>
                        <button type="submit"> Send</button>
                        <p class="form-messege"></p>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="send-loading"></div>
</div>
@endsection

@section('scripts')
    <script src="js/sweetalert.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#contact-us-form').submit(function (event) {
                event.preventDefault();
                var form_data=new FormData(this);
                $.ajax({
                    url: 'contact-us-email',
                    type: 'POST',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('.send-loading').show();
                    },
                    success: function (response) {
                        console.log('Email sent success...');
                        $('.send-loading').hide();
                        swal({
                            title: 'Success!',
                            text: 'Message successfullly to purple email. Thank you.',
                            type: "success",
                        }, function () {
                            location.reload();
                        });

                    },
                    error: function (error) {
                        console.log('Error...');
                        console.log(error);
                        console.log(error.responseJSON.message);
                        $('.send-loading').hide();
                        swal({
                            title: "",
                            text: "Oops something went wrong. Please try again later",
                            type: "error",
                        });
                    }
                });
            });
        });
    </script>
@endsection