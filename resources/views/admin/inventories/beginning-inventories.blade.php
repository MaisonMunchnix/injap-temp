@extends('layouts.default.admin.master')
@section('title','Beginning Inventories')
@section('page-title','')

@section('stylesheets')
<style>
    .border-red {
        border: 1px solid red !important;
    }

</style>
@endsection

@section('content')

<div class="content-body">
    <!-- start content- -->
    <div class="content">
        <div class="card">
            <div class="card-body">
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <h6 class="element-header text-center">Beginning Inventories</h6><br>
                <div class="table-responsive">
                    <table id="inventories_table" width="100%" class="table table-striped table-lightfont">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Date</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Date</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @if(!empty($products))
                            @foreach($products as $product)
                            <tr class="text-capitalize">
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->code }}</td>
                                <td data-toggle="tooltip" data-placement="top" title="{{ substr($product->description, 0, 70) }}...">{{ substr($product->description, 0, 20) }}...</td>
                                <td style="text-transform: capitalize;">{{ $product->category_name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->created_at }}</td>
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
<!-- end content-i -->
@endsection

@section('scripts')
{{-- additional scripts here --}}
<!-- Sweetalert -->


<script>
    $('#inventories_table').DataTable({
        dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
    });

</script>
@endsection
