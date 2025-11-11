<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    const NOT_PAID = 0;
    const PAID = 1;
    const REFUNDED = 2;
    const ERROR = 0;
    const PROCESSED = 1;
    const DECLINED = 2;

    protected $guarded = [];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function setAmountAttribute($value)
    {
        return $this->attributes['amount'] = number_format($value, 2, '.', '');
    }

    public function setShippingAttribute($value)
    {
        return $this->attributes['shipping'] = number_format($value, 2, '.', '');
    }

    public function setFeesAttribute($value)
    {
        return $this->attributes['fees'] = number_format($value, 2, '.', '');
    }
}
