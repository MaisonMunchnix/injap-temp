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
                <a href="#" data-toggle="tooltip" data-placement="right" title="Courses"
                    data-nav-target="#instructors">
                    <i data-feather="book"></i>
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
                        <i class="mr-2" data-feather="home"></i> Dashboard
                    </li>
                    <li>
                        <a class="{{ request()->is('instructor/dashboard') ? 'active' : '' }}"
                            href="{{ route('instructor.dashboard') }}">Overview</a>
                    </li>
                </ul>
            </div>
            <div id="instructors">
                <ul>
                    <li class="navigation-divider d-flex align-items-center">
                        <i class="mr-2" data-feather="book"></i> Course Management
                    </li>
                    <li>
                        <a class="{{ request()->is('instructor/courses') ? 'active' : '' }}"
                            href="{{ route('instructor.courses.index') }}">My Courses</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('instructor/courses/create') ? 'active' : '' }}"
                            href="{{ route('instructor.courses.create') }}">Create New Course</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('instructor/enrollees*') ? 'active' : '' }}"
                            href="{{ route('instructor.courses.enrollees') }}">My Students</a>
                    </li>
                    <li>
                        <a class="{{ request()->is('instructor/materials*') ? 'active' : '' }}"
                            href="{{ route('instructor.materials.index') }}">Learning Materials</a>
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

<script>
    // Visibility Helper for Instructor Sidebar
    (function () {
        function initNav() {
            if (typeof $ === 'undefined') return;
            
            // 1. Identify the currently active link
            var $activeLink = $('.navigation-menu-group .active');
            if ($activeLink.length) {
                // 2. Open the group containing that link
                var $group = $activeLink.closest('.navigation-menu-group > div');
                $group.addClass('open');
                
                // 3. Highlight the corresponding icon in the tab menu
                var groupId = $group.attr('id');
                if (groupId) {
                    $('.navigation-menu-tab a[data-nav-target="#' + groupId + '"]').closest('li').addClass('active');
                }
            }
            
            // 4. Ensure Feather icons are rendered
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initNav);
        } else {
            initNav();
        }
    })();
</script>
