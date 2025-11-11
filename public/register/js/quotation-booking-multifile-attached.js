document.addEventListener("touchstart", function() {}, false);
(function($) {
    "use strict";
    $(function() {
        var randNumber_1 = parseInt(Math.ceil(Math.random() * 15), 10);
        var randNumber_2 = parseInt(Math.ceil(Math.random() * 15), 10);
        humanCheckCaptcha(randNumber_1, randNumber_2);
    });

    function humanCheckCaptcha(randNumber_1, randNumber_2) {
        $("#humanCheckCaptchaBox").html("Solve The Math ");
        $("#firstDigit").html('<input name="mathfirstnum" id="mathfirstnum" class="form-control" type="text" value="' + randNumber_1 + '" readonly>');
        $("#secondDigit").html('<input name="mathsecondnum" id="mathsecondnum" class="form-control" type="text" value="' + randNumber_2 + '" readonly>');
    }
    $(function() {
        $('#preferred-date input').datepicker({
            format: "dd MM, yyyy",
            startDate: "0d",
            todayBtn: "linked",
            todayHighlight: true,
            autoclose: true
        });
    });
    $("#service-quotation-price-box a.close").click(function() {
        $(".service-quotation-price-box-wrap").slideToggle("slow");
        return false;
    });
    $("a.quotationpricesidebarclose").click(function() {
        $(".service-quotation-price-sidebar-wrap").slideToggle("slow");
        return false;
    });

    function updateTotalAmount() {
        var propertysize = $('input[name=propertysize]:checked').val();
        if (propertysize) var propertysizeprice = propertysize.split('|')[1];
        else
            var propertysizeprice = 0;
        var servicetype = $('input[name=servicetype]:checked').val();
        if (servicetype == "Residential") {
            var bedrooms = $('input[name=bedrooms]:checked').val();
            if (bedrooms) var bedroomsprice = bedrooms.split('|')[1];
            else
                var bedroomsprice = 0;
            var bathrooms = $('input[name=bathrooms]:checked').val();
            if (bathrooms) var bathroomsprice = bathrooms.split('|')[1];
            else
                var bathroomsprice = 0;
            var bathtubs = $('input[name=bathtubs]:checked').val();
            if (bathtubs) var bathtubsprice = bathtubs.split('|')[1];
            else
                var bathtubsprice = 0;
            var sittingroom = $('input[name=sittingroom]:checked').val();
            if (sittingroom) var sittingroomprice = sittingroom.split('|')[1];
            else
                var sittingroomprice = 0;
            var residentialpartprice = parseFloat(bedroomsprice) + parseFloat(bathroomsprice) + parseFloat(bathtubsprice) + parseFloat(sittingroomprice);
        } else {
            var rooms = $('input[name=rooms]:checked').val();
            if (rooms) var roomsprice = rooms.split('|')[1];
            else
                var roomsprice = 0;
            var conferenceroom = $('input[name=conferenceroom]:checked').val();
            if (conferenceroom) var conferenceroomprice = conferenceroom.split('|')[1];
            else
                var conferenceroomprice = 0;
            var storerooms = $('input[name=storerooms]:checked').val();
            if (storerooms) var storeroomsprice = storerooms.split('|')[1];
            else
                var storeroomsprice = 0;
            var washrooms = $('input[name=washrooms]:checked').val();
            if (washrooms) var washroomsprice = washrooms.split('|')[1];
            else
                var washroomsprice = 0;
            var commertialpartprice = parseFloat(roomsprice) + parseFloat(conferenceroomprice) + parseFloat(storeroomsprice) + parseFloat(washroomsprice);
        }
        if (!residentialpartprice) residentialpartprice = 0;
        if (!commertialpartprice) commertialpartprice = 0;
        var diningroom = $('input[name=diningroom]:checked').val();
        if (diningroom) var diningroomprice = diningroom.split('|')[1];
        else
            var diningroomprice = 0;
        var kitchen = $('input[name=kitchen]:checked').val();
        if (kitchen) var kitchenprice = kitchen.split('|')[1];
        else
            var kitchenprice = 0;
        var oven = $('input[name=oven]:checked').val();
        if (oven) var ovenprice = oven.split('|')[1];
        else
            var ovenprice = 0;
        var kitchenitem = 0;
        $('.validkitchenitems input[type=checkbox]:checked').each(function() {
            var kivalues = $(this).val();
            if (kivalues) var kiprice = parseFloat(kivalues.split('|')[1]);
            kitchenitem = parseFloat(kitchenitem + kiprice);
        });
        var kitchenitemsprice = kitchenitem;
        var totalamount = parseFloat(propertysizeprice) + parseFloat(residentialpartprice) + parseFloat(commertialpartprice) + parseFloat(diningroomprice) + parseFloat(kitchenprice) + parseFloat(ovenprice) + parseFloat(kitchenitemsprice);
        totalamount = totalamount.toFixed(2);
        $('#selecteditemprice').val(totalamount);
        var servicetaxpercentage = $('#servicetaxpercentage').val();
        if (servicetaxpercentage) {
            var totalamountTax = totalamount * servicetaxpercentage / 100;
            totalamountTax = totalamountTax.toFixed(2);
            $('#servicetax').val(totalamountTax);
        }
        var frequencycleaning = $('input[name=frequencycleaning]:checked').val();
        if (frequencycleaning) {
            var discountprice = frequencycleaning.split('|')[1];
            var commissionprice = totalamount * discountprice / 100;
            commissionprice = commissionprice.toFixed(2);
            $('#commissionprice').val(commissionprice);
        } else
            var commissionprice = $('#commissionprice').val();
        var subtotalprice = (parseFloat(totalamount) + parseFloat(totalamountTax)) - parseFloat(commissionprice);
        subtotalprice = subtotalprice.toFixed(2);
        $('#subtotalprice').val(subtotalprice);
    }
    $(function() {
        $("#QuoteForm").on('focus', ':input', function() {});
        $("input[name='propertysize']").on("click", function() {
            updateTotalAmount();
        });
        $("input[name='bedrooms']").on("click", function() {
            updateTotalAmount();
        });
        $("input[name='bathrooms']").on("click", function() {
            updateTotalAmount();
        });
        $("input[name='bathtubs']").on("click", function() {
            updateTotalAmount();
        });
        $("input[name='sittingroom']").on("click", function() {
            updateTotalAmount();
        });
        $("input[name='rooms']").on("click", function() {
            updateTotalAmount();
        });
        $("input[name='conferenceroom']").on("click", function() {
            updateTotalAmount();
        });
        $("input[name='storerooms']").on("click", function() {
            updateTotalAmount();
        });
        $("input[name='washrooms']").on("click", function() {
            updateTotalAmount();
        });
        $("input[name='diningroom']").on("click", function() {
            updateTotalAmount();
        });
        $("input[name='kitchen']").on("click", function() {
            updateTotalAmount();
        });
        $("input[name='oven']").on("click", function() {
            updateTotalAmount();
        });
        $('.validkitchenitems input[type=checkbox]').on('change', function() {
            updateTotalAmount();
        });
        $("input[name='frequencycleaning']").on("click", function() {
            updateTotalAmount();
        });
    });
    $("#QuoteForm").validator().on("submit", function(event) {
        if (event.isDefaultPrevented()) {
            formError();
            submitMSG(false, "Please fill in the form properly!");
            sweetAlert("Oops...", "Please fill in the form properly!!!", "error");
        } else {
            var mathPart_1 = parseInt($("#mathfirstnum").val(), 10);
            var mathPart_2 = parseInt($("#mathsecondnum").val(), 10);
            var correctMathSolution = parseInt((mathPart_1 + mathPart_2), 10);
            var inputHumanAns = $("#humanCheckCaptchaInput").val();
            if (inputHumanAns == correctMathSolution) {
                event.preventDefault();
                submitForm();
            } else {
                submitMSG(false, "Please solve Human Captcha!!!");
                sweetAlert("Oops...", "Please solve Human Captcha!!!", "error");
                return false;
            }
        }
    });

    function submitForm() {
        var form_data = new FormData($("#QuoteForm")[0]);
        form_data.append('file', form_data);
        $('#processing-image').show();
        $('#final-step-buttons').hide();
        $.ajax({
            type: "POST",
            url: "booking-cond-multifile-process.php",
            data: form_data,
            processData: false,
            contentType: false,
            success: function(text) {
                if (text === "success") {
                    formSuccess();
                } else {
                    formError();
                    submitMSG(false, text);
                    sweetAlert("Oops...", text, "error");
                }
            },
            complete: function() {
                $('#processing-image').hide();
                $('#final-step-buttons').show();
            }
        });
    }
    $(function() {
        $(document).on('change', ':file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });
        $(':file').on('fileselect', function(event, numFiles, label) {
            var input = $(this).parents('.form-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;
            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }
        });
    });

    function formSuccess() {
        $("#QuoteForm")[0].reset();
        $("#section-5 #lastsection-laststep").addClass("active");
        submitMSG(true, "Your Booking Request Submitted Successfully!!!");
        swal("Good job!", "Your Booking Request Submitted Successfully!!!");
    }

    function formError() {
        $(".help-block.with-errors").removeClass('hidden');
    }

    function submitMSG(valid, msg) {
        if (valid) {
            var msgClasses = "h3 text-center text-success";
            $("#final-step-buttons").html('<div class="h3 text-center text-success"> Tahnk you for your concern Booking. We will get back to you soon!</div>');
        } else {
            var msgClasses = "h3 text-center text-danger";
        }
        $("#mgsContactSubmit").removeClass().addClass(msgClasses).text(msg);
    }
})(jQuery);

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
$(function() {
    $("#residential-services-box").css('display', 'none');
    $("#commercial-services-box").css('display', 'none');
    $("input[name='servicetype']").on("click", function() {
        var servicetype = $('input[name=servicetype]:checked').val();
        if (servicetype == "Residential") {
            $("#residential-services-box").css('display', 'block');
            $("#commercial-services-box").css('display', 'none');
        } else {
            $("#commercial-services-box").css('display', 'block');
            $("#residential-services-box").css('display', 'none');
        }
    });
});

function nextStep2() {
    var cleaningtype = $('input[name=cleaningtype]:checked').val();
    var propertyaddress = $("#propertyaddress").val();
    //if (cleaningtype) $(".validcleaningtype .help-block.with-errors").html('');
    //else
      //  $(".validcleaningtype .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Cleaning Type</li></ul>');
    if (propertyaddress) $(".validpropertyaddress .help-block.with-errors").html('');
    else
        $(".validpropertyaddress .help-block.with-errors").html('<ul class="list-unstyled"><li>Please enter Activation Code</li></ul>');
    if (propertyaddress.length > 0 && propertyaddress) {
        $("#section-1 .help-block.with-errors").html('');
        $("#section-1").removeClass("open");
        $("#section-1").addClass("slide-left");
        $("#section-2").removeClass("slide-right");
        $("#section-2").addClass("open");
    } else {
        $("#section-1 .help-block.with-errors.mandatory-error").html('<ul class="list-unstyled"><li>Please Fill the Form Properly!!!</li></ul>');
        sweetAlert("Oops...", "Please Fill the Form Properly!!!", "error");
    }
}

function previousStep1() {
    $("#section-1").removeClass("slide-left");
    $("#section-1").addClass("open");
    $("#section-2").removeClass("open");
    $("#section-2").addClass("slide-right");
}

function nextStep3() {
    var frequencycleaning = $('input[name=frequencycleaning]:checked').val();
    var preferredtime = $('input[name=preferredtime]:checked').val();
    var priority = $('input[name=priority]:checked').val();
    var preferreddate = $("#preferreddate").val();
    var preferredday = '';
    //$('.validpreferreddays input[type=checkbox]:checked').each(function() {
      //  var pdvalues = $(this).val();
        //preferredday += pdvalues + ', ';
//    });
    var preferreddays = preferredday.slice(0, -2);
    if (frequencycleaning) $(".validfrequencycleaning .help-block.with-errors").html('');
    else
        $(".validfrequencycleaning .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Frequency of Cleaning</li></ul>');
    if (preferreddays) $(".validpreferreddays .help-block.with-errors").html('');
    //else
      //  $(".validpreferreddays .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Preferred Day(s)</li></ul>');
    if (preferredtime) $(".validpreferredtime .help-block.with-errors").html('');
    else
        $(".validpreferredtime .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Preferred Time</li></ul>');
    if (priority) $(".validpriority .help-block.with-errors").html('');
    else
        $(".validpriority .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Priority</li></ul>');
    if (preferreddate) $(".validpreferreddate .help-block.with-errors").html('');
    else
        $(".validpreferreddate .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Preferred Date</li></ul>');
    if (frequencycleaning && preferredtime && priority && preferreddate) {
        $("#section-2 .help-block.with-errors.mandatory-error").html('');
        $("#section-2").removeClass("open");
        $("#section-2").addClass("slide-left");
        $("#section-3").removeClass("slide-right");
        $("#section-3").addClass("open");
    } else {
        $("#section-2 .help-block.with-errors.mandatory-error").html('<ul class="list-unstyled"><li>Please Fill the Form Properly!!!</li></ul>');
        sweetAlert("Oops...", "Please Fill the Form Properly!!!", "error");
    }
}

function previousStep2() {
    $("#section-2").removeClass("slide-left");
    $("#section-2").addClass("open");
    $("#section-3").removeClass("open");
    $("#section-3").addClass("slide-right");
}

function nextStep4() {
    var frequencycleaning = $('input[name=frequencycleaning]:checked').val();
    var preferredtime = $('input[name=preferredtime]:checked').val();
    var priority = $('input[name=priority]:checked').val();
    var preferreddate = $("#preferreddate").val();
    var preferredday = '';
    $('.validpreferreddays input[type=checkbox]:checked').each(function() {
        var pdvalues = $(this).val();
        preferredday += pdvalues + ', ';
    });
    var preferreddays = preferredday.slice(0, -2);
    if (frequencycleaning) $(".validfrequencycleaning .help-block.with-errors").html('');
    else
        $(".validfrequencycleaning .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Frequency of Cleaning</li></ul>');
    if (preferreddays) $(".validpreferreddays .help-block.with-errors").html('');
    else
        $(".validpreferreddays .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Preferred Day(s)</li></ul>');
    if (preferredtime) $(".validpreferredtime .help-block.with-errors").html('');
    else
        $(".validpreferredtime .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Preferred Time</li></ul>');
    if (priority) $(".validpriority .help-block.with-errors").html('');
    else
        $(".validpriority .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Priority</li></ul>');
    if (preferreddate) $(".validpreferreddate .help-block.with-errors").html('');
    else
        $(".validpreferreddate .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Preferred Date</li></ul>');
    if (frequencycleaning && preferreddays && preferredtime && priority && preferreddate) {
        $("#section-3 .help-block.with-errors.mandatory-error").html('');
        $("#section-3").removeClass("open");
        $("#section-3").addClass("slide-left");
        $("#section-4").removeClass("slide-right");
        $("#section-4").addClass("open");
    } else {
        $("#section-3 .help-block.with-errors.mandatory-error").html('<ul class="list-unstyled"><li>Please Fill the Form Properly!!!</li></ul>');
        sweetAlert("Oops...", "Please Fill the Form Properly!!!", "error");
    }
}

function previousStep3() {
    $("#section-3").removeClass("slide-left");
    $("#section-3").addClass("open");
    $("#section-4").removeClass("open");
    $("#section-4").addClass("slide-right");
}

function nextStep5() {
    var cleaningtype = $('input[name=cleaningtype]:checked').val();
    var propertyaddress = $("#propertyaddress").val();
    var propertysize = $('input[name=propertysize]:checked').val().split('|')[0];
    var servicetype = $('input[name=servicetype]:checked').val();
    if (servicetype == "Residential") {
        var bedrooms = $('input[name=bedrooms]:checked').val().split('|')[0];
        var bathrooms = $('input[name=bathrooms]:checked').val().split('|')[0];
        var bathtubs = $('input[name=bathtubs]:checked').val().split('|')[0];
        var sittingroom = $('input[name=sittingroom]:checked').val().split('|')[0];
    } else {
        var rooms = $('input[name=rooms]:checked').val().split('|')[0];
        var conferenceroom = $('input[name=conferenceroom]:checked').val().split('|')[0];
        var storerooms = $('input[name=storerooms]:checked').val().split('|')[0];
        var washrooms = $('input[name=washrooms]:checked').val().split('|')[0];
    }
    var diningroom = $('input[name=diningroom]:checked').val().split('|')[0];
    var kitchen = $('input[name=kitchen]:checked').val().split('|')[0];
    var oven = $('input[name=oven]:checked').val().split('|')[0];
    var kitchenitem = '';
    $('.validkitchenitems input[type=checkbox]:checked').each(function() {
        var kivalues = $(this).val().split('|')[0];
        kitchenitem += kivalues + ', ';
    });
    var kitchenitems = kitchenitem.slice(0, -2);
    var frequencycleaning = $('input[name=frequencycleaning]:checked').val().split('|')[0];
    var preferredday = '';
    $('.validpreferreddays input[type=checkbox]:checked').each(function() {
        var pdvalues = $(this).val();
        preferredday += pdvalues + ', ';
    });
    var preferreddays = preferredday.slice(0, -2);
    var preferredtime = $('input[name=preferredtime]:checked').val();
    var priority = $('input[name=priority]:checked').val();
    var preferreddate = $("#preferreddate").val();
    var requirementdetails = $("#requirementdetails").val();
    var additionalinfo = $("#additionalinfo").val();
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var gender = $("#gender").val();
    var address = $("#address").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var attachedFile = $("#attachedFile").val();
    var preferedcontact = $('input[name=preferedcontact]:checked').val();
    var validemail = isEmail(email);
    var serviceprice = $("#selecteditemprice").val();
    var servicetax = $("#servicetax").val();
    var commissionprice = $("#commissionprice").val();
    var servicesubtotalprice = $("#subtotalprice").val();
    $("#cleaningtypeData").html('<strong>Selected Cleaning Type:</strong> ' + cleaningtype);
    $("#propertyaddressData").html('<strong>Property Address:</strong> ' + propertyaddress);
    $("#propertysizeData").html('<strong>ProPerty Size (sq. ft.):</strong> ' + propertysize);
    $("#servicetypeData").html('<strong>Selected Property Type:</strong> ' + servicetype);
    if (servicetype == "Residential") {
        $("#bedroomsData").html('<strong>Bedrooms:</strong> ' + bedrooms);
        $("#bathroomsData").html('<strong>Bathrooms:</strong> ' + bathrooms);
        $("#bathtubsData").html('<strong>Bath Tubs:</strong> ' + bathtubs);
        $("#sittingroomData").html('<strong>Guest Room:</strong> ' + sittingroom);
        $("#roomsData").html('');
        $("#conferenceroomData").html('');
        $("#storeroomsData").html('');
        $("#washroomsData").html('');
    } else {
        $("#roomsData").html('<strong>Rooms:</strong> ' + rooms);
        $("#conferenceroomData").html('<strong>Conference Room:</strong> ' + conferenceroom);
        $("#storeroomsData").html('<strong>Store Rooms:</strong> ' + storerooms);
        $("#washroomsData").html('<strong>Washrooms:</strong> ' + washrooms);
        $("#bedroomsData").html('');
        $("#bathroomsData").html('');
        $("#bathtubsData").html('');
        $("#sittingroomData").html('');
    }
    $("#diningroomData").html('<strong>Dining Room:</strong> ' + diningroom);
    $("#kitchenData").html('<strong>Kitchen:</strong> ' + kitchen);
    $("#ovenData").html('<strong>Oven:</strong> ' + oven);
    $("#kitchenitemsData").html('<strong>Kitchen Items:</strong> ' + kitchenitems);
    $("#frequencycleaningData").html('<strong>Frequency of Cleaning:</strong> ' + frequencycleaning);
    $("#preferreddaysData").html('<strong>Preferred Day(s):</strong> ' + preferreddays);
    $("#preferredtimeData").html('<strong>Preferred Time:</strong> ' + preferredtime);
    $("#priorityData").html('<strong>Priority:</strong> ' + priority);
    $("#preferreddateData").html('<strong>Preferred Date:</strong> ' + preferreddate);
    $("#requirementdetailsData").html('<strong>Requirement Details:</strong> ' + requirementdetails);
    $("#additionalinfoData").html('<strong>Additional Info:</strong> ' + additionalinfo);
    $("#firstNameData").html('<strong>First Name:</strong> ' + fname);
    $("#lastNameData").html('<strong>Last Name:</strong> ' + lname);
    $("#genderData").html('<strong>Gender:</strong> ' + gender);
    $("#addressData").html('<strong>Address:</strong> ' + address);
    $("#emailaddressData").html('<strong>email:</strong> ' + email);
    $("#phoneData").html('<strong>Phone:</strong> ' + phone);
    $("#preferedcontactData").html('<strong>Preferred Contact Method:</strong> ' + preferedcontact);
    $("#servicepriceData").html('<strong>Selected Service Price:</strong> $' + serviceprice);
    $("#servicetaxData").html('<strong>Selected Service Tax:</strong> $' + servicetax);
    $("#commissionpriceData").html('<strong>Selected Service Commission:</strong> $' + commissionprice);
    $("#servicesubtotalpriceData").html('<strong>Selected Service Subtotal Price:</strong> $' + servicesubtotalprice);
    if (requirementdetails.length > 0 && requirementdetails) $(".validreqdetails .help-block.with-errors").html('');
    else
        $(".validreqdetails .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Provide Requirement Details</li></ul>');
    if (fname) $(".validfname .help-block.with-errors").html('');
    else
        $(".validfname .help-block.with-errors").html('<ul class="list-unstyled"><li>Please enter First Name</li></ul>');
    if (lname) $(".validlname .help-block.with-errors").html('');
    else
        $(".validlname .help-block.with-errors").html('<ul class="list-unstyled"><li>Please enter Last Name</li></ul>');
    if (gender) $(".validgender .help-block.with-errors").html('');
    else
        $(".validgender .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Gender</li></ul>');
    if (address) $(".validaddress .help-block.with-errors").html('');
    else
        $(".validaddress .help-block.with-errors").html('<ul class="list-unstyled"><li>Please enter Address</li></ul>');
    if (validemail) $(".validemail .help-block.with-errors").html('');
    else
        $(".validemail .help-block.with-errors").html('<ul class="list-unstyled"><li>Please enter valid email</li></ul>');
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    if (filter.test(phone)) {
        $(".validphone .help-block.with-errors").html('');
        var validphone = 1;
    } else {
        $(".validphone .help-block.with-errors").html('<ul class="list-unstyled"><li>Please enter valid Phone</li></ul>');
        var validphone = 0;
    }
    if (preferedcontact) $(".validpreferedcontact .help-block.with-errors").html('');
    else
        $(".validpreferedcontact .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Select Prefered Contact Method</li></ul>');
    if ($('#aggre').is(":checked")) $(".validagree .help-block.with-errors").html('');
    else
        $(".validagree .help-block.with-errors").html('<ul class="list-unstyled"><li>Please Aggre with terms &amp; conditions</li></ul>');
    if (requirementdetails.length > 0 && requirementdetails && fname.length > 0 && fname && lname.length > 0 && lname && gender && address.length > 0 && address && validemail && phone.length > 4 && validphone > 0 && preferedcontact && $('#aggre').is(":checked")) {
        $("#section-4 .help-block.with-errors.mandatory-error").html('');
        $("#section-4").removeClass("open");
        $("#section-4").addClass("slide-left");
        $("#section-5").removeClass("slide-right");
        $("#section-5").addClass("open");
    } else {
        $("#section-4 .help-block.with-errors.mandatory-error").html('<ul class="list-unstyled"><li>Please Fill the Form Properly!!!</li></ul>');
        sweetAlert("Oops...", "Please Fill the Form Properly!!!", "error");
    }
}

function previousStep4() {
    $("#section-4").removeClass("slide-left");
    $("#section-4").addClass("open");
    $("#section-5").removeClass("open");
    $("#section-5").addClass("slide-right");
}