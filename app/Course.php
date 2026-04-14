<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'title',
        'cover_photo',
        'description',
        'level',
        'category',
        'min_age',
        'max_age',
        'min_slots',
        'max_slots',
        'schedule_start',
        'schedule_end',
        'session_count',
        'session_duration_mins',
        'recurrence',
        'meeting_link',
        'location',
        'currency',
        'suggested_price',
        'price',
        'status',
        'price_updated_at',
        'price_source',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class);
    }
}
