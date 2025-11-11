$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#proceed-checkout').on('click', function(){
    sessionStorage.clear('shipping');
    $(this).html('<i class="fa fa-spinner fa-spin"></i> Processing..');
});

$('input[name=shipping_checkout]').on('change', function(){
    const currency = $('.checkout_subtotal > .checkout_amount').html();
    const loggedIn = $('input[id=e-wallet]').attr('data-guest');
    calcTotalCheckout(currency);
    if(loggedIn === '1') checkEwalletBalance(currency);
});

function ewalletBalance(callback) {
    $.ajax({
        url: get_total_income_route,
        type: 'GET',
        success: function(response) {
            callback(response.total_income);
        },
    });
}

function checkEwalletBalance(amount){
    let subTotalParsed = Number(amount.replace(/[^0-9.-]+/g,""));
    if($("input[name=shipping_checkout]:checked").val() === 'ship-items') subTotalParsed += 250;
    
    ewalletBalance(function(balance) {
        const eWalletInput = $('input[id="e-wallet"]');
        const eWalletLabel = $('label[for="e-wallet"]');
        
        if (balance < subTotalParsed) {
            eWalletInput.attr('disabled', true);
            eWalletLabel.html("E-Wallet <span style='color:red;'>(Insufficient Balance)</span>");
        } else {
            eWalletInput.removeAttr('disabled');
            eWalletLabel.html('E-Wallet');
        }
        console.log('Current Balance: ' + balance);
    });
}


$('input[name=shipping]').on('change', function(){
    const currency = $('.cart_subtotal > .cart_amount').html();
    console.log(calcTotal(currency));
    calcTotal(currency);
});

$('.product_quantity').on('input', debounce(function() {
    const _this = $(this);
    const qty = $(this).find('input[type=number]').val();
    const url = $(this).find('input[type=number]').attr('data-url');

    $.post(url, { qty }, function(data) {
        updateRow(data, _this);
        calcTotal(data.sub_total);
        updateCart(data);
        toastr["success"]("Item successfully updated in the cart", "CART UPDATED");
    });
}, 500));

$('.product_remove').on('click', function (e) {
    e.preventDefault();
    const url = $(this).find('a')[0].href;
    const rowToRemove = $(this).closest('tr');
    
    $.get(url, function(data) {
        rowToRemove.remove();
        calcTotal(data.sub_total);
        updateCart(data);
        toastr["success"]("Item successfully removed", "ITEM REMOVED");
    });
});

$('.mini_cart').on('click', '.cart_remove > a', function (e) {
    e.preventDefault();
    const url = $(this).closest('a')[0].href;

    $.get(url, function(data) {
        updateCart(data);
        toastr["success"]("Item successfully removed", "ITEM REMOVED");
    });
});

$('.add_to_cart').on('click', function (e) {
    e.preventDefault();
    const url = $(this).find('a')[0].href;
    const t = $(this);
    const content = $(this).html();
    $(this).html('<a href="#"><i class="fa fa-spinner fa-spin"></i> Adding to cart..</a>');

    $.post(url, {}, function(data) {
        updateCart(data);
        t.html(content);
        toastr["success"]("Item successfully added to cart", "ADD TO CART");
    });
});

$('.add_to_cart_modal').on('submit', function (e) {
    e.preventDefault();
    const qty = $(this).find('input[type=number]').val();
    const url = $(this).attr('action');
    const t = $(this);
    const submitButton = t.find('button[type=submit]');
    submitButton.html('<i class="fa fa-spinner fa-spin"></i> Adding to cart..');

    $.post(url, { qty }, function(data) {
        updateCart(data);
        submitButton.html('ADD TO CART');
        $('.modal').modal('hide');
        toastr["success"]("Item successfully added to cart", "ADD TO CART");
    });
});

$('.add_to_cart_details').on('submit', function (e) {
    e.preventDefault();
    const t = $(this);
    const qty = t.find('input[type=number]').val();
    const url = t.attr('action');
    const submitButton = t.find('button[type=submit');
    submitButton.html('<i class="fa fa-spinner fa-spin"></i> Adding to cart..');

    $.post(url, { qty }, function(data) {
        updateCart(data);
        t.find('input[type=number]').val(1);
        submitButton.html('Add To Cart');
        toastr["success"]("Item successfully added to cart", "ADD TO CART");
    });
});

$(window).on('hidden.bs.modal', function(e) {
    $(e.target).find('input[type=number]').val(1);
});

function updateRow(data, el) {
    let id = el.closest('tr').attr('data-id');
    el.next('.product_total').html('P' + data.content[id].subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
}

function updateCart(items) {
    $('.cart_item').remove();
    $('.no_item').remove();
    updateCount(items.count, items.sub_total);
    if(items.count === 0) {
        $('.mini_cart').prepend(renderItem(null));
        return;
    }

    $.each(items.content, function(i, item) {
        $('.mini_cart').prepend(renderItem(item));
    });
}

function updateCount(count, subtotal) {
    if($('.mini_cart_info').has('span.cart_quantity').length > 0) {
        $('.cart_quantity').text(count);
    } else {
        $('.mini_cart_info').append(`<span class="cart_quantity">${count}</span>`);
    }
    if(count > 0) {
        $('.mini_cart_info').find('a').html('<i class="ion-bag"></i>P' + subtotal);
    } else {
        $('.mini_cart_info').find('a').html('<i class="ion-bag"></i>');
        $('.cart_quantity').remove();
    }

    $('.cart_total > span.price').text('P' + subtotal);
}

function renderItem(item) {
    if (!item) {
        return `<div class="no_item text-center">
                    No items in cart
                </div>`;
    }
    const price = item.price;
    const src = window.baseUrl + '/' + item.options.image;
    return `<div class="cart_item">
                <div class="cart_img">
                    <a href="#"><img src="${src}" alt="${item.name} Image"></a>
                </div>
                <div class="cart_info">
                    <a href="#">${item.name}</a>
                    <span class="quantity">Qty: ${item.qty}</span>
                    <span class="price_cart">P${price.toFixed(2)}</span>
                </div>
                <div class="cart_remove">
                    <a href="${window.baseUrl}/cart/${item.rowId}"><i class="ion-android-close"></i></a>
                </div>
            </div>`;
}

function debounce(func, wait, immediate) {
    let timeout;
    return function() {
        let context = this, args = arguments;
        let later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        let callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

function calcTotal(subtotal) {
    var weight = $('#total_weight').val() || 0;
    const subTotalParsed = Number(subtotal.replace(/[^0-9.-]+/g, ""));
    const shippingFee = subTotalParsed > 0 ? getFee(weight) : 0;
    $('.cart_subtotal > .cart_amount').html('P' + subTotalParsed.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
    if($("input[name=shipping]:checked").val() === 'ship-items') {
        sessionStorage.setItem('shipping', 'ship-items');
        if(weight > 50.0) {
            $('.cart_shipping > .cart_amount').html('Exceeded Weight');
            $('.cart_total > .cart_amount').html('P' + (subTotalParsed + 0.00));
        } else {
            $('.cart_shipping > .cart_amount').html('P' + shippingFee.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('.cart_total > .cart_amount').html('P' + (subTotalParsed + shippingFee).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        }
    } else {
        sessionStorage.setItem('shipping', 'pick-up-items');
        $('.cart_shipping > .cart_amount').html('P0.00');
        $('.cart_total > .cart_amount').html('P' + (subTotalParsed.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')));
    }
}

function calcTotalCheckout(subtotal) {
    var weight = $('#total_weight').val() || 0;
    const subTotalParsed = Number(subtotal.replace(/[^0-9.-]+/g, ""));
    const shippingFee = subTotalParsed > 0 ? getFee(weight) : 0;
    console.log('SubTotal: '+ subTotalParsed);
    console.log('shippingFee: '+ shippingFee);
    $('.checkout_subtotal > .checkout_amount').html('P' + subTotalParsed.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
    if($("input[name=shipping_checkout]:checked").val() === 'ship-items') {
        sessionStorage.setItem('shipping', 'ship-items');
        if(weight > 50.0) {
            $('.checkout_shipping > .checkout_amount').html('Exceeded Weight');
            $('#proceed-checkout').prop('disabled', true);
            $('.sf').val(getFee(weight));
            $('.checkout_total > .checkout_amount').html('P' + (subTotalParsed + 0.00));
        } else {
            $('.checkout_shipping > .checkout_amount').html('P' + shippingFee.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('#proceed-checkout').prop('disabled', false);
            $('.sf').val(getFee(weight));
            $('.checkout_total > .checkout_amount').html('P' + (subTotalParsed + shippingFee).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        }
    } else {
        sessionStorage.setItem('shipping', 'pick-up-items');
        $('.checkout_shipping > .checkout_amount').html('P0.00');
        $('.sf').val(0);
        $('.checkout_total > .checkout_amount').html('P' + (subTotalParsed.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')));
        $('#proceed-checkout').prop('disabled', false);
    }
}

function getFee(weight) {
    var fee = 250.00;
    if(weight < 1.0){
        fee = fee;
    }else{
        if(weight >= 1.0 && weight <= 3.0) {
            fee = 250.00;
        } else if (weight >= 3.0 && weight <= 4.0) {
            fee = 290.00;
        } else if (weight >= 4.0 && weight <= 5.0) {
            fee = 380.00;
        } else if (weight >= 5.0 && weight <= 6.0) {
            fee = 475.00;
        } else if (weight >= 6.0 && weight <= 7.0) {
            fee = 595.00;
        } else if (weight >= 7.0 && weight <= 8.0) {
            fee = 635.00;
        } else if (weight >= 8.0 && weight <= 9.0) {
            fee = 751.00;
        } else if (weight >= 9.0 && weight <= 10.0) {
            fee = 867.00;
        } else if (weight >= 10.0 && weight <= 11.0) {
            fee = 983.00;
        } else if (weight >= 11.0 && weight <= 12.0) {
            fee = 1099.00;
        } else if (weight >= 12.0 && weight <= 13.0) {
            fee = 1215.00;
        } else if (weight >= 13.0 && weight <= 14.0) {
            fee = 1331.00;
        } else if (weight >= 14.0 && weight <= 15.0) {
            fee = 1447.00;
        } else if (weight >= 15.0 && weight <= 16.0) {
            fee = 1563.00;
        } else if (weight >= 16.0 && weight <= 17.0) {
            fee = 1679.00;
        } else if (weight >= 17.0 && weight <= 18.0) {
            fee = 1795.00;
        } else if (weight >= 18.0 && weight <= 19.0) {
            fee = 1911.00;
        } else if (weight >= 19.0 && weight <= 20.0) {
            fee = 2027.00;
        } else if (weight >= 20.0 && weight <= 21.0) {
            fee = 2143.00;
        } else if (weight >= 21.0 && weight <= 22.0) {
            fee = 2259.00;
        } else if (weight >= 22.0 && weight <= 23.0) {
            fee = 2375.00;
        } else if (weight >= 23.0 && weight <= 24.0) {
            fee = 2491.00;
        } else if (weight >= 24.0 && weight <= 25.0) {
            fee = 2607.00;
        } else if (weight >= 25.0 && weight <= 26.0) {
            fee = 2723.00;
        } else if (weight >= 26.0 && weight <= 27.0) {
            fee = 2839.00;
        } else if (weight >= 27.0 && weight <= 28.0) {
            fee = 2955.00;
        } else if (weight >= 28.0 && weight <= 29.0) {
            fee = 3071.00;
        } else if (weight >= 29.0 && weight <= 30.0) {
            fee = 3187.00;
        } else if (weight >= 30.0 && weight <= 31.0) {
            fee = 4955.00;
        } else if (weight >= 31.0 && weight <= 32.0) {
            fee = 5129.00;
        } else if (weight >= 32.0 && weight <= 33.0) {
            fee = 6173.00;
        } else if (weight >= 33.0 && weight <= 34.0) {
            fee = 6347.00;
        } else if (weight >= 34.0 && weight <= 35.0) {
            fee = 6521.00;
        } else if (weight >= 35.0 && weight <= 36.0) {
            fee = 6695.00;
        } else if (weight >= 36.0 && weight <= 37.0) {
            fee = 6869.00;
        } else if (weight >= 37.0 && weight <= 38.0) {
            fee = 7043.00;
        } else if (weight >= 38.0 && weight <= 39.0) {
            fee = 7217.00;
        } else if (weight >= 39.0 && weight <= 40.0) {
            fee = 7391.00;
        } else if (weight >= 40.0 && weight <= 41.0) {
            fee = 7565.00;
        } else if (weight >= 41.0 && weight <= 42.0) {
            fee = 7739.00;
        } else if (weight >= 42.0 && weight <= 43.0) {
            fee = 7913.00;
        } else if (weight >= 43.0 && weight <= 44.0) {
            fee = 8087.00;
        } else if (weight >= 44.0 && weight <= 45.0) {
            fee = 8261.00;
        } else if (weight >= 45.0 && weight <= 46.0) {
            fee = 8435.00;
        } else if (weight >= 46.0 && weight <= 47.0) {
            fee = 8609.00;
        } else if (weight >= 47.0 && weight <= 48.0) {
            fee = 8783.00;
        } else if (weight >= 48.0 && weight <= 49.0) {
            fee = 8957.00;
        } else if (weight >= 49.0 && weight <= 50.0) {
            fee = 9131.00;
        } else {
            fee = 'Exceeded Weight';
        }
    }
    return fee;
}

$('input[name="checkout_method"]').change(function(){
    if($(this).is(":checked")){
        var val = $(this).val();
        if(val == 'bank-transfer' || val == 'gcash'){
            $('#div_proof').show();
        } else {
            $('#div_proof').hide();
        }
    }
});
