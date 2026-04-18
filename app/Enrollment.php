<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'full_name',
        'email',
        'phone',
        'age',
        'guardian_name',
        'guardian_contact',
        'payment_status',
        'payment_method',
        'enrolled_at'
    ];

    protected $dates = [
        'enrolled_at'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
