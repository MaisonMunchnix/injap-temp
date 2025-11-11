  <script src="{{asset('teller_assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('teller_assets/js/popper.min.js')}}"></script>
  <script src="{{asset('teller_assets/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('teller_assets/js/modernizr.min.js')}}"></script>
  <script src="{{asset('teller_assets/js/detect.js')}}"></script>
  <script src="{{asset('teller_assets/js/jquery.slimscroll.js')}}"></script>
  <script src="{{asset('teller_assets/js/vertical-menu.js')}}"></script>
  <!-- Switchery js -->
  <script src="{{asset('teller_assets/plugins/switchery/switchery.min.js')}}"></script>
  <!-- Chart js -->
  <script src="{{asset('teller_assets/plugins/chart.js/chart.min.js')}}"></script>
  <script src="{{asset('teller_assets/plugins/chart.js/chart-bundle.min.js')}}"></script>
  <!-- Piety Chart js -->
  <script src="{{asset('teller_assets/plugins/peity/jquery.peity.min.js')}}"></script>
  <!-- Vector Maps js -->
  <script src="{{asset('teller_assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
  <script src="{{asset('teller_assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
  <!-- Custom Dashboard Social js -->
  <script src="{{ asset('teller_assets/js/custom/custom-dashboard-social.js')}}"></script>
  <!-- Core js -->
  <script src="{{ asset('teller_assets/js/core.js')}}"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

  <!-- Sweetalert -->
  <script src="{{ asset('teller_assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>


  <script type="text/javascript">
      $(window).on('load', function() {
          // Animate loader off screen
          $(".pre-loading").fadeOut("slow");
      });
      /* global token */
      var token = "{{csrf_token()}}";
      var pub_path = '../public';

  </script>
  @yield('scripts')
