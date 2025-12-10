<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'sender_id',
        'sender_type',
        'reply_content',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'sender_id');
    }

    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'sender_id');
    }

    public function getSenderNameAttribute()
    {
        if ($this->sender_type === 'admin') {
            return $this->admin ? $this->admin->name : 'Administrator';
        } else {
            return $this->employee ? $this->employee->name : 'Employee';
        }
    }

    public function getSenderRoleAttribute()
    {
        return $this->sender_type === 'admin' ? 'Administrator' : 'Employee';
    }
}