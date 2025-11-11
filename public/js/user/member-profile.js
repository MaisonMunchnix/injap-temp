var city_data;
var valid_image = false;
$(document).ready(function () {
	getProvinceData();

	$(".numbers").each(function () {
		var new_txt = $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		$(this).text(new_txt)
	});

	$('#btn-show-update-modal').click(function () {
		$('.send-loading').show();
	});
	$('#update_info_modal').on('shown.bs.modal', function (e) {
		var prov_id = $('#hidden_prov_id').val();
		var city_id = $('#hidden_city_id').val();
		var hidden_civil = $('#hidden_civil').val();
		var hidden_gender = $('#hidden_gender').val();
		$('#upd_province').val(prov_id);
		$('#upd_city').empty();
		$('#upd_city').append('<option value="">Select</option>');
		$.each(city_data, function (i, value) {
			if (value.provCode == prov_id) {
				$('#upd_city').append('<option value="' + value.citymunCode + '">' + value.citymunDesc + '</option>');
			}
		});
		$('#upd_city').val(city_id);

		$('#upd_gender').val(hidden_gender);
		$('#upd_civil').val(hidden_civil);
		$('.send-loading').hide();
	});

	$("#upd_province").change(function (event) {
		var dis_val = $(this).val();
		$('#upd_city').empty();
		$('#upd_city').append('<option value="">Select</option>');
		$.each(city_data, function (i, value) {
			if (value.provCode == dis_val) {
				$('#upd_city').append('<option value="' + value.citymunCode + '">' + value.citymunDesc + '</option>');
			}
		});
	});

	$('#btn-update-profile').click(function () {
		var fields_require = $('.required-updated');
		var count_null_fields = 0; // for counting the empty fields
		for (var i = 0; i < fields_require.length; i++) {
			var data = $(fields_require[i]).val();
			if (data == "") {
				$(fields_require[i]).closest('.form-group').find('.display-error').text('This field is required.');
				$(fields_require[i]).closest('.form-group').find('.display-error').removeClass('d-none');
				$(fields_require[i]).addClass("border-red");
				count_null_fields++;
			} else {
				$(fields_require[i]).closest('.form-group').find('.display-error').text('');
				$(fields_require[i]).removeClass("border-red");
			}
		}

		var mobile = $("#upd_mobile").val();
		var zip = $("#upd_mobile").val();
		if (count_null_fields > 0) {
			swal({
				title: "Warning!",
				text: "Please check empty or invalid input fields.",
				type: "warning",
			});
		} else if (isNaN(mobile)) {
			swal({
				title: "Warning!",
				text: "Invalid mobile number",
				type: "warning",
			});
		} else if (mobile.length < 11) {
			swal({
				title: "Warning!",
				text: "Invalid mobile number",
				type: "warning",
			});
		} else if (isNaN(zip)) {
			swal({
				title: "Warning!",
				text: "Invalid mobile number",
				type: "warning",
			});
		} else if (zip.length < 4) {
			swal({
				title: "Warning!",
				text: "Invalid mobile number",
				type: "warning",
			});
		} else {
			updateProfile();

		}
	});

	$('#btn-update-password').click(function () {
		var fields_require = $('.required-password');
		var count_null_fields = 0; // for counting the empty fields
		for (var i = 0; i < fields_require.length; i++) {
			var data = $(fields_require[i]).val();
			if (data == "") {
				$(fields_require[i]).closest('.form-group').find('.display-error').text('This field is required.');
				$(fields_require[i]).closest('.form-group').find('.display-error').removeClass('d-none');
				$(fields_require[i]).addClass("border-red");
				count_null_fields++;
			} else {
				$(fields_require[i]).closest('.form-group').find('.display-error').text('');
				$(fields_require[i]).removeClass("border-red");
			}
		}

		var current_password = $("#current_password").val();
		var new_password = $("#new_password").val();
		var confirm_password = $("#confirm_password").val();
		if (count_null_fields > 0) {
			swal({
				title: "Warning!",
				text: "Please check empty or invalid input fields.",
				type: "warning",
			});
		} else if (new_password != confirm_password) {
			swal({
				title: "Warning!",
				text: "Password Not Match",
				type: "warning",
			});
		} else {
			updatePassword();
		}
	});

	$('.required-updated').change(function (event) {
		var dis_val = $(this).val();
		var dis = $(this);
		if (dis_val != "") {
			$(dis).closest('.form-group').find('.display-error').text('');
			$(dis).removeClass("border-red");
		}
	});

	$("#member-photo").change(function () {
		var fileExtension = ['jpeg', 'jpg', 'png'];
		if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
			//alert("Only formats are allowed : " + fileExtension.join(', '));
			valid_image = false;
			swal({
				title: "Warning!",
				text: "Invalid image type",
				type: "warning",
			});
			$(this).closest('.form-group').find('.display-error').text('Invalid image type');
			$(this).closest('.form-group').find('.display-error').removeClass('d-none');
			//$(this).addClass("border-red");
		} else {
			valid_image = true;
			previewImage(this);
			$(this).closest('.form-group').find('.display-error').text('');
			$(this).closest('.form-group').find('.display-error').addClass('d-none');
			//$(dis).removeClass("border-red");
		}
	});

	$("#form-upload-picture").submit(function (e) {
		e.preventDefault();
		if (valid_image == true) {
			var formData = new FormData(this);
			formData.append('_token', token);
			$.ajax({
				url: '../user/update-member-picture',
				type: 'POST',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function () {
					$('.send-loading').show();
				},
				success: function (response) {
					//console.log(response);
					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "Profile picture successfully changed",
						type: "success",
					}, function () {
						location.reload();
					});
				},
				error: function (error) {
					//console.log('Updating submitting error...');
					console.log(error);
					console.log(error.responseJSON.message);
					$('.send-loading ').hide();
					swal({
						title: "Error!",
						text: "Error message: " + error.responseJSON.message + "",
						type: "error",
					});
				}
			});
		} else {
			swal({
				title: "Warning!",
				text: "Invalid image type",
				type: "warning",
			});
		}
	});

});

function getProvinceData() {
	$.ajax({
		url: '../get-province',
		type: 'GET',
		beforeSend: function () {
			//console.log('Getting data ...');
		},
		success: function (response) {
			//console.log('Getting data success...');
			//console.log(response);
			city_data = response.city;
			//setting province data
			$('#upd_province').empty();
			$('#upd_province').append('<option value="">Select</option>');
			$.each(response.province, function (i, value) {
				$('#upd_province').append('<option value="' + value.provCode + '">' + value.provDesc + '</option>');
			});
			//place the preloader here to finish first of getting data
			$(".pre-loading").fadeOut("slow");
		},
		error: function (error) {
			console.log('Getting data error...');
			console.log(error);
		}
	});
}
function updatePassword() {
	var formData = new FormData();
	formData.append("current_password", $("#current_password").val());
	formData.append("new_password", $("#new_password").val());
	formData.append("confirm_password", $("#confirm_password").val());
	formData.append('_token', token);

	$.ajax({
		url: '../user/update-member-password',
		type: 'POST',
		data: formData,
		contentType: false,
		processData: false,
		beforeSend: function () {
			$('.send-loading').show();
		},
		success: function (response) {
			//console.log('Updating submitting success...');
			$('.send-loading ').hide();
			swal({
				title: "Success!",
				text: "Password successfully updated",
				type: "success",
			}, function () {
				location.reload();
			});

		},
		error: function (error) {
			//console.log('Updating submitting error...');
			console.log(error);
			console.log(error.responseJSON.message);
			$('.send-loading ').hide();
			swal({
				title: "Error!",
				text: "Error message: " + error.responseJSON.message + "",
				type: "error",
			});
		}
	});
}


function updateProfile() {
	var formData = new FormData();
	formData.append("first_name", $("#upd_fname").val());
	formData.append("middle_name", $("#upd_mname").val());
	formData.append("last_name", $("#upd_lname").val());
	formData.append("mobile_no", $("#upd_mobile").val());
	formData.append("tel_no", $("#upd_tel").val());
	formData.append("gender", $("#upd_gender").val());
	formData.append("civil_status", $("#upd_civil").val());
	formData.append("tin_no", $("#upd_tin").val());
	formData.append("beneficiary", $("#upd_beneficiary").val());
	formData.append("birth_date", $("#upd_bdate").val());
	//address
	formData.append("address", $("#upd_addr").val());
	formData.append("province_id", $("#upd_province").val());
	formData.append("city_id", $("#upd_city").val());
	formData.append("zip_code", $("#upd_zip").val());

	formData.append('_token', token);

	$.ajax({
		url: '../user/update-member-profile',
		type: 'POST',
		data: formData,
		contentType: false,
		processData: false,
		beforeSend: function () {
			$('.send-loading').show();
		},
		success: function (response) {
			//console.log('Updating submitting success...');
			$('.send-loading ').hide();
			swal({
				title: "Success!",
				text: "Personal information successfully updated",
				type: "success",
			}, function () {
				location.reload();
			});

		},
		error: function (error) {
			//console.log('Updating submitting error...');
			console.log(error);
			console.log(error.responseJSON.message);
			$('.send-loading ').hide();
			swal({
				title: "Error!",
				text: "Error message: " + error.responseJSON.message + "",
				type: "error",
			});
		}
	});
}

function getCityData() {
	$('#city').empty();
	$('#city').append('<option value="">Select</option>');
	$.each(city_data, function (i, value) {
		if (value.provCode == dis_val) {
			$('#city').append('<option value="' + value.citymunCode + '">' + value.citymunDesc + '</option>');
		}
	});
}

function previewImage(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#image-preview').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	}
}
