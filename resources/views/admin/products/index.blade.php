@extends('layouts.default.admin.master')
@section('title', 'Products')
@section('page-title', 'Products')

@section('stylesheets')
    {{-- additional style here --}}
    <!-- swal -->

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
            <div class="page-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Product management</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-center">Product Lists</h6>
                    <table id="products_table" width="100%" class="table table-striped table-lightfont">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Reward Points</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Reward Points</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @if (!empty($products))
                                @foreach ($products as $product)
                                    <tr class="text-capitalize">
                                        <td>{{ $product->name }}</td>
                                        <td data-toggle="tooltip" data-placement="top"
                                            title="{{ substr($product->description, 0, 70) }}...">
                                            {{ substr($product->description, 0, 20) }}...
                                        </td>
                                        <td style="text-transform: capitalize;">{{ $product->getRewardPointsPercentage() }}
                                        </td>
                                        <td>{{ $product->created_at }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Action </button>
                                                <div class="dropdown-menu">
                                                    <a href="#" class="dropdown-item btn-view"
                                                        data-id="{{ $product->id }}">View</a>
                                                    @if (empty($access_data))
                                                        <a href="#" class="dropdown-item btn-edit"
                                                            data-id="{{ $product->id }}">Edit</a>
                                                        <!--<a href="#" class="dropdown-item edit-discount-modal" data-id="{{ $product->id }}">Edit Discount</a>-->
                                                    @else
                                                        @if ($access_data[0]->product[0]->edit == 'true')
                                                            <a href="#" class="dropdown-item btn-edit"
                                                                data-id="{{ $product->id }}">Edit</a>
                                                            <!--<a href="#" class="dropdown-item edit-discount-modal" data-id="{{ $product->id }}">Edit Discount</a>-->
                                                        @else
                                                        @endif
                                                    @endif
                                                    @if (empty($access_data))
                                                        <a href="#" class="dropdown-item btn-delete"
                                                            data-id="{{ $product->id }}">Delete</a>
                                                    @else
                                                        @if ($access_data[0]->product[0]->delete == 'true')
                                                            <a href="#" class="dropdown-item btn-delete"
                                                                data-id="{{ $product->id }}">Delete</a>
                                                        @else
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @include('admin.products.add_modal')
            @include('admin.products.view_modal')
            @include('admin.products.edit_modal')
            @include('admin.products.edit-discount-modal')
            @include('admin.products.delete_modal')
        </div>
    </div>

    <!-- end content-i -->
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/products.js') }}"></script>
@endsection
