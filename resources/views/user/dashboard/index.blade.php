@extends('layouts.default.master')
@section('title','Home')
@section('page-title','Home')

@section('stylesheets')
{{-- additional style here --}}
@endsection

@section('content')
<div class="content-body">
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="">My Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Registered Date</th>
                                <th scope="col">Sponsor</th>
                                <th scope="col">Placement</th>
                                <th scope="col">Position</th>
                                <th scope="col">Account Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="user_reg_date">User data</td>
                                <td id="user_sponsor">User data</td>
                                <td id="user_up_placement">User data</td>
                                <td id="user_position">User data</td>
                                <td>Active</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">My Network Bonus</h6>
                <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                        <a class="nav-link active" id="referral-bonus-tab" data-toggle="tab" href="#referral-bonus"
                            role="tab" aria-controls="referral-bonus" aria-selected="false">Referral Bonus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pairing-match-tab" data-toggle="tab" href="#pairing-match"
                            role="tab" aria-controls="pairing-match" aria-selected="false">Pairing Match Bonus</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="activation-cost-reward" data-toggle="tab" href="#pairing-reward"
                            role="tab" aria-controls="pairing-reward" aria-selected="false">Activation Cost Reward</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="income-stat-tab" data-toggle="tab" href="#income-stat" role="tab"
                            aria-controls="income-stat" aria-selected="false">Income Statistics</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-content">
                    <div class="tab-pane fade show active" id="referral-bonus" role="tabpanel"
                            aria-labelledby="referral-bonus-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{route('income-listing','direct-referral-bonus')}}">
                                        <!--  -->
                                        <div class="card text-white bg-primary">
                                            <div class="card-header">Total Referral Bonus</div>
                                            <div class="card-body">
                                                <h5 class="card-title"><span id="Total_Direct_Referral">0 PHP</span></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="pairing-match" role="tabpanel"
                            aria-labelledby="pairing-match-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-header">Total Weekly Pairing Bonus</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="Total_Weekly_Pairing_Bonus">0 PHP</span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{route('income-listing','sales-match-bonus')}}">
                                        <!--  -->
                                        <div class="card text-white bg-primary">
                                            <div class="card-header">Total Pairing Bonus</div>
                                            <div class="card-body">
                                                <h5 class="card-title"><span id="TPBunos">0 PHP</span></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Pairing Reward Points -->
                        <div class="tab-pane fade show " id="pairing-reward" role="tabpanel"
                            aria-labelledby="activation-cost-reward">
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="card text-white bg-primary">
                                        <div class="card-header">Total Weekly Activation Cost Reward</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="Total_Weekly_Pairing_Points">0
                                                    Points</span>
                                            </h5>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <a href="{{route('redeem.list')}}">

                                        <div class="card text-white bg-primary">
                                            <div class="card-header">Total Activation Cost Reward</div>
                                            <div class="card-body">
                                                <h5 class="card-title"><span id="TPRPoints">0 Points</span></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="Ayuda-Compensation-Bonus" role="tabpanel"
                            aria-labelledby="Ayuda-Compensation-Bonus-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{route('income-listing','Ayuda-Sales')}}">
                                        <div class="card text-white bg-primary">
                                            <div class="card-header">Total Ayuda Compensation Bonus</div>
                                            <div class="card-body">
                                                <h5 class="card-title"><span id="Total_Ayuda_Compensation_Bonus">0
                                                        PHP</span></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="income-stat" role="tabpanel" aria-labelledby="income-stat-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card text-white bg-primary">
                                        <div class="card-header">Total No. of Pairing Bonus</div>
                                        <div class="card-body">
                                            <h5 class="card-title"><span id="TPMatch">0</span></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{route('total-income')}}">
                                        <div class="card text-white bg-primary">
                                            <div class="card-header">Total Income</div>
                                            <div class="card-body">
                                                <h5 class="card-title"><span id="total_accumulated_income">0 PHP</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>
            </div>



            {{-- <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <div class="d-flex justify-content-between">
                    <h6 class="card-title">My Sponsor Downlines</h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="position">Position</label>
                    <select class="form-control" name="position" id="position">
                        <option value="" selected disabled>Select Position</option>
                        <option value="left">Left Position</option>
                        <option value="right">Right Position</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="table-responsive">
                    <table id="table_downline" class="table table-lg">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Sponsor</th>
                                <th>Placement</th>
                                <th>Date of reg</th>
                                <th>Account Type</th>
                                <th>Geneology</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
            <!-- begin::footer -->

            <!-- end::footer -->
        </div>


        <div class="card">
            <div class="card-body">
                <h6 class="card-title">My Network Downlines</h6>
                <div class="table-responsive">
                    <div id="search-field" style="display:none;">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="ml-1">Filter</label>
                                <select class="form-control" name="filter-position" id="filter-position">
                                    <option value="">Select position</option>
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="ml-1">Search</label>
                                <input type="text" class="form-control" placeholder="Search your network downline..."
                                    id="search_field">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="binary_table" width="100%" class="table table-striped table-lightfont border mt-3">
                            <thead>
                                <tr class="row_header">
                                    <!-- <th>Count</th> -->
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Package</th>
                                    <th>Reg Date</th>
                                    <th>Sponsor</th>
                                    <th>Placement</th>
                                    <th>Position</th>
                                    <th>Top Position</th>
                                </tr>
                            </thead>
                            <tbody id="binary_table_body">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="showmore-container" class="text-center" style="display:none">
                    <!-- <button class="btn btn-primary" id="load-more">Load more data</button> -->
                    <!-- <button class="btn btn-primary" id="load-all">Show all</button> -->
                </div>
                <div id="loading-container">
                    <h5 class="text-center">Loading data...</h5>
                </div>
            </div>
        </div>


    </div>
    @include('layouts.default.footer')
    @endsection
    @section('scripts')
    {{-- additional scripts here --}}
    <script src="{{asset('js/user/home.js')}}"></script>
    <script>
        var offset = 0;
        var cont_counter = 0; //continous counter
        var network_downline_data = [];
        var temp_data = [];
        $(document).ready(function () {
            loadMore(offset);

            $('#secret-table').DataTable();

            $('#load-more').click(function () {
                loadMore(offset);
            });
            $('#load-all').click(function () {
                //reset counter = 0
                cont_counter = 0;
                loadMore(0);
            });
            $('#search_field').on('keyup', function () {
                var value = $(this).val().toLowerCase().trim();
                var position_value = $('#filter-position').val().toLowerCase().trim();
                //live search
                if (position_value == '') {
                    $("#binary_table_body tr").each(function (index) {
                        if (index !== 0) {
                            $row = $(this);
                            $row.find("td").each(function () {
                                var id = $(this).text().toLowerCase().trim();
                                if (id.indexOf(value) < 0) {
                                    $row.hide();
                                } else {
                                    $row.show();
                                    return false;
                                }
                            });
                        }
                    });
                } else {
                    var table_name = '#binary_table_body .row_' + position_value;
                    $(table_name).each(function (index) {
                        if (index !== 0) {
                            $row = $(this);
                            $row.find("td").each(function () {
                                var id = $(this).text().toLowerCase().trim();
                                if (id.indexOf(value) < 0) {
                                    $row.hide();
                                } else {
                                    $row.show();
                                    return false;
                                }
                            });
                        }
                    });
                }
            });

            $('#filter-position').on('change', function () {
                var value = $(this).val().toLowerCase().trim();
                if (value != "" || value != null)
                    $("#binary_table_body tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
            });

        });

        function loadMore(count) {
            $.ajax({
                url: 'user/view-binary-list-data-top/' + count,
                type: 'GET',
                beforeSend: function () {
                    //console.log('Getting data...');
                    $('#loading-container').show();
                    $('#showmore-container').hide();
                },
                success: function (response) {
                    var counter = 0;
                    $.each(response.binary_left_data, function (i, value) {
                        counter++;
                        /* '<td>' + counter + '</td>' + */
                        $('#binary_table > tbody:last-child').append(
                            '<tr class="row_data text-capitalize row_' + value.position + '">' +
                            '<td>' + value.full_name + '</td>' +
                            '<td>' + value.user_name + '</td>' +
                            '<td>' + value.package + '</td>' +
                            '<td data-sort="' + value.reg_sort_format_date + '">' + value
                            .reg_date_time + '</td>' +
                            '<td>' + value.sponsor_username + '</td>' +
                            '<td>' + value.placement_username + '</td>' +
                            '<td class="position_class">' + value.position + '</td>' +
                            '<td>' + value.top_position + '</td>' +
                            '</tr>'
                        );
                    });

                    $.each(response.binary_right_data, function (i, value) {
                        counter++;
                        /* '<td>' + counter + '</td>' + */
                        $('#binary_table > tbody:last-child').append(
                            '<tr class="row_data text-capitalize row_' + value.position + '">' +
                            '<td>' + value.full_name + '</td>' +
                            '<td>' + value.user_name + '</td>' +
                            '<td>' + value.package + '</td>' +
                            '<td data-sort="' + value.reg_sort_format_date + '">' + value
                            .reg_date_time + '</td>' +
                            '<td>' + value.sponsor_username + '</td>' +
                            '<td>' + value.placement_username + '</td>' +
                            '<td class="position_class">' + value.position + '</td>' +
                            '<td>' + value.top_position + '</td>' +
                            '</tr>'
                        );
                    });

                    $('#binary_table').DataTable({
                        "order": [
                            [3, "desc"]
                        ]
                    });



                    offset = offset * 2;
                    if (offset === 0) {
                        offset = 30;
                    }

                    $('#showmore-container').show();
                    $('#loading-container').hide();

                    if (response.total.length == 0 || response.has_offset === false) {
                        $('#showmore-container').hide();
                        $('#loading-container').hide();
                    }
                },
                error: function (error) {
                    console.log('error...');
                    console.log(error);
                    $('#loading-container').hide();
                    $('#showmore-container').show();
                    swal({
                        title: "Warning",
                        text: "Something went wrong. Please try again later.",
                        type: "warning",
                    });
                }
            });
        }

        function loadMoreOld(count) {
            $.ajax({
                url: '/user/view-binary-list-data/' + count,
                type: 'GET',
                beforeSend: function () {
                    //console.log('Getting data...');
                    $('#loading-container').show();
                    $('#showmore-container').hide();
                },
                success: function (response) {
                    if (offset === 0)
                        var counter = 0;
                    else
                        var counter = parseInt($('#binary_table_body > tr:last-child td:nth-child(1)')
                        .text());
                    $.each(response.data, function (i, value) {
                        counter++;
                        /* '<td>' + counter + '</td>' + */
                        $('#binary_table > tbody:last-child').append(
                            '<tr class="row_data text-capitalize row_' + value.position + '">' +
                            '<td>' + value.full_name + '</td>' +
                            '<td>' + value.user_name + '</td>' +
                            '<td>' + value.package + '</td>' +
                            '<td data-sort="' + value.reg_sort_format_date + '">' + value
                            .reg_date_time + '</td>' +
                            '<td>' + value.sponsor_username + '</td>' +
                            '<td>' + value.placement_username + '</td>' +
                            '<td class="position_class">' + value.position + '</td>' +
                            '</tr>'
                        );
                    });

                    $('#binary_table').DataTable({
                        "order": [
                            [3, "desc"]
                        ]
                    });



                    offset = offset * 2;
                    if (offset === 0) {
                        offset = 30;
                    }

                    $('#showmore-container').show();
                    $('#loading-container').hide();

                    if (response.data.length == 0 || response.has_offset === false) {
                        $('#showmore-container').hide();
                        $('#loading-container').hide();
                    }
                },
                error: function (error) {
                    console.log('error...');
                    console.log(error);
                    $('#loading-container').hide();
                    $('#showmore-container').show();
                    swal({
                        title: "Warning",
                        text: "Something went wrong. Please try again later.",
                        type: "warning",
                    });
                }
            });
        }

    </script>
    @endsection
