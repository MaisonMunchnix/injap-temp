$(document).ready(function () {
    setTimeout(getData(), 1000);
    setTimeout(network_downlines(), 1500);
    //getData(); //getting user and product data
    $('#pv-tab').click(function(){
        $.ajax({
            url: 'user/get-my-network-count',
            type: 'GET',
            beforeSend: function () {
                //console.log('Getting data...');
                //$('.preloader').css('display', '');
            },
            success: function (response) {
                var totalLeft;
                var totalright;
                var silverLeft = 0;
                var goldleft = 0;
                var silverRight = 0;
                var goldRight = 0;
                response.MynetworkData.forEach(element => {
                    // console.log(element);
                    if (element.silverLeft != undefined) {
                        silverLeft = element.silverLeft;
                    }

                    if (element.goldleft != undefined) {
                        goldleft = element.goldleft;
                    }
                    if (element.silverRight != undefined) {
                        silverRight = element.silverRight;
                    }

                    if (element.goldRight != undefined) {
                        goldRight = element.goldRight;
                    }
                });


                $('#slive_left').text("Silver Left: " + silverLeft);

                $('#gold_left').text("Gold Left: " + goldleft);

                $('#slive_right').text("Silver Right: " + silverRight);

                $('#gold_right').text("Gold Right: " + goldRight);

                totalLeft = silverLeft + goldleft;
                totalright = silverRight + goldRight;

                $('#right_total').text("Total Right: " + totalright);

                $('#left_total').text("Total Left: " + totalLeft);

                
                // console.log(response.GroupSales);
                //$('.preloader').css('display', 'none');
                $('#loader-pv-result').text('Loading data...');
                $('#loader-data-pv').hide();
                $('#show-data-pv').show();
               
            },
            error: function (error) {
                console.log('Getting data error...');
                console.log(error);
                //$('.preloader').css('display', 'none');
                $('#loader-pv-result').text('Something went wrong please try again later.');
                $('#loader-data-pv').hide();
                $('#show-data-pv').show();
            }
        });
    });

})

function getData() {
    $.ajax({
        url: 'user/get-network-data',
        type: 'GET',
        beforeSend: function () {
            $('.preloader').css('display', '');
        },
        success: function (response) {
            try {
                // Check if response has the required data
                if (!response || typeof response !== 'object') {
                    console.log('Invalid response format:', response);
                    $('.preloader').css('display', 'none');
                    return;
                }

                var totalLeft;
                var totalright;
                var silverLeft = 0;
                var goldleft = 0;
                var silverRight = 0;
                var goldRight = 0;
                
                // Safely process MynetworkData
                if (response.MynetworkData && Array.isArray(response.MynetworkData)) {
                    response.MynetworkData.forEach(element => {
                        if (element && typeof element === 'object') {
                            if (element.silverLeft != undefined) {
                                silverLeft = element.silverLeft;
                            }
                            if (element.goldleft != undefined) {
                                goldleft = element.goldleft;
                            }
                            if (element.silverRight != undefined) {
                                silverRight = element.silverRight;
                            }
                            if (element.goldRight != undefined) {
                                goldRight = element.goldRight;
                            }
                        }
                    });
                }

                $('#slive_left').text("Silver Left: " + silverLeft);
                $('#gold_left').text("Gold Left: " + goldleft);
                $('#slive_right').text("Silver Right: " + silverRight);
                $('#gold_right').text("Gold Right: " + goldRight);

                totalLeft = silverLeft + goldleft;
                totalright = silverRight + goldRight;

                $('#right_total').text("Total Right: " + totalright);
                $('#left_total').text("Total Left: " + totalLeft);

                console.log(silverLeft, goldleft, silverRight, goldRight, totalLeft, totalright);

                // Safely set sponsor data
                if (response.arr_auth_sponsor && typeof response.arr_auth_sponsor === 'object') {
                    $('#user_reg_date').text(response.arr_auth_sponsor.register_date || '');
                    $('#user_sponsor').text(response.arr_auth_sponsor.sponsor || '');
                    $('#user_up_placement').text(response.arr_auth_sponsor.placement_id || '');
                    $('#user_position').text(response.arr_auth_sponsor.placement_position || '');
                    $('#user_member_type').text(response.arr_auth_sponsor.member_type || '');
                }

                // Safely set all income/bonus data with fallback to 0
                $('#Total_Direct_Referral').text(addComma(response.Total_Direct_Referral || 0)  + ' ¥');
                $('#Direct_Referral_side').text(addComma(response.Total_Direct_Referral || 0)  + ' ¥'); 
                
                $('#Total_Weekly_Direct_Referral').text(addComma(response.Total_Weekly_Direct_Referral || 0)  + ' ¥'); 
                $('#Total_Weekly_Pairing_Bonus').text(addComma(response.weekly_income || 0)  + ' ¥'); 
                $('#Total_Charity_Bonus').text(addComma(response.Total_Charity_Bonus || 0)  + ' ¥'); 
                $('#Total_Weekly_Pairing_Points').text(addComma(response.weekly_income_points || 0) + " Points"); 
                $('#fifth_pair_total_weekly_income').text(addComma(response.fifth_sales_weekly_income || 0));
                $('#Total_Weekly_5th_Pairing_Points').text(addComma(response.weekly_5th_points || 0) + " Points"); 
                $('#T5thPRPoints').text(addComma(response.total_5th_pairing_points || 0) + " Points"); 
                $('#total_referral_bonus').text(addComma(response.total_referral || 0) + ' ¥');
                $('#TPBunos').text(addComma(response.total_sales_match || 0));
                $('#TPRPoints').text(addComma(response.total_pairing_points || 0) + " Points"); 
                $('#Total_Ayuda_Compensation_Bonus').text(addComma(response.ayuda_sales || 0));
                $('#TPMatch').text(addComma(response.TPMatch || 0) + " PAIR");
                $('#total_5th_sales_match').text(addComma(response.total_5th_sales_match || 0)  + ' ¥');
                $('#total_added_income').text(addComma(response.total_added_income || 0) + ' ¥');
                $('#total_deductions').text(addComma(response.total_deductions || 0) + ' ¥');
                $('#total_no_5th_pair').text(response.fifth_pair_count || 0);
                $('#Total_Monthly_Unilevel').text(addComma(response.Total_Monthly_Unilevel || 0)  + ' ¥'); 
                $('#Total_Unilevel_Income').text(addComma(response.Total_Unilevel_Income || 0)  + ' ¥'); 
                $('#total_accumulated_income').text(addComma(response.total_accumulated || 0) + ' ¥');
                $('#total_accumulated_encashment').text(addComma(response.total_encashment || 0) + ' ¥');
                $('#total_accumulated_bal').text(addComma(response.total_avail_bal || 0) + ' ¥');

                // Calculate and display totals tab values
                var referral_bonus = parseFloat(response.Total_Direct_Referral) || 0;
                var charity_bonus = parseFloat(response.Total_Charity_Bonus) || 0;
                var added_income = parseFloat(response.total_added_income) || 0;
                var deductions = parseFloat(response.total_deductions) || 0;
                var grand_total = referral_bonus + charity_bonus + added_income;
                
                $('#totals_referral_bonus').text(addComma(referral_bonus.toFixed(2)) + ' ¥');
                $('#totals_charity_bonus').text(addComma(charity_bonus.toFixed(2)) + ' ¥');
                $('#totals_added_income').text(addComma(added_income.toFixed(2)) + ' ¥');
                $('#totals_deductions').text(addComma(deductions.toFixed(2)) + ' ¥');
                $('#grand_total_income').text(addComma(grand_total.toFixed(2)) + ' ¥');

                // Set rank data if it exists - safely check each element
                try {
                    if (response.rank && Array.isArray(response.rank)) {
                        if (response.rank.length > 0 && response.rank[0]) $('#rank1').text(response.rank[0]['rank1'] || '');
                        if (response.rank.length > 1 && response.rank[1]) $('#rank2').text(response.rank[1]['rank2'] || '');
                        if (response.rank.length > 2 && response.rank[2]) $('#rank3').text(response.rank[2]['rank3'] || '');
                        if (response.rank.length > 3 && response.rank[3]) $('#rank4').text(response.rank[3]['rank4'] || '');
                        if (response.rank.length > 4 && response.rank[4]) $('#rank5').text(response.rank[4]['rank5'] || '');
                    }
                } catch (rankError) {
                    console.log('Error setting rank data:', rankError);
                }
                
                try {
                    if (response.GroupSales !== undefined && response.GroupSales !== null) {
                        $('#Groupsales').text(response.GroupSales);
                    }
                } catch (groupError) {
                    console.log('Error setting GroupSales:', groupError);
                }
                
                $('.preloader').css('display', 'none');
            } catch (error) {
                console.error('Error processing getData response:', error);
                console.error('Response data:', response);
                $('.preloader').css('display', 'none');
            }
        },
        error: function (error) {
            console.log('Getting data error...');
            console.log(error);
            $('.preloader').css('display', 'none');
        }
    });
}

$('#position').on('change', function () {
    var position = this.value;
    network_downlines(position);
});

function network_downlines(position) {
    $.ajax({
        url: 'user/get-network-downlines/' + position,
        type: 'GET',
        beforeSend: function () {
            //console.log('Getting data...');
            $('.preloader').css('display', '');
            //$("#table_downline tbody").empty();
            $('#table_downline').DataTable().clear().destroy();
        },
        success: function (response) {
            //setting data in table downline
            $.each(response.downline_data, function (i, value) {
                $url = 'user/view-geneology/' + value.user_id;
                $('#table_downline > tbody:last-child').append('<tr class="text-capitalize">' +
                    '<td class="nowrap"><small>' + value.full_name + '</small></small></td>' +
                    '<td class="nowrap"><small>' + value.user_name + '</small></td>' +
                    '<td class="text-left"><small>' + value.sponsor + '</small></td>' +
                    '<td class="text-center"><small>' + value.placement_position + '</small></td>' +
                    '<td class="text-center"><small>' + value.reg_date + '</small></td>' +
                    '<td class="text-center"><small>' + value.ac_type + '</small></td>' +
                    '<td class="text-right"><small><a href="' + $url + '" class="btn btn-primary btn-sm" type="button"> View</a></td>' +
                    '</tr>');
            });

            $('#table_downline').dataTable({
                "ordering": false
            });
            $('#table_downline_wrapper').removeClass('form-inline');


            $('#network_count').text(response.downline_data.length); //setting data  in network count

            $('.preloader').css('display', 'none');
        },
        error: function (error) {
            console.log('Getting data error...');
            console.log(error);
            $('.preloader').css('display', 'none');
        }
    });
}

// function addComma(num) {
//     var text = num.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
//     return text;
// }

function addComma(numStr)
{
    numStr += '';
    var x = numStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

// Load adjustment history when the adjustments tab is clicked
$(document).on('click', '#adjustments-tab', function() {
    loadAdjustmentHistory();
});

// Refresh data when the totals tab is clicked
$(document).on('click', '#totals-tab', function() {
    getData();
    loadAdjustmentHistory();
});

function loadAdjustmentHistory() {
    $.ajax({
        url: 'user/get-adjustment-history',
        type: 'GET',
        beforeSend: function() {
            $('#adjustments_table_body').html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');
        },
        success: function(response) {
            if (response.success && response.data.length > 0) {
                let html = '';
                response.data.forEach(function(item) {
                    let rowClass = item.type === 'Added' ? 'table-success' : 'table-danger';
                    let amountClass = item.type === 'Added' ? 'text-success' : 'text-danger';

                    // Normalize and map certain note labels for display
                    let displayNotes = item.notes || '';
                    if (/Direct Referral Bonus/i.test(displayNotes)) {
                        displayNotes = 'Social Funds';
                    } else if (/Pairing Bonus/i.test(displayNotes)) {
                        displayNotes = 'Charity Funds';
                    } else if (/Fund transfer/i.test(displayNotes)) {
                        displayNotes = 'Fund Transfer - ' + displayNotes;
                    }

                    // Get recipient ID, display "-" if not available
                    let recipientId = item.recipient_id || '-';

                    html += '<tr class="' + rowClass + '">' +
                        '<td>' + item.date + '</td>' +
                        '<td><span class="badge ' + (item.type === 'Added' ? 'badge-success' : 'badge-danger') + '">' + item.type + '</span></td>' +
                        '<td class="' + amountClass + ' font-weight-bold">' + item.amount + '</td>' +
                        '<td>' + recipientId + '</td>' +
                        '<td>' + displayNotes + '</td>' +
                        '</tr>';
                });
                $('#adjustments_table_body').html(html);
            } else {
                $('#adjustments_table_body').html('<tr><td colspan="5" class="text-center text-muted">No adjustments found</td></tr>');
            }
        },
        error: function(error) {
            console.log('Error loading adjustment history:', error);
            $('#adjustments_table_body').html('<tr><td colspan="5" class="text-center text-danger">Error loading data</td></tr>');
        }
    });
}

