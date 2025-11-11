@extends('layouts.default.admin.master')
@section('title','Announcement')
@section('page-title','Announcement')

@section('stylesheets')

<!--<link type="text/css" rel="stylesheet" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css">
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />-->
<style>
    .border-red {
        border: 1px solid red !important;
    }

</style>
@endsection

@section('content')
<div class="content-body">
    <!-- start content- -->
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Announcement</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                </ol>
            </nav>
        </div>

        <div class="row app-block">
            <div class="col-md-3 app-sidebar">
                <div class="card">
                    <div class="card-body">
                        @if(empty($access_data))
                        @else
                        @if($access_data[0]->announcement[0]->add=='true')
                        <a class="add-task-btn pull-right" data-target="#add-announcement-modal" data-toggle="modal" href="#"><i class="os-icon os-icon-ui-22"></i><span> Post New Announcement</span></a>
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#add-announcement-modal">
                            New Announcement
                        </button>
                        @else
                        <a class="add-task-btn pull-right disabled" href="#"><i class="os-icon os-icon-ui-22"></i><span> Post New Announcement</span></a>
                        <button class="btn btn-primary btn-block disabled">
                            New Announcement
                        </button>
                        @endif
                        @endif
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#add-announcement-modal">
                            New Announcement
                        </button>
                    </div>

                </div>
            </div>
            <div class="col-md-9 app-content">
                <div class="app-content-overlay"></div>
                <div class="card card-body app-content-body">
                    <div class="app-lists">
                        <ul class="list-group list-group-flush">
                            @if(!empty($announcement))
                            @foreach($announcement as $announce)
                            <li class="list-group-item task-list">

                                <!--<div>
                                    <div class="custom-control custom-checkbox custom-checkbox-success mr-2">
                                        <input type="checkbox" class="custom-control-input" id="customCheck3">
                                        <label class="custom-control-label" for="customCheck3"></label>
                                    </div>
                                </div>-->


                                <div class="flex-grow-1 min-width-0">
                                    <div class="mb-1 d-flex align-items-center justify-content-between">
                                        <div class="app-list-title text-truncate">{{ $announce->title }}
                                        </div>
                                        <div class="pl-3 d-flex align-items-center">
                                           <div class="mr-3">
                                               {{ $announce->created_at }}
                                           </div>
                                           
                                            @if(empty($access_data))
                                            <a href="#" title="Edit" class="task-btn-edit" data-id="{{$announce->id}}" data-toggle="tooltip" data-toggle="modal">
                                                <i data-feather="edit" class="width-15 height-15"></i>
                                            </a>
                                            @else
                                            @if($access_data[0]->announcement[0]->edit=='true')

                                            <a href="#" title="Edit" class="task-btn-edit" data-id="{{$announce->id}}" data-toggle="tooltip" data-toggle="modal">
                                                <i data-feather="edit" class="width-15 height-15"></i>
                                            </a>
                                            @else

                                            @endif
                                            @endif

                                            @if(empty($access_data))
                                            <a href="#" title="Delete" data-toggle="tooltip" class="task-btn-delete" data-id="{{$announce->id}}" data-toggle="modal">
                                                <i data-feather="trash-2" class="width-15 height-15"></i>
                                            </a>
                                            @else
                                            @if($access_data[0]->announcement[0]->delete=='true')
                                            <a href="#" title="Delete" data-toggle="tooltip" class="task-btn-delete" data-id="{{$announce->id}}" data-toggle="modal">
                                                <i data-feather="trash-2" class="width-15 height-15"></i>
                                            </a>
                                            @else

                                            @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <!-- end::app-lists -->
                </div>
            </div>
        </div>

        @include('admin.announcement.add_modal')
        @include('admin.announcement.edit_modal')
        @include('admin.announcement.delete_modal')
    </div>
</div>
<!-- end content-i -->
@endsection

@section('scripts')
{{-- additional scripts here --}}
<!-- Sweetalert -->
<script>
    $('.create-event-datepicker').datepicker({
        /*uiLibrary: 'bootstrap4',*/
        format: 'yyyy-mm-dd'
    });

</script>

<script src="{{asset('js/admin/announcement.js')}}"></script>
<!--Modal - Edit Task-->

@endsection
