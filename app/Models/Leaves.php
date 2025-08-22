<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    protected $fillable = [
        'leave_type_id',
        'start_at',
        'end_at',
        'reason',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
