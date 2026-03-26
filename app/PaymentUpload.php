<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentUpload extends Model
{
    protected $table = 'payment_uploads';

    protected $fillable = [
        'user_id',
        'user_name',
        'file_path',
        'original_filename',
        'status',
        'notes',
    ];

    /**
     * Get the user that owns this payment upload
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
