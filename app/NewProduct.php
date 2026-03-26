<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewProduct extends Model
{
    use HasFactory;

    protected $table = 'new_products';

    protected $fillable = [
        'user_id',
        'product_name',
        'picture',
        'price',
        'description',
        'country',
        'address',
        'contact_number',
        'status',
        'submitted_at',
    ];

    protected $dates = ['submitted_at'];

    /**
     * Relationship: Product belongs to a User (submitter)
     */
    public function submitter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
