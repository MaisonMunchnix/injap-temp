@extends('layouts.teller.master')
@section('title', 'Generate Product Code')


@section('stylesheets')

@endsection

@section('breadcrumbs')
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h3 class="page-title">@yield('title')</h3>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! url('teller-admin/') !!}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-standard"><i
                        class='feather icon-plus'></i> Generate New Product Code</button>
            </div>
        </div>
    </div>
@endsection

@section('contents')

    <div class="col-lg-12 card-body">
        <div class="row">
            <!--<div class="col-md-12">
       <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modal-standard">Generate New Product Code</button>
      </div>
            <div class="col-lg-12 card-body">
            </div>-->
            <div class="col-md-12">
                <p><strong class="headings-color">Product Codes Today ({{ date('F d, Y') }})</strong></p>
            </div>
            <!-- Button to Open the Modal -->

            <div class="col-md-12">
                @if (Session::has('successMsg'))
                    <div class="alert alert-success"> {{ Session::get('successMsg') }}</div>
                @endif
            </div>
            <div class="col-md-12">
                <form action="{{ route('print-codes') }}" method="post">
                    @csrf
                    <div class="table-responsive border-bottom">
                        <table class="table mb-0 thead-border-top-0" id="generated_codes_table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAl"> Select All</th>
                                    <th>Code</th>
                                    <th>Security Pin</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($product_codes as $product_code)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="checkbox[{{ $product_code->id }}]"
                                                value="{{ $product_code->id }}">
                                        </td>
                                        <td>{{ $product_code->code }}</td>
                                        <td>{{ $product_code->security_pin }}</td>
                                        <td style="text-transform: capitalize;">{{ $product_code->type }}</td>
                                        <td>{{ $product_code->status }}</td>
                                        <td>{{ $product_code->created_at }}</td>
                                        <td>
                                            <div class="dropdown ml-auto">
                                                <a href="#" data-toggle="dropdown" data-caret="false"
                                                    class="text-muted"><i class="material-icons">keyboard_arrow_down</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <!--<a class="dropdown-item" href="{{ route('landing.home') }}">Edit</a>-->
                                                    <!--<a class="dropdown-item" href="profile.html">Delete</a>-->
                                                    <a href="javascript:;" class="dropdown-item deleteRecord"
                                                        data-id="{{ $product_code->id }}"><i class="fa fa-trash"></i>
                                                        Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary" name="print"><i class="material-icons">print</i> Print
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')

    <script>
        $(document).ready(function() {
            $('#generated_codes_table').DataTable();
            $("#checkAl").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $(".deleteRecord").click(function() {
                var id = $(this).data("id");
                var token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: "generate_codes/" + id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function() {
                        console.log("it Works");
                    }
                });

            });
        });
    </script>
    <!-- The Modal -->
    <div id="modal-standard" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('insert-codes') }}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-standard-title">Generate Code/s</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> <!-- // END .modal-header -->
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="number_generate">Number to Generate:</label>
                            <input type="number" class="form-control" id="number_generate" placeholder="Enter Number"
                                name="number_generate" min="1" max="10000" autocomplete="off" autofocus required>
                        </div>
                    </div> <!-- // END .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="generate-code">Submit</button>
                    </div> <!-- // END .modal-footer -->
                </form>
            </div> <!-- // END .modal-content -->
        </div> <!-- // END .modal-dialog -->
    </div> <!-- // END .modal -->

    <!--Delete Modal-->
    <div id="deleteData" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" id="deleteForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-standard-title">Generate Code/s</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> <!-- // END .modal-header -->
                    <div class="modal-body">
                        @csrf
                        <p class="text-center">Are You Sure Want To Delete ?</p>
                    </div> <!-- // END .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" data-dismiss="modal"
                            onclick="formSubmit()">Delete</button>
                    </div> <!-- // END .modal-footer -->
                </form>
            </div> <!-- // END .modal-content -->
        </div> <!-- // END .modal-dialog -->
    </div> <!-- // END .modal -->
@endsection
