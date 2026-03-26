<!-------------------- START - Mobile Menu -------------------->
<div class="menu-mobile menu-activated-on-click color-scheme-dark">
    <div class="mm-logo-buttons-w">
        <a class="mm-logo" href="{{ route('home') }}"><span>Purple Life</span></a>
        <div class="mm-buttons">
            {{-- <div class="content-panel-open">
                <div class="os-icon os-icon-grid-circles"></div>
            </div> --}}
            <div class="mobile-menu-trigger">
                <div class="os-icon os-icon-hamburger-menu-1"></div>
            </div>
        </div>
    </div>
    <div class="menu-and-user">
        <div class="logged-user-w">
            <div class="avatar-w"><img alt=""
                    @if (!empty($global_user_data->profile_picture)) src="{{ asset('images/users/' . $global_user_data->user_id . '/' . $global_user_data->profile_picture) }}" @else src="{{ asset('img/default_image.png') }}" @endif>
            </div>
            <div class="logged-user-info-w">
                <div class="logged-user-name">
                    @if (!empty($global_user_data->first_name))
                        {{ $global_user_data->first_name }}
                        @endif @if (!empty($global_user_data->last_name))
                            {{ $global_user_data->last_name }}
                        @endif
                </div>
                <div class="logged-user-role">Administrator</div>
            </div>
        </div>
        <!-------------------- START - Mobile Menu List -------------------->
        <ul class="main-menu">
            <li>
                <a href="{{ route('admin-dashboard') }}">
                    <div class="icon-w">
                        <div class="os-icon os-icon-layout"></div>
                    </div><span>Dashboard</span>
                </a>
            </li>
            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-file-text"></div>
                    </div>
                    <span>Applications</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('applications.pending') }}">Pending List</a></li>
                </ul>
            </li>
            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-grid"></div>
                    </div>
                    <span>Product Codes</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('applications.codes') }}">Code Generator</a></li>
                </ul>
            </li>
            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-users"></div>
                    </div>
                    <span>Members Account</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('members-today') }}">Member List</a></li>
                </ul>
            </li>
            <!--<li class="has-sub-menu">
    <a href="#">
     <div class="icon-w">
      <div class="os-icon os-icon-info"></div>
     </div><span>Staff Management</span>
    </a>
    <ul class="sub-menu">
     <li><a href="#">Add Staff</a></li>
     <li><a href="#">Permission</a></li>
    </ul>
   </li>-->
            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-tasks-checked"></div>
                    </div><span>Inventory</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('beginning-inventories') }}">Beginning Inventory</a></li>
                    <li><a href="{{ URL::to('staff/all-inventories', 1) }}">Inventory List</a></li>
                    <!--<li><a href="">Void Transaction</a></li>-->
                    <li><a href="{{ route('transfer-stocks') }}">Transfer Stocks</a></li>
                </ul>
            </li>

            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-package"></div>
                    </div><span>Product Management</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('ewallet-purchases') }}">EWallet Purchases</a></li>
                    <li><a href="{{ route('product-list') }}">Product List</a></li>
                    <li><a href="{{ route('add-product') }}">Product Setup</a></li>
                    <li><a href="{{ route('package-list') }}">Package List</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('announcement-list') }}">
                    <div class="icon-w">
                        <div class="os-icon os-icon-file-text"></div>
                    </div><span>Announcement</span>
                </a>
                <ul class="sub-menu">
                </ul>
            </li>
            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-package"></div>
                    </div><span>Reimbursements</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('encashment-view', 'all') }}">All Reimbursements</a></li>
                    <li><a href="{{ route('encashment-view', 'pending') }}">Pending</a></li>
                    <li><a href="{{ route('encashment-view', 'hold') }}">Hold</a></li>
                    <li><a href="{{ route('encashment-view', 'decline') }}">Declined</a></li>
                    <li><a href="{{ route('encashment-view', 'approved') }}">Approved</a></li>
                    <li><a href="{{ route('encashment-view', 'claimed') }}">Claimed</a></li>
                </ul>
            </li>
            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-grid"></div>
                    </div><span>Reports</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('product-codes', 'members') }}">Checking of codes</a></li>
                    <li><a href="{{ route('sales-report') }}">Sales Report</a></li>
                    <li><a href="{{ route('user-logs') }}">User Logs</a></li>
                </ul>
            </li>
            <!-- <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-crown"></div>
                    </div><span>Recognition</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('top-earners') }}">Top Earners</a></li>
                    <li><a href="{{ route('top-recuiters') }}">Top Recruiters</a></li>
                </ul>
            </li> -->

            <li class="has-sub-menu">
                <a href="#">
                    <div class="icon-w">
                        <div class="os-icon os-icon-signs-11"></div>
                    </div><span>Branch</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="{{ route('add-branch') }}">Add Branch</a></li>
                    <li><a href="{{ route('branch-list') }}">Branch List</a></li>
                    <li><a href="{{ route('users') }}">Staff / Teller List</a></li>
                    <!-- <li><a href="{{ route('add-supplier') }}">Add Supplier</a></li>
                    <li><a href="{{ route('supplier-list') }}">Supplier List</a></li> -->
                </ul>
            </li>

        </ul>
        <!-------------------- END - Mobile Menu List -------------------->
        <div class="mobile-menu-magic">
            <h4>Purple Life</h4>
            <p>Organic Products</p>

        </div>
    </div>
</div>
<!-------------------- END - Mobile Menu -------------------->

<!-------------------- START - Main Menu -------------------->
<div
    class="menu-w color-scheme-dark color-style-bright menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
    <div class="logo-w">
        <a class="logo" href="">
            <div style=" height: 5px;"></div>
            <div class="logo-label">Purple Life Organic</div>
        </a>
    </div>
    <div class="logged-user-w avatar-inline">
        <div class="logged-user-i">
            <div class="avatar-w"><img alt=""
                    @if (!empty($global_user_data->profile_picture)) src="{{ asset('images/users/' . $global_user_data->user_id . '/' . $global_user_data->profile_picture) }}" @else src="{{ asset('img/default_image.png') }}" @endif>
            </div>
            <div class="logged-user-info-w">
                <div class="logged-user-name text-capitalize">
                    @if (!empty($global_user_data->first_name))
                        {{ $global_user_data->first_name }}
                        @endif @if (!empty($global_user_data->last_name))
                            {{ $global_user_data->last_name }}
                        @endif
                </div>
                <div class="logged-user-role text-capitalize">Administrator</div>
            </div>
            <div class="logged-user-toggler-arrow">
                <div class="os-icon os-icon-chevron-down"></div>
            </div>
            <div class="logged-user-menu color-style-bright">
                <div class="logged-user-avatar-info">
                    <div class="avatar-w"><img alt=""
                            @if (!empty($global_user_data->profile_picture)) src="{{ asset('images/users/' . $global_user_data->user_id . '/' . $global_user_data->profile_picture) }}" @else src="{{ asset('img/default_image.png') }}" @endif>
                    </div>
                    <div class="logged-user-info-w">
                        <div class="logged-user-name text-capitalize">
                            @if (!empty($global_user_data->first_name))
                                {{ $global_user_data->first_name }}
                                @endif @if (!empty($global_user_data->last_name))
                                    {{ $global_user_data->last_name }}
                                @endif
                        </div>
                        <div class="logged-user-role text-capitalize">Administrator</div>
                    </div>
                </div>
                <div class="bg-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                <ul>

                    {{-- <li><a href="#"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a></li> --}}
                    <li><a href="{{ route('logout') }}"><i
                                class="os-icon os-icon-signs-11"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <h1 class="menu-page-header">Page Header</h1>
    <ul class="main-menu">
        <li class="sub-header"><span>Home</span></li>
        <li>
            <a href="{{ route('admin-dashboard') }}">
                <div class="icon-w">
                    <div class="os-icon os-icon-layout"></div>
                </div><span>Dashboard</span>
            </a>

        </li>
        <li class="sub-header"><span>Options</span></li>
        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-file-text"></div>
                </div><span>Applications</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Applications</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-file-text"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{ route('applications.pending') }}">Pending List</a></li>
                    </ul>
                </div>
            </div>
        </li>

        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-grid"></div>
                </div><span>Product Codes</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Product Codes</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-grid"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{ route('applications.codes') }}">Code Generator</a></li>
                    </ul>
                </div>
            </div>
        </li>

        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-users"></div>
                </div><span>Members Account</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Members</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{ route('members-today') }}">Distributors List</a></li>
                    </ul>

                </div>
            </div>
        </li>
        <!--<li class=" has-sub-menu">
   <a href="#">
    <div class="icon-w">
     <div class="os-icon os-icon-info"></div>
    </div><span>Staff Management</span>
   </a>
   <div class="sub-menu-w">
    <div class="sub-menu-header">Company</div>
    <div class="sub-menu-icon"><i class="os-icon os-icon-file-info"></i></div>
    <div class="sub-menu-i">
     <ul class="sub-menu">
      <li><a href="#">Add Staff</a></li>
      <li><a href="#">Permissions</a></li>
     </ul>
    </div>
   </div>
  </li>-->


        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-tasks-checked"></div>
                </div><span>Inventory</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Inventory</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-tasks-checked"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">

                        <li><a href="{{ route('beginning-inventories') }}">Beginning Inventory</a></li>
                        <li><a href="{{ URL::to('staff/all-inventories', 1) }}">Inventory List</a></li>
                        <!--<li><a href="#">Void Transaction</a></li>-->
                        <li><a href="{{ route('transfer-stocks') }}">Transfer Stocks</a></li>
                    </ul>
                </div>
            </div>
        </li>
        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-package"></div>
                </div><span>Product Management</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Product</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-package"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{ route('ewallet-purchases') }}">EWallet Purchases</a></li>
                        <li><a href="{{ route('product-list') }}">Product List</a></li>
                        <li><a href="{{ route('add-product') }}">Product Setup</a></li>
                        <li><a href="{{ route('package-list') }}">Package List</a></li>
                        <!--<li><a href="#">Package Setup</a></li>-->
                    </ul>
                </div>
            </div>
        </li>

        <li>
            <a href="{{ route('announcement-list') }}">
                <div class="icon-w">
                    <div class="os-icon os-icon-file-text"></div>
                </div><span>Announcement</span>
            </a>
        </li>

        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-package"></div>
                </div><span>Encashments</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Encashments</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-package"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{ route('encashment-view', 'all') }}">All Reimbursements</a></li>
                        <li><a href="{{ route('encashment-view', 'pending') }}">Pending</a></li>
                        <li><a href="{{ route('encashment-view', 'hold') }}">Hold</a></li>
                        <li><a href="{{ route('encashment-view', 'decline') }}">Declined</a></li>
                        <li><a href="{{ route('encashment-view', 'approved') }}">Approved</a></li>
                        <li><a href="{{ route('encashment-view', 'claimed') }}">Claimed</a></li>
                    </ul>
                </div>
            </div>
        </li>

        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-grid"></div>
                </div><span>Reports</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Reports</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-grid"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{ route('product-codes', 'members') }}">Checking of codes</a></li>
                        <li><a href="{{ route('sales-report') }}">Sales Report</a></li>
                        <li><a href="{{ route('user-logs') }}">User Logs</a></li>
                    </ul>

                </div>
            </div>
        </li>
        <li class="sub-header"><span>Others</span></li>
        <!-- <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-crown"></div>
                </div><span>Recognition</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Recognition</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-crown"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{ route('top-earners') }}">Top Earners</a></li>
                        <li><a href="{{ route('top-recuiters') }}">Top Recruiters</a></li>

                    </ul>
                </div>
            </div>
        </li> -->
        <li class=" has-sub-menu">
            <a href="#">
                <div class="icon-w">
                    <div class="os-icon os-icon-signs-11"></div>
                </div><span>Branches</span>
            </a>
            <div class="sub-menu-w">
                <div class="sub-menu-header">Branch Setup</div>
                <div class="sub-menu-icon"><i class="os-icon os-icon-signs-11"></i></div>
                <div class="sub-menu-i">
                    <ul class="sub-menu">
                        <li><a href="{{ route('add-branch') }}">Add Branch</a></li>
                        <li><a href="{{ route('branch-list') }}">Branch List</a></li>
                        <li><a href="{{ route('users') }}">Staff / Teller List</a></li>
                        <!-- <li><a href="{{ route('add-supplier') }}">Add Supplier</a></li>
                        <li><a href="{{ route('supplier-list') }}">Supplier List</a></li> -->
                    </ul>
                </div>
            </div>
        </li>
    </ul>
    <div class="side-menu-magic">
        <h4>Purple Life</h4>
        <p>Organic Products</p>

    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</div>
<!-------------------- END - Main Menu -------------------->
