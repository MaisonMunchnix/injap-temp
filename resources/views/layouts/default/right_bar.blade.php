<div class="sidebar-group">
    <!-- BEGIN: User Menu -->
    <div class="sidebar" id="user-menu">
        <div class="py-4 text-center" data-backround-image="{{asset('dashboard/assets/media/image/image1.jpg')}}">
            <figure class="avatar avatar-lg mb-3 border-0">
                <img @if(!empty($global_user_data->profile_picture)) src="{{asset($global_user_data->profile_picture)}}" @else src="{{asset('images/users/default_image.png')}}" @endif class="rounded-circle" alt="image">
            </figure>
            <div>
                <strong class="text-capitalize">
                @if(!empty($global_user_data->username)) {{$global_user_data->username}} @endif
                </strong><br>
                @if(!empty($global_package_type)) {{$global_package_type}} @endif
            </div>
        </div>
        <div class="card mb-0 card-body shadow-none">
            <div class="mb-4">
                <div class="list-group list-group-flush">
                    <a href="{{route('member-profile')}}" class="list-group-item p-l-r-0">Profile</a>
                    <a href="{{route('logout')}}" class="list-group-item p-l-r-0 text-danger">Sign Out</a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: User Menu -->
</div>
