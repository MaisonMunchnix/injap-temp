@extends('layouts.user.master')
@section('title', 'Announcement')
@section('page-title', 'Income Listing')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    {{-- content here --}}
    <div class="content-i">
        <div class="content-box">
            <div class="app-email-w">
                <div class="app-email-i">
                    <div class="ae-list-w">
                        <div class="ael-head">
                            <div class="actions-left">
                                <select>
                                    <option>Sort by date</option>
                                </select>
                            </div>
                            <div class="actions-right"><a href="#"><i class="os-icon os-icon-ui-37"></i></a><a
                                    href="#"><i class="os-icon os-icon-grid-18"></i></a></div>
                        </div>
                        <div class="ae-list">
                            @if (!empty($announcements))
                                @foreach ($announcements as $key => $data)
                                    <div class="ae-item with-status ann-click status-green @if ($key == 0) active @endif"
                                        data-id="{{ $data->id }}">
                                        @if ($key == 0)
                                            <input type="hidden" id="key_zero" value="{{ $data->id }}">
                                        @endif
                                        <div class="aei-content">
                                            <div class="aei-timestamp">
                                                @php
                                                    $date_today = date('Y/m/d');
                                                    $date_annou = date('Y/m/d', strtotime($data->created_at));
                                                    $date1 = new DateTime($date_annou);
                                                    $date2 = new DateTime($date_today);
                                                    $diff = $date2->diff($date1);
                                                    $date_diff = $diff->d;
                                                @endphp
                                                @if ($date_diff > 1)
                                                    {{ $date_annou }}
                                                @elseif($date_diff == 1)
                                                    Yesterday
                                                @else
                                                    @php echo date("h:i a",strtotime($data->created_at)); @endphp
                                                @endif


                                            </div>
                                            <h6 class="aei-title">{{ $data->title }}</h6>
                                            <div class="aei-sub-title">{{ $data->subject }}</div>
                                            <div class="aei-text">
                                                @if (strlen($data->content) >= 70)
                                                    @php $new_content=substr($data->content, 0, 70); @endphp
                                                    {{ $new_content }}...
                                                @else
                                                    @php
                                                        $count_chr = strlen($data->content);
                                                        $missing_chr = 70 - $count_chr;
                                                        $add_sp = str_repeat('&nbsp;', 100);
                                                    @endphp
                                                    {{ $data->content }}
                                                    @php echo $add_sp @endphp
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @if (!empty($announcement_count))
                            @if ($announcement_count > 10)
                                <a class="ae-load-more" href="#" id="load_more_ann"><span>Load More
                                        Announcements</span></a>
                            @endif
                        @endif
                    </div>
                    <div class="ae-content-w">
                        <div class="ae-content">
                            <div class="aec-full-message-w show-pack">
                                <div class="more-messages" id="ann_subject">Subject data</div>
                                <div class="aec-full-message">
                                    <div class="message-head">
                                        <div class="user-w with-status status-green">
                                            <div class="user-avatar-w">
                                                <div class="user-avatar"><img alt=""
                                                        src="{{ asset('img/default_image.png') }}"></div>
                                            </div>
                                            <div class="user-name">
                                                <h6 class="user-title" id="user_created_by">Created data</h6>
                                                <div class="user-role">Purple Administrator<span></span></div>
                                            </div>
                                        </div>
                                        <div class="message-info">
                                            <span id="ann_date">Created data</span>
                                            <br>
                                            <span id="ann_time"></span>
                                        </div>
                                    </div>
                                    <div class="message-content">
                                        <div id="ann_content">Content Data</div>
                                        <div class="message-attachments">
                                            <div class="attachments-heading">Attachments</div>
                                            <div class="attachments-docs row">
                                                <!--<a href="{{ $data->source }}"><i class="os-icon os-icon-ui-51"></i><span></span></a>-->
                                                <!--<a href="#"><i class="os-icon os-icon-documents-07"></i><span>Image File</span></a></div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('user.customizer')
            </div>
        </div>
    @endsection

    @section('scripts')
        {{-- additional scripts here --}}
        <script src="{{ asset('js/user/announcement.js') }}"></script>
    @endsection
