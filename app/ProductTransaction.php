<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    protected $fillable = [
        'product_id',
        'branch_to',
        'transaction_id',
        'admin_id',
        'entry_type',
        'quantity',
        'user_id',
        'branch_from'
    ];
}
