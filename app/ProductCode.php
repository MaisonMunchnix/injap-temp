<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCode extends Model
{
    protected $fillable = [
        'user_id',
        'status',
    ];
    
    public function package()
    {
        return $this->belongsTo(Package::class, 'category', 'id');
    }
}
