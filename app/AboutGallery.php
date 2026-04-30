<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutGallery extends Model
{
    protected $fillable = [
        'image_path',
        'description',
        'is_active',
        'sort_order',
    ];
}
