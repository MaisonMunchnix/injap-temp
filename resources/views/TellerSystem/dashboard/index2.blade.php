@extends('layouts.user.master')
@section('title', 'Teller Dashboard')
@section('page-title', 'Add Branch')

@section('stylesheets')
    {{-- additional style here --}}
    <style>
        .border-red {
            border: 1px solid red !important;
        }

        .first {
            width: 5% !important;
        }

        .others {
            width: 19% !important;
        }

        .content-i {
            height: 93vh !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-i">
        <!-- start content- -->
        <div class="content-box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">@yield('title')</h6>
                        <br><br>
                        <div class="col-sm-8 col-md-12 col-lg-12">
                            <div class="element-wrapper">
                                <div class="element-box">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="pipeline white lined-primary">
                                                <div class="pipeline-header">
                                                    <h5 class="pipeline-name">Process Orders</h5>
                                                    <div class="pipeline-settings os-dropdown-trigger">
                                                        <div class="os-dropdown">
                                                            <div class="icon-w"><i class="os-icon os-icon-ui-46"></i></div>
                                                            <ul>
                                                                <li><a href="#"><i
                                                                            class="os-icon os-icon-ui-49"></i><span>Edit
                                                                            Record</span></a></li>
                                                                <li><a href="#"><i
                                                                            class="os-icon os-icon-grid-10"></i><span>Duplicate
                                                                            Item</span></a></li>
                                                                <li><a href="#"><i
                                                                            class="os-icon os-icon-ui-15"></i><span>Remove
                                                                            Item</span></a></li>
                                                                <li><a href="#"><i
                                                                            class="os-icon os-icon-ui-44"></i><span>Archive
                                                                            Project</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pipeline-body">
                                                    <div class="pipeline-item">
                                                        <div class="pi-body">
                                                            <div class="pi-info">
                                                                <div class="pi-sub">
                                                                    <div class="pipeline-header-numbers">
                                                                        <!--<div class="pipeline-value"></div>-->
                                                                        <h2>{{ $orders_count }}</h2>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="pi-foot">
                                                            <div class="tags"><a class="tag"
                                                                    href="{{ route('order.process-order') }}">View
                                                                    Details</a></div>
                                                            <a class="extra-info" href="#"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-------------------- END - Pipeline -------------------->
                                        </div>
                                        <div class="col-md-3">
                                            <div class="pipeline white lined-primary">
                                                <div class="pipeline-header">
                                                    <h5 class="pipeline-name">Record Sales</h5>
                                                    <div class="pipeline-settings os-dropdown-trigger">
                                                        <div class="os-dropdown">
                                                            <div class="icon-w"><i class="os-icon os-icon-ui-46"></i></div>
                                                            <ul>
                                                                <li><a href="#"><i
                                                                            class="os-icon os-icon-ui-49"></i><span>Edit
                                                                            Record</span></a></li>
                                                                <li><a href="#"><i
                                                                            class="os-icon os-icon-grid-10"></i><span>Duplicate
                                                                            Item</span></a></li>
                                                                <li><a href="#"><i
                                                                            class="os-icon os-icon-ui-15"></i><span>Remove
                                                                            Item</span></a></li>
                                                                <li><a href="#"><i
                                                                            class="os-icon os-icon-ui-44"></i><span>Archive
                                                                            Project</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pipeline-body">
                                                    <div class="pipeline-item">
                                                        <div class="pi-body">
                                                            <div class="pi-info">
                                                                <div class="pi-sub">
                                                                    <div class="pipeline-header-numbers">
                                                                        <!--<div class="pipeline-value"></div>-->
                                                                        <h2>{{ $sales_count }}</h2>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="pi-foot">
                                                            <div class="tags"><a class="tag"
                                                                    href="{{ route('order.record-sales') }}">View
                                                                    Details</a></div>
                                                            <a class="extra-info" href="#"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-------------------- END - Pipeline -------------------->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end content-i -->
    @endsection

    @section('scripts')
        <script>
            var token = "{{ csrf_token() }}";
            //console.log('TOKEN:' + token);
        </script>
    @endsection
