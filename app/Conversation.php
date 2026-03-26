<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['admin_id', 'member_id', 'subject', 'status', 'last_message_at'];

    protected $casts = [
        'last_message_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Get the admin (staff member)
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Relationship: Get the member (regular user)
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * Relationship: Get all messages in this conversation
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the latest message
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    /**
     * Get unread message count for a specific user
     */
    public function unreadCount($userId)
    {
        return $this->messages()
            ->where('is_read', false)
            ->where('recipient_id', $userId)
            ->count();
    }

    /**
     * Scope: Get conversations for an admin
     */
    public function scopeForAdmin($query, $adminId)
    {
        return $query->where('admin_id', $adminId);
    }

    /**
     * Scope: Get conversations for a member
     */
    public function scopeForMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    /**
     * Scope: Active conversations only
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
