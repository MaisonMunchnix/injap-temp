<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function productCodes()
    {
        return $this->hasMany(ProductCode::class, 'category', 'id');
    }
}
