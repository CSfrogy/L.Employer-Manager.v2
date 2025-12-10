<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'dob',
        'city',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tasks(){
        return $this->hasMany(Task::class, 'emp_id');
    }

    // Cache employee task count
    public function getTaskCountAttribute()
    {
        return \Cache::remember("employee_{$this->id}_task_count", 300, fn() => $this->tasks()->count());
    }

    // Get active tasks only
    public function activeTasks()
    {
        return $this->tasks()->where('status', 1);
    }

    // Get completed tasks only
    public function completedTasks()
    {
        return $this->tasks()->where('status', 2);
    }
}