<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class AdminNotifications extends Model
{
    
    protected $fillable = [
        'user_id',
        'type',
        'message',
        'is_read',
        
    ];
    



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
