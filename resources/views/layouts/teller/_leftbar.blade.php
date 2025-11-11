 <!-- Start Leftbar -->
 <div class="leftbar">
 	<!-- Start Sidebar -->
 	<div class="sidebar">
 		<!-- Start Logobar -->
 		<div class="logobar">
 			<a href="{!! url('teller-admin/'); !!}" class="logo logo-large"><img src="{{ asset('teller_assets/images/logo.svg') }}" class="img-fluid" alt="logo"></a>
 			<a href="{!! url('teller-admin/'); !!}" class="logo logo-small"><img src="{{ asset('teller_assets/images/fav.png') }}" class="img-fluid" alt="logo"></a>
 		</div>
 		<!-- End Logobar -->
 		<!-- Start Profilebar -->
 		<div class="profilebar text-center">
 			<img src="{{ asset('teller_assets/images/users/profile.svg') }}" class="img-fluid" alt="profile">
 			<div class="profilename" style="text-transform: uppercase">
 				<!--<h5 class="text-white">Rommel Lacap</h5>-->
 				<h5 class="text-white">{{ $user = auth()->user()->email }}</h5>
 				<p>{{ $user = auth()->user()->userType }}</p>
 			</div>
 			<div class="userbox">
 				<ul class="list-inline mb-0">
 					<li class="list-inline-item"><a href="#" class="profile-icon"><img src="{{ asset('teller_assets/images/svg-icon/user.svg') }}" class="img-fluid" alt="user"></a></li>
 					<li class="list-inline-item"><a href="#" class="profile-icon"><img src="{{ asset('teller_assets/images/svg-icon/email.svg') }}" class="img-fluid" alt="email"></a></li>
 					<li class="list-inline-item"><a href="{{route('logout')}}" class="profile-icon"><img src="{{ asset('teller_assets/images/svg-icon/logout.svg') }}" class="img-fluid" alt="logout"></a></li>
 				</ul>
 			</div>
 		</div>
 		<!-- End Profilebar -->
 		<!-- Start Navigationbar -->
 		<div class="navigationbar">
 			<ul class="vertical-menu">
 				<li class="vertical-header">Main</li>
 				<li class="{{ Request::is('teller-admin/new-transaction/*') ? 'active' : '' }}">
 					<a href="{!! url('teller/new-transaction/non-member'); !!}">
 						<img src="{{ asset('teller_assets/images/svg-icon/apps.svg') }}" class="img-fluid " alt="widgets"><span>New Transaction</span>
 					</a>
 				</li>


 				<li class="{{ Request::is('teller-admin/members') ? 'active' : '' }}">
 					<a href="javaScript:void();">
 						<img src="{{ asset('teller_assets/images/svg-icon/user.svg') }}" class="img-fluid" alt="tables"><span>Member </span><i class="feather icon-chevron-right pull-right"></i>
 					</a>
 					<a href="javaScript:void();">
 						<img src="{{ asset('teller_assets/images/svg-icon/user.svg') }}" class="img-fluid" alt="tables"><span>Non Member </span><i class="feather icon-chevron-right pull-right"></i>
 					</a>
 					<ul class="vertical-submenu ">
 						<!--<li><a href="process-order.html" class="active"><i class="mdi mdi-circle "></i>Add New Member</a></li>-->
 						<li class="{{ Request::is('teller/members') ? 'active' : '' }}"><a href="{!! url('teller/members'); !!}"><i class="mdi mdi-circle"></i>Member List</a></li>
 					</ul>
 				</li>
 				@if(auth()->user()->userType == 'admin')
 				<li class="{{ Request::is('admin/users') ? 'active' : '' }}">
 					<a href="javaScript:void();">
 						<img src="{{ asset('teller_assets/images/svg-icon/user.svg') }}" class="img-fluid" alt="tables"><span>Users </span><i class="feather icon-chevron-right pull-right"></i>
 					</a>
 					<ul class="vertical-submenu ">
 						<li class="{{ Request::is('admin/users') ? 'active' : '' }}"><a href="{!! url('admin/users'); !!}"><i class="mdi mdi-circle"></i>Users List</a></li>
 					</ul>
 				</li>
 				@endif
 				<li class="{{ Request::is('teller-admin/process-order') ? 'active' : '' }}">
 					<a href="javaScript:void();">
 						<img src="{{ asset('teller_assets/images/svg-icon/ecommerce.svg') }}" class="img-fluid" alt="tables"><span>Order Management</span><i class="feather icon-chevron-right pull-right"></i>
 					</a>
 					<ul class="vertical-submenu ">
 						<li class="{{ Request::is('teller-admin/process-order') ? 'active' : '' }}">
 							<a href="{!! url('teller/process-order'); !!}"><i class="mdi mdi-circle "></i>Process Order</a>
 						</li>
 						<li><a href="{!! url('teller/record-sales'); !!}"><i class="mdi mdi-circle"></i>Record Sales</a></li>
 						<li><a href="{!! url('teller/overide-sales'); !!}"><i class="mdi mdi-circle"></i>Override</a></li>
 						<li><a href="{!! url('teller/void-transaction'); !!}"><i class="mdi mdi-circle"></i>Void Transaction</a></li>
 					</ul>
 				</li>
 				@if(auth()->user()->userType == 'admin')
 				<li class="{{ Request::is('admin/products') ? 'active' : '' }}">
 					<a href="javaScript:void();">
 						<img src="{{ asset('teller_assets/images/svg-icon/tables.svg') }}" class="img-fluid" alt="tables"><span>Products </span><i class="feather icon-chevron-right pull-right"></i>
 					</a>
 					<ul class="vertical-submenu ">
 						<li class="{{ Request::is('admin/inventories') ? 'active' : '' }}">
 							<a href="{!! url('admin/inventories'); !!}"><i class="mdi mdi-circle"></i>Inventories</a>
 						</li>

 						<li class="{{ Request::is('admin/product-categories') ? 'active' : '' }}">
 							<a href="{!! url('admin/product-categories'); !!}"><i class="mdi mdi-circle"></i>Categories</a>
 						</li>
 						<li class="{{ Request::is('admin/packages') ? 'active' : '' }}">
 							<a href="{!! url('admin/packages'); !!}"><i class="mdi mdi-circle"></i>Packages</a>
 						</li>
 						<li class="{{ Request::is('admin/packages') ? 'active' : '' }}">
 							<a href="{!! url('admin/package-products'); !!}"><i class="mdi mdi-circle"></i>Package Products</a>
 						</li>

 						<li class="{{ Request::is('admin/products') ? 'active' : '' }}">
 							<a href="{!! url('admin/products'); !!}"><i class="mdi mdi-circle"></i>Product List</a>
 						</li>



 					</ul>
 				</li>
 				@endif
 				<li class="vertical-header">Extras</li>
 				<li>
 					<a href="{{route('logout')}}">
 						<img src="{{ asset('teller_assets/images/svg-icon/horizontal.svg') }}" class="img-fluid" alt="user"><span>Logout</span>
 					</a>

 				</li>
 			</ul>
 		</div>
 		<!-- End Navigationbar -->
 	</div>
 	<!-- End Sidebar -->
 </div>
