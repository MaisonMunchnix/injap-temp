@extends('layouts.default.master')
@section('title','Binary List')
@section('page-title','Binary List ')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    {{-- content here --}}
    <div class="content-body">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">My Network Binary List</h6>
                    <div class="table-responsive">
                        <div id="search-field">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="ml-1">Search</label>
                                    <input type="text" class="form-control" placeholder="Search your network downline..." id="search_field">
                                </div>
                            </div>
                        </div>
                        <table id="binary_table" class="table table-striped table-lightfont border mt-3">
                            <thead>
                                <tr class="row_header">
                                    <th>Count</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Package</th>
                                    <th>Reg Date</th>
                                    <th>Sponsor</th>
                                    <th>Placement</th>
                                    <th>Position</th>
                                </tr>
                            </thead>
                            <tbody id="binary_table_body">
                                
                            </tbody>
                        </table>
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
            <!-- begin::footer -->
			@include('layouts.default.footer')
			<!-- end::footer -->
        </div>
    </div>


@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script>
        $(document).ready(function () {
            var offset = 0;
            var cont_counter = 0; //continous counter
            loadMoreBinary(offset);
            $('#load-more').click(function(){
                loadMoreBinary(offset);
            });
            $('#load-all').click(function(){
                //reset counter = 0
                cont_counter = 0;
                loadMoreBinary(0);
            });
            $('#search_field').on('keyup',function() {
                var value = $(this).val().toLowerCase().trim();
                var position_value = $('#filter-position').val().toLowerCase().trim();
                //live search
                if(position_value == ''){
                    $("#binary_table_body tr").each(function(index) {
                        if (index !== 0) {
                            $row = $(this);
                            $row.find("td").each(function(){
                                var id = $(this).text().toLowerCase().trim();
                                if (id.indexOf(value) < 0) {
                                    $row.hide();
                                }else {
                                    $row.show();
                                    return false;                           
                                }
                            });
                        }
                    });
                }else{
                    var table_name = '#binary_table_body .row_'+position_value;
                    $(table_name).each(function(index) {
                        if (index !== 0) {
                            $row = $(this);
                            $row.find("td").each(function(){
                                var id = $(this).text().toLowerCase().trim();
                                if (id.indexOf(value) < 0) {
                                    $row.hide();
                                }else {
                                    $row.show();
                                    return false;                           
                                }
                            });
                        }
                    });
                }
            });

            $('#filter-position').on('change',function() {
                var value = $(this).val().toLowerCase().trim();
                if(value != "" || value != null)
                $("#binary_table_body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            function loadMoreBinary(count) {
            $.ajax({
                url : '/user/view-binary-list-data/' + count,
                type: 'GET',
                beforeSend: function () {
                    //console.log('Getting data...');
                    $('#loading-container').show();
                    $('#showmore-container').hide();
                },
                success: function (response) {
                    if(offset === 0)
                        var counter = 0;
                    else
                        var counter = parseInt($('#binary_table_body > tr:last-child td:nth-child(1)').text());
                    $.each(response.data, function (i, value) {
                        counter++;
                        $('#binary_table > tbody:last-child').append(
                            '<tr class="row_data text-capitalize row_'+value.position+'">'+
                            '<td>'+counter+'</td>'+
                            '<td>'+value.full_name+'</td>'+
                            '<td>'+value.user_name+'</td>'+
                            '<td>'+value.package+'</td>'+
                            '<td>'+value.reg_date_time+'</td>'+
                            '<td>'+value.sponsor_username+'</td>'+
                            '<td>'+value.placement_username+'</td>'+
                            '<td class="position_class">'+value.position+'</td>'+
                            '</tr>'
                        );
                    });

                    offset = offset * 2;
                    if(offset === 0 ){
                        offset = 30;
                    }

                    $('#showmore-container').show();
                    $('#loading-container').hide();

                    if(response.data.length == 0 || response.has_offset === false){
                        $('#showmore-container').hide();
                        $('#loading-container').hide();
                    }
                    /* if(count == 0){
                        $('#binary_table > tbody').empty();
                    }
                    $.each(response.data, function (i, value) {
                        cont_counter++;
                        var level = null;
                        if(i == 0){
                            level = value.level;
                        }else{
                            var minus_key = i - 1;
                            if(value.level == response.data[minus_key].level){
                                level = null;
                            }else{
                                level = value.level;
                            }
                        }               
                        if(level == null){
                            $('#binary_table > tbody:last-child').append(
                                '<tr class="row_data text-capitalize">'+
                                    '<td>'+cont_counter+'</td>'+
                                    '<td>'+value.full_name+'</td>'+
                                    '<td>'+value.user_name+'</td>'+
                                    '<td>'+value.package+'</td>'+
                                    '<td>'+value.reg_date+'</td>'+
                                    '<td>'+value.sponsor+'</td>'+
                                    '<td>'+value.placement+'</td>'+
                                    '<td>'+value.position+'</td>'+
                                '</tr>'
                            );
                        }else{
                            $('#binary_table > tbody:last-child').append(
                                '<tr class="row_data">'+
                                    '<td colspan="8" class="text-center"><strong>'+ value.level +'</strong></td>'+
                                '</tr>'
                            );
                            $('#binary_table > tbody:last-child').append(
                                '<tr class="row_data text-capitalize">'+
                                    '<td>'+cont_counter+'</td>'+
                                    '<td>'+value.full_name+'</td>'+
                                    '<td>'+value.user_name+'</td>'+
                                    '<td>'+value.package+'</td>'+
                                    '<td>'+value.reg_date+'</td>'+
                                    '<td>'+value.sponsor+'</td>'+
                                    '<td>'+value.placement+'</td>'+
                                    '<td>'+value.position+'</td>'+
                                '</tr>'
                            );
                        }                                                      
                    });
                    if(count == 0){
                        $('#showmore-container').hide();
                        $('#loading-container').hide();
                    }else{
                        $('#showmore-container').show();
                        $('#loading-container').hide();
                    }
                    //hide
                    if(response.data.length == 0){
                        $('#showmore-container').hide();
                        $('#loading-container').hide();
                    }

                    offset = offset * 2;
                    if(count == 0 ){
                        offset = 16;
                    } */
                    
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

        });
        
    </script>
@endsection
