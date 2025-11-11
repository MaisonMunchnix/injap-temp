<div class="content-panel">
    <div class="content-panel-close"><i class="os-icon os-icon-close"></i></div>
    <div class="element-wrapper">
        <h6 class="element-header">My Binary Rank</h6>
        <div class="element-box-tp">
            <div class="profile-tile">
                <a class="profile-tile-box" href="{{route('member-profile')}}">
                    <div class="pt-avatar-w"><img alt="" @if(!empty($global_user_data->profile_picture) && file_exists(public_path($global_user_data->profile_picture))) src="{{asset($global_user_data->profile_picture)}}" @else src="{{asset('img/default_image.png')}}" @endif></div>
                    <div class="pt-user-name">@if(!empty($global_user_data->first_name)) {{$global_user_data->first_name}} @endif @if(!empty($global_user_data->last_name)) {{$global_user_data->last_name}} @endif</div>
                </a>
                <div class="profile-tile-meta">
                    <ul>
                        <li>Account Type :<strong>@if(!empty($global_user_data->package_type)) {{$global_user_data->package_type}} @endif</strong></li>
                        <li>Network :<strong><a href="#" id="network_count">0</a></strong></li>

                    </ul>
                    <div class="pt-btn"><button class="btn btn-success btn-sm" data-target="#upgrade-account-modal" data-toggle="modal">Upgrade Account</button></div>
                </div>
            </div>
            @if(!empty($announcements) && $announcements->count()>0)
                <h6 class="element-header">Announcement</h6>
                <div class="element-box-tp">
                    <div class="alert alert-danger borderless">
                        <div class="container">
                            <div id="carouselContent" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">                             
                                    @foreach($announcements as $key=>$data)
                                        <div class="carousel-item  @if($key==0) active @endif text-center p-4">
                                            <h5 class="alert-heading mb-3">{{$data->title}}</h5>
                                            @if(strlen($data->content)>=130)
                                                @php $new_content=substr($data->content, 0, 130);  @endphp
                                                <p>{{$new_content}}...</p>
                                            @else
                                                {{$data->content}}
                                            @endif
                                            <div class="alert-btn mt-4"><a class="btn btn-white-gold" href="{{route('announcement','view')}}"><span>Read More</span></a></div>
                                        </div>
                                    @endforeach                                      
                                </div>
                                <a class="carousel-control-prev" href="#carouselContent" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselContent" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
