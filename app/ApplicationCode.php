<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationCode extends Model
{
    protected $fillable = [
        'code',
        'is_used',
        'user_id'
    ];

    /**
     * Relationship to retrieve the user who used this code (if used).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
