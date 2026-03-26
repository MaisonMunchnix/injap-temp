<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class MessageAttachment extends Model
{
    protected $fillable = ['message_id', 'filename', 'stored_path', 'mime_type', 'file_size'];

    /**
     * Relationship: Get the message this attachment belongs to
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Delete physical file when attachment record is deleted
     */
    protected static function booted()
    {
        static::deleting(function ($attachment) {
            $fullPath = public_path($attachment->stored_path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        });
    }

    /**
     * Get public URL for download
     */
    public function getPublicUrlAttribute()
    {
        return asset($this->stored_path);
    }

    /**
     * Get file size in human-readable format
     */
    public function getHumanFileSize()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
