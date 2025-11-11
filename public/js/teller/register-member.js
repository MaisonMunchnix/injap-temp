var product_code_data; //global declaration
var user_data; //global declaration
var error_count = 0; //global declaration
var err_sponsor = 0,
	err_pcode = 0,
	err_upline = 0,
	err_email = 0;


$(document).ready(function () {
	getData(); //getting user and product data


	/*$("#product_codes").change(function (event) {
		var dis_val = $(this).val();
		var dis = $(this);
		var count_true = 0;
		$.each(product_code_data, function (i, value) {
			if (value.code == dis_val) {
				count_true++;
				$('#sec_pin').val(value.security_pin);
			}
		});
		if (count_true == 0) {
			showErrors(dis, 'err-pcode');
			err_pcode = 1;
		} else {
			hideErrors(dis, 'err-pcode');
			err_pcode = 0;
		}
	});*/

	$("#sponsor").change(function (event) {
		var dis_val = $(this).val();
		var dis = $(this);
		var count_true = 0;
		$.each(user_data, function (i, value) {
			if (value.username == dis_val) {
				count_true++;
			}
		});
		if (dis_val == '' || dis_val == null) {
			count_true = 1;
			err_sponsor = 0;
			err_upline = 0;
			var upline = $("#upline_placement");
			hideErrors(upline, 'err-uuser');
			$('#upline_placement').removeAttr("required");
			$('#placement_position').removeAttr("required");
			$('#upline_placement').val('');
			$('#placement_position').val('');
		}
		if (count_true == 0) {
			showErrors(dis, 'err-suser');
			err_sponsor = 1;
			$('#upline_placement').attr("required", true);
			$('#placement_position').attr("required", true);
		} else {
			hideErrors(dis, 'err-suser');
			err_sponsor = 0;
		}
	});

	$("#upline_placement").change(function (event) {
		var dis_val = $(this).val();
		var dis = $(this);
		var count_true = 0;
		$.each(user_data, function (i, value) {
			if (value.username == dis_val) {
				count_true++;
			}
		});
		if (dis_val == '' || dis_val == null) {
			count_true = 1;
			err_upline = 0;
		}
		if (count_true == 0) {
			showErrors(dis, 'err-uuser');
			err_upline = 1;
		} else {
			hideErrors(dis, 'err-uuser');
			err_upline = 0;
		}
	});

	$("#email_address").change(function (event) {
		var dis_val = $(this).val();
		var dis = $(this);
		var count_true = 0;
		$.each(user_data, function (i, value) {
			if (value.username == dis_val) {
				count_true++;
			}
		});
		if (count_true > 0) {
			showErrors(dis, 'err-email');
			err_email = 1;
		} else {
			hideErrors(dis, 'err-email');
			err_email = 0;
		}
	});

	$("#form_register_member").submit(function (event) {
		event.preventDefault();
		console.log('Register submitting...');
		var formData = new FormData();
		var product_num = $("#product_num").val();
		formData.append("sponsor", $("#sponsor").val());
		formData.append("upline_placement", $("#upline_placement").val());
		formData.append("placement_position", $("#placement_position").val());
		formData.append("package_type", $("#package_type").val());
		formData.append("product_num", $("#product_num").val());
		//formData.append("product_codes", $("#product_codes").val());
		//formData.append("sec_pin", $("#sec_pin").val());
		formData.append("email_address", $("#email_address").val());
		formData.append("first_name", $("#first_name").val());
		formData.append("last_name", $("#last_name").val());
		formData.append("mobile_no", $("#mobile_no").val());
		formData.append('_token', token);

		var count_err = err_sponsor + err_pcode + err_upline + err_email;
		console.log('Invalid input fields count: ' + count_err);
		if(product_num == ''){
			alert('No of Product is required');
		} else if (count_err == 0) {
			$.ajax({
				url: 'register/insert',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				beforeSend: function () {
					$('.send-loading').show();
				},
				success: function (response) {
					console.log('Register submitting success...');
					$('.send-loading').hide();
					swal({
						title: "Success!",
						text: "Successfully added",
						type: "success",
					}, function () {
						window.location.href = 'register';
					});

				},
				error: function (error) {
					console.log('Register submitting error...');
					console.log(error);
					console.log(error.responseJSON.message);
					$('.send-loading').hide();
					swal({
						title: "Error!",
						text: "Error Msg: " + error.responseJSON.message + "",
						type: "error",
					});
				}
			});
		} else {
			swal({
				title: "Warning!",
				text: "Please check invalid input fields.",
				type: "warning",
			});
		}
	})

})

function getData() {
	$.ajax({
		url: 'register/member-get-data',
		type: 'GET',
		beforeSend: function () {
			console.log('Getting data (user and product codes)...');
		},
		success: function (response) {
			console.log('Getting data success...');
			console.log(response);
			product_code_data = response.product_codes;
			user_data = response.users;

			//setting data package
			$.each(response.package, function (i, value) {
				$('#package_type').append('<option value="' + value.id + '">' + value.type + '</option>');
			});
			$('#package_type').css('text-transform', 'capitalize');

		},
		error: function (error) {
			console.log('Getting data error...');
			console.log(error);
		}
	});
}

function showErrors(dis, err_id) {
	//$('#member-reg-err').removeClass('d-none');
	$('#' + err_id).removeClass('d-none');
	dis.addClass('border-red');
}

function hideErrors(dis, err_id) {
	$('#' + err_id).addClass('d-none');
	dis.removeClass('border-red');
}
