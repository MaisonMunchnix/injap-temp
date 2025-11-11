<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script>
    var token = "{{csrf_token()}}";
    $(window).on('load', function() {
        $('.pre-loading').fadeOut('slow');
    });

</script>
@yield('scripts')
