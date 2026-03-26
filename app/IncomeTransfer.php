<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeTransfer extends Model
{
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'amount',
        'type',
        'reason',
        'status',
        'transaction_date'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'datetime'
    ];

    /**
     * Get the sender user
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Get the recipient user
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
