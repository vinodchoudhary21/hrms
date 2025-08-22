<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'task_name',
        'status',
        'project_id',
        'user_id',
        'start_time',
        'end_time',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Tasks.php
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
