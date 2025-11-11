<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PvPoint extends Model
{
    protected $fillable = [
        'user_id',
        'leftpart',
        'rightpart',
    ];
}
