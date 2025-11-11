@extends('layouts.default.master')
@section('title', 'Products')
@section('page-title', 'Products')

@section('stylesheets')
    {{-- additional style here --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .border-red {
            border: 1px solid red !important;
        }

        .select2-selection {
            height: 35px !important;
        }

        .card .bg-info-gradient {
            min-height: 146px !important;
        }

        @media only screen and (max-width: 767px) {
            .input-group {
                margin-bottom: 20px;
            }
        }
    </style>
@endsection

@section('content')
    {{-- content here --}}

    <div class="content-body">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Income Overview</h6>
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="card bg-success-gradient">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="card-title">Balance</h6>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h2 class="font-weight-bold" id="total-income">0</h2>
                                        <div class="avatar border-0">
                                            <span class="avatar-title rounded-circle bg-success">
                                                <i class="ti-arrow-top-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>{{ $products->count() }} Products found</h3>
                    <!-- content -->
                    <div class="col-lg-12">
                        <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">

                            {{-- <div class="ms-auto">
                                <select class="form-select d-inline-block w-auto border pt-1">
                                    <option value="0">Best match</option>
                                    <option value="1">Recommended</option>
                                    <option value="2">High rated</option>
                                    <option value="3">Randomly</option>
                                </select>
                                <div class="btn-group shadow-0 border">
                                    <a href="#" class="btn btn-light" title="List view">
                                        <i class="fa fa-bars fa-lg"></i>
                                    </a>
                                    <a href="#" class="btn btn-light active" title="Grid view">
                                        <i class="fa fa-th fa-lg"></i>
                                    </a>
                                </div>
                            </div> --}}
                        </header>
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-lg-3 col-md-6 col-sm-6 d-flex">
                                    <div class="card w-100 my-2 shadow-2-strong">
                                        <img src="{{ asset($product->image) }}" class="card-img-top" />
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex flex-row">
                                                <h4 class="mb-1 me-1">{{ $product->name }}</h4>
                                            </div>
                                            <div class="d-flex flex-row">
                                                <h5 class="mb-1 me-1">&#8369;{{ $product->price }}</h5>
                                                {{-- <span class="text-danger"><s>$49.99</s></span> --}}
                                            </div>
                                            <p class="card-text">{{ $product->description }}</p>
                                            <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                                <form class="add_to_cart_details"
                                                    action="{{ route('products.cart.add', $product->id) }}" method="POST">
                                                    @csrf
                                                    <div class="input-group mb-3">
                                                        <input min="1" max="100" value="1" type="number"
                                                            class="form-control" name="qty">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-primary shadow-0 me-1">add
                                                                to
                                                                cart</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <hr class="mt-3">
                        {{ $products->onEachSide(5)->links() }}
                    </div>

                </div>

            </div>
        </div>

    @endsection

    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            var get_total_income_route = "{{ route('user.get-total-income') }}";
        </script>
        <script src="{{ asset('js/user/cart.js') }}"></script>
        <script>
            getTotalIncome();

            function getTotalIncome() {
                $.ajax({
                    url: get_total_income_route,
                    type: 'GET',
                    success: function(response) {
                        $('#total-income').text(addComma(response.total_income ?? 0) + " PHP");
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            function addComma(numStr) {
                numStr += '';
                var x = numStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }
        </script>

    @endsection
