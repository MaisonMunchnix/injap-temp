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
                 <a href="#" data-toggle="tooltip" data-placement="right" title="New Transaction"
                     data-nav-target="#user">
                     <i data-feather="users"></i>
                 </a>
             </li>
             <li>
                 <a href="#" data-toggle="tooltip" data-placement="right" title="Order Management"
                     data-nav-target="#components">
                     <i data-feather="shopping-cart"></i>
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
                         <a class="{{ request()->is('tellers/') || request()->is('tellers') || request()->is('teller-dashboard') ? 'active' : '' }}"
                             href="{{ route('teller-dashboard') }}">Dashboard</a>
                     </li>
                 </ul>
             </div>


             <div id="user">
                 <ul>
                     <li class="navigation-divider d-flex align-items-center">
                         <i class="mr-2" data-feather="users"></i> New Transaction
                     </li>
                     <li>
                         <a class="{{ request()->is('tellers/new-transaction/member') || request()->is('tellers/view-receipt/4') ? 'active' : '' }}"
                             href="{!! url('tellers/new-transaction/member') !!}">Walk In Member</a>
                     </li>
                     <li>
                         <a class="{{ request()->is('tellers/new-transaction/non-member') ? 'active' : '' }}"
                             href="{!! url('tellers/new-transaction/non-member') !!}">Walk In Non-Member</a>
                     </li>
                     <!--<li>
                         <a class="{{ request()->is('tellers/new-transaction/upgrade') ? 'active' : '' }}" href="{!! url('tellers/new-transaction/upgrade') !!}">Upgrade Investment</a>
                     </li>-->

                 </ul>
             </div>
             <div id="components">
                 <ul>
                     <li class="navigation-divider d-flex align-items-center">
                         <i class="mr-2" data-feather="shopping-cart"></i> Record Sales
                     </li>

                     {{-- <li>
                         <a class="{{ request()->is('tellers/process-order') ? 'active' : '' }}" href="{!! url('tellers/process-order') !!}">Process Order</a></li> --}}
                     <li>
                         <a class="{{ request()->is('tellers/record-sales') || request()->is('tellers/view-receipt/*') ? 'active' : '' }}"
                             href="{!! url('tellers/record-sales') !!}">Record Sales</a>
                     </li>
                 </ul>
             </div>
             <div id="forms">
                 <ul>
                     <li class="navigation-divider d-flex align-items-center">
                         <i class="mr-2" data-feather="globe"></i> Announcement
                     </li>
                     <li>
                         <a href="{{ route('landing.announcements') }}">View Announcement</a>
                     </li>

                 </ul>
             </div>

             <div id="pages">
                 <ul>
                     <li class="navigation-divider d-flex align-items-center">
                         <i class="mr-2" data-feather="settings"></i> Settings
                     </li>

                     <li>
                         <a href="{{ route('logout') }}">Logout</a>
                     </li>

                 </ul>
             </div>
         </div>
     </div>
 </div>
