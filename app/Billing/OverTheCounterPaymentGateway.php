<?php

namespace App\Billing;

use Illuminate\Support\Str;

class OverTheCounterPaymentGateway implements PaymentGateway
{
    public function charge($amount, $shipping)
    {
        $subtotal = $amount + $shipping;
        $fees = 0;
        $total_amount = $subtotal - $fees;
        return [
            'amount' => $total_amount,
            'confirmation_number' => "REF-" . strtotime(now()),
            'currency' => 'php',
            'shipping' => $shipping,
            'fees' => $fees,
            'driver' => (new \ReflectionClass($this))->getShortName(),
            'status' => 1,
            'is_paid' => 0,
            'error' => null
        ];
    }
}