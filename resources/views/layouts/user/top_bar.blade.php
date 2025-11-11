<!-------------------- START - Top Bar -------------------->
<div class="top-bar color-scheme-bright">
    <!-------------------- START - Top Menu Controls -------------------->
    <div class="top-menu-controls">
        <div class="logged-user-w">
            <div class="logged-user-i">
                <div class="avatar-w"><img alt=""@if(!empty($global_user_data->profile_picture) && file_exists(public_path($global_user_data->profile_picture))) src="{{asset($global_user_data->profile_picture)}}" @else src="{{asset('img/default_image.png')}}" @endif style="width:45px; height:45px;"></div>
                <div class="logged-user-menu color-style-bright">
                    <div class="logged-user-avatar-info">
                        <div class="avatar-w"><img alt="" @if(!empty($global_user_data->profile_picture) && file_exists(public_path($global_user_data->profile_picture))) src="{{asset($global_user_data->profile_picture)}}" @else src="{{asset('img/default_image.png')}}" @endif style="width:45px; height:45px;"></div>
                        <div class="logged-user-info-w">
                            <div class="logged-user-name">
                                @if($global_user_data->userType=='user')
                                    <span class="">@if(!empty($global_user_data->username)) {{$global_user_data->username}} @endif</span>
                                @else
                                    <span class="text-capitalize">
                                    @if(!empty($global_user_data->first_name))
                                        {{$global_user_data->first_name}}
                                    @endif
                                    @if(!empty($global_user_data->first_name))
                                        {{$global_user_data->last_name}}
                                    @endif
                                    </span>
                                @endif
                            </div>
                            @if($global_user_data->userType=='admin')
                            <div class="logged-user-role text-capitalize text-center">
                                {{ $user = auth()->user()->userType }}
                            </div>
                            @elseif($global_user_data->userType=='tellers')
                            <div class="logged-user-role text-capitalize text-center">
                             
                            </div>
                             @elseif($global_user_data->userType=='staff')
                            <div class="logged-user-role text-capitalize text-center">
                                
                            </div>
                            @else
                            <div class="logged-user-role text-capitalize">
                                @if(!empty($global_user_data->package_type))
                                {{$global_user_data->package_type}} @endif Member
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="bg-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                    <ul>
                        @if($global_user_data->userType=='user')
                        <li><a @if($global_user_data->userType=='user') href="{{ route('member-profile') }}" @else href="#" @endif><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a></li>
                        @endif
                        <li><a href="{{ route('logout') }}"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--------------------END - User avatar and menu in secondary top menu-------------------->
    </div>
    <!-------------------- END - Top Menu Controls -------------------->
</div>
<!-------------------- END - Top Bar -------------------->
