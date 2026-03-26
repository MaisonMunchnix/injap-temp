<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationAttachment extends Model
{
    protected $fillable = [
        'user_id',
        'file_name',
        'file_path',
        'file_type',
        'original_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
