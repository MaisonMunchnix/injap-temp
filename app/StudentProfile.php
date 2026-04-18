<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'age',
        'guardian_name',
        'guardian_contact',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
