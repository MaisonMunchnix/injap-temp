<div class="navigation">
    @php
        $isInstructorsOnlyStaff = auth()->check()
            && auth()->user()->userType === 'staff'
            && auth()->user()->admin_scope === 'instructors_only';
    @endphp
    <div class="navigation-menu-tab">
        <ul>
            <!-- Dashboard - Always visible for all approver types -->
            @if(!$isInstructorsOnlyStaff)
                <li>
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Dashboard" data-nav-target="#ecommerce">
                        <i data-feather="home"></i>
                    </a>
                </li>
            @endif



            <!-- Application Approver: Show Distributors List tab -->
            @if(!$isInstructorsOnlyStaff && auth()->user() && (auth()->user()->userType === 'staff' || auth()->user()->userType === 'applicationApprover'))
                <li>
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Distributors List"
                        data-nav-target="#user">
                        <i data-feather="users"></i>
                    </a>
                </li>
            @endif

            <!-- Instructors: Show if can_manage_instructors -->
            @if(auth()->check() && auth()->user()->can_manage_instructors)
                <li>
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Instructors"
                        data-nav-target="#instructors">
                        <i data-feather="book-open"></i>
                    </a>
                </li>
            @endif

            <!-- Product Approver: Show Products & Orders tab -->
            @if(!$isInstructorsOnlyStaff && auth()->user() && (auth()->user()->userType === 'staff' || auth()->user()->userType === 'productApprover'))
                <li>
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Products & Orders"
                        data-nav-target="#products">
                        <i data-feather="star"></i>
                    </a>
                </li>
            @endif

            <!-- Payment Approver: Show Payments tab -->
            @if(!$isInstructorsOnlyStaff && auth()->user() && (auth()->user()->userType === 'staff' || auth()->user()->userType === 'paymentApprover'))
                <li>
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Payments" data-nav-target="#payments">
                        <i data-feather="credit-card"></i>
                    </a>
                </li>
            @endif

            <!-- Messages - Staff only -->
            @if(!$isInstructorsOnlyStaff && auth()->user() && auth()->user()->userType === 'staff')
                <li>
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Messages" data-nav-target="#messages">
                        <i data-feather="mail"></i>
                    </a>
                </li>
            @endif

            <!-- Top Pairing & Referral - Staff only -->
            @if(!$isInstructorsOnlyStaff && auth()->user() && auth()->user()->userType === 'staff')
                <li>
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Top Pairing & Referral"
                        data-nav-target="#top-pairing-referral">
                        <i data-feather="trending-up"></i>
                    </a>
                </li>
            @endif

            <!-- Settings - Always visible -->
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Settings" data-nav-target="#pages">
                    <i data-feather="settings"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="navigation-menu-body">
        <div class="navigation-menu-group">
            <!-- Dashboard Section - Always shown -->
            @if(!$isInstructorsOnlyStaff)
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
            @endif



            <!-- Application Approver Section - Pending Applications & Members -->
            @if(!$isInstructorsOnlyStaff && auth()->user() && (auth()->user()->userType === 'staff' || auth()->user()->userType === 'applicationApprover'))
                <div id="user">
                    <ul>
                        <li class="navigation-divider d-flex align-items-center">
                            <i class="mr-2" data-feather="users"></i> Distributors List
                        </li>
                        @if(auth()->user() && auth()->user()->userType === 'staff')
                            <li>
                                <a class="{{ request()->is('staff/members/all') || request()->is('members/all') ? 'active' : '' }}"
                                    href="{{ route('members-all') }}">All Members</a>
                            </li>
                            <li>
                                <a class="{{ request()->is('staff/applications/pending') ? 'active' : '' }}"
                                    href="{{ route('applications.pending') }}">Pending Applications</a>
                            </li>
                            <li>
                                <a class="{{ request()->is('staff/applications/codes') ? 'active' : '' }}"
                                    href="{{ route('applications.codes') }}">Product Codes</a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif

            <!-- Instructors Section -->
            @if(auth()->check() && auth()->user()->can_manage_instructors)
                <div id="instructors">
                    <ul>
                        <li class="navigation-divider d-flex align-items-center">
                            <i class="mr-2" data-feather="book-open"></i> Instructors Management
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/instructors*') ? 'active' : '' }}"
                                href="{{ route('admin.instructors.index') }}">Instructors Directory</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/courses*') ? 'active' : '' }}"
                                href="{{ route('admin.courses.index') }}">Course Review</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/enrollments*') ? 'active' : '' }}"
                                href="{{ route('admin.courses.enrollments') }}">Manage Enrollments</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/materials*') ? 'active' : '' }}"
                                href="{{ route('admin.courses.materials') }}">Learning Materials</a>
                        </li>
                    </ul>
                </div>
            @endif

            <!-- Product Approver Section - Products & Orders -->
            @if(!$isInstructorsOnlyStaff && auth()->user() && (auth()->user()->userType === 'staff' || auth()->user()->userType === 'productApprover'))
                <div id="products">
                    <ul>
                        <li class="navigation-divider d-flex align-items-center">
                            <i class="mr-2" data-feather="star"></i> Product & Order Management
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/admin/products/submissions/pending') || request()->is('admin/products/submissions/pending') ? 'active' : '' }}"
                                href="{{ route('admin.products.pending-submissions') }}">Pending Product Submissions</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/admin/availed-products/pending') || request()->is('admin/availed-products/pending') ? 'active' : '' }}"
                                href="{{ route('admin.availed-products.pending') }}">Pending Orders</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/admin/availed-products/approved') || request()->is('admin/availed-products/approved') ? 'active' : '' }}"
                                href="{{ route('admin.availed-products.approved') }}">Approved Orders</a>
                        </li>
                    </ul>
                </div>
            @endif

            <!-- Payment Approver Section - Payments -->
            @if(!$isInstructorsOnlyStaff && auth()->user() && (auth()->user()->userType === 'staff' || auth()->user()->userType === 'paymentApprover'))
                <div id="payments">
                    <ul>
                        <li class="navigation-divider d-flex align-items-center">
                            <i class="mr-2" data-feather="credit-card"></i> Payment Management
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/payments') || request()->is('staff/payments/*') ? 'active' : '' }}"
                                href="{{ route('admin.payments.index') }}">Manage Payments</a>
                        </li>
                    </ul>
                </div>
            @endif

            <!-- Messages Section - Staff only -->
            @if(!$isInstructorsOnlyStaff && auth()->user() && auth()->user()->userType === 'staff')
                <div id="messages">
                    <ul>
                        <li class="navigation-divider d-flex align-items-center">
                            <i class="mr-2" data-feather="mail"></i> Messages
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/messages') || request()->is('staff/messages/*') ? 'active' : '' }}"
                                href="{{ route('staff.messages.index') }}">Conversations</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/messages/create') ? 'active' : '' }}"
                                href="{{ route('staff.messages.create') }}">New Conversation</a>
                        </li>
                    </ul>
                </div>
            @endif

            <!-- Top Earners & Recognition - Only for Staff -->
            @if(!$isInstructorsOnlyStaff && auth()->user() && auth()->user()->userType === 'staff')
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

                <div id="top-pairing-referral">
                    <ul>
                        <li class="navigation-divider d-flex align-items-center">
                            <i class="mr-2" data-feather="trending-up"></i> Top Pairing & Referral
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/top-pairing-referral') || request()->is('top-pairing-referral') ? 'active' : '' }}"
                                href="{{ route('top-pairing-referral') }}">View Rankings</a>
                        </li>
                    </ul>
                </div>
            @endif

            <!-- Settings Section - Always shown -->
            <div id="pages">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="settings"></i> Settings
                    </li>
                    @if(!$isInstructorsOnlyStaff && auth()->user() && auth()->user()->userType === 'staff')
                        <li>
                            <a class="{{ request()->is('staff/users') ? 'active' : '' }}" href="{{ route('users') }}">Staff
                                Management</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/about-gallery*') ? 'active' : '' }}"
                                href="{{ route('admin.about-gallery.index') }}">About Page Gallery</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('staff/popup-announcements*') ? 'active' : '' }}"
                                href="{{ route('admin.popup-announcements.index') }}">Announcements</a>
                        </li>
                    @endif
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