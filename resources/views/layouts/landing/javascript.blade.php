<script src="{{ asset('landing/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('landing/js/app.min.js') }}"></script>
<script src="{{ asset('landing/js/layerslider.utils.js') }}"></script>
<script src="{{ asset('landing/js/layerslider.transitions.js') }}"></script>
<script src="{{ asset('landing/js/layerslider.kreaturamedia.jquery.js') }}"></script>
<script src="{{ asset('landing/js/main.js') }}"></script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('landing.get-currencies') }}",
            method: 'GET',
            success: function(data) {
                var currencies = {
                    'YEN': {
                        buy: '#buy_yen',
                        sell: '#sell_yen'
                    },
                    'USD': {
                        buy: '#buy_usd',
                        sell: '#sell_usd'
                    },
                    'HKD': {
                        buy: '#buy_hkd',
                        sell: '#sell_hkd'
                    }
                };

                for (var currencyName in currencies) {
                    var currency = data.find(currency => currency.name === currencyName);
                    if (currency) {
                        $(currencies[currencyName].buy).text(currency.buy);
                        $(currencies[currencyName].sell).text(currency.sell);
                    }
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
</script>
@yield('scripts')
