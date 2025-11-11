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
            //console.log('Getting data...');
            $('.preloader').css('display', '');
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


            console.log(silverLeft);
            console.log(goldleft);
            console.log(silverRight);
            console.log(goldRight);
            console.log(totalLeft);
            console.log(totalright);

            //console.log('Getting data success...');
            //onsole.log(response);
            //setting data in table my sponsor
            $('#user_reg_date').text(response.arr_auth_sponsor.register_date);
            $('#user_sponsor').text(response.arr_auth_sponsor.sponsor);
            $('#user_up_placement').text(response.arr_auth_sponsor.placement_id);
            $('#user_position').text(response.arr_auth_sponsor.placement_position);

            //console.log('Network count'+response.downline_data.length);

            $('#Total_Direct_Referral').text(addComma(response.Total_Direct_Referral) + " PHP");
            $('#Direct_Referral_side').text(addComma(response.Total_Direct_Referral) + " PHP"); 
            
            $('#Total_Weekly_Direct_Referral').text(addComma(response.Total_Weekly_Direct_Referral) + " PHP"); 

            $('#Total_Weekly_Pairing_Bonus').text(addComma(response.weekly_income) + " PHP"); 

            $('#Total_Weekly_Pairing_Points').text(addComma(response.weekly_income_points) + " Points"); 

            $('#fifth_pair_total_weekly_income').text(addComma(response.fifth_sales_weekly_income) + " PHP"); //setting data  in 5th sales match bonus
            //11-22-2021
            $('#Total_Weekly_5th_Pairing_Points').text(addComma(response.weekly_5th_points) + " Points"); 
            $('#T5thPRPoints').text(addComma(response.total_5th_pairing_points) + " Points"); 
            $('#total_referral_bonus').text(addComma(response.total_referral) + " PHP"); //setting data  in total referral
            $('#TPBunos').text(addComma(response.total_sales_match) + " PHP"); //setting data  in sales match bonus
            ///10-25-2021
            $('#TPRPoints').text(addComma(response.total_pairing_points) + " Points"); //setting data  in sales match bonus
            
            $('#Total_Ayuda_Compensation_Bonus').text(addComma(response.ayuda_sales) + " PHP"); //Ayuda Sales
            
            $('#TPMatch').text(addComma(response.TPMatch) + " PAIR"); //setting data  in sales match bonus

            //$('#ParingBonusID').text(addComma(response.TPBunos) + " PHP"); //setting data  in sales match bonus
            //$('#ParingMatchID').text(addComma(response.TPMatch) + " PAIR"); //setting data  in sales match bonus
            $('#total_5th_sales_match').text(addComma(response.total_5th_sales_match) + " PHP"); //setting data  in sales match bonus
            
            
            $('#total_no_5th_pair').text(response.fifth_pair_count); //setting data  in sales match bonus
            
            
            $('#Total_Monthly_Unilevel').text(addComma(response.Total_Monthly_Unilevel) + " PHP"); 
            $('#Total_Unilevel_Income').text(addComma(response.Total_Unilevel_Income) + " PHP"); 

            
            
            
            


            $('#total_accumulated_income').text(addComma(response.total_accumulated) + " PHP"); //setting data  in total accumulated income
            $('#total_accumulated_encashment').text(addComma(response.total_encashment) + " PHP"); //setting data  in total encashment
            $('#total_accumulated_bal').text(addComma(response.total_avail_bal) + " PHP"); //setting data  in total available balance

            $('#rank1').text(response.rank[0]['rank1']);
            $('#rank2').text(response.rank[1]['rank2']);
            $('#rank3').text(response.rank[2]['rank3']);
            $('#rank4').text(response.rank[3]['rank4']);
            $('#rank5').text(response.rank[4]['rank5']);
            $('#Groupsales').text(response.GroupSales);
            // console.log(response.GroupSales);
            $('.preloader').css('display', 'none');
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

