<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <style>
        .invoice-w {
            font-family: "Avenir Next W01", "Proxima Nova W01", "Rubik", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            position: relative;
            overflow: hidden;
        }

        .pt-5 {
            padding-top: 3rem !important;
        }

        .invoice-w:before {
            width: 140%;
            height: 450px;
            background-color: #faf9f3;
            position: absolute;
            top: -15%;
            left: -24%;
            -webkit-transform: rotate(-27deg);
            transform: rotate(-27deg);
            content: "";
            z-index: 1;
        }

        *,
        *::before,
        *::after {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .invoice-w .infos {
            position: relative;
            z-index: 2;
        }

        .w-50 {
            width: 50% !important;
        }

        .invoice-heading {
            margin-bottom: 4rem;
            margin-top: 7rem;
            position: relative;
            z-index: 2;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .invoice-body {
            position: relative;
            z-index: 2;
        }

        .invoice-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            margin-top: 6rem;
        }

        .invoice-w .infos .info-1 {
            font-size: 1.08rem;
        }

        .invoice-w .infos .info-1 .company-name {
            font-size: 2.25rem;
            margin-bottom: 0.5rem;
            margin-top: 10px;
        }

        .invoice-w .infos .info-1 .company-extra {
            font-size: .81rem;
            color: rgba(0, 0, 0, 0.4);
            margin-top: 1rem;
        }

        .invoice-w .infos .info-2 {
            padding-top: 140px;
            text-align: right;
        }

        .text-left {
            text-align: left !important;
        }

        .invoice-w .infos .info-2 .company-name {
            margin-bottom: 1rem;
            font-size: 1.26rem;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .invoice-w .infos .info-2 .company-address {
            color: rgba(0, 0, 0, 0.6);
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .invoice-heading h3 {
            margin-bottom: 0px;
        }

        h3 {
            font-size: 1.75rem;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-bottom: .5rem;
            font-family: "Avenir Next W01", "Proxima Nova W01", "Rubik", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-weight: 500;
            line-height: 1.2;
            color: #334152;
        }

        .invoice-body {
            font-size: 1.17rem;
        }

        .element-box .table:last-child,
        .invoice-w .table:last-child,
        .big-error-w .table:last-child {
            margin-bottom: 0;
        }

        table {
            border-collapse: collapse;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .invoice-table thead th {
            border-bottom: 2px solid #333;
        }

        .table tfoot th,
        .table thead th {
            font-size: .63rem;
            text-transform: uppercase;
            border-top: none;
        }

        .invoice-table tbody tr td {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table-sm th,
        .table-sm td {
            padding: .3rem;
        }

        .table th,
        .table td {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid rgba(83, 101, 140, 0.33);
        }

        .text-right {
            text-align: right !important;
        }

        .invoice-table tfoot tr td {
            border-top: 3px solid #333;
            font-size: 1.26rem;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table-sm th,
        .table-sm td {
            padding: .3rem;
        }
    </style>
</head>

<body>
    <div class="invoice-w" style="padding: 10px">
        <div class="infos">
            <div class="info-1">
                <div class="invoice-logo-w"><img alt="" src="{{ asset('images/logo.png') }}"></div>
                <div class="company-name">{{ env('APP_NAME') }}</div>
            </div>
        </div>
        <div class="infos w-50">
            <div class="info-2 pt-5 text-left">
                <div class="company-name mb-0">{{ $sale->getInvoiceName() }} @if ($sale->getUsername())
                        - {{ $sale->getUsername() }}
                    @endif
                </div>
                <div class="company-address">{{ $sale->getInvoiceAddress() }}</div>
            </div>
        </div>
        <div class="invoice-heading mt-5 mb-3">
            <h3>{{ $sale->getInvoiceNumber() }}</h3>
            <div class="invoice-date">{{ $sale->created_at->format('j F Y') }}</div>
        </div>
        <div class="invoice-body">
            <div class="invoice-table">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th class="text-left">Description</th>
                            <th class="text-left">Unit Price</th>
                            <th class="text-left">Qty</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->products as $order)
                            <tr>
                                <td>{{ $order->name }}</td>
                                <td>P{{ $order->pivot->price + $order->pivot->discount }}</td>
                                <td>{{ $order->pivot->quantity }}</td>
                                <td class="text-right">
                                    P{{ number_format($order->pivot->price * $order->pivot->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @if ($sale->shipping > 0)
                            <tr>
                                <td class="border-top-0" style="font-size: 1rem">Shipping Fee</td>
                                <td class="border-top-0 text-right" style="font-size: 0.8rem" colspan="4">+
                                    P{{ $sale->shipping }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>Total</td>
                            <td class="text-right" colspan="4">P{{ number_format($sale->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
        <div class="invoice-footer">
            <div>{{ env('APP_NAME') }}</div>
        </div>
    </div>
</body>

</html>
