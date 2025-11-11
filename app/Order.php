<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Order extends Pivot
{
    public $incrementing = true;

    public function setPriceAttribute($value)
    {
        return $this->attributes['price'] = number_format($value, 2, '.', '');
    }

    public function setDiscountAttribute($value)
    {
        return $this->attributes['discount'] = number_format($value, 2, '.', '');
    }

    public function setCommissionAttribute($value)
    {

        return $this->attributes['commission'] = $value ? number_format($value, 2, '.', ''):null;
    }
}
