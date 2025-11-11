@extends('layouts.user.master')
@section('title', 'Add Announcement')
@section('page-title', 'Add Announcement')

@section('stylesheets')
    <style>
        .border-red {
            border: 1px solid red !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-i">
        <!-- start content- -->
        <div class="content-box">
            <div class="element-wrapper">
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <div class="element-box">
                    <h5 class="form-header text-center">@yield('title')</h5>
                    <div class="form-desc text-center"></div>
                </div>
                <div class="content-i">
                    <div class="content-box">
                        <!--START - To Do Application-->
                        <div class="todo-app-w">
                            <div class="todo-content">
                                <h4 class="todo-content-header"><i
                                        class="os-icon os-icon-ui-83"></i><span>Announcement</span></h4>
                                <div class="all-tasks-w">
                                    <div class="tasks-section">
                                        <!--START - TASKS HEADER-->
                                        <div class="tasks-header-w"><a class="tasks-header-toggler" href="#"><i
                                                    class="os-icon os-icon-ui-23"></i></a>
                                            <h5 class="tasks-header">Announcement</h5><span
                                                class="tasks-sub-header">February 19, 2020</span><a class="add-task-btn"
                                                data-target="#taskModal" data-toggle="modal" href="#"><i
                                                    class="os-icon os-icon-ui-22"></i><span>Add Announcement</span></a>
                                        </div>
                                        <!--END - TASKS HEADER-->
                                        <div class="tasks-list-w">
                                            <div class="tasks-list-header">Subject of Announcment</div>
                                            <!--START - Tasks List-->
                                            <ul class="tasks-list">
                                                <li class="draggable-task danger">
                                                    <div class="todo-task-drag drag-handle"><i
                                                            class="os-icon os-icon-hamburger-menu-2 drag-handle"></i></div>
                                                    <div class="todo-task"><span contenteditable="true">Content of
                                                            Announcment will goes here.....</span>
                                                        <div class="todo-task-buttons"><a class="task-btn-done"
                                                                href="#"><span>Post</span><i
                                                                    class="os-icon os-icon-ui-21"></i></a><a
                                                                class="task-btn-edit" data-target="#taskModal"
                                                                data-toggle="modal" href="#"><span>Edit</span><i
                                                                    class="os-icon os-icon-ui-49"></i></a><a
                                                                class="task-btn-delete" href="#"><span>Delete</span><i
                                                                    class="os-icon os-icon-ui-15"></i></a></div>
                                                    </div>
                                                </li>


                                            </ul>
                                            <!--END - Tasks List-->

                                            <!--START - Tasks List-->

                                        </div>
                                    </div>
                                    <!--END - Tasks List-->
                                    <div class="tasks-section">
                                        <!--START - TASKS HEADER-->
                                        <div class="tasks-header-w"><a class="tasks-header-toggler" href="#"><i
                                                    class="os-icon os-icon-ui-23"></i></a>
                                            <h5 class="tasks-header">Announcement</h5><span
                                                class="tasks-sub-header">February 19, 2020</span><a class="add-task-btn"
                                                data-target="#taskModal" data-toggle="modal" href="#"><i
                                                    class="os-icon os-icon-ui-22"></i><span>Add Announcement</span></a>
                                        </div>
                                        <!--END - TASKS HEADER-->
                                        <div class="tasks-list-w">
                                            <div class="tasks-list-header">Subject of Announcment</div>
                                            <!--START - Tasks List-->
                                            <ul class="tasks-list">
                                                <li class="draggable-task danger">
                                                    <div class="todo-task-drag drag-handle"><i
                                                            class="os-icon os-icon-hamburger-menu-2 drag-handle"></i></div>
                                                    <div class="todo-task"><span contenteditable="true">Content of
                                                            Announcment will goes here.....</span>
                                                        <div class="todo-task-buttons"><a class="task-btn-done"
                                                                href="#"><span>Post</span><i
                                                                    class="os-icon os-icon-ui-21"></i></a><a
                                                                class="task-btn-edit" data-target="#taskModal"
                                                                data-toggle="modal" href="#"><span>Edit</span><i
                                                                    class="os-icon os-icon-ui-49"></i></a><a
                                                                class="task-btn-delete" href="#"><span>Delete</span><i
                                                                    class="os-icon os-icon-ui-15"></i></a></div>
                                                    </div>
                                                </li>


                                            </ul>
                                            <!--END - Tasks List-->

                                            <!--START - Tasks List-->

                                        </div>
                                    </div>
                                    <div class="tasks-section">
                                        <!--START - TASKS HEADER-->
                                        <div class="tasks-header-w"><a class="tasks-header-toggler" href="#"><i
                                                    class="os-icon os-icon-ui-23"></i></a>
                                            <h5 class="tasks-header">Announcement</h5><span
                                                class="tasks-sub-header">February 19, 2020</span><a class="add-task-btn"
                                                data-target="#taskModal" data-toggle="modal" href="#"><i
                                                    class="os-icon os-icon-ui-22"></i><span>Add Announcement</span></a>
                                        </div>
                                        <!--END - TASKS HEADER-->
                                        <div class="tasks-list-w">
                                            <div class="tasks-list-header">Subject of Announcment</div>
                                            <!--START - Tasks List-->
                                            <ul class="tasks-list">
                                                <li class="draggable-task danger">
                                                    <div class="todo-task-drag drag-handle"><i
                                                            class="os-icon os-icon-hamburger-menu-2 drag-handle"></i></div>
                                                    <div class="todo-task"><span contenteditable="true">Content of
                                                            Announcment will goes here.....</span>
                                                        <div class="todo-task-buttons"><a class="task-btn-done"
                                                                href="#"><span>Post</span><i
                                                                    class="os-icon os-icon-ui-21"></i></a><a
                                                                class="task-btn-edit" data-target="#taskModal"
                                                                data-toggle="modal" href="#"><span>Edit</span><i
                                                                    class="os-icon os-icon-ui-49"></i></a><a
                                                                class="task-btn-delete"
                                                                href="#"><span>Delete</span><i
                                                                    class="os-icon os-icon-ui-15"></i></a></div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!--END - Tasks List-->
                                            <!--START - Tasks List-->
                                        </div>
                                    </div>
                                </div>
                                <!--Modal - Edit Task-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.announcements.view_modal')
        </div>
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <!-- Sweetalert -->
    {{-- <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script> --}}

    <script src="{{ asset('js/admin/branch.js') }}"></script>

@endsection
