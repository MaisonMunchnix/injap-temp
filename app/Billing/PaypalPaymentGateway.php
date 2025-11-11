<?php

namespace App\Billing;

use Illuminate\Support\Str;

class PaypalPaymentGateway implements PaymentGateway
{
    public function charge($amount, $shipping)
    {
        // Charge Paypal

        $subtotal = $amount + $shipping;
        $fees = 0; //TODO set when payment gateway is already available
        $total_amount = $subtotal - $fees;
        return [
            'amount' => $total_amount,
            'confirmation_number' => "REF-" . strtotime(now()), //TODO replace with real confirmation number
            'currency' => 'php',
            'shipping' => $shipping,
            'fees' => $fees,
            'driver' => (new \ReflectionClass($this))->getShortName(),
            'status' => 0,
            'is_paid' => 0,
            'error' => 'Credit card is declined'
        ];
    }
}