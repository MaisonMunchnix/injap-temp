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
     * Get conversations where user is the admin
     */
    public function administratedConversations()
    {
        return $this->hasMany(Conversation::class, 'admin_id');
    }

    /**
     * Get conversations where user is the member
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'member_id');
    }

    /**
     * Get sent messages
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get received messages
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    /**
     * Get unread message count
     */
    public function unreadMessageCount()
    {
        return $this->receivedMessages()
            ->where('is_read', false)
            ->count();
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
        'admin_scope',
        'can_manage_instructors',
        'account_type',
        'account_extension',
        'account_status',
        'member_type',
        'sub_package',
        'is_application_approved',
        'affiliate_link',
        'sponsor_id'
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
        'can_manage_instructors' => 'boolean',
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

    public static function getSalesCommission($affiliate_link_or_sponsor_id)
    {
        if(Auth::check() && Auth::user()->sponsor_id === $affiliate_link_or_sponsor_id) return null;

        // Try to find by sponsor_id first (new system)
        $user = self::where('sponsor_id', $affiliate_link_or_sponsor_id)->first();
        
        // Fallback to affiliate_link for backward compatibility
        if (!$user) {
            $user = self::where('affiliate_link', $affiliate_link_or_sponsor_id)->first();
        }
        
        if (!$user) {
            return 0;
        }
        
        return $user->package->account_discount ?? 0;
    }
}
