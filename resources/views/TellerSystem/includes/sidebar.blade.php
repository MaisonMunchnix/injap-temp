<style>
    .sidebar-menu-item .active {
        background-color: #4a90e2;
        color: white;
    }
</style>
<div class="mdk-drawer  js-mdk-drawer" id="default-drawer" data-align="start">
    <div class="mdk-drawer__content">
        <div class="sidebar sidebar-dark sidebar-left simplebar" data-simplebar>
            <div class="d-flex align-items-center sidebar-p-a border-bottom sidebar-account flex-shrink-0">
                <a href="{{ route('landing.home') }}" class="flex d-flex align-items-center text-underline-0 text-body">
                    <span class="mr-3">
                        <img src="../assets/images/logo.svg" width="43" height="43" alt="avatar">
                    </span>
                    <span class="flex d-flex flex-column">
                        <strong class="h5 text-body mb-0">Company</strong>
                        <small class="text-muted text-uppercase">Company Details</small>
                    </span>
                </a>
                <div class="dropdown ml-auto">
                    <a href="#" data-toggle="dropdown" data-caret="false" class="text-muted"><i
                            class="material-icons">keyboard_arrow_down</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-item-text dropdown-item-text--lh">
                            <div><strong>Administrator</strong></div>
                            <div>@administrator</div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item active" href="{{ route('landing.home') }}">Dashboard</a>
                        <a class="dropdown-item" href="profile.html">Change Password</a>
                        <!--<a class="dropdown-item" href="edit-account.html">Edit account</a>-->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
            <div class="sidebar-stats row no-gutters align-items-center text-center border-bottom flex-shrink-0">
                <div class="sidebar-stats__col col">
                    <div class="sidebar-stats__title">Members</div>
                    <div class="sidebar-stats__value">1,000</div>
                </div>
                <!--<div class="sidebar-stats__col col border-left">
                            <div class="sidebar-stats__title">Earnings</div>
                            <div class="sidebar-stats__value">$1,402</div>
                        </div>-->
            </div>

            <div class="py-4 text-center flex-shrink-0">
                <a href="{!! url('teller-admin/register') !!}" class="btn btn-primary w-50">Add New Member </a>
            </div>

            <ul class="nav nav-tabs sidebar-tabs flex-shrink-0" role="tablist">
                <li class="nav-item"><a class="nav-link active show" id="sm-menu-tab" href="#sm-menu" data-toggle="tab"
                        role="tab" aria-controls="sm-menu" aria-selected="true">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="#sm-account" data-toggle="tab">Account</a></li>
                <!--<li class="nav-item"><a class="nav-link" href="#sm-settings" data-toggle="tab">Settings</a></li>-->
            </ul>
            <div class="tab-content">
                <div id="sm-menu" class="tab-pane show active" role="tabpanel" aria-labelledby="sm-menu-tab">
                    <ul class="sidebar-menu flex">
                        <li class="sidebar-menu-item {{ Request::is('teller-admin') ? 'active' : '' }}">
                            <a class="sidebar-menu-button" href="/teller-admin">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dvr</i>
                                <span class="sidebar-menu-text">Dashboard</span>
                            </a>
                        </li>

                        <li
                            class="sidebar-menu-item {{ Request::is('teller-admin/generate') || Request::is('teller-admin/product_codes') ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" data-toggle="collapse" href="#pages_menu">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">description</i>
                                <span class="sidebar-menu-text">Activation Code List</span>
                                <!--<span class="badge badge-warning rounded-circle badge-notifications ml-auto">8</span>-->
                                <span class="sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu collapse" id="pages_menu">
                                <li
                                    class="sidebar-menu-item {{ Request::is('teller-admin/generate') ? 'active' : '' }}">
                                    <a class="sidebar-menu-button" href="{!! url('teller-admin/generate') !!}">
                                        <span class="sidebar-menu-text">Generate</span>
                                    </a>
                                </li>
                                <!--<li class="sidebar-menu-item {{ Request::is('teller-admin/generate_codes') ? 'active' : '' }}">
         <a class="sidebar-menu-button" href="{!! url('teller-admin/generate_codes') !!}">
          <span class="sidebar-menu-text">Generate New Code</span>
         </a>
        </li>-->
                                <li
                                    class="sidebar-menu-item {{ Request::is('teller-admin/product_codes') ? 'active' : '' }}">
                                    <a class="sidebar-menu-button" href="{!! url('teller-admin/product_codes') !!}">
                                        <span class="sidebar-menu-text">Existing Code List</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="sidebar-menu-item {{ Request::is('teller-admin/register') || Request::is('teller-admin/members') || Request::is('teller-admin/users') ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" data-toggle="collapse" href="#components_menu">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">developer_board</i>
                                <span class="sidebar-menu-text">Users List</span>
                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu collapse" id="components_menu">
                                <li class="sidebar-menu-item {{ Request::is('teller-admin/users') ? 'active' : '' }}">
                                    <a class="sidebar-menu-button" href="{!! url('teller-admin/users') !!}">
                                        <span class="sidebar-menu-text">Users</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-menu-item {{ Request::is('teller-admin/members') ? 'active' : '' }}">
                                    <a class="sidebar-menu-button" href="{!! url('teller-admin/members') !!}">
                                        <span class="sidebar-menu-text">Members</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-menu-item {{ Request::is('teller-admin/register') ? 'active' : '' }}">
                                    <a class="sidebar-menu-button" href="{!! url('teller-admin/register') !!}">
                                        <span class="sidebar-menu-text">Add New Member</span>
                                    </a>
                                </li>
                                <!--<li class="sidebar-menu-item">
         <a class="sidebar-menu-button" href="edit-account.html">
          <span class="sidebar-menu-text">Update Existing Member</span>
         </a>
        </li>-->
                            </ul>
                        </li>
                        <!-- Product Management-->
                        <li
                            class="sidebar-menu-item {{ Request::is('teller-admin/products') || Request::is('teller-admin/inventories') || Request::is('teller-admin/product-categories') || Request::is('teller-admin/packages') ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" data-toggle="collapse" href="#product_menu">
                                <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">developer_board</i>
                                <span class="sidebar-menu-text">Product Management</span>
                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu collapse" id="product_menu">
                                <li
                                    class="sidebar-menu-item {{ Request::is('teller-admin/packages') ? 'active' : '' }}">
                                    <a class="sidebar-menu-button" href="{!! url('teller-admin/packages') !!}">
                                        <span class="sidebar-menu-text">Packages</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-menu-item {{ Request::is('teller-admin/products') ? 'active' : '' }}">
                                    <a class="sidebar-menu-button" href="{!! url('teller-admin/products') !!}">
                                        <span class="sidebar-menu-text">Product List</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-menu-item {{ Request::is('teller-admin/inventories') ? 'active' : '' }}">
                                    <a class="sidebar-menu-button" href="{!! url('teller-admin/inventories') !!}">
                                        <span class="sidebar-menu-text">Inventories</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-menu-item {{ Request::is('teller-admin/product-categories') ? 'active' : '' }}">
                                    <a class="sidebar-menu-button" href="{!! url('teller-admin/product-categories') !!}">
                                        <span class="sidebar-menu-text">Categories</span>
                                    </a>
                                </li>
                                <!--<li class="sidebar-menu-item {{ Request::is('teller-admin/register') ? 'active' : '' }}">
         <a class="sidebar-menu-button" href="{!! url('teller-admin/register') !!}">
          <span class="sidebar-menu-text">Add New Product</span>
         </a>
        </li>
        <li class="sidebar-menu-item">
         <a class="sidebar-menu-button" href="edit-account.html">
          <span class="sidebar-menu-text">Package</span>
         </a>
        </li>-->
                            </ul>
                        </li>

                    </ul>
                </div>
                <div id="sm-account" class="tab-pane">
                    <ul class="sidebar-menu">
                        <!--<li class="sidebar-menu-item">
       <a class="sidebar-menu-button" href="edit-account.html">
        <span class="sidebar-menu-text">Edit Information</span>
       </a>
      </li>
      <!-- <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="edit-account.html">
                                        <span class="sidebar-menu-text">Payments</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="edit-account.html">
                                        <span class="sidebar-menu-text">Billing</span>
                                    </a>
                                </li>-->
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" href="edit-account.html">
                                <span class="sidebar-menu-text">Change Password</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-button" href="{{ route('logout') }}">
                                <span class="sidebar-menu-text">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-auto sidebar-p-a sidebar-b-t d-flex flex-column flex-shrink-0">
                <a class="sidebar-link" href="{{ route('logout') }}">
                    Logout
                    <i class="sidebar-menu-icon ml-2 material-icons icon-16pt">exit_to_app</i>
                </a>
            </div>

        </div>
    </div>
</div>
