<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailedProduct extends Model
{
    protected $table = 'availed_products';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
        'attachment',
    ];

    /**
     * Relationship: AvailedProduct belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: AvailedProduct belongs to NewProduct
     */
    public function product()
    {
        return $this->belongsTo(NewProduct::class, 'product_id');
    }
}
