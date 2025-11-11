@extends('layouts.user.master')
@section('title', 'Refund Transaction')
@section('page-title', 'Refund Transaction')
@section('content')
    <div class="content-i" style="min-height:100vh">
        <!-- start content- -->
        <div class="content-box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">
                        <h6 class="element-header">@yield('title')</h6>
                        <br><br>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="element-wrapper">
                                <div class="element-box">
                                    <div class="table-responsive">
                                        <table id="override-sales" width="100%"
                                            class="table table-striped table-lightfont">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Order #</th>
                                                    <th>Transaction #</th>
                                                    <th>Member</th>
                                                    <th>Total</th>
                                                    <th>Paid</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Order #</th>
                                                    <th>Transaction #</th>
                                                    <th>Member</th>
                                                    <th>Total</th>
                                                    <th>Paid</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td>{{ $order->created_at->format('m/d/Y g:i a') }}</td>
                                                        <td>{{ $order->id }}</td>
                                                        <td>{{ $order->payment->confirmation_number }}</td>
                                                        <td>{{ $order->getMember() }}</td>
                                                        <td>P{{ $order->total }}</td>
                                                        <td>{{ $order->getPaymentStatus() }}</td>
                                                        <td>{{ $order->getStatusDetails() }}</td>
                                                        <td>
                                                            @if ($order->payment->is_paid == 1)
                                                                <a href="{{ route('order.override-sale', $order->id) }}"
                                                                    class="btn btn-primary refund-order" type="button">
                                                                    Refund</a>
                                                            @elseif($order->payment->is_paid == 2)
                                                                <button class="btn btn-primary" type="button" disabled>
                                                                    Refunded</button>
                                                            @else
                                                                <button class="btn btn-primary" type="button" disabled>
                                                                    Unpaid</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script>
        var token = "{{ csrf_token() }}";
        $('#override-sales').DataTable({
            aaSorting: [
                [0, 'desc']
            ]
        });
        $('.refund-order').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            swal({
                title: "Refunding!",
                text: 'Enter override password',
                content: {
                    element: "input",
                    attributes: {
                        type: "text",
                        style: "-webkit-text-security: disc;"
                    },
                },
                buttons: {
                    cancel: true,
                    confirm: "Confirm"
                }
            }).then(function(value) {
                if (value) {
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: {
                            "_token": token,
                            'override_password': value
                        },
                        beforeSend: function() {
                            $('.send-loading').show();
                        },
                        success: function(data) {
                            $('.send-loading').hide();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                icon: "success",
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(error) {
                            $('.send-loading').hide();
                            swal({
                                title: 'Error!',
                                text: error.responseJSON.message,
                                icon: "error",
                            });
                        }
                    });
                }
            });
        });
    </script>

@endsection
