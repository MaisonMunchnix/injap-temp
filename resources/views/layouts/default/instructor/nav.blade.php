<div class="navigation">
    <div class="navigation-menu-tab">
        <ul>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Courses"
                    data-nav-target="#courses">
                    <i data-feather="book"></i>
                </a>
            </li>
            <li>
                <a href="#" data-toggle="tooltip" data-placement="right" title="Settings"
                    data-nav-target="#settings">
                    <i data-feather="settings"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="navigation-menu-body">
        <div class="navigation-menu-group">
            <div id="courses">
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
                </ul>
            </div>
            <div id="settings">
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
