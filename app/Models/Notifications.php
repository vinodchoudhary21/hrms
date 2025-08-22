<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $fillable = ['user_id', 'type', 'message', 'is_read'];



    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
