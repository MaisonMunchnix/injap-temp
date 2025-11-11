<?php

namespace App;

use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model implements Buyable
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'category',
        'reward_points',
        'critical_level',
        'price',
        'cost_price',
        //'unilevel_price',
        'quantity',
        'image',
        'status'
    ];

    //protected $with = ['product_category'];

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'category');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category');
    }

    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    public function getBuyableDescription($options = null)
    {
        return $this->name;
    }

    public function getBuyablePrice($options = null)
    {
        return $this->price;
    }

    public function getRewardPointsPercentage($options = null)
    {
        return intval($this->reward_points * 100) . '%';
    }

    public function getBuyableWeight($options = null)
    {
        return 0;
    }

    public function getDiscountAttribute()
    {
        return Auth::check() && $this->category !== '1' ? Auth::user()->package->account_discount * 100 : 0;
    }

    public function inventory()
    {
        return $this->hasOne(ProductInventory::class);
    }

    public function transactions()
    {
        return $this->hasMany(ProductTransaction::class);
    }
}
