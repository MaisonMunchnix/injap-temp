<?php

namespace App;

use Gloudemans\Shoppingcart\Contracts\InstanceIdentifier;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements InstanceIdentifier
{
    use Notifiable;

    protected $with = ['info'];

	public function package() {
        return $this->belongsTo(Package::class, 'account_type');
    }

    public function info() {
        return $this->hasOne(UserInfo::class);
    }

    public function network() {
        return $this->hasOne(Network::class);
    }

    public function sales() {
	    return $this->hasMany(Sale::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'username',
        'email',
        'password',
        'plain_password',
        'status',
        'userType',
        'account_type',
        'account_extension',
        'account_status',
        'member_type',
        'sub_package'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'plain_password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	/**
     * Get the unique identifier to load the Cart from
     *
     * @return int|string
     */
    public function getInstanceIdentifier($options = null)
    {
        return $this->email;
    }

    /**
     * Get the unique identifier to load the Cart from.
     *
     * @return int|string
     */
    public function getInstanceGlobalDiscount($options = null)
    {
        return $this->package->account_discount ?? 0 * 100;
    }

    public function getEWalletPurchases()
    {
        return $this->sales()->get()
        ->filter(function($sale){
            return $sale->payment()
                ->where('driver', 'EWalletPaymentGateway')
                ->where('is_paid', 1)
                ->where('status', 1)
                ->first();
        })->map(function($sale){
            return $sale->payment->amount;
        })->sum();
    }

    public static function getSalesCommission($affiliate_link_used)
    {
        if(Auth::check() && Auth::user()->affiliate_link === $affiliate_link_used) return null;

        return self::where('affiliate_link', $affiliate_link_used)->first()->package->account_discount;
    }
}
