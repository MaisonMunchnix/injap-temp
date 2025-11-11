@extends('layouts.user.master')
@section('title', 'Income Listing')
@section('page-title', 'Income Listing')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    {{-- content here --}}
    <div class="content-i">
        <div class="content-box">
            <div class="element-wrapper">
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <div class="element-box">
                    <h5 class="form-header text-center">Income Listing</h5>
                    <div class="form-desc text-center">Unilevel Sales</div>

                    <div class="table-responsive">
                        <table id="income_table" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>

                                    <th>Trans Date</th>
                                    <th>Product Name</th>
                                    <th>Source</th>
                                    <th>quantity</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>

                                    <th>Trans Date</th>
                                    <th>Product Name</th>
                                    <th>Source</th>
                                    <th>quantity</th>
                                    <th>Value</th>
                                </tr>
                            </tfoot>
                            <tbody>

                                @foreach ($unilevel_sales as $unilevel_sales)
                                    <tr>
                                        <td>{{ $unilevel_sales->created_at }}</td>
                                        <td>{{ $unilevel_sales->name }}</td>
                                        <td>{{ $unilevel_sales->username }}</td>
                                        <td>{{ $unilevel_sales->quantity }}</td>
                                        <td class="numbers">{{ $unilevel_sales->total_price }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <br />
                    <h5 class="form-header text-right">Total: <span class=" text-danger">P @if (!empty($groupSales))
                                <span class="numbers">{{ $groupSales }}</span>
                            @else
                                0
                            @endif
                        </span></h5>
                </div>
            </div>
            @include('user.customizer')
        </div>
    </div>

@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script>
        $('#income_table').dataTable();
        $(document).ready(function() {
            $('#income_table_wrapper').removeClass('form-inline');
            $(".numbers").each(function() {
                var new_txt = $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $(this).text(new_txt)
            });
        });
    </script>
@endsection
