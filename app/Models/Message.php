<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'subject',
        'message',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function isRead()
    {
        return !is_null($this->read_at);
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function replies()
    {
        return $this->hasMany(MessageReply::class)->latest();
    }
}