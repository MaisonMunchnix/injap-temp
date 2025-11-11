<?php

namespace App\Billing;

use App\Encashment;
use App\Payment;
use App\Referral;
use App\IncomeTransfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EWalletPaymentGateway implements PaymentGateway
{
    public function charge($amount, $shipping)
    {
        $subtotal = $amount + $shipping;
        $fees = 0;
        $total_amount = $subtotal;
        if(!Auth::check()){
            return [
                'amount' => $total_amount,
                'confirmation_number' => "REF-" . strtotime(now()),
                'currency' => 'php',
                'shipping' => $shipping,
                'fees' => $fees,
                'driver' => (new \ReflectionClass($this))->getShortName(),
                'status' => 0,
                'is_paid' => 0,
                'error' => 'Not Authorize to use this payment method'
            ];
        }
        $user_id = Auth::id();

        $get_total_earnings=Referral::select('amount')->where('user_id',$user_id)->sum('amount');
        $get_total_encashment=Encashment::select('amount_approved')->where('user_id', $user_id)->where('status','claimed')->sum('amount_approved');
        $get_total_purchase=Auth::user()->getEWalletPurchases();
         // Total transfer
         $transfer = IncomeTransfer::where(function ($query) use ($user_id) {
            $query->where('from_user_id', $user_id)
                ->orWhere('to_user_id', $user_id);
        })->where('status', 1)->get();
    
        // Calculate total sent and received amounts
        $total_sent = $transfer->where('from_user_id', $user_id)->sum('amount');
        $total_received = $transfer->where('to_user_id', $user_id)->sum('new_amount');

        $available_balance = ($get_total_earnings + $total_received) - ($get_total_encashment + $get_total_purchase + $total_sent);

        if($available_balance < $total_amount) {
            return [
                'amount' => $total_amount,
                'confirmation_number' => "REF-" . strtotime(now()),
                'currency' => 'php',
                'shipping' => $shipping,
                'fees' => $fees,
                'driver' => (new \ReflectionClass($this))->getShortName(),
                'status' => 0,
                'is_paid' => 0,
                'error' => 'Not enough balance available on your e-wallet to complete this purchase'
            ];
        }

        return [
            'amount' => $total_amount,
            'confirmation_number' => "REF-" . strtotime(now()),
            'currency' => 'php',
            'shipping' => $shipping,
            'fees' => $fees,
            'driver' => (new \ReflectionClass($this))->getShortName(),
            'status' => 1,
            'is_paid' => 1,
            'error' => null
        ];
    }
}