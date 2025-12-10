<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'title',
        'content',
        'date',
        'status',
    ];

    public function getStatusTextAttribute()
    {
        return $this->status == 1 ? 'active' : 'inactive';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}