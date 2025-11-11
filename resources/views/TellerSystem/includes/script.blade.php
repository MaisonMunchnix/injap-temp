<!-- jQuery -->
	<script src="{{asset('assets/vendor/jquery.min.js')}}"></script>

	<!-- Bootstrap -->
	<script src="{{asset('assets/vendor/popper.min.js')}}"></script>
	<script src="{{asset('assets/vendor/bootstrap.min.js')}}"></script>

	<!-- Simplebar -->
	<script src="{{asset('assets/vendor/simplebar.min.js')}}"></script>

	<!-- DOM Factory -->
	<script src="{{asset('assets/vendor/dom-factory.js')}}"></script>

	<!-- MDK -->
	<script src="{{asset('assets/vendor/material-design-kit.js')}}"></script>

	<!-- Range Slider -->
	<script src="{{asset('assets/vendor/ion.rangeSlider.min.js')}}"></script>
	<script src="{{asset('assets/js/ion-rangeslider.js')}}"></script>

	<!-- App -->
	<script src="{{asset('assets/js/toggle-check-all.js')}}"></script>
	<script src="{{asset('assets/js/check-selected-row.js')}}"></script>
	<script src="{{asset('assets/js/dropdown.js')}}"></script>
	<script src="{{asset('assets/js/sidebar-mini.js')}}"></script>
	<script src="{{asset('assets/js/app.js')}}"></script>

	<!-- App Settings (safe to remove) -->
	<script src="{{asset('assets/js/app-settings.js')}}"></script>



	<!-- Flatpickr -->
	<script src="{{asset('assets/vendor/flatpickr/flatpickr.min.js')}}"></script>
	<script src="{{asset('assets/js/flatpickr.js')}}"></script>

	<!-- Global Settings -->
	<script src="{{asset('assets/js/settings.js')}}"></script>

	<!-- Chart.js -->
	<!--<script src="/assets/vendor/Chart.min.js')}}"></script>-->

	<!-- App Charts JS -->
	<!--<script src="/assets/js/chartjs-rounded-bar.js')}}"></script>
	<script src="/assets/js/charts.js')}}"></script>-->

	<!-- Vector Maps -->
	<script src="{{asset('assets/vendor/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{asset('assets/vendor/jqvmap/maps/jquery.vmap.world.js')}}"></script>
	<script src="{{asset('assets/js/vector-maps.js')}}"></script>

	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

	<!-- Sweetalert -->
	<script src="../js/sweetalert.min.js"></script>

	<script type="text/javascript">
		$(window).on('load',function() {
            // Animate loader off screen
            $(".pre-loading").fadeOut("slow");
        });
		/* global token */
		var token = "{{csrf_token()}}";
		var pub_path='../public';
    </script>

	<!-- Chart Samples -->
	<!--<script src="/assets/js/page.dashboard.js"></script>-->
