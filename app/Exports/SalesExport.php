<?php

namespace App\Exports;

use App\Sale;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sale::where('branch_id', Auth::user()->branch_id)->get();
    }

    public function map($sale): array
    {
        return [
            sprintf('%06d', $sale->id),
            $sale->getInvoiceName(),
            $sale->getUsername(),
            $sale->getEmail(),
            $sale->subtotal,
            $sale->shipping,
            $sale->fees,
            $sale->discount,
            $sale->total,
            $sale->note,
            $sale->created_at,
            $sale->payment->confirmation_number,
            $sale->payment->driver,
            $sale->getPaymentStatus(),
            $sale->getGatewayStatus(),
            $sale->payment->error,
            $sale->getShippingDetails()
        ];
    }

    public function headings(): array
    {
        return [
            'Invoice #',
            'Name',
            'Username',
            'Email',
            'Sub Total',
            'Shipping',
            'Fees',
            'Discount',
            'Total',
            'Note',
            'Transaction Date',
            'Transaction Number',
            'Transaction Gateway',
            'Transaction Paid',
            'Transaction Gateway Status',
            'Transaction Error Message',
            'Shipping to another address'
        ];
    }
}
