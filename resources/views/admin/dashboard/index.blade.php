@extends('layouts.default.admin.master')
@section('title', 'Home')
@section('page-title', 'Home')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    <div class="content-body">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-md-4">
                            <div class="card shadow-none border mb-0">
                                <div class="card-header">
                                    MEMBERS
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Members verification and Modification</h5>
                                    <a href="{{ route('members-today') }}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-none border mb-0">
                                <div class="card-header">
                                    ENCASHMENTS
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Users Encashments</h5>
                                    <a href="{{ route('encashment-view', 'all') }}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-none border mb-0">
                                <div class="card-header">
                                    <form action="" method="post" id="filter-form" class="pull-right">
                                        <div class="input-group">
                                            <select name="type" class="form-control" required>
                                                <option value="" selected disabled>Selet Type</option>
                                                <option value="pair">Pair</option>
                                                <option value="entry">Entry</option>
                                            </select>
                                            <input type="date" class="form-control" name="date_from"
                                                placeholder="Date From" required>
                                            <input type="date" class="form-control" name="date_to" placeholder="Date To"
                                                required>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"
                                                    id="btn-filter">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <h1 class="text-center mb-4" id="count-text">{{ $pairs }} Pair</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow-none border mb-0">
                                <div class="card-header">
                                    PRODUCTCODES
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Users Product Codes</h5>

                                    <a href="{{ route('product-codes', 'members') }}" class="btn btn-primary">View
                                        Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-none border mb-0">
                                <div class="card-header">
                                    RECOGNITION
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Sales Recognition and Performance Monitoring</h5>

                                    <a href="{{ route('top-earners') }}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-4">
                            <div class="card shadow-none border mb-0">
                                <div class="card-header">
                                    YEN
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.currency-update') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Buy</label>
                                                    <input type="hidden" name="currency" value="yen" required>
                                                    <input type="number" name='buy' step="0.01" class="form-control"
                                                        placeholder="Buy" value="{{ $yen->buy ?? null }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Sell</label>
                                                    <input type="number" name='sell' step="0.01" class="form-control"
                                                        placeholder="Sell" value="{{ $yen->sell ?? null }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary pull-right">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-none border mb-0">
                                <div class="card-header">
                                    HKG
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.currency-update') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Buy</label>
                                                    <input type="hidden" name="currency" value="hkd" required>
                                                    <input type="number" name='buy' step="0.01"
                                                        class="form-control" placeholder="Buy"
                                                        value="{{ $hkd->buy ?? null }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Sell</label>
                                                    <input type="number" name='sell' step="0.01"
                                                        class="form-control" placeholder="Sell"
                                                        value="{{ $hkd->sell ?? null }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary pull-right">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-none border mb-0">
                                <div class="card-header">
                                    USD
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.currency-update') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Buy</label>
                                                    <input type="hidden" name="currency" value="usd" required>
                                                    <input type="number" name='buy' step="0.01"
                                                        class="form-control" placeholder="Buy"
                                                        value="{{ $usd->buy ?? null }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Sell</label>
                                                    <input type="number" name='sell' step="0.01"
                                                        class="form-control" placeholder="Sell"
                                                        value="{{ $usd->sell ?? null }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary pull-right">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script>
        var token = "{{ csrf_token() }}";
        $('body').on('submit', '#filter-form', function(e) {
            e.preventDefault();
            var form_data = new FormData(this);
            form_data.append('_token', token);
            $.ajax({
                url: "{{ route('admin.filter-count') }}",
                type: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.preloader').show();
                },
                success: function(response) {
                    $('.preloader').hide();
                    $('#count-text').text(response.count);
                },
                error: function(error) {
                    $('.preloader').hide();;
                    swal({
                        title: "Warning!",
                        text: "Error Please try again!",
                        type: "warning",
                    });
                }
            });
        });
    </script>
@endsection
