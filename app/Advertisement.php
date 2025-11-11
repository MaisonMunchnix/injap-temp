<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Advertisement extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($advertisement) {
            $advertisement->slug = Str::slug($advertisement->title);
        });

        static::updating(function ($advertisement) {
            $advertisement->slug = Str::slug($advertisement->title);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
