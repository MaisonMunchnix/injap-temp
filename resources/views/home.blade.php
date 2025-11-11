<!DOCTYPE html>
<html>
<!-- Mirrored from light.pinsupreme.com/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 25 Nov 2019 05:21:53 GMT -->

<head>
    <title>Admin Dashboard HTML Template</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="css/favicon.ico" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="http://fast.fonts.net/cssapi/487b73f1-c2d1-43db-8526-db577e4c822b.css" rel="stylesheet" type="text/css">
    <link href="css/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="css/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="css/bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="css/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="css/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="css/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="css/bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="css/css/maince5a.css?version=4.4.1" rel="stylesheet">
    <script src="js/js/jq.js"></script>
    <link href="css/tab.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="js/js/tab.min.js"></script>



    <link href="css/bower_components/dragula.js/dist/dragula.min.css" rel="stylesheet">


    <style>
        .panel.with-nav-tabs .panel-heading {
            padding: 5px 5px 0 5px;
        }

        .panel.with-nav-tabs .nav-tabs {
            border-bottom: none;
        }

        .panel.with-nav-tabs .nav-justified {
            margin-bottom: -1px;
        }

        /********************************************************************/
        /*** PANEL DEFAULT ***/
        .with-nav-tabs.panel-default .nav-tabs>li>a,
        .with-nav-tabs.panel-default .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-default .nav-tabs>li>a:focus {
            color: #777;
        }

        .with-nav-tabs.panel-default .nav-tabs>.open>a,
        .with-nav-tabs.panel-default .nav-tabs>.open>a:hover,
        .with-nav-tabs.panel-default .nav-tabs>.open>a:focus,
        .with-nav-tabs.panel-default .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-default .nav-tabs>li>a:focus {
            color: #777;
            background-color: #ddd;
            border-color: transparent;
        }

        .with-nav-tabs.panel-default .nav-tabs>li.active>a,
        .with-nav-tabs.panel-default .nav-tabs>li.active>a:hover,
        .with-nav-tabs.panel-default .nav-tabs>li.active>a:focus {
            color: #555;
            background-color: #fff;
            border-color: #ddd;
            border-bottom-color: transparent;
        }

        .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu {
            background-color: #f5f5f5;
            border-color: #ddd;
        }

        .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>li>a {
            color: #777;
        }

        .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
        .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
            background-color: #ddd;
        }

        .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>.active>a,
        .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
        .with-nav-tabs.panel-default .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
            color: #fff;
            background-color: #555;
        }

        /********************************************************************/
        /*** PANEL PRIMARY ***/
        .with-nav-tabs.panel-primary .nav-tabs>li>a,
        .with-nav-tabs.panel-primary .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-primary .nav-tabs>li>a:focus {
            color: #fff;
        }

        .with-nav-tabs.panel-primary .nav-tabs>.open>a,
        .with-nav-tabs.panel-primary .nav-tabs>.open>a:hover,
        .with-nav-tabs.panel-primary .nav-tabs>.open>a:focus,
        .with-nav-tabs.panel-primary .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-primary .nav-tabs>li>a:focus {
            color: #fff;
            background-color: #3071a9;
            border-color: transparent;
        }

        .with-nav-tabs.panel-primary .nav-tabs>li.active>a,
        .with-nav-tabs.panel-primary .nav-tabs>li.active>a:hover,
        .with-nav-tabs.panel-primary .nav-tabs>li.active>a:focus {
            color: #428bca;
            background-color: #fff;
            border-color: #428bca;
            border-bottom-color: transparent;
        }

        .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu {
            background-color: #428bca;
            border-color: #3071a9;
        }

        .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>li>a {
            color: #fff;
        }

        .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
        .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
            background-color: #3071a9;
        }

        .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>.active>a,
        .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
        .with-nav-tabs.panel-primary .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
            background-color: #4a9fe9;
        }

        /********************************************************************/
        /*** PANEL SUCCESS ***/
        .with-nav-tabs.panel-success .nav-tabs>li>a,
        .with-nav-tabs.panel-success .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-success .nav-tabs>li>a:focus {
            color: #3c763d;
        }

        .with-nav-tabs.panel-success .nav-tabs>.open>a,
        .with-nav-tabs.panel-success .nav-tabs>.open>a:hover,
        .with-nav-tabs.panel-success .nav-tabs>.open>a:focus,
        .with-nav-tabs.panel-success .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-success .nav-tabs>li>a:focus {
            color: #3c763d;
            background-color: #d6e9c6;
            border-color: transparent;
        }

        .with-nav-tabs.panel-success .nav-tabs>li.active>a,
        .with-nav-tabs.panel-success .nav-tabs>li.active>a:hover,
        .with-nav-tabs.panel-success .nav-tabs>li.active>a:focus {
            color: #3c763d;
            background-color: #fff;
            border-color: #d6e9c6;
            border-bottom-color: transparent;
        }

        .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu {
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }

        .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>li>a {
            color: #3c763d;
        }

        .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
        .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
            background-color: #d6e9c6;
        }

        .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>.active>a,
        .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
        .with-nav-tabs.panel-success .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
            color: #fff;
            background-color: #3c763d;
        }

        /********************************************************************/
        /*** PANEL INFO ***/
        .with-nav-tabs.panel-info .nav-tabs>li>a,
        .with-nav-tabs.panel-info .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-info .nav-tabs>li>a:focus {
            color: #31708f;
        }

        .with-nav-tabs.panel-info .nav-tabs>.open>a,
        .with-nav-tabs.panel-info .nav-tabs>.open>a:hover,
        .with-nav-tabs.panel-info .nav-tabs>.open>a:focus,
        .with-nav-tabs.panel-info .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-info .nav-tabs>li>a:focus {
            color: #31708f;
            background-color: #bce8f1;
            border-color: transparent;
        }

        .with-nav-tabs.panel-info .nav-tabs>li.active>a,
        .with-nav-tabs.panel-info .nav-tabs>li.active>a:hover,
        .with-nav-tabs.panel-info .nav-tabs>li.active>a:focus {
            color: #31708f;
            background-color: #fff;
            border-color: #bce8f1;
            border-bottom-color: transparent;
        }

        .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu {
            background-color: #d9edf7;
            border-color: #bce8f1;
        }

        .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>li>a {
            color: #31708f;
        }

        .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
        .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
            background-color: #bce8f1;
        }

        .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>.active>a,
        .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
        .with-nav-tabs.panel-info .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
            color: #fff;
            background-color: #31708f;
        }

        /********************************************************************/
        /*** PANEL WARNING ***/
        .with-nav-tabs.panel-warning .nav-tabs>li>a,
        .with-nav-tabs.panel-warning .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-warning .nav-tabs>li>a:focus {
            color: #8a6d3b;
        }

        .with-nav-tabs.panel-warning .nav-tabs>.open>a,
        .with-nav-tabs.panel-warning .nav-tabs>.open>a:hover,
        .with-nav-tabs.panel-warning .nav-tabs>.open>a:focus,
        .with-nav-tabs.panel-warning .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-warning .nav-tabs>li>a:focus {
            color: #8a6d3b;
            background-color: #faebcc;
            border-color: transparent;
        }

        .with-nav-tabs.panel-warning .nav-tabs>li.active>a,
        .with-nav-tabs.panel-warning .nav-tabs>li.active>a:hover,
        .with-nav-tabs.panel-warning .nav-tabs>li.active>a:focus {
            color: #8a6d3b;
            background-color: #fff;
            border-color: #faebcc;
            border-bottom-color: transparent;
        }

        .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu {
            background-color: #fcf8e3;
            border-color: #faebcc;
        }

        .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>li>a {
            color: #8a6d3b;
        }

        .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
        .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
            background-color: #faebcc;
        }

        .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>.active>a,
        .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
        .with-nav-tabs.panel-warning .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
            color: #fff;
            background-color: #8a6d3b;
        }

        /********************************************************************/
        /*** PANEL DANGER ***/
        .with-nav-tabs.panel-danger .nav-tabs>li>a,
        .with-nav-tabs.panel-danger .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-danger .nav-tabs>li>a:focus {
            color: #a94442;
        }

        .with-nav-tabs.panel-danger .nav-tabs>.open>a,
        .with-nav-tabs.panel-danger .nav-tabs>.open>a:hover,
        .with-nav-tabs.panel-danger .nav-tabs>.open>a:focus,
        .with-nav-tabs.panel-danger .nav-tabs>li>a:hover,
        .with-nav-tabs.panel-danger .nav-tabs>li>a:focus {
            color: #a94442;
            background-color: #ebccd1;
            border-color: transparent;
        }

        .with-nav-tabs.panel-danger .nav-tabs>li.active>a,
        .with-nav-tabs.panel-danger .nav-tabs>li.active>a:hover,
        .with-nav-tabs.panel-danger .nav-tabs>li.active>a:focus {
            color: #a94442;
            background-color: #fff;
            border-color: #ebccd1;
            border-bottom-color: transparent;
        }

        .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu {
            background-color: #f2dede;
            /* bg color */
            border-color: #ebccd1;
            /* border color */
        }

        .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>li>a {
            color: #a94442;
            /* normal text color */
        }

        .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>li>a:hover,
        .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>li>a:focus {
            background-color: #ebccd1;
            /* hover bg color */
        }

        .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>.active>a,
        .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>.active>a:hover,
        .with-nav-tabs.panel-danger .nav-tabs>li.dropdown .dropdown-menu>.active>a:focus {
            color: #fff;
            /* active text color */
            background-color: #a94442;
            /* active bg color */
        }
    </style>

</head>
@csrf

<body class="menu-position-side menu-side-left full-screen with-content-panel">
    <div class="all-wrapper with-side-panel solid-bg-all">
        <div aria-hidden="true" class="onboarding-modal modal fade animated show-on-load" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-centered" role="document">
                <div class="modal-content text-center">
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            class="close-label">Skip Intro</span><span class="os-icon os-icon-close"></span></button>
                    <div class="onboarding-slider-w">
                        <div class="onboarding-slide">
                            <div class="onboarding-media"><img alt="" src="img/bigicon2.png" width="200px">
                            </div>
                            <div class="onboarding-content with-gradient">
                                <h4 class="onboarding-title">Notification !</h4>
                                <div class="onboarding-text">We strongly suggest you update your password to a stronger
                                    and unique password if you are using default or basic password.</div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="search-with-suggestions-w">
            <div class="search-with-suggestions-modal">
                <div class="element-search">
                    <input class="search-suggest-input" placeholder="Start typing to search..." type="text">
                    <div class="close-search-suggestions"><i class="os-icon os-icon-x"></i></div>

                </div>
                <div class="search-suggestions-group">
                    <div class="ssg-header">
                        <div class="ssg-icon">
                            <div class="os-icon os-icon-box"></div>
                        </div>
                        <div class="ssg-name">Projects</div>
                        <div class="ssg-info">24 Total</div>
                    </div>
                    <div class="ssg-content">
                        <div class="ssg-items ssg-items-boxed">
                            <a class="ssg-item" href="users_profile_big.html">
                                <div class="item-media" style="background-image: url(img/company6.png)"></div>
                                <div class="item-name">Integ<span>ration</span> with API</div>
                            </a>
                            <a class="ssg-item" href="users_profile_big.html">
                                <div class="item-media" style="background-image: url(img/company7.png)"></div>
                                <div class="item-name">Deve<span>lopm</span>ent Project</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="search-suggestions-group">
                    <div class="ssg-header">
                        <div class="ssg-icon">
                            <div class="os-icon os-icon-users"></div>
                        </div>
                        <div class="ssg-name">Customers</div>
                        <div class="ssg-info">12 Total</div>
                    </div>
                    <div class="ssg-content">
                        <div class="ssg-items ssg-items-list">
                            <a class="ssg-item" href="users_profile_big.html">
                                <div class="item-media" style="background-image: url(img/avatar1.jpg)"></div>
                                <div class="item-name">John Ma<span>yer</span>s</div>
                            </a>
                            <a class="ssg-item" href="users_profile_big.html">
                                <div class="item-media" style="background-image: url(img/avatar2.jpg)"></div>
                                <div class="item-name">Th<span>omas</span> Mullier</div>
                            </a>
                            <a class="ssg-item" href="users_profile_big.html">
                                <div class="item-media" style="background-image: url(img/avatar3.jpg)"></div>
                                <div class="item-name">Kim C<span>olli</span>ns</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="search-suggestions-group">
                    <div class="ssg-header">
                        <div class="ssg-icon">
                            <div class="os-icon os-icon-folder"></div>
                        </div>
                        <div class="ssg-name">Files</div>
                        <div class="ssg-info">17 Total</div>
                    </div>
                    <div class="ssg-content">
                        <div class="ssg-items ssg-items-blocks">
                            <a class="ssg-item" href="#">
                                <div class="item-icon"><i class="os-icon os-icon-file-text"></i></div>
                                <div class="item-name">Work<span>Not</span>e.txt</div>
                            </a>
                            <a class="ssg-item" href="#">
                                <div class="item-icon"><i class="os-icon os-icon-film"></i></div>
                                <div class="item-name">V<span>ideo</span>.avi</div>
                            </a>
                            <a class="ssg-item" href="#">
                                <div class="item-icon"><i class="os-icon os-icon-database"></i></div>
                                <div class="item-name">User<span>Tabl</span>e.sql</div>
                            </a>
                            <a class="ssg-item" href="#">
                                <div class="item-icon"><i class="os-icon os-icon-image"></i></div>
                                <div class="item-name">wed<span>din</span>g.jpg</div>
                            </a>
                        </div>
                        <div class="ssg-nothing-found">
                            <div class="icon-w"><i class="os-icon os-icon-eye-off"></i></div><span>No files were
                                found. Try changing your query...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layout-w">
            <!--------------------
START - Mobile Menu
-------------------->
            <div class="menu-mobile menu-activated-on-click color-scheme-dark">
                <div class="mm-logo-buttons-w">
                    <a class="mm-logo" href="{{ route('landing.home') }}"><img src="img/logo.png"><span>Company
                            Name</span></a>
                    <div class="mm-buttons">
                        <div class="content-panel-open">
                            <div class="os-icon os-icon-grid-circles"></div>
                        </div>
                        <div class="mobile-menu-trigger">
                            <div class="os-icon os-icon-hamburger-menu-1"></div>
                        </div>
                    </div>
                </div>
                <div class="menu-and-user">
                    <div class="logged-user-w">
                        <div class="avatar-w"><img alt="" src="img/avatar1.jpg"></div>
                        <div class="logged-user-info-w">
                            <div class="logged-user-name">Rommel Lacap</div>
                            <div class="logged-user-role">Premium Member</div>
                        </div>
                    </div>
                    <!--------------------
START - Mobile Menu List
-------------------->
                    <ul class="main-menu">
                        <li class="has-sub-menu">
                            <a href="{{ route('landing.home') }}">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-layout"></div>
                                </div><span>Dashboard</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('landing.home') }}">Dashboard 1</a></li>
                                <li><a href="apps_crypto.html">Crypto Dashboard <strong
                                            class="badge badge-danger">Hot</strong></a></li>
                                <li><a href="apps_support_dashboard.html">Dashboard 3</a></li>
                                <li><a href="apps_projects.html">Dashboard 4</a></li>
                                <li><a href="apps_bank.html">Dashboard 5</a></li>
                                <li><a href="layouts_menu_top_image.html">Dashboard 6</a></li>
                            </ul>
                        </li>
                        <li class="has-sub-menu">
                            <a href="layouts_menu_top_image.html">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-layers"></div>
                                </div><span>Menu Styles</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="layouts_menu_side_full.html">Side Menu Light</a></li>
                                <li><a href="layouts_menu_side_full_dark.html">Side Menu Dark</a></li>
                                <li><a href="layouts_menu_side_transparent.html">Side Menu Transparent <strong
                                            class="badge badge-danger">New</strong></a></li>
                                <li><a href="apps_pipeline.html">Side &amp; Top Dark</a></li>
                                <li><a href="apps_projects.html">Side &amp; Top</a></li>
                                <li><a href="layouts_menu_side_mini.html">Mini Side Menu</a></li>
                                <li><a href="layouts_menu_side_mini_dark.html">Mini Menu Dark</a></li>
                                <li><a href="layouts_menu_side_compact.html">Compact Side Menu</a></li>
                                <li><a href="layouts_menu_side_compact_dark.html">Compact Menu Dark</a></li>
                                <li><a href="layouts_menu_right.html">Right Menu</a></li>
                                <li><a href="layouts_menu_top.html">Top Menu Light</a></li>
                                <li><a href="layouts_menu_top_dark.html">Top Menu Dark</a></li>
                                <li><a href="layouts_menu_top_image.html">Top Menu Image <strong
                                            class="badge badge-danger">New</strong></a></li>
                                <li><a href="layouts_menu_sub_style_flyout.html">Sub Menu Flyout</a></li>
                                <li><a href="layouts_menu_sub_style_flyout_dark.html">Sub Flyout Dark</a></li>
                                <li><a href="layouts_menu_sub_style_flyout_bright.html">Sub Flyout Bright</a></li>
                                <li><a href="layouts_menu_side_compact_click.html">Menu Inside Click</a></li>
                            </ul>
                        </li>
                        <li class="has-sub-menu">
                            <a href="apps_bank.html">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-package"></div>
                                </div><span>Applications</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="apps_email.html">Email Application</a></li>
                                <li><a href="apps_support_dashboard.html">Support Dashboard</a></li>
                                <li><a href="apps_support_index.html">Tickets Index</a></li>
                                <li><a href="apps_crypto.html">Crypto Dashboard <strong
                                            class="badge badge-danger">New</strong></a></li>
                                <li><a href="apps_projects.html">Projects List</a></li>
                                <li><a href="apps_bank.html">Banking <strong
                                            class="badge badge-danger">New</strong></a></li>
                                <li><a href="apps_full_chat.html">Chat Application</a></li>
                                <li><a href="apps_todo.html">To Do Application <strong
                                            class="badge badge-danger">New</strong></a></li>
                                <li><a href="misc_chat.html">Popup Chat</a></li>
                                <li><a href="apps_pipeline.html">CRM Pipeline</a></li>
                                <li><a href="rentals_index_grid.html">Property Listing <strong
                                            class="badge badge-danger">New</strong></a></li>
                                <li><a href="misc_calendar.html">Calendar</a></li>
                            </ul>
                        </li>
                        <li class="has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-file-text"></div>
                                </div><span>Pages</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="misc_invoice.html">Invoice</a></li>
                                <li><a href="rentals_index_grid.html">Property Listing <strong
                                            class="badge badge-danger">New</strong></a></li>
                                <li><a href="misc_charts.html">Charts</a></li>
                                <li><a href="auth_login.html">Login</a></li>
                                <li><a href="auth_register.html">Register</a></li>
                                <li><a href="auth_lock.html">Lock Screen</a></li>
                                <li><a href="misc_pricing_plans.html">Pricing Plans</a></li>
                                <li><a href="misc_error_404.html">Error 404</a></li>
                                <li><a href="misc_error_500.html">Error 500</a></li>
                            </ul>
                        </li>
                        <li class="has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-life-buoy"></div>
                                </div><span>UI Kit</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="uikit_modals.html">Modals <strong
                                            class="badge badge-danger">New</strong></a></li>
                                <li><a href="uikit_alerts.html">Alerts</a></li>
                                <li><a href="uikit_grid.html">Grid</a></li>
                                <li><a href="uikit_progress.html">Progress</a></li>
                                <li><a href="uikit_popovers.html">Popover</a></li>
                                <li><a href="uikit_tooltips.html">Tooltips</a></li>
                                <li><a href="uikit_buttons.html">Buttons</a></li>
                                <li><a href="uikit_dropdowns.html">Dropdowns</a></li>
                                <li><a href="uikit_typography.html">Typography</a></li>
                            </ul>
                        </li>
                        <li class="has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-mail"></div>
                                </div><span>Emails</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="emails_welcome.html">Welcome Email</a></li>
                                <li><a href="emails_order.html">Order Confirmation</a></li>
                                <li><a href="emails_payment_due.html">Payment Due</a></li>
                                <li><a href="emails_forgot.html">Forgot Password</a></li>
                                <li><a href="emails_activate.html">Activate Account</a></li>
                            </ul>
                        </li>
                        <li class="has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-users"></div>
                                </div><span>Users</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="users_profile_big.html">Big Profile</a></li>
                                <li><a href="users_profile_small.html">Compact Profile</a></li>
                            </ul>
                        </li>
                        <li class="has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-edit-32"></div>
                                </div><span>Forms</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="forms_regular.html">Regular Forms</a></li>
                                <li><a href="forms_validation.html">Form Validation</a></li>
                                <li><a href="forms_wizard.html">Form Wizard</a></li>
                                <li><a href="forms_uploads.html">File Uploads</a></li>
                                <li><a href="forms_wisiwig.html">Wisiwig Editor</a></li>
                            </ul>
                        </li>
                        <li class="has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-grid"></div>
                                </div><span>Tables</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="tables_regular.html">Regular Tables</a></li>
                                <li><a href="tables_datatables.html">Data Tables</a></li>
                                <li><a href="tables_editable.html">Editable Tables</a></li>
                            </ul>
                        </li>
                        <li class="has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-zap"></div>
                                </div><span>Icons</span>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="icon_fonts_simple_line_icons.html">Simple Line Icons</a></li>
                                <li><a href="icon_fonts_feather.html">Feather Icons</a></li>
                                <li><a href="icon_fonts_themefy.html">Themefy Icons</a></li>
                                <li><a href="icon_fonts_picons_thin.html">Picons Thin</a></li>
                                <li><a href="icon_fonts_dripicons.html">Dripicons</a></li>
                                <li><a href="icon_fonts_eightyshades.html">Eightyshades</a></li>
                                <li><a href="icon_fonts_entypo.html">Entypo</a></li>
                                <li><a href="icon_fonts_font_awesome.html">Font Awesome</a></li>
                                <li><a href="icon_fonts_foundation_icon_font.html">Foundation Icon Font</a></li>
                                <li><a href="icon_fonts_metrize_icons.html">Metrize Icons</a></li>
                                <li><a href="icon_fonts_picons_social.html">Picons Social</a></li>
                                <li><a href="icon_fonts_batch_icons.html">Batch Icons</a></li>
                                <li><a href="icon_fonts_dashicons.html">Dashicons</a></li>
                                <li><a href="icon_fonts_typicons.html">Typicons</a></li>
                                <li><a href="icon_fonts_weather_icons.html">Weather Icons</a></li>
                                <li><a href="icon_fonts_light_admin.html">Light Admin</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!--------------------
END - Mobile Menu List
-------------------->
                    <div class="mobile-menu-magic">
                        <h4>Light Admin</h4>
                        <p>Clean Bootstrap 4 Template</p>
                        <div class="btn-w"><a class="btn btn-white btn-rounded"
                                href="https://themeforest.net/item/light-admin-clean-bootstrap-dashboard-html-template/19760124?ref=Osetin"
                                target="_blank">Purchase Now</a></div>
                    </div>
                </div>
            </div>
            <!--------------------
END - Mobile Menu
-------------------->
            <!--------------------
START - Main Menu
-------------------->
            <div
                class="menu-w color-scheme-dark color-style-bright menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
                <div class="logo-w">







                    <a class="logo" href="{{ route('landing.home') }}">
                        <div class="logo-element"></div>
                        <div class="logo-label">Company Name</div>
                    </a>
                </div>
                <div class="logged-user-w avatar-inline">
                    <div class="logged-user-i">
                        <div class="avatar-w"><img alt="" src="img/avatar1.jpg"></div>
                        <div class="logged-user-info-w">
                            <div class="logged-user-name">Rommel Lacap</div>
                            <div class="logged-user-role">Premium Member</div>
                        </div>
                        <div class="logged-user-toggler-arrow">
                            <div class="os-icon os-icon-chevron-down"></div>
                        </div>
                        <div class="logged-user-menu color-style-bright">
                            <div class="logged-user-avatar-info">
                                <div class="avatar-w"><img alt="" src="img/avatar1.jpg"></div>
                                <div class="logged-user-info-w">
                                    <div class="logged-user-name">Rommel Lacap</div>
                                    <div class="logged-user-role">Premium Member</div>
                                </div>
                            </div>
                            <div class="bg-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                            <ul>

                                <li><a href="users_profile_big.html"><i
                                            class="os-icon os-icon-user-male-circle2"></i><span>Profile
                                            Details</span></a></li>
                                <li><a href="users_profile_small.html"><i
                                            class="os-icon os-icon-coins-4"></i><span>Account Details</span></a></li>
                                <li><a href="#"><i
                                            class="os-icon os-icon-others-43"></i><span>Notifications</span></a></li>
                                <li><a href="{{ route('logout') }}"><i
                                            class="os-icon os-icon-signs-11"></i><span>Logout</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--<div class="menu-actions">
                    <!--------------------
START - Messages Link in secondary top menu
-------------------->
                <!--<div class="messages-notifications os-dropdown-trigger os-dropdown-position-right"><i class="os-icon os-icon-mail-14"></i>
                        <div class="new-messages-count">12</div>
                        <div class="os-dropdown light message-list">
                            <ul>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="img/avatar1.jpg"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">John Mayers</h6>
                                            <h6 class="message-title">Account Update</h6></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="img/avatar2.jpg"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">Phil Jones</h6>
                                            <h6 class="message-title">Secutiry Updates</h6></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="img/avatar3.jpg"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">Bekky Simpson</h6>
                                            <h6 class="message-title">Vacation Rentals</h6></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="img/avatar4.jpg"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">Alice Priskon</h6>
                                            <h6 class="message-title">Payment Confirmation</h6></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--------------------
END - Messages Link in secondary top menu
-------------------->
                <!--------------------
START - Settings Link in secondary top menu
-------------------->
                <!-- <div class="top-icon top-settings os-dropdown-trigger os-dropdown-position-right"><i class="os-icon os-icon-ui-46"></i>
                        <div class="os-dropdown">
                            <div class="icon-w"><i class="os-icon os-icon-ui-46"></i></div>
                            <ul>
                                <li><a href="users_profile_small.html"><i class="os-icon os-icon-ui-49"></i><span>Profile Settings</span></a></li>
                                <li><a href="users_profile_small.html"><i class="os-icon os-icon-grid-10"></i><span>Billing Info</span></a></li>
                                <li><a href="users_profile_small.html"><i class="os-icon os-icon-ui-44"></i><span>My Invoices</span></a></li>
                                <li><a href="users_profile_small.html"><i class="os-icon os-icon-ui-15"></i><span>Cancel Account</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <!--------------------
END - Settings Link in secondary top menu
-------------------->
                <!--------------------
START - Messages Link in secondary top menu
-------------------->
                <!-- <div class="messages-notifications os-dropdown-trigger os-dropdown-position-right"><i class="os-icon os-icon-zap"></i>
                        <div class="new-messages-count">4</div>
                        <div class="os-dropdown light message-list">
                            <div class="icon-w"><i class="os-icon os-icon-zap"></i></div>
                            <ul>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="img/avatar1.jpg"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">John Mayers</h6>
                                            <h6 class="message-title">Account Update</h6></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="img/avatar2.jpg"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">Phil Jones</h6>
                                            <h6 class="message-title">Secutiry Updates</h6></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="img/avatar3.jpg"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">Bekky Simpson</h6>
                                            <h6 class="message-title">Vacation Rentals</h6></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="user-avatar-w"><img alt="" src="img/avatar4.jpg"></div>
                                        <div class="message-content">
                                            <h6 class="message-from">Alice Priskon</h6>
                                            <h6 class="message-title">Payment Confirmation</h6></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--------------------
END - Messages Link in secondary top menu
-------------------->
                <!--</div>-->
                <div class="element-search autosuggest-search-activator">
                    <input placeholder="Start typing to search..." type="text">
                </div>
                <h1 class="menu-page-header">Page Header</h1>
                <ul class="main-menu">
                    <li class="sub-header"><span>Statistics</span></li>
                    <li class="selected has-sub-menu">
                        <a href="{{ route('landing.home') }}">
                            <div class="icon-w">
                                <div class="os-icon os-icon-layout"></div>
                            </div><span>Dashboard</span>
                        </a>
                        <div class="sub-menu-w">
                            <div class="sub-menu-header">Dashboard</div>
                            <div class="sub-menu-icon"><i class="os-icon os-icon-layout"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li><a href="{{ route('landing.home') }}">Sales Match Waiting PV</a></li>

                                    <li><a href="apps_support_dashboard.html">Network Statistics</a></li>
                                    <li><a href="apps_projects.html">Network Over-all Performance</a></li>
                                    <li><a href="apps_bank.html">eWallet Statistics</a></li>
                                    <li><a href="layouts_menu_top_image.html">Latest Network</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <!--  <li class=" has-sub-menu">
                        <a href="layouts_menu_top_image.html">
                            <div class="icon-w">
                                <div class="os-icon os-icon-users"></div>
                            </div><span>My Group</span></a>
                        <div class="sub-menu-w">
                            <div class="sub-menu-header">My Group</div>
                            <div class="sub-menu-icon"><i class="os-icon os-icon-layers"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li><a href="layouts_menu_side_full.html">Side Menu Light</a></li>
                                    <li><a href="layouts_menu_side_full_dark.html">Side Menu Dark</a></li>
                                    <li><a href="layouts_menu_side_transparent.html">Side Menu Transparent <strong class="badge badge-danger">New</strong></a></li>
                                    <li><a href="apps_pipeline.html">Side &amp; Top Dark</a></li>
                                    <li><a href="apps_projects.html">Side &amp; Top</a></li>
                                    <li><a href="layouts_menu_side_mini.html">Mini Side Menu</a></li>
                                </ul>
                                <ul class="sub-menu">
                                    <li><a href="layouts_menu_side_mini_dark.html">Mini Menu Dark</a></li>
                                    <li><a href="layouts_menu_side_compact.html">Compact Side Menu</a></li>
                                    <li><a href="layouts_menu_side_compact_dark.html">Compact Menu Dark</a></li>
                                    <li><a href="layouts_menu_right.html">Right Menu</a></li>
                                    <li><a href="layouts_menu_top.html">Top Menu Light</a></li>
                                    <li><a href="layouts_menu_top_dark.html">Top Menu Dark</a></li>
                                </ul>
                                <ul class="sub-menu">
                                    <li><a href="layouts_menu_top_image.html">Top Menu Image <strong class="badge badge-danger">New</strong></a></li>
                                    <li><a href="layouts_menu_sub_style_flyout.html">Sub Menu Flyout</a></li>
                                    <li><a href="layouts_menu_sub_style_flyout_dark.html">Sub Flyout Dark</a></li>
                                    <li><a href="layouts_menu_sub_style_flyout_bright.html">Sub Flyout Bright</a></li>
                                    <li><a href="layouts_menu_side_compact_click.html">Menu Inside Click</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>-->
                    <li class="sub-header"><span>Options</span></li>
                    <li class=" has-sub-menu">
                        <a href="apps_bank.html">
                            <div class="icon-w">
                                <div class="os-icon os-icon-package"></div>
                            </div><span>Network</span>
                        </a>
                        <div class="sub-menu-w">
                            <div class="sub-menu-header">Network</div>
                            <div class="sub-menu-icon"><i class="os-icon os-icon-package"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li><a href="apps_email.html">Binary Graphical</a></li>
                                    <li><a href="apps_support_dashboard.html">Binary List</a></li>
                                    <li><a href="apps_support_dashboard.html">Personal Enrollment Tree</a></li>
                                    <!--<li><a href="apps_support_index.html">Tickets Index</a></li>
                                    <li><a href="apps_crypto.html">Crypto Dashboard <strong class="badge badge-danger">New</strong></a></li>
                                    <li><a href="apps_projects.html">Projects List</a></li>
                                    <li><a href="apps_bank.html">Banking <strong class="badge badge-danger">New</strong></a></li>-->
                                </ul>
                                <!--  <ul class="sub-menu">
                                    <li><a href="apps_full_chat.html">Chat Application</a></li>
                                    <li><a href="apps_todo.html">To Do Application <strong class="badge badge-danger">New</strong></a></li>
                                    <li><a href="misc_chat.html">Popup Chat</a></li>
                                    <li><a href="apps_pipeline.html">CRM Pipeline</a></li>
                                    <li><a href="rentals_index_grid.html">Property Listing <strong class="badge badge-danger">New</strong></a></li>
                                    <li><a href="misc_calendar.html">Calendar</a></li>
                                </ul>-->
                            </div>
                        </div>
                    </li>
                    <li class=" has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-file-text"></div>
                            </div><span>Request</span>
                        </a>
                        <div class="sub-menu-w">
                            <div class="sub-menu-header">Request</div>
                            <div class="sub-menu-icon"><i class="os-icon os-icon-file-text"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li><a href="misc_invoice.html">Enchashment</a></li>

                                    <li><a href="misc_charts.html">Maintenance Activation</a></li>
                                    <li><a href="auth_login.html">Maintenance Activation List</a></li>
                                    <li><a href="auth_register.html">Upgrade Account Activation</a></li>
                                </ul>
                                <ul class="sub-menu">
                                    <li><a href="auth_lock.html">Item for Reward Points </a></li>
                                    <li><a href="misc_pricing_plans.html">ePoints Consolidation Facility </a></li>
                                    <li><a href="misc_error_404.html">ePoints Redemption History</a></li>

                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class=" has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-grid"></div>
                            </div><span>Listing</span>
                        </a>
                        <div class="sub-menu-w">
                            <div class="sub-menu-header">Listing</div>
                            <div class="sub-menu-icon"><i class="os-icon os-icon-grid"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li><a href="uikit_alerts.html">My Group</a></li>
                                    <li><a href="uikit_alerts.html">My Orders</a></li>
                                    <!--<li><a href="uikit_grid.html">Grid</a></li>
                                    <li><a href="uikit_progress.html">Progress</a></li>
                                    <li><a href="uikit_popovers.html">Popover</a></li>-->
                                </ul>
                                <!--<ul class="sub-menu">
                                    <li><a href="uikit_tooltips.html">Tooltips</a></li>
                                    <li><a href="uikit_buttons.html">Buttons</a></li>
                                    <li><a href="uikit_dropdowns.html">Dropdowns</a></li>
                                    <li><a href="uikit_typography.html">Typography</a></li>
                                </ul>-->
                            </div>
                        </div>
                    </li>
                    <li class="sub-header"><span>Others</span></li>
                    <li class=" has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-info"></div>
                            </div><span>FAQs</span>
                        </a>
                        <!--<div class="sub-menu-w">
                            <!--<div class="sub-menu-header">Emails</div>
                            <div class="sub-menu-icon"><i class="os-icon os-icon-mail"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li><a href="emails_welcome.html">Welcome Email</a></li>
                                    <li><a href="emails_order.html">Order Confirmation</a></li>
                                    <li><a href="emails_payment_due.html">Payment Due</a></li>
                                    <li><a href="emails_forgot.html">Forgot Password</a></li>
                                    <li><a href="emails_activate.html">Activate Account</a></li>
                                </ul>
                            </div>
                        </div>-->
                    </li>
                    <li class=" has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-users"></div>
                            </div><span>Profile</span>
                        </a>
                        <div class="sub-menu-w">
                            <div class="sub-menu-header">Profile</div>
                            <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li><a href="users_profile_big.html">View Profile</a></li>
                                    <li><a href="users_profile_small.html">Update Profile</a></li>
                                    <li><a href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <!--<li class=" has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-edit-32"></div>
                            </div><span>Forms</span></a>
                        <div class="sub-menu-w">
                            <div class="sub-menu-header">Forms</div>
                            <div class="sub-menu-icon"><i class="os-icon os-icon-edit-32"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li><a href="forms_regular.html">Regular Forms</a></li>
                                    <li><a href="forms_validation.html">Form Validation</a></li>
                                    <li><a href="forms_wizard.html">Form Wizard</a></li>
                                    <li><a href="forms_uploads.html">File Uploads</a></li>
                                    <li><a href="forms_wisiwig.html">Wisiwig Editor</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class=" has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-grid"></div>
                            </div><span>Tables</span></a>
                        <div class="sub-menu-w">
                            <div class="sub-menu-header">Tables</div>
                            <div class="sub-menu-icon"><i class="os-icon os-icon-grid"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li><a href="tables_regular.html">Regular Tables</a></li>
                                    <li><a href="tables_datatables.html">Data Tables</a></li>
                                    <li><a href="tables_editable.html">Editable Tables</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class=" has-sub-menu">
                        <a href="#">
                            <div class="icon-w">
                                <div class="os-icon os-icon-zap"></div>
                            </div><span>Icons</span></a>
                        <div class="sub-menu-w">
                            <div class="sub-menu-header">Icons</div>
                            <div class="sub-menu-icon"><i class="os-icon os-icon-zap"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li><a href="icon_fonts_simple_line_icons.html">Simple Line Icons</a></li>
                                    <li><a href="icon_fonts_feather.html">Feather Icons</a></li>
                                    <li><a href="icon_fonts_themefy.html">Themefy Icons</a></li>
                                    <li><a href="icon_fonts_picons_thin.html">Picons Thin</a></li>
                                    <li><a href="icon_fonts_dripicons.html">Dripicons</a></li>
                                    <li><a href="icon_fonts_eightyshades.html">Eightyshades</a></li>
                                </ul>
                                <ul class="sub-menu">
                                    <li><a href="icon_fonts_entypo.html">Entypo</a></li>
                                    <li><a href="icon_fonts_font_awesome.html">Font Awesome</a></li>
                                    <li><a href="icon_fonts_foundation_icon_font.html">Foundation Icon Font</a></li>
                                    <li><a href="icon_fonts_metrize_icons.html">Metrize Icons</a></li>
                                    <li><a href="icon_fonts_picons_social.html">Picons Social</a></li>
                                    <li><a href="icon_fonts_batch_icons.html">Batch Icons</a></li>
                                </ul>
                                <ul class="sub-menu">
                                    <li><a href="icon_fonts_dashicons.html">Dashicons</a></li>
                                    <li><a href="icon_fonts_typicons.html">Typicons</a></li>
                                    <li><a href="icon_fonts_weather_icons.html">Weather Icons</a></li>
                                    <li><a href="icon_fonts_light_admin.html">Light Admin</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>-->
                </ul>
                <div class="side-menu-magic">
                    <h4>Company Name</h4>
                    <p>Company Details</p>
                    <!--<div class="btn-w"><a class="btn btn-white btn-rounded" href="https://themeforest.net/item/light-admin-clean-bootstrap-dashboard-html-template/19760124?ref=Osetin" target="_blank">Purchase Now</a></div>-->
                </div>
            </div>
            <!--------------------
END - Main Menu
-------------------->
            <div class="content-w">
                <!--------------------
START - Top Bar
-------------------->
                <div class="top-bar color-scheme-bright">
                    <!--------------------
START - Top Menu Controls
-------------------->
                    <div class="top-menu-controls">
                        <div class="element-search autosuggest-search-activator">
                            <input placeholder="Start typing to search..." type="text">
                        </div>
                        <!--------------------
START - Messages Link in secondary top menu
-------------------->



                        <!-- <div class="messages-notifications os-dropdown-trigger os-dropdown-position-left"><i class="os-icon os-icon-mail-14"></i>
                            <div class="new-messages-count">12</div>
                            <div class="os-dropdown light message-list">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <div class="user-avatar-w"><img alt="" src="img/avatar1.jpg"></div>
                                            <div class="message-content">
                                                <h6 class="message-from">John Mayers</h6>
                                                <h6 class="message-title">Account Update</h6></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="user-avatar-w"><img alt="" src="img/avatar2.jpg"></div>
                                            <div class="message-content">
                                                <h6 class="message-from">Phil Jones</h6>
                                                <h6 class="message-title">Secutiry Updates</h6></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="user-avatar-w"><img alt="" src="img/avatar3.jpg"></div>
                                            <div class="message-content">
                                                <h6 class="message-from">Bekky Simpson</h6>
                                                <h6 class="message-title">Vacation Rentals</h6></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="user-avatar-w"><img alt="" src="img/avatar4.jpg"></div>
                                            <div class="message-content">
                                                <h6 class="message-from">Alice Priskon</h6>
                                                <h6 class="message-title">Payment Confirmation</h6></div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--------------------
END - Messages Link in secondary top menu
-------------------->
                        <!--------------------
START - Settings Link in secondary top menu
-------------------->
                        <div class="top-icon top-settings os-dropdown-trigger os-dropdown-position-left"><i
                                class="os-icon os-icon-ui-46"></i>
                            <div class="os-dropdown">
                                <div class="icon-w"><i class="os-icon os-icon-ui-46"></i></div>
                                <ul>
                                    <li><a href="users_profile_small.html"><i
                                                class="os-icon os-icon-ui-49"></i><span>Profile Settings</span></a>
                                    </li>
                                    <li><a href="users_profile_small.html"><i
                                                class="os-icon os-icon-grid-10"></i><span>Account Info</span></a></li>

                                    <li><a href="users_profile_small.html"><i
                                                class="os-icon os-icon-ui-15"></i><span>Cancel Account</span></a></li>
                                </ul>
                            </div>
                        </div>
                        <!--------------------
END - Settings Link in secondary top menu
-------------------->
                        <!--------------------
START - User avatar and menu in secondary top menu
-------------------->
                        <div class="logged-user-w">
                            <div class="logged-user-i">
                                <div class="avatar-w"><img alt="" src="img/avatar1.jpg"></div>
                                <div class="logged-user-menu color-style-bright">
                                    <div class="logged-user-avatar-info">
                                        <div class="avatar-w"><img alt="" src="img/avatar1.jpg"></div>
                                        <div class="logged-user-info-w">
                                            <div class="logged-user-name">Rommel</div>
                                            <div class="logged-user-role">Premium Member</div>
                                        </div>
                                    </div>
                                    <div class="bg-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                                    <ul>

                                        <li><a href="users_profile_big.html"><i
                                                    class="os-icon os-icon-user-male-circle2"></i><span>Profile
                                                    Details</span></a></li>
                                        <li><a href="users_profile_small.html"><i
                                                    class="os-icon os-icon-coins-4"></i><span>Account
                                                    Details</span></a></li>
                                        <li><a href="#"><i
                                                    class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
                                        </li>
                                        <li><a href="{{ route('logout') }}"><i
                                                    class="os-icon os-icon-signs-11"></i><span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--------------------
END - User avatar and menu in secondary top menu
-------------------->
                    </div>
                    <!--------------------
END - Top Menu Controls
-------------------->
                </div>
                <!--------------------
END - Top Bar
-------------------->
                <!--------------------
START - Breadcrumbs
-------------------->
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('landing.home') }}">Dashboard</a></li>
                    <!--<li class="breadcrumb-item"><span>Laptop with retina screen</span></li>-->
                </ul>
                <!--------------------
END - Breadcrumbs
-------------------->



                <div class="content-panel-toggler"><i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span>
                </div>
                <div class="content-i">


                    <div class="content-box">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="element-wrapper">
                                    <div class="element-actions">
                                        <form class="form-inline justify-content-sm-end">
                                            <select class="form-control form-control-sm rounded">
                                                <option value="Pending">Today</option>
                                                <option value="Active">Last Week </option>
                                                <option value="Cancelled">Last 30 Days</option>
                                            </select>
                                        </form>
                                    </div>
                                    <h6 class="element-header">My Dashboard</h6>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="element-wrapper">

                                                <div class="element-box-tp">
                                                    <!--------------------
START - Controls Above Table
-------------------->

                                                    <!--------------------
END - Controls Above Table
------------------          -->
                                                    <!--------------------
START - Table with actions
------------------  -->
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <thead style="background-color : #1b55e2">
                                                                <tr>

                                                                    <th style="text-align: center; color:white">
                                                                        Register Date</th>
                                                                    <th style="text-align: center; color:white">Sponsor
                                                                    </th>
                                                                    <th style="text-align: center; color:white">
                                                                        Placement</th>
                                                                    <th style="text-align: center; color:white">
                                                                        Position</th>
                                                                    <th style="text-align: center; color:white">Active
                                                                        Status</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>

                                                                    <td style="text-align: center">December 19, 2018
                                                                    </td>
                                                                    <td style="text-align: center">Rommel Lacap</td>
                                                                    <td style="text-align: center">Rommel Lacap</td>
                                                                    <td style="text-align: center">Left</td>
                                                                    <td style="text-align: center">
                                                                        <div class="status-pill green"
                                                                            data-title="Complete"
                                                                            data-toggle="tooltip"></div>
                                                                    </td>

                                                                </tr>




                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--------------------
END - Table with actions
------------------            -->
                                                    <!--------------------
START - Controls below table
------------------  -->

                                                    <!--------------------
END - Controls below table
-------------------->
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="container">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="panel with-nav-tabs panel-primary">
                                                    <div class="panel-heading" style="background-color : #1b55e2">
                                                        <ul class="nav nav-tabs">
                                                            <li class="active"><a href="#tab1primary"
                                                                    data-toggle="tab">Referral Bonus</a></li>
                                                            <li><a href="#tab2primary" data-toggle="tab">Sales Match
                                                                    Bonus</a></li>
                                                            <li><a href="#tab3primary" data-toggle="tab">Retail
                                                                    Commision</a></li>
                                                            <li><a href="#tab4primary" data-toggle="tab">Leadership
                                                                    Bonus</a></li>
                                                            <li><a href="#tab5primary" data-toggle="tab">Income
                                                                    Statistics</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="tab-content">
                                                            <div class="tab-pane fade in active" id="tab1primary">

                                                                <div class="element-content">
                                                                    <div class="row">


                                                                        <div class="col-4 col-sm-3 col-xxl-2">


                                                                            <a class="element-box el-tablo centered trend-in-corner smaller"
                                                                                href="#"
                                                                                style="background-color : #1b55e2">
                                                                                <div class="label"
                                                                                    style="color:white; font-size: 7px">
                                                                                    Total Referral Bonus</div>

                                                                                <hr style="background-color :white">
                                                                                <div class="value"
                                                                                    style="color:white">400 PHP</div>
                                                                                <div class="trending trending-up">
                                                                                    <span></span><i
                                                                                        class="os-icon os-icon-arrow-up6"></i>
                                                                                </div>
                                                                            </a>

                                                                        </div>


                                                                        <div class="col-4 col-sm-3 col-xxl-2">


                                                                            <a class="element-box el-tablo centered trend-in-corner smaller"
                                                                                href="#"
                                                                                style="background-color : #1b55e2">
                                                                                <div class="label"
                                                                                    style="color:white; font-size: 7px">
                                                                                    Total Direct Referral</div>

                                                                                <hr style="background-color :white">
                                                                                <div class="value"
                                                                                    style="color:white">1000 PHP</div>
                                                                                <div class="trending trending-up">
                                                                                    <span></span><i
                                                                                        class="os-icon os-icon-arrow-up6"></i>
                                                                                </div>
                                                                            </a>

                                                                        </div>


                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="tab-pane fade" id="tab2primary">


                                                                <div class="element-content">
                                                                    <div class="row">


                                                                        <div class="col-4 col-sm-3 col-xxl-2">


                                                                            <a class="element-box el-tablo centered trend-in-corner smaller"
                                                                                href="#"
                                                                                style="background-color : #1b55e2">
                                                                                <div class="label"
                                                                                    style="color:white; font-size: 7px">
                                                                                    Total Sales Match Bonus</div>

                                                                                <hr style="background-color :white">
                                                                                <div class="value"
                                                                                    style="color:white">400 PHP</div>
                                                                                <div class="trending trending-up">
                                                                                    <span></span><i
                                                                                        class="os-icon os-icon-arrow-up6"></i>
                                                                                </div>
                                                                            </a>

                                                                        </div>


                                                                        <div class="col-4 col-sm-3 col-xxl-2">


                                                                            <a class="element-box el-tablo centered trend-in-corner smaller"
                                                                                href="#"
                                                                                style="background-color : #1b55e2">
                                                                                <div class="label"
                                                                                    style="color:white; font-size: 7px">
                                                                                    5th Match Rewards Points</div>

                                                                                <hr style="background-color :white">
                                                                                <div class="value"
                                                                                    style="color:white">1000 PHP</div>
                                                                                <div class="trending trending-up">
                                                                                    <span></span><i
                                                                                        class="os-icon os-icon-arrow-up6"></i>
                                                                                </div>
                                                                            </a>

                                                                        </div>


                                                                    </div>
                                                                </div>



                                                            </div>
                                                            <div class="tab-pane fade" id="tab3primary">

                                                                <div class="element-content">
                                                                    <div class="row">


                                                                        <div class="col-4 col-sm-3 col-xxl-2">


                                                                            <a class="element-box el-tablo centered trend-in-corner smaller"
                                                                                href="#"
                                                                                style="background-color : #1b55e2">
                                                                                <div class="label"
                                                                                    style="color:white; font-size: 7px">
                                                                                    Total RCB</div>

                                                                                <hr style="background-color :white">
                                                                                <div class="value"
                                                                                    style="color:white">100 PHP</div>
                                                                                <div class="trending trending-up">
                                                                                    <span></span><i
                                                                                        class="os-icon os-icon-arrow-up6"></i>
                                                                                </div>
                                                                            </a>

                                                                        </div>


                                                                        <div class="col-4 col-sm-3 col-xxl-2">


                                                                            <a class="element-box el-tablo centered trend-in-corner smaller"
                                                                                href="#"
                                                                                style="background-color : #1b55e2">
                                                                                <div class="label"
                                                                                    style="color:white; font-size: 7px">
                                                                                    Current Month PV</div>

                                                                                <hr style="background-color :white">
                                                                                <div class="value"
                                                                                    style="color:white">1000 PHP</div>
                                                                                <div class="trending trending-up">
                                                                                    <span></span><i
                                                                                        class="os-icon os-icon-arrow-up6"></i>
                                                                                </div>
                                                                            </a>

                                                                        </div>


                                                                        <div class="col-4 col-sm-6 col-xxl-3">


                                                                            <a class="element-box el-tablo centered trend-in-corner smaller"
                                                                                href="#"
                                                                                style="background-color : #e65252">
                                                                                <div class="label"
                                                                                    style="color:white; font-size: 7px">
                                                                                    Current Month Qualification</div>

                                                                                <hr style="background-color :white">
                                                                                <div class="value"
                                                                                    style="color:white">500 PHP</div>
                                                                                <div class="trending trending-up">
                                                                                    <span></span><i
                                                                                        class="os-icon os-icon-arrow-up6"></i>
                                                                                </div>
                                                                            </a>

                                                                        </div>




                                                                    </div>
                                                                </div>




                                                            </div>
                                                            <div class="tab-pane fade" id="tab4primary">

                                                                <div class="element-content">
                                                                    <div class="row">


                                                                        <div class="col-4 col-sm-3 col-xxl-2">


                                                                            <a class="element-box el-tablo centered trend-in-corner smaller"
                                                                                href="#"
                                                                                style="background-color : #1b55e2">
                                                                                <div class="label"
                                                                                    style="color:white; font-size: 7px">
                                                                                    Total Leadership Bonus</div>

                                                                                <hr style="background-color :white">
                                                                                <div class="value"
                                                                                    style="color:white">400 PHP</div>
                                                                                <div class="trending trending-up">
                                                                                    <span></span><i
                                                                                        class="os-icon os-icon-arrow-up6"></i>
                                                                                </div>
                                                                            </a>

                                                                        </div>





                                                                    </div>
                                                                </div>



                                                            </div>
                                                            <div class="tab-pane fade" id="tab5primary">

                                                                <div class="element-content">
                                                                    <div class="row">


                                                                        <div class="col-4 col-sm-3 col-xxl-2">


                                                                            <a class="element-box el-tablo centered trend-in-corner smaller"
                                                                                href="#"
                                                                                style="background-color : #1b55e2">
                                                                                <div class="label"
                                                                                    style="color:white; font-size: 7px">
                                                                                    Total Accumulated Income</div>

                                                                                <hr style="background-color :white">
                                                                                <div class="value"
                                                                                    style="color:white">50 PHP</div>
                                                                                <div class="trending trending-up">
                                                                                    <span></span><i
                                                                                        class="os-icon os-icon-arrow-up6"></i>
                                                                                </div>
                                                                            </a>

                                                                        </div>


                                                                        <div class="col-4 col-sm-3 col-xxl-2">


                                                                            <a class="element-box el-tablo centered trend-in-corner smaller"
                                                                                href="#"
                                                                                style="background-color : #1b55e2">
                                                                                <div class="label"
                                                                                    style="color:white; font-size: 7px">
                                                                                    Total Accumulated Encashment</div>

                                                                                <hr style="background-color :white">
                                                                                <div class="value"
                                                                                    style="color:white">120 PHP</div>
                                                                                <div class="trending trending-up">
                                                                                    <span></span><i
                                                                                        class="os-icon os-icon-arrow-up6"></i>
                                                                                </div>
                                                                            </a>

                                                                        </div>


                                                                        <div class="col-4 col-sm-6 col-xxl-3">


                                                                            <a class="element-box el-tablo centered trend-in-corner smaller"
                                                                                href="#"
                                                                                style="background-color : #24b314a3">
                                                                                <div class="label"
                                                                                    style="color:white; font-size: 7px">
                                                                                    Total Avialable Balance</div>

                                                                                <hr style="background-color :white">
                                                                                <div class="value"
                                                                                    style="color:white">500 PHP</div>
                                                                                <div class="trending trending-up">
                                                                                    <span></span><i
                                                                                        class="os-icon os-icon-arrow-up6"></i>
                                                                                </div>
                                                                            </a>

                                                                        </div>




                                                                    </div>
                                                                </div>





                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="element-content">
                                        <div class="row">
                                            <div class="col-sm-4 col-xxxl-4">
                                                <a class="element-box el-tablo" href="#">
                                                    <div class="label" style="text-align: left">NetWork Statistics
                                                    </div>

                                                    <div class="trending trending-up-basic"><span
                                                            style="color:black">Sale Associate : </span><span>
                                                            100</span></div>
                                                    <br>
                                                    <div class="trending trending-up-basic"><span
                                                            style="color:black">Silver Executive : </span><span>
                                                            100</span></div>
                                                    <br>
                                                    <div class="trending trending-up-basic"><span
                                                            style="color:black">Gold Associate : </span><span>
                                                            100</span></div>
                                                    <br>
                                                    <div class="trending trending-up-basic"><span
                                                            style="color:black">Diamond Associate : </span><span>
                                                            100</span></div>
                                                    <hr>
                                                    <div class="label" style="text-align: left">Total : <span>
                                                            400</span></div>
                                                </a>
                                            </div>


                                            <div class="col-sm-4 col-xxxl-4">
                                                <a class="element-box el-tablo" href="#">
                                                    <div class="label" style="text-align: left">Sales Match Waiting
                                                        PV</div>
                                                    <div class="value">PV</div>


                                                    <div class="trending trending-up-basic"><span>Left : 0</span></div>
                                                    <br>
                                                    <div class="value">PV</div>
                                                    <div class="trending trending-up-basic"><span>Right : 0</span>
                                                    </div>
                                                </a>

                                            </div>

                                            <div class="col-sm-4 col-xxxl-4">
                                                <a class="element-box el-tablo" href="#">
                                                    <div class="label" style="text-align: left">Network Over-all
                                                        Performance</div>
                                                    <div class="trending trending-up-basic"><span
                                                            style="color:black">No. of Direct : </span><span>
                                                            100</span></div>
                                                    <hr>
                                                    <div class="label" style="text-align: left">Total Group : <span>
                                                            400</span></div>
                                                    <br>
                                                </a>
                                            </div>

                                        </div>
                                    </div>




                                    <div class="element-content">
                                        <div class="row">
                                            <div class="col-sm-4 col-xxxl-4">
                                                <a class="element-box el-tablo" href="#">
                                                    <div class="label" style="text-align: left">eWallet Statistics
                                                    </div>

                                                    <div class="trending trending-up-basic"><span
                                                            style="color:black">Gross Accumulated : </span><span>
                                                            100</span></div>
                                                    <br>
                                                    <div class="trending trending-up-basic"><span
                                                            style="color:black">Debit Executive : </span><span>
                                                            100</span></div>
                                                    <br>
                                                    <div class="trending trending-up-basic"><span
                                                            style="color:black">Available Balance : </span><span>
                                                            100</span></div>

                                                </a>
                                            </div>


                                            <div class="col-sm-4 col-xxxl-4">
                                                <a class="element-box el-tablo" href="#">
                                                    <div class="label" style="text-align: left">Network - Current
                                                        Month</div>
                                                    <div class="trending trending-up-basic"><span
                                                            style="color:black">No. of Direct : </span><span>
                                                            100</span></div>
                                                    <hr>
                                                    <div class="label" style="text-align: left">Total Group : <span>
                                                            400</span></div>

                                                </a>
                                            </div>



                                        </div>
                                    </div>





                                </div>
                            </div>
                        </div>
                        <div class="row">





                            <div class="col-sm-8 col-xxxl-12">
                                <div class="element-wrapper">
                                    <h6 class="element-header">Latest Downlines</h6>
                                    <div class="element-box">
                                        <div class="table-responsive">
                                            <table class="table table-lightborder">
                                                <thead>
                                                    <tr>
                                                        <th>Full Name</th>
                                                        <th>Sponsor</th>
                                                        <th class="text-center">Placement Position</th>
                                                        <th class="text-right">Geneology</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="nowrap">Rommel Lacap</td>
                                                        <td class="text-left">Bill Gates</td>
                                                        <td class="text-center">Left</td>
                                                        <td class="text-right"> <button class="btn btn-primary"
                                                                type="submit"> View</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="nowrap">Jesser Galapon</td>
                                                        <td class="text-left">Elon Musk</td>
                                                        <td class="text-center">Left</td>
                                                        <td class="text-right"><button class="btn btn-primary"
                                                                type="submit"> View</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="nowrap">Joe Manuel Irinco</td>
                                                        <td class="text-left">Jack Ma</td>
                                                        <td class="text-center">Left</td>
                                                        <td class="text-right"><button class="btn btn-primary"
                                                                type="submit"> View</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="nowrap">Japz Nakamura</td>
                                                        <td class="text-left">Chavit Singson</td>
                                                        <td class="text-center">Right</td>
                                                        <td class="text-right"><button class="btn btn-primary"
                                                                type="submit"> View</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="nowrap">Emil Tamayo</td>
                                                        <td class="text-left">Manny Pacquiao</td>
                                                        <td class="text-center">Right</td>
                                                        <td class="text-right"><button class="btn btn-primary"
                                                                type="submit"> View</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 d-xxxl-none">
                                <!--START - Top Selling Chart-->
                                <div class="element-wrapper">
                                    <h6 class="element-header">Top Selling Today</h6>
                                    <div class="element-box">
                                        <div class="el-chart-w">
                                            <canvas height="120" id="donutChart" width="120"></canvas>
                                            <div class="inside-donut-chart-label"><strong>142</strong><span>Total
                                                    Orders</span></div>
                                        </div>
                                        <div class="el-legend condensed">
                                            <div class="row">
                                                <div class="col-auto col-xxxxl-6 ml-sm-auto mr-sm-auto col-6">
                                                    <div class="legend-value-w">
                                                        <div class="legend-pin legend-pin-squared"
                                                            style="background-color: #6896f9;"></div>
                                                        <div class="legend-value"><span>Prada</span>
                                                            <div class="legend-sub-value">14 Pairs</div>
                                                        </div>
                                                    </div>
                                                    <div class="legend-value-w">
                                                        <div class="legend-pin legend-pin-squared"
                                                            style="background-color: #85c751;"></div>
                                                        <div class="legend-value"><span>Maui Jim</span>
                                                            <div class="legend-sub-value">26 Pairs</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 d-lg-none d-xxl-block">
                                                    <div class="legend-value-w">
                                                        <div class="legend-pin legend-pin-squared"
                                                            style="background-color: #806ef9;"></div>
                                                        <div class="legend-value"><span>Gucci</span>
                                                            <div class="legend-sub-value">17 Pairs</div>
                                                        </div>
                                                    </div>
                                                    <div class="legend-value-w">
                                                        <div class="legend-pin legend-pin-squared"
                                                            style="background-color: #d97b70;"></div>
                                                        <div class="legend-value"><span>Armani</span>
                                                            <div class="legend-sub-value">12 Pairs</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--END - Top Selling Chart-->
                            </div>
                            <!--<div class="d-none d-xxxl-block col-xxxl-6">

                                <div class="element-wrapper">
                                    <div class="element-actions">
                                        <form class="form-inline justify-content-sm-end">
                                            <select class="form-control form-control-sm rounded">
                                                <option value="Pending">Today</option>
                                                <option value="Active">Last Week </option>
                                                <option value="Cancelled">Last 30 Days</option>
                                            </select>
                                        </form>
                                    </div>
                                    <h6 class="element-header">Inventory Stats</h6>
                                    <div class="element-box">
                                        <div class="os-progress-bar primary">
                                            <div class="bar-labels">
                                                <div class="bar-label-left"><span class="bigger">Eyeglasses</span></div>
                                                <div class="bar-label-right"><span class="info">25 items / 10 remaining</span></div>
                                            </div>
                                            <div class="bar-level-1" style="width: 100%">
                                                <div class="bar-level-2" style="width: 70%">
                                                    <div class="bar-level-3" style="width: 40%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="os-progress-bar primary">
                                            <div class="bar-labels">
                                                <div class="bar-label-left"><span class="bigger">Outwear</span></div>
                                                <div class="bar-label-right"><span class="info">18 items / 7 remaining</span></div>
                                            </div>
                                            <div class="bar-level-1" style="width: 100%">
                                                <div class="bar-level-2" style="width: 40%">
                                                    <div class="bar-level-3" style="width: 20%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="os-progress-bar primary">
                                            <div class="bar-labels">
                                                <div class="bar-label-left"><span class="bigger">Shoes</span></div>
                                                <div class="bar-label-right"><span class="info">15 items / 12 remaining</span></div>
                                            </div>
                                            <div class="bar-level-1" style="width: 100%">
                                                <div class="bar-level-2" style="width: 60%">
                                                    <div class="bar-level-3" style="width: 30%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="os-progress-bar primary">
                                            <div class="bar-labels">
                                                <div class="bar-label-left"><span class="bigger">Jeans</span></div>
                                                <div class="bar-label-right"><span class="info">12 items / 4 remaining</span></div>
                                            </div>
                                            <div class="bar-level-1" style="width: 100%">
                                                <div class="bar-level-2" style="width: 30%">
                                                    <div class="bar-level-3" style="width: 10%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 border-top pt-3">
                                            <div class="element-actions d-none d-sm-block">
                                                <form class="form-inline justify-content-sm-end">
                                                    <select class="form-control form-control-sm form-control-faded">
                                                        <option selected="true">Last 30 days</option>
                                                        <option>This Week</option>
                                                        <option>This Month</option>
                                                        <option>Today</option>
                                                    </select>
                                                </form>
                                            </div>
                                            <h6 class="element-box-header">Inventory History</h6>
                                            <div class="el-chart-w">
                                                <canvas data-chart-data="13,28,19,24,43,49,40,35,42,46,38,32,45" height="50" id="liteLineChartV3" width="300"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--END - Questions per product
                            </div>-->





                        </div>
                        <!-- <div class="row">
                            <div class="col-sm-12 col-xxxl-9">
                                <div class="element-wrapper">
                                    <h6 class="element-header">Unique Visitors Graph</h6>
                                    <div class="element-box">
                                        <div class="os-tabs-w">
                                            <div class="os-tabs-controls">
                                                <ul class="nav nav-tabs smaller">
                                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab_overview">Overview</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_sales">Sales</a></li>
                                                </ul>
                                                <ul class="nav nav-pills smaller d-none d-md-flex">
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#">Today</a></li>
                                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#">7 Days</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#">14 Days</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#">Last Month</a></li>
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_overview">
                                                    <div class="el-tablo bigger">
                                                        <div class="label">Unique Visitors</div>
                                                        <div class="value">12,537</div>
                                                    </div>
                                                    <div class="el-chart-w">
                                                        <canvas height="150px" id="lineChart" width="600px"></canvas>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_sales"></div>
                                                <div class="tab-pane" id="tab_conversion"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-none d-xxxl-block col-xxxl-3">
                                <div class="element-wrapper">
                                    <h6 class="element-header">Visitors by Browser</h6>
                                    <div class="element-box less-padding">
                                        <div class="el-chart-w">
                                            <canvas height="120" id="donutChart1" width="120"></canvas>
                                            <div class="inside-donut-chart-label"><strong>1,248</strong><span>Visitors</span></div>
                                        </div>
                                        <div class="el-legend condensed">
                                            <div class="row">
                                                <div class="col-auto col-xxxxl-6 ml-sm-auto mr-sm-auto">
                                                    <div class="legend-value-w">
                                                        <div class="legend-pin legend-pin-squared" style="background-color: #6896f9;"></div>
                                                        <div class="legend-value"><span>No. of Direct</span>
                                                            <div class="legend-sub-value">17%, 12 Visits</div>
                                                        </div>
                                                    </div>
                                                    <div class="legend-value-w">
                                                        <div class="legend-pin legend-pin-squared" style="background-color: #85c751;"></div>
                                                        <div class="legend-value"><span>Chrome</span>
                                                            <div class="legend-sub-value">22%, 763 Visits</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 d-none d-xxxxl-block">
                                                    <div class="legend-value-w">
                                                        <div class="legend-pin legend-pin-squared" style="background-color: #806ef9;"></div>
                                                        <div class="legend-value"><span>Firefox</span>
                                                            <div class="legend-sub-value">3%, 7 Visits</div>
                                                        </div>
                                                    </div>
                                                    <div class="legend-value-w">
                                                        <div class="legend-pin legend-pin-squared" style="background-color: #d97b70;"></div>
                                                        <div class="legend-value"><span>Explorer</span>
                                                            <div class="legend-sub-value">15%, 45 Visits</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        <!--------------------
START - Color Scheme Toggler
-------------------->
                        <div class="floated-colors-btn second-floated-btn">
                            <div class="os-toggler-w">
                                <div class="os-toggler-i">
                                    <div class="os-toggler-pill"></div>
                                </div>
                            </div><span>Dark </span><span>Colors</span>
                        </div>
                        <!--------------------
END - Color Scheme Toggler
-------------------->
                        <!--------------------
START - Demo Customizer
-------------------->
                        <div class="floated-customizer-btn third-floated-btn">
                            <div class="icon-w"><i class="os-icon os-icon-ui-46"></i></div><span>Customizer</span>
                        </div>
                        <div class="floated-customizer-panel">
                            <div class="fcp-content">
                                <div class="close-customizer-btn"><i class="os-icon os-icon-x"></i></div>
                                <div class="fcp-group">
                                    <div class="fcp-group-header">Menu Settings</div>
                                    <div class="fcp-group-contents">
                                        <div class="fcp-field">
                                            <label for="">Menu Position</label>
                                            <select class="menu-position-selector">
                                                <option value="left">Left</option>
                                                <option value="right">Right</option>
                                                <option value="top">Top</option>
                                            </select>
                                        </div>
                                        <div class="fcp-field">
                                            <label for="">Menu Style</label>
                                            <select class="menu-layout-selector">
                                                <option value="compact">Compact</option>
                                                <option value="full">Full</option>
                                                <option value="mini">Mini</option>
                                            </select>
                                        </div>
                                        <div class="fcp-field with-image-selector-w">
                                            <label for="">With Image</label>
                                            <select class="with-image-selector">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="fcp-field">
                                            <label for="">Menu Color</label>
                                            <div class="fcp-colors menu-color-selector">
                                                <div class="color-selector menu-color-selector color-bright selected">
                                                </div>
                                                <div class="color-selector menu-color-selector color-dark"></div>
                                                <div class="color-selector menu-color-selector color-light"></div>
                                                <div class="color-selector menu-color-selector color-transparent">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="fcp-group">
                                    <div class="fcp-group-header">Sub Menu</div>
                                    <div class="fcp-group-contents">
                                        <div class="fcp-field">
                                            <label for="">Sub Menu Style</label>
                                            <select class="sub-menu-style-selector">
                                                <option value="flyout">Flyout</option>
                                                <option value="inside">Inside/Click</option>
                                                <option value="over">Over</option>
                                            </select>
                                        </div>
                                        <div class="fcp-field">
                                            <label for="">Sub Menu Color</label>
                                            <div class="fcp-colors">
                                                <div
                                                    class="color-selector sub-menu-color-selector color-bright selected">
                                                </div>
                                                <div class="color-selector sub-menu-color-selector color-dark"></div>
                                                <div class="color-selector sub-menu-color-selector color-light"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="fcp-group">
                                    <div class="fcp-group-header">Other Settings</div>
                                    <div class="fcp-group-contents">
                                        <div class="fcp-field">
                                            <label for="">Full Screen?</label>
                                            <select class="full-screen-selector">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="fcp-field">
                                            <label for="">Show Top Bar</label>
                                            <select class="top-bar-visibility-selector">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="fcp-field">
                                            <label for="">Above Menu?</label>
                                            <select class="top-bar-above-menu-selector">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="fcp-field">
                                            <label for="">Top Bar Color</label>
                                            <div class="fcp-colors">
                                                <div
                                                    class="color-selector top-bar-color-selector color-bright selected">
                                                </div>
                                                <div class="color-selector top-bar-color-selector color-dark"></div>
                                                <div class="color-selector top-bar-color-selector color-light"></div>
                                                <div class="color-selector top-bar-color-selector color-transparent">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--------------------
END - Demo Customizer
-------------------->
                        <!--------------------
START - Chat Popup Box
-------------------->
                        <!-- <div class="floated-chat-btn"><i class="os-icon os-icon-mail-07"></i><span>Demo Chat</span></div>
                        <div class="floated-chat-w">
                            <div class="floated-chat-i">
                                <div class="chat-close"><i class="os-icon os-icon-close"></i></div>
                                <div class="chat-head">
                                    <div class="user-w with-status status-green">
                                        <div class="user-avatar-w">
                                            <div class="user-avatar"><img alt="" src="img/avatar1.jpg"></div>
                                        </div>
                                        <div class="user-name">
                                            <h6 class="user-title">John Mayers</h6>
                                            <div class="user-role">Account Manager</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-messages">
                                    <div class="message">
                                        <div class="message-content">Hi, how can I help you?</div>
                                    </div>
                                    <div class="date-break">Mon 10:20am</div>
                                    <div class="message">
                                        <div class="message-content">Hi, my name is Mike, I will be happy to assist you</div>
                                    </div>
                                    <div class="message self">
                                        <div class="message-content">Hi, I tried ordering this product and it keeps showing me error code.</div>
                                    </div>
                                </div>
                                <div class="chat-controls">
                                    <input class="message-input" placeholder="Type your message here..." type="text">
                                    <div class="chat-extra"><a href="#"><span class="extra-tooltip">Attach Document</span><i class="os-icon os-icon-documents-07"></i></a><a href="#"><span class="extra-tooltip">Insert Photo</span><i class="os-icon os-icon-others-29"></i></a><a href="#"><span class="extra-tooltip">Upload Video</span><i class="os-icon os-icon-ui-51"></i></a></div>
                                </div>
                            </div>
                        </div>
                        <!--------------------
END - Chat Popup Box
-------------------->
                    </div>
                    <!--------------------
START - Sidebar
-------------------->
                    <div class="content-panel">
                        <div class="content-panel-close"><i class="os-icon os-icon-close"></i></div>


                        <div class="element-wrapper">
                            <h6 class="element-header">My Binary Rank</h6>
                            <div class="element-box-tp">
                                <div class="profile-tile">
                                    <a class="profile-tile-box" href="users_profile_small.html">
                                        <div class="pt-avatar-w"><img alt="" src="img/avatar1.jpg"></div>
                                        <div class="pt-user-name">Rommel Lacap</div>
                                    </a>
                                    <div class="profile-tile-meta">
                                        <ul>
                                            <li>Account Type :<strong>Premium</strong></li>
                                            <li>Network :<strong><a href="apps_support_index.html">12</a></strong>
                                            </li>

                                        </ul>
                                        <div class="pt-btn"><a class="btn btn-success btn-sm"
                                                href="apps_full_chat.html">Encode Maintenance</a></div>
                                    </div>






                                </div>

                                <h6 class="element-header">Quick Links</h6>
                                <div class="element-box-tp">
                                    <div class="el-buttons-list full-width"><a class="btn btn-white btn-sm"
                                            href="#"><i
                                                class="os-icon os-icon-delivery-box-2"></i><span>Binary Network
                                                List</span></a><a class="btn btn-white btn-sm" href="#"><i
                                                class="os-icon os-icon-window-content"></i><span>Personal Enrollment
                                                Tree</span></a><a class="btn btn-white btn-sm" href="#"><i
                                                class="os-icon os-icon-wallet-loaded"></i><span>Encashment
                                                Report</span></a></div>
                                </div>





                            </div>






                        </div>



                        <!--------------------
START - Support Agents
-------------------->

                        <!--------------------
END - Support Agents
-------------------->
                        <!--------------------
START - Recent Activity
-------------------->

                        <!--------------------
END - Recent Activity
-------------------->
                        <!--------------------
START - Team Members
-------------------->

                        <!--------------------
END - Team Members
-------------------->
                    </div>
                    <!--------------------
END - Sidebar
-------------------->
                </div>
            </div>
        </div>
        <div class="display-type"></div>
    </div>
    <script src="js/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="js/bower_components/popper.js/dist/umd/popper.min.js"></script>
    <script src="js/bower_components/moment/moment.js"></script>
    <script src="js/bower_components/chart.js/dist/Chart.min.js"></script>
    <script src="js/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="js/bower_components/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
    <script src="js/bower_components/ckeditor/ckeditor.js"></script>
    <script src="js/bower_components/bootstrap-validator/dist/validator.min.js"></script>
    <script src="js/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="js/bower_components/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <script src="js/bower_components/dropzone/dist/dropzone.js"></script>
    <script src="js/bower_components/editable-table/mindmup-editabletable.js"></script>
    <script src="js/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="js/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="js/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="js/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="js/bower_components/tether/dist/js/tether.min.js"></script>
    <script src="js/bower_components/slick-carousel/slick/slick.min.js"></script>
    <script src="js/bower_components/bootstrap/js/dist/util.js"></script>
    <script src="js/bower_components/bootstrap/js/dist/alert.js"></script>
    <script src="js/bower_components/bootstrap/js/dist/button.js"></script>
    <script src="js/bower_components/bootstrap/js/dist/carousel.js"></script>
    <script src="js/bower_components/bootstrap/js/dist/collapse.js"></script>
    <script src="js/bower_components/bootstrap/js/dist/dropdown.js"></script>
    <script src="js/bower_components/bootstrap/js/dist/modal.js"></script>
    <script src="js/bower_components/bootstrap/js/dist/tab.js"></script>
    <script src="js/bower_components/bootstrap/js/dist/tooltip.js"></script>
    <script src="js/bower_components/bootstrap/js/dist/popover.js"></script>
    <script src="js/js/demo_customizerce5a.js?version=4.4.1"></script>
    <script src="js/js/maince5a.js?version=4.4.1"></script>
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '../www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-42863888-9', 'auto');
        ga('send', 'pageview');
    </script>





</body>
<!-- Mirrored from light.pinsupreme.com/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 25 Nov 2019 05:23:55 GMT -->

</html>
