var offset = 0;
var count_all = 0;
$(document).ready(function () {
    if ($('#key_zero').length != 0) {
        var ann_id = $('#key_zero').val();
        if (ann_id.length != 0) {
            showAnnouncementContent(ann_id);
        }
    }

    $(document).on('click', '.ann-click', function () {
        $('.ann-click').removeClass('active');
        var id = $(this).attr('data-id');
        showAnnouncementContent(id);
        $(this).addClass('active');
    });

    $('.ann-click').click(function () {
        $('.ann-click').removeClass('active');
        var id = $(this).attr('data-id');
        showAnnouncementContent(id);
        $(this).addClass('active');
    });

    $('#load_more_ann').click(function () {
        loadMore();

    });

});

function loadMore() {
    offset = offset + 10;
    $.ajax({
        url: '/user/load-more-announcement/' + offset,
        type: 'GET',
        beforeSend: function () {
            //console.log('Getting data...');
            $('.send-loading').show();
        },
        success: function (response) {
            //console.log('success..');
            //console.log(response);
            count_all = response.announcement_count;
            $.each(response.announcements, function (i, value) {
                var content = value.content;
                var new_content;
                if (content.length > 70) {
                    var res = content.substring(0, 70);
                    new_content = res + '...';
                } else {
                    var count_chr = content.length;
                    var missing_chr = 70 - count_chr;
                    var add_space = "";
                    for (var i = 0; i < missing_chr; i++) {
                        add_space = add_space + "&nbsp;";
                    }
                    new_content = value.content + add_space;
                }
                var options_year = {
                    year: '2-digit'
                };
                var options_month = {
                    month: '2-digit'
                };
                var today = new Date();
                var created_d = new Date(value.created_at);
                var date_today = today.toLocaleDateString();
                var created_date = created_d.toLocaleDateString();
                var diff = today - created_d;
                // get days
                var days = diff / 1000 / 60 / 60 / 24;
                var diff_days = Math.round(days);
                var set_time;
                if (diff_days == 0) {
                    var getTime = value.created_at;
                    var explode_time = getTime.split(' ');
                    set_time = timeConvert(explode_time[1]);
                } else if (diff_days == 1) {
                    set_time = 'Yesterday';
                } else {
                    set_time = created_date;
                }


                //var two_digit_year = today.toLocaleDateString("en-US", options_year)
                //var two_digit_month = today.toLocaleDateString("en-US", options_month)
                //var date_today = two_digit_year + '-' + two_digit_month;


                $('.ae-list').append(
                    '<div class="ae-item with-status ann-click status-green" data-id="' + value.id + '">' +
                    '<div class="aei-content">' +
                    '<div class="aei-timestamp">' + set_time + '</div>' +
                    '<h6 class="aei-title">' + value.title + '</h6>' +
                    '<div class="aei-sub-title">' + value.title + '</div>' +
                    '<div class="aei-text">' + new_content + '</div>' +
                    '</div>' +
                    '</div>');
            });

            var temp_offset = offset + 1;
            if (temp_offset >= response.announcement_count) {
                $('#load_more_ann').hide();
            }

            $('.send-loading').hide();

        },
        error: function (error) {
            console.log('error...');
            console.log(error);
            $('.send-loading').hide();
            swal({
                title: "Warning",
                text: "Something went wrong. Please try again later.",
                type: "warning",
            });
        }
    });


}

function showAnnouncementContent(id) {
    $.ajax({
        url: '/user/get-announcement-data/' + id,
        type: 'GET',
        beforeSend: function () {
            //console.log('Getting data...');
            $('.send-loading').show();
            $('.attachments-docs').empty();
        },
        success: function (response) {
            //console.log('success..');
            //console.log(response);
            $('#ann_subject').text(response.announcements.subject);
            $('#user_created_by').text(response.created.first_name + " " + response.created.last_name);
            $('#ann_content').html(nl2br(response.announcements.content));
            $('#ann_content').html(nl2br(response.announcements.content));
            /*$.each(response.attachments, function () {
                $.each(this, function (k, v) {
                    /// do stuff
                });
            });*/
            jQuery.each(response.attachments, function (index, item) {
                $(".attachments-docs").append('<a class="col-md-12" href="../../' + item.source +'" download><i class="os-icon os-icon-ui-51"></i><span>' + item.name +'</span></a><br>');
            });


            //date
            var options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            var convert_date = new Date(response.announcements.created_at);
            var created_date = convert_date.toLocaleDateString("en-US", options);

            var getTime = response.announcements.created_at;
            var explode_time = getTime.split(' ');
            var set_time = timeConvert(explode_time[1]);
            //var expl_conv_time = conv_time.split(':');
            //var cut = expl_conv_time[2].substring(2, 4);
            //var set_time = expl_conv_time[0] + ':' + expl_conv_time[1] + ' ' + cut;
            //console.log(set_time);

            $('#ann_date').text(created_date);
            $('#ann_time').text(set_time);

            $('.send-loading').hide();

        },
        error: function (error) {
            console.log('error...');
            console.log(error);
            $('.send-loading').hide();
            swal({
                title: "Warning",
                text: "Something went wrong. Please try again later.",
                type: "warning",
            });
        }
    });
}

function nl2br(str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function timeConvert(time) {
    // Check correct time format and split into components
    time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

    if (time.length > 1) { // If time format correct
        time = time.slice(1); // Remove full string match value
        time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
        time[0] = +time[0] % 12 || 12; // Adjust hours
    }
    //return time.join(''); // return adjusted time or original string
    var return_time = time.join('');

    var expl_conv_time = return_time.split(':');
    var cut = expl_conv_time[2].substring(2, 4);
    var set_time = expl_conv_time[0] + ':' + expl_conv_time[1] + ' ' + cut;
    return set_time;
}
