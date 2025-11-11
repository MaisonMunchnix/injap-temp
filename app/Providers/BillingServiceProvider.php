<?php

namespace App\Providers;

use App\Billing\BankTransferPaymentGateway;
use App\Billing\EWalletPaymentGateway;
use App\Billing\OverTheCounterPaymentGateway;
use App\Billing\PaymentGateway;
use App\Billing\PaynamicsPaymentGateway;
use App\Billing\PaypalPaymentGateway;
use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PaymentGateway::class, function($app) {
            switch(request()->input('checkout_method')){
                case 'over-the-counter':
                    return new OverTheCounterPaymentGateway();
                case 'bank-transfer':
                    return new BankTransferPaymentGateway();
                case 'paypal':
                    return new PaypalPaymentGateway();
                case 'e-wallet':
                    return new EWalletPaymentGateway();
                case 'paynamics':
                    return new PaynamicsPaymentGateway();
            }

        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
