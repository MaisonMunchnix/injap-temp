<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<title>Dashboard - @yield('title')</title>
		 @include('TellerSystem.includes.head')
	</head>
	@csrf
	<body class="layout-default">
		<div class="preloader"></div>
		<div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px" data-fullbleed>
			<div class="mdk-drawer-layout__content">

				<!-- Header Layout -->
				<div class="mdk-header-layout js-mdk-header-layout" data-has-scrolling-region>

					 @include('TellerSystem.includes.header')

					<!-- Header Layout Content -->
					<div class="mdk-header-layout__content mdk-header-layout__content--fullbleed mdk-header-layout__content--scrollable page">
					
						<div class="container-fluid page__container">
							<div class="card card-form">
								<div class="row no-gutters">
									@yield('content')
								</div>
							</div>
						</div>
					</div>
					<!-- // END header-layout__content -->
				</div>
				<!-- // END header-layout -->
			</div>
			<!-- // END drawer-layout__content -->
			 @include('TellerSystem.includes.sidebar')
		</div>
		<!-- // END drawer-layout -->
		<!-- App Settings FAB -->
		<div id="app-settings">
			<app-settings></app-settings>
		</div>
		<div class="pre-loading"></div>
		<div class="send-loading"></div>
 		@include('TellerSystem.includes.script')
		@yield('script_add')
	</body>
</html>
