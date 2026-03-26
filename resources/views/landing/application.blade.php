@extends('layouts.landing.master')
@section('title', 'INJAP - Innovation Japan | Application')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
     <!-- Subpage Section Start -->
    <div class="page-header parallaxie contact-us-hero">
        <div class="container">
            <div class="row">
                <div class="co-md-12">
                    <!-- Sub page Header start -->
                    <div class="page-header-box">
                        <h1 class="text-anime">Application Form</h1>
                        
                    </div>
                    <!-- Sub page Header end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Subpage Section End -->

    <!-- Contact Us Section Start -->
    <div class="contact-us-section">
        <div class="container">
            <div class="row">
                <!-- Contact Info Box start -->
                <div class="col-lg-4 col-md-12">
                    <div class="contact-info-box wow fadeInUp" data-wow-delay="0.25s">
                        <div class="contact-info-icon">
                            <img src="{{ asset('new_landing/images/icon-location.svg')}}" alt="">
                        </div>
                        <div class="contact-info-body">
                            <h2>Address</h2>
                            <p>518-0225 Japan Mie-ken, Iga Shi, Kirigaoka 3Chome 212</p>
                        </div>
                    </div>
                </div>
                <!-- Contact Info Box end -->

                <!-- Contact Info Box start -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-box wow fadeInUp" data-wow-delay="0.50s">
                        <div class="contact-info-icon">
                            <img src="{{ asset('new_landing/images/icon-phone.svg')}}" alt="">
                        </div>
                        <div class="contact-info-body">
                            <h2>Phone Number</h2>
                            <p>
                                <a href="tel:0595518190">0595518190</a><br>
                               
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Contact Info Box end -->

                <!-- Contact Info Box start -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-box wow fadeInUp" data-wow-delay="0.75s">
                        <div class="contact-info-icon">
                            <img src="{{ asset('new_landing/images/icon-mail.svg')}}" alt="">
                        </div>
                        <div class="contact-info-body">
                            <h2>E-mail Address</h2>
                            <p>
                                <a href="#">innovationjapan3@gmail.com</a>
                        
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Contact Info Box end -->
            </div>
        </div>
    </div>
    <!-- Contact Us Section End -->

    <!-- Get In Touch Section Start -->
    <div class="get-in-touch">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <!-- Section Title start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp" data-wow-delay="0.25s">Application Form</h3>
                        <h2 class="text-anime">Join Our United Community</h2>
                    </div>
                    <!-- Section Title end -->

                    <!-- Get In Touch start -->
                    <div class="get-in-touch-body wow fadeInUp" data-wow-delay="0.50s">
                        <p>Take the first step toward a more secure and prosperous future by becoming a valued member of Innovation Japan.</p>

                        <br>
                    </div>
                    <!-- Get In Touch end -->
                </div>

                <div class="col-lg-12">
                    <!-- Contact Form Start -->
                    <div class="contact-form wow fadeInUp" data-wow-delay="0.75s">
                        <form id="applicationForm" onsubmit="return false;">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">

                                       <label for="name" class="form-placeholder">Name</label>

                                    <input type="text" class="form-control" id="name" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group  col-md-6 mb-3">
                                      <label for="username" class="form-placeholder">Username</label>
                                    <input type="text" class="form-control" id="username" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group  col-md-6 mb-3">
                                      <label for="email" class="form-placeholder">Email Address</label>
                                    <input type="email" class="form-control" id="email"  required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                     <label for="birthday" class="form-placeholder">Contact Number</label>
                                    <input type="text" class="form-control" id="phone"  required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group  col-md-6 mb-3">
                                      <label for="birthday" class="form-placeholder">Country</label>
                                    <input type="text" class="form-control" id="country"  required>
                                    <div class="help-block with-errors"></div>
                                </div>


                         <div class="form-group col-md-6 mb-3">
                              <label for="birthday" class="form-placeholder">Birthday</label>
                <input type="date" class="form-control" id="birthday" required onfocus="this.showPicker()">
              
                <div class="help-block with-errors"></div>
            </div>


                                <div class="form-group  col-md-6 mb-3">
                                        <label for="sponsor_id" class="form-placeholder">Sponsor ID</label>
                                    <input type="text" class="form-control" id="sponsor_id" placeholder="Enter your sponsor's ID">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="member_type" class="form-placeholder">Member Type</label>
                                    <select class="form-control" id="member_type" required>
                                        <option value="">Select Member Type</option>
                                        @foreach($packages as $package)
                                            <option value="{{ $package->type }}">{{ $package->type }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                                <label for="address" class="form-placeholder">Address</label>
                                    <textarea class="form-control" id="address" rows="4" required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>


                                <div class="form-group col-md-12 mb-3">
                    <label class="form-placeholder">Terms and Conditions</label>
                    <div class="pdf-viewer mb-3">
                        <iframe src="{{ asset('new_landing/injap.pdf')}}" width="100%" height="400px" style="border:1px solid #ccc; border-radius:10px;"></iframe>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                        <label class="form-check-label" for="agreeTerms">
                            I have read and accept the Terms and Conditions.
                        </label>
                    </div>
                </div>

                                <div class="form-group col-md-12 mb-3">
                    <label for="proofOfPayment" class="form-placeholder">Proof of Payment <span class="text-danger">*</span></label>
                    <small class="d-block text-muted mb-2">Upload a screenshot or document showing your payment (PDF, JPG, PNG)</small>
                    <div class="custom-file-upload">
                        <input type="file" class="form-control" id="proofOfPayment" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div id="fileInfo" class="mt-2" style="display: none;">
                        <small class="text-success"><i class="fas fa-check-circle"></i> File selected: <span id="fileName"></span></small>
                    </div>
                </div>


                                <div class="col-md-12">
                                    <button type="button" id="submitBtn" class="btn-default">Submit Now</button>
                                    <div id="msgSubmit" class="h3 text-left hidden"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Contact Form End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Get In Touch Section End -->

    <!-- Google Map Start -->
   
    <!-- Google Map End -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            console.log('Application form script loaded');
            
            // Handle file upload
            $('#proofOfPayment').change(function(e) {
                var file = e.target.files[0];
                if (file) {
                    var allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
                    
                    if (!allowedTypes.includes(file.type)) {
                        alert('Invalid file type. Please upload PDF, JPG, or PNG.');
                        $(this).val('');
                        $('#fileInfo').hide();
                        return;
                    }
                    
                    $('#fileName').text(file.name);
                    $('#fileInfo').show();
                } else {
                    $('#fileInfo').hide();
                }
            });
            
            $('#submitBtn').click(function(e) {
                e.preventDefault();
                console.log('Submit button clicked');
                
                var name = $('#name').val();
                var username = $('#username').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var country = $('#country').val();
                var birthday = $('#birthday').val();
                var sponsor_id = $('#sponsor_id').val();
                var address = $('#address').val();
                var member_type = $('#member_type').val();
                var agreeTerms = $('#agreeTerms').is(':checked');
                var proofOfPaymentFile = $('#proofOfPayment')[0].files[0];

                console.log('Form data:', {
                    name: name,
                    username: username,
                    email: email,
                    phone: phone,
                    country: country,
                    birthday: birthday,
                    sponsor_id: sponsor_id,
                    address: address,
                    member_type: member_type,
                    agreeTerms: agreeTerms,
                    proofOfPaymentFile: proofOfPaymentFile ? proofOfPaymentFile.name : 'none'
                });

                if (!name || !username || !email || !phone || !country || !birthday || !address || !member_type || !agreeTerms) {
                    alert("Please fill all required fields");
                    return;
                }

                if (!proofOfPaymentFile) {
                    alert("Please upload your Proof of Payment before submitting");
                    return;
                }

                // Disable submit button to prevent multiple submissions
                $('#submitBtn').prop('disabled', true).text('Submitting...');

                // Use FormData to send file
                var formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('name', name);
                formData.append('username', username);
                formData.append('email', email);
                formData.append('phone', phone);
                formData.append('country', country);
                formData.append('birthday', birthday);
                formData.append('sponsor_id', sponsor_id);
                formData.append('address', address);
                formData.append('member_type', member_type);
                formData.append('agreeTerms', agreeTerms ? 1 : 0);
                formData.append('proof_of_payment', proofOfPaymentFile);

                $.ajax({
                    url: '{{ route("landing.application.submit") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('Success response:', response);
                        if (response.success) {
                            alert(response.message);
                            // Reset form
                            $('#applicationForm')[0].reset();
                            $('#fileInfo').hide();
                            $('#submitBtn').prop('disabled', false).text('Submit Now');
                        } else {
                            alert('Error: ' + response.message);
                            $('#submitBtn').prop('disabled', false).text('Submit Now');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error response:', xhr);
                        var errorMessage = 'An error occurred. Please try again.';
                        
                        // Handle validation errors
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            var errorList = [];
                            $.each(errors, function(field, messages) {
                                errorList.push(field + ': ' + messages[0]);
                            });
                            errorMessage = errorList.join('\n');
                        } 
                        // Handle server errors
                        else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.statusText) {
                            errorMessage = xhr.statusText;
                        }
                        
                        console.error('AJAX Error:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            message: errorMessage,
                            response: xhr.responseJSON
                        });
                        alert('Error: ' + errorMessage);
                        $('#submitBtn').prop('disabled', false).text('Submit Now');
                    }
                });
            });
        });
    </script>
@endsection
