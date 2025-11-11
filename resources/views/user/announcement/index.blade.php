@extends('layouts.default.master')
@section('title','Announcements')
@section('page-title','Announcement')

@section('stylesheets')
{{-- additional style here --}}
@endsection

@section('content')
{{-- content here --}}
<div class="content-body">
    <div class="content">
        @if(empty($announcements) || $announcement_count==0)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">No announcement yet...</h2>
                    </div>
                </div>
            </div>
        </div>
        @else
        @foreach($announcements as $key=>$data)
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="d-flex">
                                <div>
                                    <figure class="avatar mr-3">
                                        <img src="{{asset('images/users/default_image.png')}}" class="rounded" alt="...">
                                    </figure>
                                </div>
                                <div>
                                    <h5 class="mt-0">{{$data->title}}</h5>
                                    <span class="badge bg-info-bright text-info">{{$data->priority}}</span>
                                </div>
                            </div>                             
                        </div>
                        <p>Project Description:</p>
                        <p>Subject: {{$data->subject}}</p>
                        <p>{!! $data->content !!}</p>
                        <div class="row my-4">
                            <div class="col-md-3">
                                <p class="mb-2">Created:</p>
                                <div>
                                    <i class="ti-calendar mr-1"></i>
                                    {{date("Y-m-d",strtotime($data->created_at))}}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-2">Deadline:</p>
                                <div>
                                    <i class="ti-calendar mr-1"></i>
                                    {{$data->date_end}}
                                </div>
                            </div>
                        </div>
                        <hr class="my-4"> 
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">                    
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Attachment</h6>
                        <div class="card-scroll">
                            <ul class="list-group list-group-flush">
                                @php $count_att=0; @endphp
                                @foreach($get_announcement as $att)
                                    @if($data->id==$att->announcement_id)
                                    @php $count_att++; @endphp
                                <li class="list-group-item d-flex align-items-center pl-0 pr-0">
                                    <div>
                                        <figure class="avatar mr-3">
                                            <span class="avatar-title bg-info-bright text-info rounded">
                                                <i class="fa fa-file-text-o"></i>
                                            </span>
                                        </figure>
                                    </div>
                                    <div>                                      
                                        <a href="{{asset($att->source)}}" download>
                                            <h6 class="mb-0 ml-1 mr-1">{{$att->name}}</h6>
                                        </a>                                          
                                    </div>
                                </li>    
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection

@section('scripts')
{{-- additional scripts here --}}
<script src="{{asset('js/user/announcement.js')}}"></script>
@endsection
