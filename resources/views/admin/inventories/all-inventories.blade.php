@extends('layouts.default.admin.master')
@section('title', 'Inventories')
@section('page-title', '')

@section('stylesheets')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
    <style>
        .border-red {
            border: 1px solid red !important;
        }

        #in {
            border: 2px solid #3498db;
        }

        #out {
            border: 2px solid #e74c3c;
        }

        .btn-primary:hover {
            background-color: #983fea !important;
            color: white !important;
        }

        .btn-danger:hover {
            background-color: #e74c3c !important;
            color: white !important;
        }
    </style>
@endsection

@section('content')

    <div class="content-body">
        <!-- start content- -->
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h3 class="text-center element-header">Branches</h3>
                            <ul class="nav nav-pills flex-column">
                                @if (!empty($branches))
                                    @foreach ($branches as $branch)
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('staff/all-inventories/' . $branch->id) ? 'active' : '' }}"
                                                href="{{ $branch->id }}">{{ $branch->name }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-10">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <h2 class="element-header text-center">
                                    @if (!empty($branch_name))
                                        {{ $branch_name->name }} Branch
                                    @endif
                                </h2>
                                <div class="table-responsive">
                                    <table id="inventories_table" width="100%"
                                        class="table table-striped table-lightfont">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Code</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>Date</th>
                                                <th>Actions</th>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Code</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @if (!empty($products))
                                                @foreach ($products as $product)
                                                    <tr class="text-capitalize">
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->code }}</td>
                                                        <td style="text-transform: capitalize;">
                                                            {{ $product->category_name }}</td>
                                                        <td>{{ $product->qty }}</td>
                                                        <td>{{ $product->created_at }}</td>
                                                        <td><button class="btn btn-primary btn-view"
                                                                data-id="{{ $product->id }}"
                                                                data-branch_id="{{ $product->branch_id }}">View</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        @include('admin.inventories.view_modal')
    </div>
    <!-- end content-i -->
@endsection

@section('scripts')
    {{-- additional scripts here --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script>
        $(document).ready(function() {
            $('#inventories_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            /*$('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: "yyyy-mm-dd",
                autoclose: true
            });*/

            $('body').on('click', '.btn-view', function() {
                var id = $(this).data('id');
                var branch_id = $(this).data('branch_id');
                $('#table-movements-in').dataTable().fnClearTable();
                $('#table-movements-in').dataTable().fnDestroy();
                $('#table-movements-out').dataTable().fnClearTable();
                $('#table-movements-out').dataTable().fnDestroy();
                $.ajax({
                    url: '../view-product/' + id,
                    type: 'GET',
                    beforeSend: function() {
                        $('.preloader').show();
                    },
                    success: function(data) {
                        var entry_type = '';
                        var branch_to = '';
                        $('.preloader').hide();
                        $('#view_name').html(data.name);
                        $('#search_id').val(id);
                        $('#search_branch_id').val(branch_id);
                        load_data(id, branch_id);
                        $('#view-modal').modal('show');
                    },
                    error: function(error) {
                        console.log('Error...');
                        console.log(error);
                        console.log(error.responseJSON.message);
                        $('.preloader').hide();
                        swal({
                            title: "Error!",
                            text: "Error message: " + error.responseJSON.message + "",
                            type: "error",
                        });
                    }
                });

            });

            function load_data(id, branch_id, from_date = '', to_date = '') {
                $('#table-movements-in').DataTable({
                    "ajax": {
                        url: "../view-product-movement/" + id + "/in",
                        type: "GET",
                        data: {
                            id: id,
                            branch_id: branch_id,
                            from_date: from_date,
                            to_date: to_date,
                        }
                    },
                    "columns": [{
                            "data": "quantity"
                        },
                        {
                            "data": "created_at"
                        }

                    ]
                });
                $('#table-movements-out').DataTable({
                    "ajax": {
                        url: "../view-product-movement/" + id + "/out",
                        type: "GET",
                        data: {
                            id: id,
                            branch_id: branch_id,
                            from_date: from_date,
                            to_date: to_date
                        }
                    },
                    "columns": [{
                            "data": "quantity"
                        },
                        {
                            "data": "created_at"
                        }

                    ]
                });

            }

            $('#filter').click(function() {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var id = $('#search_id').val();
                var branch_id = $('#search_branch_id').val();
                if (from_date != '' && to_date != '') {
                    $('#table-movements-in').dataTable().fnClearTable();
                    $('#table-movements-in').dataTable().fnDestroy();
                    $('#table-movements-out').dataTable().fnClearTable();
                    $('#table-movements-out').dataTable().fnDestroy();
                    load_data(id, branch_id, from_date, to_date);
                } else {
                    alert('Both Date is required');
                }
            });

            $('#refresh').click(function() {
                $('#from_date').val('');
                $('#to_date').val('');
                var id = $('#search_id').val();
                var branch_id = $('#search_branch_id').val();
                $('#table-movements-in').dataTable().fnClearTable();
                $('#table-movements-in').dataTable().fnDestroy();
                $('#table-movements-out').dataTable().fnClearTable();
                $('#table-movements-out').dataTable().fnDestroy();
                load_data(id, branch_id);
            });
        });
    </script>
@endsection
