<div class="navigation">
    <div class="navigation-menu-tab">
        <ul>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Dashboard"
                    data-nav-target="#ecommerce">
                    <i data-feather="home"></i>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Disributor Lists"
                    data-nav-target="#user">
                    <i data-feather="users"></i>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Encashment"
                    data-nav-target="#encash">
                    <i data-feather="edit-3"></i>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Reports"
                    data-nav-target="#reports">
                    <i data-feather="copy"></i>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Recognition"
                    data-nav-target="#recognition">
                    <i data-feather="gift"></i>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Products"
                    data-nav-target="#products">
                    <i data-feather="star"></i>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Settings"
                    data-nav-target="#pages">
                    <i data-feather="settings"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="navigation-menu-body">
        <div class="navigation-menu-group">
            <div id="ecommerce">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="home"></i> My Dashboard
                    </li>
                    <li>
                        <a class="{{ request()->is('admin-dashboard') || request()->is('staff') ? 'active' : '' }}"
                            href="{{ route('admin-dashboard') }}">Dashboard</a>
                    </li>
                </ul>
            </div>
            <div id="user">
                <ul
                    class="{{ request()->is('staff/members/today') || request()->is('staff/members/all') ? 'active' : '' }}">
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="users"></i> Distributors List
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/members/today') || request()->is('members/today') ? 'active' : '' }}"
                            href="{{ route('members-today') }}">New Members Today</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/members/all') || request()->is('members/all') ? 'active' : '' }}"
                            href="{{ route('members-all') }}">All Members</a>
                    </li>
                </ul>
            </div>



            <div id="encash">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="edit-3"></i> Encashments
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/encashment-view/*') || request()->is('encashment-view') || request()->is('staff/encashment-voucher/*') ? 'active' : '' }}"
                            href="{{ route('encashment-view', 'all') }}">All Encashment</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/redeem') ? 'active' : '' }}"
                            href="{{ route('redeem.admin-list') }}">Redeem</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/advertisements') ? 'active' : '' }}"
                            href="{{ route('admin.advertisements') }}">Advertisements</a>
                    </li>
                </ul>
            </div>
            <div id="reports">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="copy"></i> Reports
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/product-codes/members') || request()->is('product-codes/members') ? 'active' : '' }}"
                            href="/staff/product-codes/members">Members Product Codes</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/sales-report') || request()->is('sales-report') ? 'active' : '' }}"
                            href="{{ route('sales-report') }}">Sales Report</a>
                    </li>
                </ul>
            </div>
            <div id="recognition">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="gift"></i> Recognition
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/top-earners') || request()->is('top-earners') ? 'active' : '' }}"
                            href="{{ route('top-earners') }}">Top Earners</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/top-recruiters') || request()->is('top-recruiters') ? 'active' : '' }}"
                            href="{{ route('top-recuiters') }}">Top Recruiters</a>
                    </li>
                </ul>
            </div>
            <div id="products">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="star"></i> Product Management
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/products') || request()->is('products') ? 'active' : '' }}"
                            href="{{ route('product-list') }}">Products</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/add-product') || request()->is('add-product') ? 'active' : '' }}"
                            href="{{ route('add-product') }}">Add Product</a>
                    </li>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="star"></i> Inventory
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/all-inventories/*') ? 'active' : '' }}"
                            href="{{ route('branch-inventories', 1) }}">Inventories</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/add-stocks') || request()->is('add-stocks') ? 'active' : '' }}"
                            href="{{ route('add-stocks') }}">Add Stock</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/transfer-stocks') || request()->is('transfer-stocks') ? 'active' : '' }}"
                            href="{{ route('transfer-stocks') }}">Transfer Stock</a>
                    </li>
                </ul>
            </div>
            <div id="branches">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="activity"></i> Branches
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/users') || request()->is('users') ? 'active' : '' }}"
                            href="{{ route('users') }}">Teller List</a>
                    </li>
                </ul>
            </div>
            <div id="pages">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="settings"></i> Settings
                    </li>
                    <li>
                        <a class="{{ request()->is('staff/profile') || request()->is('profile') ? 'active' : '' }}"
                            href="{{ route('admin.profile') }}">Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end::navigation -->
